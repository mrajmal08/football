<?php

namespace App\Console\Commands;

use App\Http\Controllers\PlayerController;
use App\Models\DraftOrder;
use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyTeam;
use App\Models\FantasyTeamsPlayerTransaction;
use App\Models\League;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Helper;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class StartDraft extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'StartDraft {--league_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Draft';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->info('Running');
        $draftPickTime = 30;
        if ($draftPickTime == 1) {
            $counter = 200;
        }

        $league_id = $this->option('league_id');
        if ($league_id > 0) {
            $league = League::find($league_id);
            $league->draft_started = 1;
            $league->save();
            if ($league->draft_completed) {
                $this->info('League draft complete');

                return;
            }

            if ($league->draft_pick_max_time) {
                $draftPickTime = $league->draft_pick_max_time;
                $counter = 120 * $league->draft_pick_max_time;    //We have 108 picks so this should be more than enough time
            }

            //Run every second for 59 seconds
            $count = 0;
            $systemSettings = Helper::getSystemSettingsDetails();

            $this->info('Counter is '.$counter);
            $this->info('Count is '.$count);
            while ($count <= $counter) {
                $startTime = Carbon::now();
                $qb_reached = $rb_reached = $wr_reached = $te_reached = $k_reached = $def_reached = $st_reached = $success = 0;
                $tqb_reached = $team_qb = 0;
                $current_draft = DraftOrder::where('fantasy_player_id', null)
                                    ->where('deadline', '<>', null)
                                    ->where('league_id', $league_id)
                                    ->first();

                if (! empty($current_draft)) {
                    //$this->info($current_draft);
                    if (! empty($league)) {
                        $week = $systemSettings['week'];
                        $season = $systemSettings['season'];
                        $seasonType = $systemSettings['season_type'];
                    }
                    $cur_date = Carbon::now();
                    if ($current_draft->deadline <= $cur_date) {
                        //$this->info('need to draft');
                        // $current_draft->deadline	= NULL;
                        // $current_draft->save();
                        $selectTrans = FantasyTeamsPlayerTransaction::selectRaw('count(*) as counts,position')
                            ->where('player_transaction_type_id', 1)
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_player_transactions.fantasy_player_id')
                            ->where('fantasy_teams_player_transactions.active', 1)
                            ->where('fantasy_team_id', $current_draft->fantasy_team_id)
                            ->groupBy('position')
                            ->get();

                        if (! empty($selectTrans)) {
                            $playerArray = $selectTrans->toArray();
                            $countArray = array_column($playerArray, 'counts', 'position');
                            $exclude_position = [];

                            if (isset($countArray['RB']) && $countArray['RB'] >= 2) {
                                $rb_reached = 1;
                                array_push($exclude_position, 'RB');
                            }

                            if (isset($countArray['WR']) && $countArray['WR'] >= 2) {
                                $wr_reached = 1;
                                array_push($exclude_position, 'WR');
                            }

                            if (isset($countArray['TE']) && $countArray['TE'] >= 1) {
                                $te_reached = 1;
                                array_push($exclude_position, 'TE');
                            }

                            if (isset($countArray['K']) && $countArray['K'] >= 1) {
                                $k_reached = 1;
                                array_push($exclude_position, 'K');
                            }

                            if (isset($countArray['TQB']) && $countArray['TQB'] >= 1) {
                                $tqb_reached = 1;
                                array_push($exclude_position, 'TQB');
                            }

                            if (isset($countArray['DEF']) && $countArray['DEF'] >= 1) {
                                $def_reached = 1;
                                array_push($exclude_position, 'DEF');
                            }

                            if (isset($countArray['ST']) && $countArray['ST'] >= 1) {
                                $st_reached = 1;
                                array_push($exclude_position, 'ST');
                            }
                        }
                        $addedIds = [];
                        $alreadyAddedIds = FantasyTeamsPlayerTransaction::select('fantasy_player_id')
                                            ->where('league_id', $current_draft->league_id)
                                            ->where('active', 1)
                                            ->where('player_transaction_type_id', 1)
                                            ->get()->toArray();

                        if (! empty($alreadyAddedIds)) {
                            foreach ($alreadyAddedIds as $key=>$val) {
                                $addedIds[] = $val['fantasy_player_id'];
                            }
                        }

                        $positionsStillNeeded = ['RB', 'WR', 'TE', 'K', 'TQB', 'DEF', 'ST'];

                        if (count($exclude_position) > 0) {
                            //Individual Player Positions this player still needs to draft for
                            $positionsStillNeeded = array_diff($positionsStillNeeded, $exclude_position);
                        }

                        // Select the next fantasy_player the team should draft based on available IDs and positions needed.
                        // TODO: 04/26/20 Update this to use the ACME Fantasy Points
                        $player = FantasyPlayer::select('position', 'id', 'team', 'fantasy_player_key')
                             ->whereIn('position', $positionsStillNeeded)
                             ->whereNotIn('id', $addedIds)
                             //->whereNotNull('average_draft_position_id_p')
                             //->orderBy('average_draft_position_id_p', 'desc')
                             ->orderBy('last_season_fantasy_points', 'desc')
                             ->first();

                        if (! empty($player)) {
                            // Call the controller method to create the transaction
                            //$this->info('have a player to draft.');
                            $request = new Request(
                                [
                                    'player_id' => $player->id,
                                    'fantasy_team_id' => $current_draft->fantasy_team_id,
                                    'transaction_id' => 1,
                                ],
                                ['CONTENT_TYPE' => 'application/json']
                            );

                            $playerController = new PlayerController();
                            $response = $playerController->insertTransactionDetails($request);
                            //$this->info($response);

                            if (! empty($current_draft)) {
                                // NOTE: Completed in PlayerController above to help reduce redundancy.
                                // $current_draft->fantasy_player_id	= $player_id;
                                // $current_draft->deadline	= null;
                                // $current_draft->save();

                                $this->info('[count '.$count.'] League: '.$league->name.' - Draft picked Overall #'.$current_draft->league_overall_pick);
                            }
                        }
                    } else {
                        $this->info('[count '.$count.'] No Draft pick needed (Deadline !<= Current Date. '.$current_draft->deadline.' <='.$cur_date);
                        $deadline = new Carbon($current_draft->deadline);
                        $this->info('difference is: '.$deadline->diffInSeconds($cur_date));
                    }
                } else {
                    // Do one more check to make sure all draft picks were made.
                    $needPlayer = DraftOrder::where('fantasy_player_id', null)
                        ->where('league_id', $league_id)
                        ->first();

                    // If we don't need a player we can safely exit out of the loop and end the draft.
                    if (! $needPlayer) {
                        $this->info('[count '.$count.'] No Draft pick needed. No deadline Found');
                        $this->info('completed');

                        $league->draft_completed = 1;
                        $league->save();

                        //call the GenerateLeagueSchedules console command
                        $this->info('GenerateLeagueSchedules');
                        $this->call('GenerateLeagueSchedules', ['--league_id'=>$league_id]);

                        //Fill the FantasyTeamRoster table for the first week
                        //$this->call('FillFantasyTeamsRoster', []);

                        //call the UpdateLeagueGames console command
                        $this->info('UpdateLeagueGames');
                        $this->call('UpdateLeagueGames', ['--league_id'=>$league_id]);

                        // if ($current_draft->league_overall_pick >108) {
                        //     break;
                        // }
                        $this->info('EXITING DRAFT PROCESS');
                        break;
                    }
                    $this->info('BUG PREVENTED: waiting 1 second');
                }
                $endTime = Carbon::now();
                $totalDuration = $endTime->diffInSeconds($startTime);
                if ($totalDuration > 0) {
                    $count += $totalDuration;
                } else {
                    sleep(1); //ran for less than a second, so we will sleep a second. continue loop
                    $count++;
                }
            }
        } else {
            $this->error('League id is required');
        }
    }
}
