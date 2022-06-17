<?php

namespace App\Jobs;

use App\Http\Controllers\PlayerController;
use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyData\Player;
use App\Models\FantasyData\PlayerGameProjection;
use App\Models\FantasyData\Team;
use App\Models\FantasyTeam;
use App\Models\FantasyTeamsPlayerTransaction;
use App\Models\FantasyTeamsRoster;
use App\Models\League;
use App\Notifications\FantasyTeamNotValid;
use Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ValidateFantasyTeamByWeek implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fantasyTeam;

    protected $commitTransaction;

    protected $week;

    protected $season;

    protected $seasonType;

    protected $benchFilter;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(FantasyTeam $fantasyTeam, $commitTransaction)
    {
        $systemSettings = Helper::getSystemSettingsDetails();
        $this->fantasyTeam = $fantasyTeam;
        $this->commitTransaction = $commitTransaction;
        $this->week = $systemSettings['week'];
        $this->season = $systemSettings['season'];
        $this->seasonType = $systemSettings['season_type'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $week = $this->week;
        $season = $this->season;
        $seasonType = $this->seasonType;

        $activeFilter = function ($query) use ($season, $seasonType, $week) {
            $query->where('season', $season);
            $query->where('season_type', $seasonType);
            $query->where('week', $week);
            $query->where('active', true);
        };

        $this->benchFilter = function ($query) use ($season, $seasonType, $week) {
            $query->where('season', $season);
            $query->where('season_type', $seasonType);
            $query->where('week', $week);
            $query->where('bench', true);
        };

        $fantasyTeam = FantasyTeam::where('id', $this->fantasyTeam->id)
                    ->with(['FantasyTeamRoster' => $activeFilter])
                    ->first();

        $benchFantasyTeam = FantasyTeam::where('id', $this->fantasyTeam->id)
            ->with(['FantasyTeamRoster' => $this->benchFilter])
            ->first();

        $fantasyTeamArray = $fantasyTeam->toArray();
        $fantasyTeamRoster = $fantasyTeamArray['fantasy_team_roster'];
        $currentRosterPositionCount = array_count_values(array_column($fantasyTeamRoster, 'position'));
        //dd($currentRosterPositionCount);

        // Set the max roster counts allowed
        // TODO 04/05/20: Add in a logical check for postseason where we have more players
        // TODO 04/05/20: Add in a logical check for allowed bench players based on injury status or BYE
        $maxStartAllowed = [
            'TQB' => 1,
            'RB' => 2,
            'WR' => 2,
            'K' => 1,
            'TE' => 1,
            'ST' => 1,
            'DEF' => 1,
        ];

        $fantasyTeamArray['position'] = $maxStartAllowed;
        $fantasyTeamArray['bench_fantasy_team_roster'] = $benchFantasyTeam->toArray()['fantasy_team_roster'];

        $transactions = FantasyTeamsRoster::where('fantasy_team_id', $fantasyTeam->id)
                            ->where('week', '=', $week)
                            ->where('season', $season)
                            ->where('season_type', $seasonType)
                            ->where(function ($query) {
                                $query->orWhere('active', 1)
                                      ->orWhere('bench', 1);
                            })
                            ->get();

        if (! empty($transactions)) {
            //dd($transactions);
            foreach ($transactions as $skey=>$fantasyTransaction) {
                $fantasyPlayer = FantasyPlayer::where('id', '=', $fantasyTransaction->fantasy_player_id)->with(['player', 'teamGame', 'teamGame.Score'])->first();
//                $player_id      = $fantasyPlayer->player_id;
//                $player         = Player::where('player_id', '=', $player_id)->first();

                if ($fantasyPlayer && $fantasyTransaction->active) {
                    $status = $fantasyPlayer->player->status ?? 'Active'; // Default to active for ST, DEF, TQB because they will be kicked out only for a BYE Week.
                    $playerOnByeWeek = ($fantasyPlayer->bye_week == $week) ? true : false;
                    $injury_status = $fantasyPlayer->player->injury_status;

                    // #1 Handle a player that is not on an active NFL Team by dropping the player completely.
                    if (! $fantasyPlayer->team) {

                        //Find next best player
                        $nextBestPlayer = $this->findNextBestPlayer([$fantasyPlayer->position]);

                        if ($this->commitTransaction) {
                            // Drop Player
                            $this->createTransaction($fantasyPlayer->id, 2);

                            // Add Next Best Player
                            $this->createTransaction($nextBestPlayer->id, 1);
                        }

                        // Build the message to send to the user.
                        //$this->info("Build message");
                        $this->buildMessage($fantasyPlayer, 'drop', $nextBestPlayer);
                        continue;
                    }

                    // #2 Handle a player that is on a BYE this week or is injured. Move to bench
                    // AND Add the next best player that should be a replacement.

                    if ($playerOnByeWeek || $status != 'Active' || $injury_status == 'Questionable' || $injury_status == 'Out') {
                        if ($fantasyPlayer->teamGame) {
                            if ($fantasyPlayer->teamGame->Score->has_started) {
                                continue;
                            }
                        }

                        // Check if there is already a player on the bench that could be moved to the starting lineup.
                        $replaceWithFantasyTeamBench = false;
                        foreach ($transactions as $rosterPlayer) {
                            if (
                                ($rosterPlayer->bench) &&
                                ($rosterPlayer->fantasyPlayer->team == $fantasyPlayer->team) &&
                                ($rosterPlayer->fantasyPlayer->position == $fantasyPlayer->position) &&
                                ($rosterPlayer->fantasyPlayer->bye_week != $this->week)
                            ) {
//                                // If not TQB, DEF, or ST check injury
//                                if(!in_array($fantasyPlayer->position, array('DEF', 'ST', 'TQB')))
//                                {
//                                    if($rosterPlayer->fantasyPlayer->player->injury_statues == 'Out')
//                                }

                                $replaceWithFantasyTeamBench = $rosterPlayer;
                            }
                        }
                        //dd($injury_status);
                        // Message to move payer from Active -> Bench

                        //Find next best player
                        if ($replaceWithFantasyTeamBench) {
                            //dd($replaceWithFantasyTeamBench->fantasyPlayer->player_id);
                            $nextBestPlayer = $this->findNextBestPlayer(null, null, $replaceWithFantasyTeamBench->fantasyPlayer->player_id);
                        } else {
                            if ($playerOnByeWeek) {
                                $nextBestPlayer = $this->findNextBestPlayer([$fantasyPlayer->position]);
                            } else {
                                $nextBestPlayer = $this->findNextBestPlayer([$fantasyPlayer->position], $fantasyPlayer->team);
                            }
                        }

                        // Commit the transaction only if the player is not Questonable
                        // i.e.: Bye or Out Status
                        if ($this->commitTransaction && ($injury_status == 'Out' || $playerOnByeWeek)) {
                            // dd('here');
                            //Move player to the bench.
                            $resultBench = $this->createTransaction($fantasyPlayer->id, 8);

                            // Add Next Best Player & Reassign the data so it goes in the email.
                            $nextBestPlayerSelected = $nextBestPlayer->first();
                            //dd($nextBestPlayerSelected->id);

                            // Move next best player from bench to roster
                            // Otherwise do an "add" to pick up the next best player
                            if ($replaceWithFantasyTeamBench) {
                                //dd($nextBestPlayerSelected->name);
                                $resultAdd = $this->createTransaction($nextBestPlayerSelected->id, 9);                   // Bench -> Active
                            } else {
                                $resultAdd = $this->createTransaction($nextBestPlayerSelected->id, 1);      // Add New player to Active
                            }
                            // Build the Message that we will send to the user.
                            $this->buildMessage($fantasyPlayer, 'bench', $nextBestPlayer, $replaceWithFantasyTeamBench);
                        }

                        // If the injury is questionable, add the next best player that is not already on the bench,
                        // Then add a player, to THE BENCH ONLY.
                        // This protects the user so that they have the next best backup on their roster.
                        // If $replaceWithFantasyTeamBench has a value then the player is already on the bench. Don't do anything.
                        if ($this->commitTransaction && $injury_status == 'Questionable' && ! $replaceWithFantasyTeamBench) {
                            $nextBestPlayerSelected = $nextBestPlayer->first();

                            // Ensure we have a player. Sometimes a "K" won't have the next best replacement on the same team.
                            if ($nextBestPlayerSelected) {
                                $resultAdd = $this->createTransaction($nextBestPlayerSelected->id, 11);
                                $this->buildMessage($fantasyPlayer, 'backup', $nextBestPlayer, $replaceWithFantasyTeamBench);
                            }
                        }

                        // Send email for non commit transactions
                        if (! $this->commitTransaction && ($playerOnByeWeek || $status != 'Active' || $injury_status == 'Questionable' || $injury_status == 'Out')) {
                            // Build the Message that we will send to the user.
                            $this->buildMessage($fantasyPlayer, 'bench', $nextBestPlayer, $replaceWithFantasyTeamBench);
                        }
                    }
                }
            }
        }

        // Validate that the team now has all the correct number of starters
//        if($this->commitTransaction)
        $this->checkRosterComplete($fantasyTeam, $benchFantasyTeam);

        $info = true;
    }

    // TODO: Have it make sure only 9 starters per roster
    public function checkRosterComplete()
    {
        $complete = true;
        //Build an array with useful info
        $fantasyTeamData = Helper::getUserFantasyTeamRoster($this->fantasyTeam->id);

        $benchFantasyTeam = FantasyTeam::where('id', $this->fantasyTeam->id)
            ->with(['FantasyTeamRoster' => $this->benchFilter])
            ->first();

        //dd($fantasyTeamData['position']);

        foreach ($fantasyTeamData['position'] as $position => $positionData) {

            //dd($position,$positionData);
            if (! $positionData['maxReached']) {
                $complete = false;
                // #1: Try to see if we have a bench player that can be moved to the team.
                $handleBench = $this->handleBenchPlayers($position, $benchFantasyTeam);

                if ($handleBench) {
                    continue;
                }

                // #2 Try to find a player to add
                //dd($position, 'no bench, find next best');
                $handleEmptyStarter = $this->handleEmptyStarter([$position]);

                if ($handleEmptyStarter) {
                    continue;
                }
            }
        }

        // Not complete? Run it again if we need to commit transactions. Otherwise, it will create an infinite loop.
        if (! $complete && $this->commitTransaction) {
            $this->checkRosterComplete();
        }
    }

    /**
     * @param $fantasyPlayer
     * @param $action = drop, bench, start
     * @param null $nextBestPlayer
     */
    public function buildMessage($fantasyPlayer, $action, $nextBestPlayer = null, $replaceWithFantasyTeamBench = false)
    {
        if (! $fantasyPlayer) {
            $fantasyPlayer = new \stdClass();
            $fantasyPlayer->bye_week = null;
            $fantasyPlayer->player = new \stdClass();
            $fantasyPlayer->player->injury_status = null;
            $fantasyPlayer->team = null;
            $fantasyPlayer->name = null;
            $fantasyPlayer->id = false;
        }

        $status = $fantasyPlayer->player->status ?? 'Active'; // Default to active for ST, DEF, TQB because they will be kicked out only for a BYE Week.
        $playerOnByeWeek = ($fantasyPlayer->bye_week == $this->week) ? true : false;
        $injury_status = $fantasyPlayer->player->injury_status;
        $nflTeam = $fantasyPlayer->team;

        if (! $fantasyPlayer->id) {
            $reason = 'Missing enough players for a valid roster';
        } elseif (! $nflTeam) {
            $reason = 'is not on an active NFL roster';
        } elseif ($playerOnByeWeek) {
            $reason = 'is on a bye this week';
        } else {
            if ($injury_status == 'Out') {
                $reason = 'has been ruled Out with a '.$fantasyPlayer->player->injury_body_part.' injury. <br/><br/>'.$fantasyPlayer->player->injury_notes;
            } else {
                $reason = 'is injured with a status of '.$injury_status;
            }
        }

        if (! $fantasyPlayer->id) {
            $actionMessage = 'and need to add a player.';
        } elseif ($action == 'drop') {
            $actionMessage = 'and should be dropped from your team.';
        }
        if ($action == 'bench') {
            $actionMessage = 'and should be moved to the bench.';
        }
        if ($action == 'start') {
            $actionMessage = 'and should be moved to starting lineup.';
        }
        if ($action == 'backup') {
            $actionMessage = 'and needs a backup on the roster.';
        }
        if ($injury_status == 'Out') {
            $actionMessage = 'He should be moved to the bench.';
        }
//        if($action == 'add')
//            $actionMessage = 'added to your team';

        if (! $fantasyPlayer->id) {
            $message = $reason.' '.$actionMessage;
        } else {
            $message = $fantasyPlayer->name.'('.$fantasyPlayer->team.' '.$fantasyPlayer->position.') '.$reason.' '.$actionMessage;
        }

        if ($this->commitTransaction) {
            if (! $fantasyPlayer->id) {
                $actionMessage = 'and need to add a player';
            } elseif ($action == 'drop') {
                $actionMessage = 'and was dropped from your team.';
            }
            if ($action == 'bench' && $fantasyPlayer->id) {
                $actionMessage = 'and was moved to the bench';
            }
            if ($action == 'start' && $fantasyPlayer->id) {
                $actionMessage = 'and was moved to starting lineup.';
            }
            if ($injury_status == 'Out' && $fantasyPlayer->id) {
                $actionMessage = 'He was moved to the bench';
            }
            if ($action == 'backup') {
                $actionMessage = 'and was given a backup';
            }

            if (! $fantasyPlayer->id) {
                $message = $reason.' '.$actionMessage.' automatically per league rules.';
            } else {
                $message = $fantasyPlayer->name.'('.$fantasyPlayer->team.' '.$fantasyPlayer->position.') '.$reason.' '.$actionMessage.' automatically by the league.';
            }
        }

        // Replacement Message
        $replacementMessage = '';
        if ($nextBestPlayer) {
            if ($replaceWithFantasyTeamBench) {
                $replacementMessage .= 'At this time, you could move the following player from your bench to your starting lineup:<br/><br/>';
            } else {
                $numberReplacementsFound = count($nextBestPlayer);
                $replacementMessage .= 'At this time, the top '.$numberReplacementsFound.' potential replacements for Week '.$this->week.' are:<br/><br/>';
            }
            $number = 0;
            foreach ($nextBestPlayer as $key => $potentialReplacement) {
                $number++;
                //dd($potentialReplacement);
                $projPts = $potentialReplacement->playerGameProjection->first()->fantasy_points_acme ?? 'Unknown';
                if ($potentialReplacement) {
                    $replacementMessage .= $number.'. '.$potentialReplacement->name.', '.$potentialReplacement->team.' (Proj Pts: '.$projPts.')<br/>';
                }
                // $replacementMessage .= $number.'. '. $potentialReplacement->name.'('.$potentialReplacement->team .' '.$potentialReplacement->position .')\r\n';
            }
            if ($this->commitTransaction && $key = 1) {
                if ($replaceWithFantasyTeamBench) {
                    $replacementMessage = $nextBestPlayer->first()->name.' was moved from your bench to your starting lineup.';
                } elseif ($action == 'backup') {
                    $replacementMessage = $nextBestPlayer->first()->name.' was added as a backup to your bench.';
                } else {
                    $replacementMessage = $nextBestPlayer->first()->name.' was added as a replacement to your starting lineup.';
                }
            }
        }

        $this->fantasyTeam->teamOwner->notify(new FantasyTeamNotValid($message, $replacementMessage));
    }

    public function handleEmptyStarter($positionToFill)
    {
        $completed = false;

        //dd('do it');
        $nextBestPlayer = $this->findNextBestPlayer($positionToFill);
        //dd($nextBestPlayer->id);
        if ($this->commitTransaction) {
            $response = $this->createTransaction($nextBestPlayer->first()->id, 1);
            $this->buildMessage(null, 'add', $nextBestPlayer, false);
        }
        $completed = true;

        return $completed;
    }

    public function handleBenchPlayers($positionToFill, $benchRoster)
    {
//        dd($benchRoster);
        $completed = false;
        $benchRosterArray = $benchRoster->toArray();

        $iterations = 0;

        $numberBenchOptions = count(array_filter($benchRosterArray['fantasy_team_roster'], function ($element) use ($positionToFill) {
            return $element['position'] == $positionToFill;
        }));
        //dd($numberBenchOptions);
        foreach ($benchRosterArray['fantasy_team_roster'] as $benchPlayer) {
            $iterations++;
//          dd($benchPlayer['position']);

            // If the player isn't "Out" then move to starter
            if ($positionToFill == $benchPlayer['position'] && $benchPlayer['fantasy_player']['bye_week'] != $this->week && $benchPlayer['fantasy_player']['player']['injury_status'] != 'Out') {

                    //dd('do it');
                $nextBestPlayer = $this->findNextBestPlayer(null, null, $benchPlayer['fantasy_player']['player_id']);
                if ($this->commitTransaction) {
                    $response = $this->createTransaction($benchPlayer['fantasy_player']['id'], 9);
                }
                //dd($nextBestPlayer);
                $this->buildMessage(null, 'start', $nextBestPlayer, true);
                $completed = true;
            }

            // If they have an injured player on the bench that is "Out". Add a player from the same team and same position group.
            // Only if we have gone through all the options.
//            if ($iterations == $numberBenchOptions && $positionToFill == $benchPlayer['position'] && $benchPlayer['fantasy_player']['bye_week'] != $this->week && $benchPlayer['fantasy_player']['player']['injury_status'] == 'Out') {
//                if ($this->commitTransaction) {
//                    //dd('do it');
//                    $nextBestPlayer = $this->findNextBestPlayer(array($benchPlayer['fantasy_player']['position']), $benchPlayer['fantasy_player']['team'], false);
//                    $response = $this->createTransaction($nextBestPlayer->first()->id, 1);
//                    //dd($nextBestPlayer);
//                    $this->buildMessage(null, 'start',$nextBestPlayer, false);
//                    $completed = true;
//                }
//            }
        }

        return $completed;
    }

    // Find the next best player that should be added to the team.
    public function findNextBestPlayer($positionsStillNeeded, $nflTeam = null, $replaceWithFantasyTeamBench = null)
    {
        // Players already added in the league.
        $addedIds = [];
        $alreadyAddedIds = FantasyTeamsRoster::select('fantasy_player_id')
            ->where('league_id', $this->fantasyTeam->league->id)
            ->where('player_transaction_type_id', 1)
            ->where('week', '=', $this->week)
            ->where('season', '=', $this->season)
            ->where('season_type', '=', $this->seasonType)
            ->where(function ($q) {
                $q->where('active', 1)
                ->orWhere('bench', 1);
            })
            ->get()->toArray();

        if (! empty($alreadyAddedIds)) {
            foreach ($alreadyAddedIds as $key=>$val) {
                $addedIds[] = $val['fantasy_player_id'];
            }
        }

        // Select the player

        $season = $this->season;
        $seasonType = $this->seasonType;

        $filter = function ($query) use ($season, $seasonType) {
            $query->where('season', $season);
            $query->where('season_type', $seasonType);
            $query->orderBy('fantasy_points_acme', 'desc');
        };

        //dd($addedIds);
        $qWeek = $this->week;
        if ($replaceWithFantasyTeamBench) {
            $fantasyPlayers = FantasyPlayer::where('player_id', '=', $replaceWithFantasyTeamBench)
                ->with('player')
                ->with(['playerGameProjection' => function ($query) use ($qWeek) {
                    $query->where('week', '=', $qWeek);
                }])
                ->whereHas('player', function ($q) {
                    $q->where('status', '=', 'Active');
                    $q->whereNotNull('fantasy_position_depth_order');
                })
                ->get();
        } elseif ($nflTeam) {
            //dd($positionsStillNeeded);
            $fantasyPlayers = FantasyPlayer::whereIn('position', $positionsStillNeeded)
                ->whereNotIn('id', $addedIds)
                ->whereNotNull('team')
                ->where('team', $nflTeam)
                ->with('player')
                ->with(['playerGameProjection' => function ($query) use ($qWeek) {
                    $query->where('week', '=', $qWeek);
                }])
                ->whereHas('player', function ($q) {
                    $q->where('status', '=', 'Active');
                    $q->whereNotNull('fantasy_position_depth_order');
                })
                ->get();
        } elseif (! in_array('DEF', $positionsStillNeeded)) {
            $fantasyPlayers = FantasyPlayer::whereIn('position', $positionsStillNeeded)
                ->whereNotIn('id', $addedIds)
                ->whereNotNull('team')
                ->whereNotIn('bye_week', [$this->week])
                ->with(['playerGameProjection' => function ($query) use ($qWeek) {
                    $query->where('week', '=', $qWeek);
                }])
            ->get();
            // Sort the colection based on the playerGameProjection
            $fantasyPlayers = $fantasyPlayers->sort(function ($a, $b) {
                if (count($a->playerGameProjection) == 0 || count($b->playerGameProjection) == 0) {
                    return 0;
                }
                if ($a->playerGameProjection->first()->fantasy_points_acme == $b->playerGameProjection->first()->fantasy_points_acme) {
                    return 0;
                }

                return ($a->playerGameProjection->first()->fantasy_points_acme > $b->playerGameProjection->first()->fantasy_points_acme) ? -1 : 1;
            });
        } else {
            $fantasyPlayers = FantasyPlayer::whereIn('position', $positionsStillNeeded)
                ->whereNotIn('id', $addedIds)
                ->whereNotNull('team')
                ->whereNotIn('bye_week', [$this->week])
                ->with(['fantasyDefenseGameProjection' => function ($query) use ($qWeek) {
                    $query->where('week', '=', $qWeek);
                }])
            ->get();
            // Sort the colection based on the fantasyDefenseGameProjection
            // dd($fantasyPlayers->first());

            $fantasyPlayers = $fantasyPlayers->sort(function ($a, $b) {
                // dd($b->fantasyDefenseGameProjection->first()->fantasy_points_acme);
                // echo $a->name.": ".$a->fantasyDefenseGameProjection->first()->fantasy_points_acme ."\r\n";
                // echo $b->name.": ".$b->fantasyDefenseGameProjection->first()->fantasy_points_acme ."\r\n";
                // dd($b->fantasyDefenseGameProjection);

                // echo $a->name."\r\n";
                // echo $b->name."\r\n";
                // if ($b->name == 'DEF Denver Broncos') {
                //     //dd(count($b->fantasyDefenseGameProjection));
                // }

                // Weird issue observed 11/29/20 - DEF Denver Broncos returned 0 projection games for week 11.
                // Catch and return 0;
                if (count($a->fantasyDefenseGameProjection) == 0 || count($b->fantasyDefenseGameProjection) == 0) {
                    return 0;
                }
                if ($a->fantasyDefenseGameProjection->first()->fantasy_points_acme == $b->fantasyDefenseGameProjection->first()->fantasy_points_acme) {
                    return 0;
                }

                return ($a->fantasyDefenseGameProjection->first()->fantasy_points_acme > $b->fantasyDefenseGameProjection->first()->fantasy_points_acme) ? -1 : 1;
            });
        }
        // Return the first 3 results.
        $fantasyPlayers = $fantasyPlayers->slice(0, 3);
        //dd($fantasyPlayers->player_id);
        return $fantasyPlayers;
    }

    /**
     * @param $fantasy_player_id
     * @param $transaction_id 1=add 2=drop 3=trade 4=watch 5=claim, 6=claim reject, 7=claim approve, 8=active to bench, 9=bench to active, 10 = Cancel Claim, 11 = Add Straight to Bench
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTransaction($fantasy_player_id, $transaction_id)
    {
        $request = new Request(
            [
                'player_id' => $fantasy_player_id,
                'fantasy_team_id' => $this->fantasyTeam->id,
                'transaction_id' => $transaction_id,
            ],
            ['CONTENT_TYPE' => 'application/json']
        );

        $playerController = new PlayerController();
        $response = $playerController->insertTransactionDetails($request);

        return $response;
    }
}
