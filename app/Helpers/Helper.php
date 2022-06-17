<?php

namespace App\Helpers;

use App\Http\Controllers\PlayerController;
use App\Models\DraftOrder;
use App\Models\FantasyData\FantasyDefenseGame;
use App\Models\FantasyData\FantasyDefenseSeason;
use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyData\PlayerGame;
use App\Models\FantasyData\PlayerGameProjection;
use App\Models\FantasyData\PlayerSeason;
use App\Models\FantasyData\Score;
use App\Models\FantasyData\ScoringDetail;
use App\Models\FantasyData\TeamGame;
use App\Models\FantasyTeam;
use App\Models\FantasyTeamsPlayerTransaction;
use App\Models\FantasyTeamsRoster;
use App\Models\LeagueGame;
use App\Models\LeagueGamesSim;
use App\Models\LeaguePostseasonScores;
use App\Models\LeagueSchedule;
use App\Models\LeagueTeamRanking;
use App\Models\SystemSetting;
use Auth;
use Illuminate\Http\Request;

class Helper
{
    public static function sortTeamArray($teamArray)
    {
        $order = ['TQB', 'QB', 'RB', 'WR', 'TE', 'K', 'DEF', 'ST'];
        usort($teamArray, function ($a, $b) use ($order) {
            $pos_a = array_search($a['position'], $order);
            $pos_b = array_search($b['position'], $order);

            return $pos_a - $pos_b;
        });

        return $teamArray;
    }

    public static function sum()
    {
        return array_sum(func_get_args());
    }

    public static function calculateTqbSeasonData($playerTeams)
    {
        $tqb_fantasy_points_acme = 0;

        $teamQB = [];
        $teamQB['fantasy_points_acme'] = 0;
        $teamQB['passing_yards'] = 0;
        $teamQB['passing_touchdowns'] = 0;
        $teamQB['passing_interceptions'] = 0;
        $teamQB['rushing_yards'] = 0;
        $teamQB['rushing_touchdowns'] = 0;
        $teamQB['fumbles_lost'] = 0;
        $teamQB['passing_attempts'] = 0;
        $teamQB['passing_completions'] = 0;
        $teamQB['week'] = '';
        $teamQB['season'] = '';
        $teamQB['game_date'] = '';
        $teamQB['opponent'] = '';

        if ($playerTeams) {
            //$teamQB = array_merge($teamQB, $playerTeams[0]);

            $ignoredKeys = ['id', 'game_key', 'player_id', 'season_type',  'season', 'game_date', 'week', 'team', 'opponent', 'home_or_away', 'number', 'name', 'position', 'position_category', 'fantasy_position', 'player_game_id', 'short_name', 'playing_surface', 'stadium', 'injury_status', 'injury_body_part', 'injury_start_date', 'injury_notes', 'fan_duel_position', 'draft_kings_position', 'yahoo_position', 'injury_practice', 'injury_practice_description', 'fantasy_draft_position', 'day', 'date_time', 'scoring_details'];

            foreach ($playerTeams as $k=>$subArray) {
                foreach ($subArray as $id=>$value) {
                    if (! in_array($id, $ignoredKeys, true) && is_numeric($value)) {
                        if (! isset($teamQB[$id])) {
                            $teamQB[$id] = 0;
                        }
                        $teamQB[$id] += $value;
                    } else {
                        if (! isset($teamQB[$id])) {
                            $teamQB[$id] = 0;
                        }
                        $teamQB[$id] = $value;
                    }
                }
            }
        }

        return $teamQB;
    }

    public static function calculateStSeasonData($playerGames)
    {
        $acmeFantasyPoints = 0;
        $playerData = [];

        if ($playerGames) {
            $ignoredKeys = [
                'id',
                'game_key',
                'player_id',
                'season_type',
                'season',
                'game_date',
                'week',
                'team',
                'opponent',
                'home_or_away',
                'number',
                'name',
                'position',
                'position_category',
                'fantasy_position',
                'player_game_id',
                'short_name',
                'playing_surface',
                'stadium',
                'injury_status',
                'injury_body_part',
                'injury_start_date',
                'injury_notes',
                'fan_duel_position',
                'draft_kings_position',
                'yahoo_position',
                'injury_practice',
                'injury_practice_description',
                'fantasy_draft_position',
                'day',
                'date_time',
                'scoring_details',
            ];

            foreach ($playerGames as $k=>$subArray) {
                foreach ($subArray as $id=>$value) {
                    if (! in_array($id, $ignoredKeys, true) && is_numeric($value)) {
                        if (! isset($playerData[$id])) {
                            $playerData[$id] = 0;
                        }
                        $playerData[$id] += $value;
                    } else {
                        if (! isset($playerData[$id])) {
                            $teamQB[$id] = 0;
                        }
                        $playerData[$id] = $value;
                    }
                }
            }
        }

        return $playerData;
    }

    public static $seasonTypes = [
        '1' => 'REG',
        '2' => 'PRE',
        '3' => 'POST',
    ];

    public static function getFantasyPLayerDataByWeekEloquent($season, $seasonType, $week, $players)
    {
        $filter = function ($query) use ($week, $season, $seasonType) {
            $query->where('season', $season);
            $query->where('week', $week);
            $query->where('season_type', $seasonType);
        };

        $teamRoster = FantasyTeamsRoster::whereIn('fantasy_player_id', $players)
                                                ->with(['fantasyPlayer.fantasyDefenseGame'=> $filter])
                                                //->with(['fantasyPlayer.gameFantasyPoint'=>$filter])
                                                ->with(['fantasyPlayer.teamGame.Score'])
                                                ->with(['fantasyPlayer.playerGameProjection'=> $filter])
                                                ->with(['fantasyPlayer.fantasyDefenseGameProjection'=> $filter])
                                                ->with(['fantasyPlayer.teamGame' => $filter])
                                                ->with(['fantasyPlayer.playerGame.Score'])
                                                ->with(['fantasyPlayer.playerGame'=> $filter])
                                                ->with(['fantasyPlayer.team.TeamAwaySchedule'=> $filter])
                                                ->with(['fantasyPlayer.team.TeamHomeSchedule'=> $filter])
                                                ->with(['fantasyPlayer.team'])
                                                ->get();

        return $teamRoster;
    }

    public static function getFantasyTeamDataByWeekEloquent($season, $seasonType, $week, $teamId, $simple = true)
    {
        $filter = function ($query) use ($week, $season, $seasonType) {
            $query->where('season', $season);
            $query->where('week', $week);
            $query->where('season_type', $seasonType);
        };

        $filterRoster = function ($query) use ($week, $season, $seasonType) {
            $query->where('season', $season);
            $query->where('week', $week);
            $query->where('season_type', $seasonType);
            $query->where(function ($q) {
                $q->where('active', 1)
                    ->orWhere('bench', 1);
            });
        };

        if ($simple) {
            $teamRoster = FantasyTeam::where('id', $teamId)
                                                // ->with(['FantasyTeamRoster.fantasyPlayer.fantasyDefenseGame.FantasyPlayerGameFantasyPoint'=> $filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.fantasyDefenseGame'=> $filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.teamGame.Score' => $filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.teamGame' => $filter])
                                                // ->with(['FantasyTeamRoster.fantasyPlayer.playerGame.FantasyPlayerGameFantasyPoint'=> $filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.playerGame'=> $filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer'])
                                                ->with(['FantasyTeamRoster' => $filterRoster])
                                                ->first();
        } else {
            $teamRoster = FantasyTeam::where('id', $teamId)
                                                ->with(['FantasyTeamRoster.fantasyPlayer.fantasyDefenseGame'=> $filter])
                                                // ->with(['FantasyTeamRoster.fantasyPlayer.fantasyDefenseSeason'=>$without_week_filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.teamGame.Score' => $filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.playerGameProjection'=> $filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.fantasyDefenseGameProjection'=> $filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.teamGame.Score'])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.teamGame' => $filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.playerGame.Score'])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.playerGame'=> $filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer'=> $filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.team.TeamAwaySchedule'=> $filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.team.TeamHomeSchedule'=> $filter])
                                                ->with(['FantasyTeamRoster.fantasyPlayer.team'])
                                                ->with(['FantasyTeamRoster' => $filterRoster])
                                                ->first();
        }

        // This sorted stuff works but for some reason the relation value isn't saving the sorted data.
        // Moved to sort inside of the VUEjs compnent
        // $sorted = $teamRoster->FantasyTeamRoster->sort(function ($a, $b) {
        //     $key = ['position'];
        //     if ($a['position'] == $b['position']) {
        //         return 0;
        //     }

        //     $order=array("TQB","RB","WR","TE","K","DEF","ST");

        //     $position = array_search($a['position'], $order);
        //     $position2 = array_search($b['position'], $order);

        //     //if both are in the $order, then sort according to their order in $order...
        //     if ($position2!==false && $position!==false) {
        //         return ($position < $position2) ? -1 : 1;
        //     }
        //     //if only one is in $order, then sort to put the one in $order first...
        //     if ($position['position']!==false) {
        //         return -1;
        //     }
        //     if ($position2['position']!==false) {
        //         return 1;
        //     }
        // });

        //return $teamRoster;

        //dd($teamRoster->FantasyTeamRoster);
        //dd($teamRoster);

        //$teamRoster['FantasyTeamRosterSorted'] = $sorted;
        //$teamRoster->unsetRelation('FantasyTeamRoster');
        //dd($teamRoster);
        //$teamRoster->setRelation('fantasy_team_roster', $sorted);
        //dd($teamRoster);

        //dd($sorted);

        //dd($teamRoster->toArray());

        //usort($teamRoster, 'sortByPosition');

        // $roster = $teamRoster->FantasyTeamRoster->toArray();

        // usort($roster, function ($a, $b) {
        //     $key = ['position'];
        //     if ($a['position'] == $b['position']) {
        //         return 0;
        //     }

        //     $order=array("TQB","RB","WR","TE","K","ST","DEF");

        //     $position = array_search($a['position'], $order);
        //     $position2 = array_search($b['position'], $order);

        //     //if both are in the $order, then sort according to their order in $order...
        //     if ($position2!==false && $position!==false) {
        //         return ($position < $position2) ? -1 : 1;
        //     }
        //     //if only one is in $order, then sort to put the one in $order first...
        //     if ($position['position']!==false) {
        //         return -1;
        //     }
        //     if ($position2['position']!==false) {
        //         return 1;
        //     }
        // });

        //dd($roster);
        //$teamRoster->FantasyTeamRoster = $roster;

        // usort($teamRoster, function ($rosterA, $rosterB): int {
        //     if ($rosterA) {
        //         return $b->getPrice() <=> $a->getPrice();
        //     }
        // });

        return $teamRoster;
    }

    public function sortByPosition($a, $b)
    {
        $key = ['fantasy_player']['position'];
        if ($a[$key] == $b[$key]) {
            return 0;
        }

        $order = ['TQB', 'RB', 'WR', 'TE', 'K', 'ST', 'DEF'];

        $position = array_search($a[$key], $order);
        $position2 = array_search($b[$key], $order);

        //if both are in the $order, then sort according to their order in $order...
        if ($position2 !== false && $position !== false) {
            return ($position[$key] < $position2[$key]) ? -1 : 1;
        }
        //if only one is in $order, then sort to put the one in $order first...
        if ($position[$key] !== false) {
            return -1;
        }
        if ($position2[$key] !== false) {
            return 1;
        }

        //if neither in $order, then a simple alphabetic sort...
        //return ($a[$key] < $b[$key]) ? -1 : 1;
    }

    public static function calculateFantasyPlayerGameFantasyPoints($week, $season, $seasonType, $fantasy_player, $isProjection = false)
    {
        //Assume we can pass a full FantasyPlayer object to reduce unnecessary queries
        //Or we can run this as a mass command and get just a player_id
        //not an object? Look up the player we need.

        $filter = function ($query) use ($week, $season, $seasonType) {
            $query->where('season', $season);
            $query->where('week', $week);
            $query->where('season_type', $seasonType);
        };
        if (! is_object($fantasy_player)) {
            if ($isProjection) {
                //Get the Projection FantasyPlayer record for the player_id we were passed.
                $fantasy_player = FantasyPlayer::where('player_id', $fantasy_player)->first();
            // ->with(['fantasyPlayerGameProjection' => $filter])
                                                // ->with(['fantasyDefenseGameProjection' => $filter])->first();
            } else {
                //Get the FantasyPlayer record for the player_id we were passed.
                $fantasy_player = FantasyPlayer::where('player_id', $fantasy_player)->first();
                // ->with(['teamGame' => $filter])
                                                // ->with(['playerGame' => $filter])
                                                // ->with(['fantasyDefenseGame' => $filter])
            }
        }

        //dd($fantasy_player);
        //echo $fantasy_player;

        //Ensure we have a fantasy player before proceeding.
        if (! $fantasy_player) {
            return;
        }

        //echo "Got: ". $fantasy_player->name ." ". $fantasy_player->id ."\r\n";

        $offenseArray = ['RB', 'QB', 'WR', 'TE', 'TQB', 'K'];	//Array of individual player positions (Not "Team" based)

        //If offense player load the records we need
        if (in_array($fantasy_player->position, $offenseArray)) {
            $fantasy_player->load(['playerGame' => $filter]);
        } else {
            $fantasy_player->load(['fantasyDefenseGame' => $filter], ['teamGame' => $filter]);
        }

        $game_key = '';
        $fantasy_points = 0;
        $team = $fantasy_player->team;
        $player_id = $fantasy_player->player_id;

        //Make sure we have a game_key and if we do then process to calculate points
        //if we don't have a record that means game hasn't started or player didn't play
        //Handle regular individual player positions; RB, WR, TE, QB, K
        $player_game = [];
        //dd($fantasy_player);
        if (count($fantasy_player->playerGame) > 0 || count($fantasy_player->fantasyPlayerGameProjection) > 0) {

            //echo "have this many records: ". count($fantasy_player->playerGame) ."\r\n";

            if ($isProjection) {
                if (count($fantasy_player->fantasyPlayerGameProjection) > 0) {
                    $player_game = $fantasy_player->fantasyPlayerGameProjection[0];
                }
            } else {
                if (count($fantasy_player->playerGame) > 0) {
                    //echo "---Have PlayerGame info1 ---- \r\n";
                    $player_game = $fantasy_player->playerGame[0];
                }
            }

            if (! empty($player_game)) {
                //echo "---Have PlayerGame info2 ---- \r\n";
                $game_key = $player_game->game_key;
                $passing_yards = $player_game->passing_yards;
                $rushing_yards = $player_game->rushing_yards;
                $receiving_yards = $player_game->receiving_yards;
                $passing_interceptions = $player_game->passing_interceptions;
                $fumbles_lost = $player_game->fumbles_lost;
                $two_point_conversion_passes = $player_game->two_point_conversion_passes;
                $two_point_conversion_runs = $player_game->two_point_conversion_runs;
                $two_point_conversion_receptions = $player_game->two_point_conversion_receptions;

                $fg1 = $player_game->field_goals_made0to19;
                $fg2 = $player_game->field_goals_made20to29;
                $fg3 = $player_game->field_goals_made30to39;
                $fg4 = $player_game->field_goals_made40to49;
                $fg5 = $player_game->field_goals_made50_plus;
                $extra_points_made = $player_game->extra_points_made;
                $extra_points_attempted = $player_game->extra_points_attempted;
                $offense_points_acme = 0;
                $fantasy_player->id;
                if (in_array($fantasy_player->position, $offenseArray)) {
                    $touchdownPass = self::getScores($game_key, $player_id, 'PassingTouchdown');
                    $touchdownRush = self::getScores($game_key, $player_id, 'RushingTouchdown');
                    $touchdownRec = self::getScores($game_key, $player_id, 'ReceivingTouchdown');

                    $touchdownPassScores = $touchdownPass['score'];
                    $touchdownRushScores = $touchdownRush['score'];
                    $touchdownRecScores = $touchdownRec['score'];

                    $offense_points_acme = ($passing_yards * 0.011) + ($rushing_yards * 0.025) + ($receiving_yards * 0.025) +
                         ($passing_interceptions * (-0.20)) + ($fumbles_lost * (-0.20)) + ($two_point_conversion_passes * 0.100) +
                         ($two_point_conversion_runs * 0.250) + ($two_point_conversion_receptions * 0.250) +
                         $touchdownPassScores + $touchdownRushScores + $touchdownRecScores;

                    $fantasy_points = number_format($offense_points_acme, 2);
                }
                if ($fantasy_player->position == 'K') {
                    $sumValue = $fg1 + $fg2 + $fg3 + $fg4 + $fg5;
                    if ($game_key != null) {
                        $fieldGoal = self::getScores($game_key, $player_id, 'FieldGoalMade');
                        $fieldGoalMissed = self::getScores($game_key, $player_id, 'FieldGoalMissed');
                        $fieldGoalScores = $fieldGoal['score'];
                        $fantasy_points = ($extra_points_made * 0.530) +
                                                                (($extra_points_attempted - $extra_points_made) * -0.200) +
                                                                $fieldGoalScores +
                                                                $fieldGoalMissed['score'];
                    }
                }
            }
        }

        //Begin to handle players that are "team" related; DEF, ST, TQB
        //Handle "DEF"
        $fantasy_defense_game = [];
        if ((count($fantasy_player->fantasyDefenseGame) > 0 || count($fantasy_player->fantasyDefenseGameProjection) > 0) && $fantasy_player->position == 'DEF') {
            //echo "have this many records: ". count($fantasy_player->fantasyDefenseGame) ."\r\n";

            if ($isProjection) {
                if (count($fantasy_player->fantasyDefenseGameProjection) > 0) {
                    $fantasy_defense_game = $fantasy_player->fantasyDefenseGameProjection[0];
                }
            } else {
                if (count($fantasy_player->fantasyDefenseGame) > 0) {
                    $fantasy_defense_game = $fantasy_player->fantasyDefenseGame[0];
                }
            }
            if (! empty($fantasy_defense_game)) {
                //$fantasy_defense_game		= $fantasy_player->fantasyDefenseGame[0];
                $points_allowed = $fantasy_defense_game->points_allowed;
                $offensive_yards_allowed = $fantasy_defense_game->offensive_yards_allowed;
                $interceptions = $fantasy_defense_game->interceptions;
                $fumbles_recovered = $fantasy_defense_game->fumbles_recovered;
                $sacks = $fantasy_defense_game->sacks;
                $safeties = $fantasy_defense_game->safeties;
                $game_key = $fantasy_defense_game->game_key;
                $defensiveInterceptionTouchdownScores = self::getScores($game_key, $team, 'InterceptionReturnTouchdown', true);
                $defensiveFumbleTouchdownScores = self::getScores($game_key, $team, 'FumbleReturnTouchdown', true);

                $fantasy_points = (6 + ($points_allowed * -0.100)) + (6 + ($offensive_yards_allowed * -0.010)) +
                                                ($interceptions * 0.250) + ($fumbles_recovered * 0.250) +
                                                ($sacks * 0.100) + ($safeties * 0.500) + $defensiveInterceptionTouchdownScores['score'] + $defensiveFumbleTouchdownScores['score'];
            }
        }

        //Handle "ST"
        if (count($fantasy_player->teamGame) > 0 && $fantasy_player->position == 'ST') {
            $teamGame = $fantasy_player->teamGame[0];
            $game_key = $teamGame->game_key;
            $punt_return_yards = $teamGame->punt_return_yards;
            $kick_return_yards = $teamGame->kick_return_yards;

            //This is required because some scoring is related to individual plays and the amount of yards related on that play.
            //Note: TODO - Update to not use player_id but to pass the team key at the end. These Score records can be assigned
            //to  many different player_ids. So we need to get them by the "whole TEAM"
            $kickoffReturnTouchdown = self::getScores($game_key, $player_id, 'KickoffReturnTouchdown', $team = true);
            $puntReturnTouchdown = self::getScores($game_key, $player_id, 'PuntReturnTouchdown', $team = true);
            $blockedFieldGoalReturnTouchdown = self::getScores($game_key, $player_id, 'BlockedFieldGoalReturnTouchdown', $team = true);
            $blockedPuntReturnTouchdown = self::getScores($game_key, $player_id, 'BlockedPuntReturnTouchdown', $team = true);
            $fieldGoalReturnTouchdown = self::getScores($game_key, $player_id, 'FieldGoalReturnTouchdown', $team = true);

            $specialTeamsScores = $kickoffReturnTouchdown['score'] +
                                                    $puntReturnTouchdown['score'] +
                                                    $blockedFieldGoalReturnTouchdown['score'] +
                                                    $blockedPuntReturnTouchdown['score'] +
                                                    $fieldGoalReturnTouchdown['score'];

            $kickerScores = self::getPlayerScores($game_key, $team, 'K');
            $punterScores = self::getPlayerScores($game_key, $team, 'P');

            //KickOffTouchbacks Data for now
            $kickOffTouchbacksScores = self::getTeamGameScoreAndData($game_key, $team);

            $fantasy_points =
                        ($punt_return_yards * 0.01) +
                        ($kick_return_yards * 0.01) +
                        $specialTeamsScores['score'] +
                        $punterScores['score'] +
                        $kickerScores['score'] +
                        $kickOffTouchbacksScores['score'];
        }
        if ($game_key) {
            $transactions_data = [
                'fantasy_player_id'           => $fantasy_player->id,
                'week'           			  => $week,
                'season'           			  => $season,
                'season_type'       	      => $seasonType,
                'fantasy_points'     		  => $fantasy_points,
                'game_key'            		  => $game_key,
            ];
            if ($isProjection) {
                //Save the data
                \App\Models\FantasyPlayerProjectedGameFantasyPoint::updateOrCreate(
                    [
                        'week'=>$week,
                        'season'=>$season,
                        'season_type'=>$seasonType,
                        'fantasy_player_id'=>$fantasy_player->id,
                    ],
                    $transactions_data
                );
            } else {
                //Save the data
                \App\Models\FantasyPlayerGameFantasyPoint::updateOrCreate(
                    [
                        'week'=>$week,
                        'season'=>$season,
                        'season_type'=>$seasonType,
                        'fantasy_player_id'=>$fantasy_player->id,

                    ],
                    $transactions_data
                );
            }
        }
        unset($fantasy_player);	//Help to unload memory in the app.
        unset($transactions_data);	//Help to unload memory in the app.
        unset($fantasy_defense_game); //Help to unload memory in the app.

        //return the points value for this fantasy_player.
        return $fantasy_points;
    }

    public static function getFantasyTeamDataByWeek($season, $seasonType, $week, $teamId)
    {
        $offenseTeams = $kickerTeams = $qbTeams = $diffTeams = $specialTeams = [];
        $offenseArray = ['RB', 'QB', 'WR', 'TE', 'TQB'];
        $offense_points_acme = $kicker_points_acme = $def_points_acme = $spec_points_acme = 0;
        $active_player_offense_points_acme = $active_player_kicker_points_acme = $active_player_def_points_acme = $active_player_spec_points_acme = 0;
        $offense_points_acme_total = $kicker_points_acme_total = $def_points_acme_total = $spec_points_acme_total = 0;
        //$total_home_acme_points	=	0;
        $fantasy_team_details = FantasyTeam::where('id', $teamId)->first();
        //Get TeamQB Datastats
        $teamQB = FantasyTeamsRoster::selectRaw('p.bye_week,p.position,p.name,p.team,fd.opponent,is_st,team_qb,is_def,fd.home_or_away,s.away_team,s.home_team,s.away_score,s.home_score,fd.points_allowed,fantasy_teams_roster.fantasy_team_id as fantasy_team_id,fdgp.fantasy_points as predicted_score,p.player_id as player_id,s.quarter,s.date_time,sc.game_key as game_key,fd.id as fantasy_defense_game_id,pl.photo_url,t.wikipedia_logo_url,fantasy_teams_roster.active as active_player,p.id as fplayer_id,fantasy_teams_roster.bench as bench_player,pl.injury_status,pl.injury_body_part,pl.injury_start_date,t.full_name,t.primary_color,t.secondary_color,t.tertiary_color,fantasy_teams_roster.season_type as season_type,fantasy_teams_roster.week as roster_week')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_roster.fantasy_player_id')
                            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
                            ->leftJoin('team as t', 't.key', '=', 'p.team')
                            ->leftJoin('fantasy_defense_game as fd', function ($join) use ($season, $seasonType, $week) {
                                $join->on('fd.player_id', '=', 'p.player_id');
                                $join->where('fd.season', $season);
                                $join->where('fd.season_type', $seasonType);
                                $join->where('fd.week', $week);
                            })
                            ->leftJoin('schedule as sc', function ($join) use ($season, $seasonType, $week) {
                                $join->on(function ($query) {
                                    $query->on('sc.home_team', '=', 'p.team');
                                    $query->orOn('sc.away_team', '=', 'p.team');
                                });
                                $join->where('sc.season', $season);
                                $join->where('sc.season_type', $seasonType);
                                $join->where('sc.week', $week);
                                $join->orWhere(function ($query) {
                                    $query->where('sc.home_team', '=', 'pl.team')
                                          ->where('sc.away_team', '=', 'pl.team');
                                });
                            })
                            ->leftJoin('score as s', 's.game_key', '=', 'sc.game_key')
                            //->leftJoin('score as s','s.game_key','=','fd.game_key')
                            ->leftJoin('fantasy_defense_game_projection as fdgp', function ($join) {
                                $join->on('s.game_key', '=', 'fdgp.game_key');
                                $join->on('fd.player_id', '=', 'fdgp.player_id');
                            })
                            ->whereIn('fantasy_teams_roster.fantasy_team_id', $teamId)
                            ->where('fantasy_teams_roster.player_transaction_type_id', 1)
                            ->where('fantasy_teams_roster.team_qb', 1)
                            ->where('fantasy_teams_roster.week', $week)
                            ->where('fantasy_teams_roster.season', $season)
                            ->where('fantasy_teams_roster.season_type', $seasonType)
                            ->Where(function ($query) {
                                $query->orWhere('fantasy_teams_roster.active', 1)
                                          ->orWhere('fantasy_teams_roster.bench', 1);
                            })
                            ->get()->toArray();

        $rosterTeams = FantasyTeamsRoster::selectRaw('p.bye_week,p.position,p.name,p.team,pg.opponent,is_st,team_qb,is_def,pg.home_or_away,pg.passing_yards,
								pg.passing_touchdowns,pg.passing_interceptions,pg.rushing_yards,pg.rushing_touchdowns,pg.receiving_yards,pg.receiving_touchdowns,pg.punt_return_touchdowns ,pg.kick_return_touchdowns,pg.two_point_conversion_passes ,pg.two_point_conversion_runs ,pg.two_point_conversion_receptions,pg.fumbles_lost,pg.fantasy_points,
								pg.extra_points_made,pg.field_goals_made0to19 as fg1,pg.field_goals_made20to29 as fg2,pg.field_goals_made30to39 as fg3,pg.field_goals_made40to49 as fg4,
								pg.field_goals_made50_plus as fg5,pg.sacks,pg.interceptions,pg.fumbles_recovered,pg.safeties,pg.defensive_touchdowns,pg.special_teams_touchdowns,pg.kick_return_yards,
								pg.kick_return_fair_catches,pg.punt_return_yards,pg.punt_touchbacks,s.quarter,s.date_time,s.away_team,s.home_team,s.away_score,s.home_score,
								fantasy_teams_roster.fantasy_team_id as fantasy_team_id,pgp.fantasy_points as predicted_score,p.player_id as player_id,p.id as fplayer_id,sc.game_key as game_key,pg.extra_points_attempted,pg.id as player_game_id,pl.photo_url,t.wikipedia_logo_url,fantasy_teams_roster.active as active_player,fantasy_teams_roster.bench as bench_player,pl.injury_status,pl.injury_body_part,pl.injury_start_date,t.full_name,t.primary_color,t.secondary_color,t.tertiary_color,fantasy_teams_roster.season_type as season_type,fantasy_teams_roster.week as roster_week')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_roster.fantasy_player_id')
                            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
                            ->leftJoin('team as t', 't.key', '=', 'p.team')
                            ->leftJoin('player_game as pg', function ($join) use ($season, $seasonType, $week) {
                                $join->on('pg.player_id', '=', 'p.player_id');
                                $join->where('pg.season', $season);
                                $join->where('pg.season_type', $seasonType);
                                $join->where('pg.week', $week);
                            })
                            ->leftJoin('schedule as sc', function ($join) use ($season, $seasonType, $week) {
                                $join->on(function ($query) {
                                    $query->on('sc.home_team', '=', 'p.team');
                                    $query->orOn('sc.away_team', '=', 'p.team');
                                });
                                $join->where('sc.season', $season);
                                $join->where('sc.season_type', $seasonType);
                                $join->where('sc.week', $week);
                                $join->orWhere(function ($query) {
                                    $query->where('sc.home_team', '=', 'pl.team')
                                          ->where('sc.away_team', '=', 'pl.team');
                                });
                            })
                            ->leftJoin('score as s', 's.game_key', '=', 'sc.game_key')
                        //	->leftJoin('score as s','s.game_key2','=','pg.game_key')
                            ->leftJoin('player_game_projection as pgp', function ($join) {
                                $join->on('s.game_key', '=', 'pgp.game_key');
                                $join->on('pg.player_id', '=', 'pgp.player_id');
                            })
                            ->whereIn('fantasy_teams_roster.fantasy_team_id', $teamId)
                            ->where('fantasy_teams_roster.week', $week)
                            ->where('fantasy_teams_roster.season', $season)
                            ->where('fantasy_teams_roster.season_type', $seasonType)
                            ->where('fantasy_teams_roster.is_def', '<>', 1)
                            ->where('fantasy_teams_roster.is_st', '<>', 1)
                            ->where('fantasy_teams_roster.team_qb', '<>', 1)
                            ->where('fantasy_teams_roster.player_transaction_type_id', 1)
                           // ->where('fantasy_teams_roster.active',1)
                            ->Where(function ($query) {
                                $query->orWhere('fantasy_teams_roster.active', 1)
                                          ->orWhere('fantasy_teams_roster.bench', 1);
                            })
                            ->get()->toArray();
        if ($teamQB) {
            foreach ($teamQB as $k => $qb) {
                //Update position
                $teamQB[$k]['position'] = 'TQB';

                //Load data based on QB players that played on the team for the specific game we need data for.
                $team = $qb['team'];
                $gameKey = $qb['game_key'];
                //dd($team, $gameKey);
                $teamQBPlayerGame = self::getTqbPlayergame($team, $season, $seasonType, $week, $gameKey, $yearly = false);

                $mergeTeamQB = array_merge($teamQBPlayerGame, $teamQB[$k]);
                //dd($mergeTeamQB);
                $rosterTeams = array_merge([$mergeTeamQB], $rosterTeams);
            }
        }
        //dd($rosterTeams);
        if (! empty($rosterTeams)) {
            foreach ($rosterTeams as $key=>$val) {
                $val['score_object'] = self::getScoreObject($val['game_key'], $seasonType, $season, $week);
                $val['schedule_date_time'] = date('D H:i', strtotime($val['date_time']));
                $offense_points_acme = 0;
                $active_player_offense_points_acme = 0;
                $isTeamQbItem = $val['position'] == 'TQB';
                if ($isTeamQbItem) {
                    $offense_points_acme = (! empty($val['fantasy_points_acme'])) ? number_format($val['fantasy_points_acme'], 2) : 0;
                    if ($val['active_player'] == 1) {
                        $active_player_offense_points_acme = $offense_points_acme;
                    }
                } elseif (isset($val['player_game_id']) && $val['player_game_id'] != null) {
                    $touchdownPass = self::getScores($val['game_key'], $val['player_id'], 'PassingTouchdown');
                    $touchdownRush = self::getScores($val['game_key'], $val['player_id'], 'RushingTouchdown');
                    $touchdownRec = self::getScores($val['game_key'], $val['player_id'], 'ReceivingTouchdown');
                    $touchdownPassScores = $touchdownPass['score'];
                    $touchdownRushScores = $touchdownRush['score'];
                    $touchdownRecScores = $touchdownRec['score'];

                    $offense_points_acme = ($val['passing_yards'] * 0.013) + ($val['rushing_yards'] * 0.025) + ($val['receiving_yards'] * 0.025) + ($val['passing_interceptions'] * (-0.20)) +
                                                  ($val['fumbles_lost'] * (-0.20)) + ($val['two_point_conversion_passes'] * 0.100) + ($val['two_point_conversion_runs'] * 0.250) +
                                                  ($val['two_point_conversion_receptions'] * 0.250) + $touchdownPassScores + $touchdownRushScores + $touchdownRecScores;
                    $offense_points_acme = number_format($offense_points_acme, 2);
                    if ($val['active_player'] == 1) {
                        $active_player_offense_points_acme = $offense_points_acme;
                        // $active_player_offense_points_acme	    = ($val['passing_yards']*0.013)+($val['rushing_yards']*0.025)+($val['receiving_yards']*0.025)+($val['passing_interceptions']*(-0.20))+
                    // 							  ($val['fumbles_lost']*(-0.20))+($val['two_point_conversion_passes']*0.100)+($val['two_point_conversion_runs']*0.250)+
                    // 							  ($val['two_point_conversion_receptions']*0.250)+$touchdownPassScores+$touchdownRushScores+$touchdownRecScores;
                    }
                    $val['ret_td'] = $val['punt_return_touchdowns'] + $val['kick_return_touchdowns'];
                    $val['two_pt'] = $val['two_point_conversion_passes'] + $val['two_point_conversion_runs'] + $val['two_point_conversion_receptions'];
                }
                //$active_player_offense_points_acme	= number_format($active_player_offense_points_acme,2);
                $val['statistics'] = '';
                $offense_points_acme_total += $active_player_offense_points_acme;
                $val['fantasy_points_acme'] = $offense_points_acme;

                if ($val['home_or_away'] == 'AWAY') {
                    $val['opponent'] = '@'.$val['opponent'];
                }
                if ($val['away_team'] != '' || $val['home_team'] != '') {
                    $val['status'] = $val['away_team'].' '.$val['away_score'].' @ '.$val['home_team'].' '.$val['home_score'].' '.$val['score_object']->quarter.' '.$val['score_object']->time_remaining;
                }

                if ($val['position'] == 'TQB') {
                    if ($val['passing_yards']) {
                        $val['statistics'] .= $val['passing_yards'].' PaYd, ';
                    }
                    if ($val['passing_touchdowns']) {
                        $val['statistics'] .= $val['passing_touchdowns'].' PaTD('.implode(',', array_column($val['tdPass'], 'length')).'), ';
                    }
                    if ($val['passing_interceptions']) {
                        $val['statistics'] .= $val['passing_interceptions'].' Int, ';
                    }
                    if ($val['rushing_yards']) {
                        $val['statistics'] .= $val['rushing_yards'].' RuYd, ';
                    }
                    if ($val['rushing_touchdowns']) {
                        $val['statistics'] .= $val['rushing_touchdowns'].' RuTD('.implode(',', array_column($val['tdRush'], 'length')).'), ';
                    }
                    if ($val['fumbles_lost']) {
                        $val['statistics'] .= $val['fumbles_lost'].' Fum, ';
                    }
                    if (isset($val['two_pt']) && $val['two_pt'] > 0) {
                        $val['statistics'] .= $val['two_pt'].' 2Pts, ';
                    }
                }

                if (in_array($val['position'], ['RB', 'WR', 'TE'])) {
                    if ($val['rushing_yards']) {
                        $val['statistics'] .= $val['rushing_yards'].' RuYd, ';
                    }
                    if ($val['rushing_touchdowns']) {
                        $val['statistics'] .= $val['rushing_touchdowns'].' RuTD('.implode(',', array_column($touchdownRush['plays'], 'length')).'), ';
                    }
                    if ($val['receiving_yards'] > 0) {
                        $val['statistics'] .= $val['receiving_yards'].' ReYd, ';
                    }
                    if ($val['receiving_touchdowns']) {
                        $val['statistics'] .= $val['receiving_touchdowns'].' ReTD('.implode(',', array_column($touchdownRec['plays'], 'length')).'), ';
                    }
                    if ($val['fumbles_lost']) {
                        $val['statistics'] .= $val['fumbles_lost'].' Fum, ';
                    }
                    if (isset($val['two_pt']) && $val['two_pt'] > 0) {
                        $val['statistics'] .= $val['two_pt'].' 2Pts, ';
                    }
                }

                //				if($val['position'] == 'WR'){
                //					if($val['receiving_yards'])
//                    	$val['statistics']	.=	$val['receiving_yards'].' ReYd, ';
//                    if($val['receiving_touchdowns'])
//                    	$val['statistics']	.= $val['receiving_touchdowns'].' ReTD, ';
//                    if($val['rushing_yards'])
//                    	$val['statistics']	.=	$val['rushing_yards'].' RuYd, ';
//                    if($val['rushing_touchdowns'])
//                    	$val['statistics']	.= $val['rushing_touchdowns'].' RuTD, ';
//                    if($val['fumbles_lost'])
                //						$val['statistics'] .= $val['fumbles_lost'].' Fum, ';
                //				}
//
                //				if($val['position'] == 'TE'){
//                    if($val['receiving_yards'])
//                    	$val['statistics']	.=	$val['receiving_yards'].' ReYd, ';
//                    if($val['receiving_touchdowns'])
//                    	$val['statistics']	.= $val['receiving_touchdowns'].' ReTD ';
//                    if($val['rushing_yards'])
//                    	$val['statistics']	.= $val['rushing_yards'].' RuYd, ';
//                    if($val['rushing_touchdowns'])
//                    	$val['statistics']	.= $val['rushing_touchdowns'].' RuTD, ';
//                    if($val['fumbles_lost'])
                //						$val['statistics'] .= $val['fumbles_lost'].' Fum, ';
                //				}

                //Strip trailing ,  (comma and space)
                $val['statistics'] = rtrim($val['statistics'], ", \t\n");

                $predicted_score = 0;
                if ($val['predicted_score'] > 0) {
                    $predicted_score = $val['predicted_score'];
                }
                $val['predicted_score'] = $predicted_score;

                if (in_array($val['position'], $offenseArray)) {
                    $offenseTeams[] = $val;
                }

                // if($isTeamQbItem){
                // 	array_unshift($offenseTeams,$mergeTeamQB);
                //                // $offenseTeams[]	=	$val;
                //             }

                if ($val['position'] == 'K') {
                    $kicker_points_acme = 0;
                    $sumValue = $val['fg1'] + $val['fg2'] + $val['fg3'] + $val['fg4'] + $val['fg5'];
                    $val['statistics'] = '';
                    if ($val['player_game_id'] != null) {
                        $fieldGoal = self::getScores($val['game_key'], $val['player_id'], 'FieldGoalMade');
                        $fieldGoalMissed = self::getScores($val['game_key'], $val['player_id'], 'FieldGoalMissed');
                        $fieldGoalScores = $fieldGoal['score'];
                        $kicker_points_acme = ($val['extra_points_made'] * 0.530) +
                                                        (($val['extra_points_attempted'] - $val['extra_points_made']) * -0.200) +
                                                        $fieldGoalScores +
                                                        $fieldGoalMissed['score'];

                        if ($fieldGoal['score'] > 0) {
                            $val['statistics'] .= ' FG('.implode(', ', array_column($fieldGoal['plays'], 'length')).'), ';
                        }
                        if ($fieldGoalMissed['score'] < 0) {
                            $val['statistics'] .= ' Miss('.implode(', ', array_column($fieldGoalMissed['plays'], 'length')).'), ';
                        }
                        if ($val['extra_points_made']) {
                            $val['statistics'] .= $val['extra_points_made'].' XP, ';
                        }
                        if ($missed = $val['extra_points_attempted'] - $val['extra_points_made']) {
                            $val['statistics'] .= $missed.'MXP, ';
                        }

                        $val['statistics'] = rtrim($val['statistics'], ", \t\n");

                        $kicker_points_acme = number_format($kicker_points_acme, 2);
                        if ($val['active_player'] == 1) {
                            $active_player_kicker_points_acme = $kicker_points_acme;
                        }
                    }
                    $val['fantasy_points_acme'] = $kicker_points_acme;
                    $kickerTeams[] = $val;
                    $kicker_points_acme_total += $active_player_kicker_points_acme;
                }
            }
        }

        $defTeams = FantasyTeamsRoster::selectRaw('p.bye_week,p.position,p.name,p.team,fd.opponent,is_st,team_qb,is_def,fd.home_or_away,fd.sacks,fd.interceptions,fd.fumbles_recovered,fd.safeties,fd.defensive_touchdowns,fd.special_teams_touchdowns,fd.fantasy_points,s.away_team,s.home_team,s.away_score,s.home_score,fd.points_allowed,fantasy_teams_roster.fantasy_team_id as fantasy_team_id,fdgp.fantasy_points as predicted_score,p.player_id as player_id,s.quarter,s.date_time,sc.game_key as game_key,fd.offensive_yards_allowed,fd.id as fantasy_defense_game_id,pl.photo_url,t.wikipedia_logo_url,fantasy_teams_roster.active as active_player,p.id as fplayer_id,fantasy_teams_roster.bench as bench_player,pl.injury_status,pl.injury_body_part,pl.injury_start_date,t.full_name,t.primary_color,t.secondary_color,t.tertiary_color,fantasy_teams_roster.season_type as season_type,fantasy_teams_roster.week as roster_week')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_roster.fantasy_player_id')
                            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
                            ->leftJoin('team as t', 't.key', '=', 'p.team')
                            ->leftJoin('fantasy_defense_game as fd', function ($join) use ($season, $seasonType, $week) {
                                $join->on('fd.player_id', '=', 'p.player_id');
                                $join->where('fd.season', $season);
                                $join->where('fd.season_type', $seasonType);
                                $join->where('fd.week', $week);
                            })
                            //->leftJoin('score as s','s.game_key','=','fd.game_key')
                            ->leftJoin('schedule as sc', function ($join) use ($season, $seasonType, $week) {
                                $join->on(function ($query) {
                                    $query->on('sc.home_team', '=', 'p.team');
                                    $query->orOn('sc.away_team', '=', 'p.team');
                                });
                                $join->where('sc.season', $season);
                                $join->where('sc.season_type', $seasonType);
                                $join->where('sc.week', $week);
                                $join->orWhere(function ($query) {
                                    $query->where('sc.home_team', '=', 'pl.team')
                                          ->where('sc.away_team', '=', 'pl.team');
                                });
                            })
                            ->leftJoin('score as s', 's.game_key', '=', 'sc.game_key')
                            ->leftJoin('fantasy_defense_game_projection as fdgp', function ($join) {
                                $join->on('s.game_key', '=', 'fdgp.game_key');
                                $join->on('fd.player_id', '=', 'fdgp.player_id');
                            })
                            ->whereIn('fantasy_teams_roster.fantasy_team_id', $teamId)
                            ->where('fantasy_teams_roster.player_transaction_type_id', 1)
                            ->where('fantasy_teams_roster.is_def', 1)
                            ->where('fantasy_teams_roster.week', $week)
                            ->where('fantasy_teams_roster.season', $season)
                            ->where('fantasy_teams_roster.season_type', $seasonType)
                            ->where(function ($query) {
                                $query->orWhere('fantasy_teams_roster.active', 1)
                                          ->orWhere('fantasy_teams_roster.bench', 1);
                            })
                            ->get()->toArray();

        if (! empty($defTeams)) {
            foreach ($defTeams as $dkey=>$dval) {
                $dval['score_object'] = self::getScoreObject($dval['game_key'], $seasonType, $season, $week);
                $dval['schedule_date_time'] = date('D H:i', strtotime($dval['date_time']));
                //$active_player_def_points_acme = 0;
                $def_points_acme = 0;
                $predicted_score = 0;
                if ($dval['predicted_score'] > 0) {
                    $predicted_score = $dval['predicted_score'];
                }
                $dval['predicted_score'] = $predicted_score;
                if ($dval['home_or_away'] == 'AWAY') {
                    $dval['opponent'] = '@'.$dval['opponent'];
                }
                if ($dval['away_team'] != '' || $dval['home_team'] != '') {
                    $dval['status'] = $dval['away_team'].' '.$dval['away_score'].' @ '.$dval['home_team'].' '.$dval['home_score'].' '.$dval['score_object']->quarter.' '.$dval['score_object']->time_remaining;
                }

                $dval['statistics'] = '';
                if ($dval['points_allowed']) {
                    $dval['statistics'] .= $dval['points_allowed'].' Pts, ';
                }
                if ($dval['sacks']) {
                    $dval['statistics'] .= $dval['sacks'].' Sck, ';
                }
                if ($dval['interceptions']) {
                    $dval['statistics'] .= $dval['interceptions'].' Int, ';
                }
                if ($dval['fumbles_recovered']) {
                    $dval['statistics'] .= $dval['fumbles_recovered'].' Fum, ';
                }

                if ($dval['fantasy_defense_game_id'] != null) {
                    $defensiveInterceptionTouchdownScores = self::getScores($dval['game_key'], $dval['team'], 'InterceptionReturnTouchdown', true);
                    $defensiveFumbleTouchdownScores = self::getScores($dval['game_key'], $dval['team'], 'FumbleReturnTouchdown', true);

                    if ($defensiveInterceptionTouchdownScores['score'] > 0) {
                        $dval['statistics'] .= count($defensiveInterceptionTouchdownScores['plays']).' DIntTD('.implode(',', array_column($defensiveInterceptionTouchdownScores['plays'], 'length')).'), ';
                    }

                    if ($defensiveFumbleTouchdownScores['score'] > 0) {
                        $dval['statistics'] .= count($defensiveFumbleTouchdownScores['plays']).' DFumTD('.implode(',', array_column($defensiveFumbleTouchdownScores['plays'], 'length')).'), ';
                    }

                    $def_points_acme = (6 + ($dval['points_allowed'] * -0.100)) + (6 + ($dval['offensive_yards_allowed'] * -0.010)) +
                                                        ($dval['interceptions'] * 0.250) + ($dval['fumbles_recovered'] * 0.250) +
                                                        ($dval['sacks'] * 0.100) + ($dval['safeties'] * 0.500) + $defensiveInterceptionTouchdownScores['score'] + $defensiveFumbleTouchdownScores['score'];

                    //					if($dval['active_player']==1){
//
//					$active_player_def_points_acme	=	(6 + ($dval['points_allowed'] * -0.100) ) + (6 + ($dval['offensive_yards_allowed'] * -0.010)) +
//														($dval['interceptions'] * 0.250) + ($dval['fumbles_recovered'] * 0.250) +
//														($dval['sacks'] * 0.100) + ($dval['safeties'] * 0.500) + $defensiveTouchdownScores;
//
//					}
                }

                $dval['statistics'] = rtrim($dval['statistics'], ", \t\n");
                $def_points_acme = number_format($def_points_acme, 2);
                if ($dval['active_player'] == 1) {

                //$active_player_def_points_acme	= 	number_format($active_player_def_points_acme,2);
                    $def_points_acme_total = $def_points_acme;
                }
                $dval['fantasy_points_acme'] = $def_points_acme;
                $diffTeams[] = $dval;
            }
        }

        $specTeams = FantasyTeamsRoster::selectRaw('p.bye_week,p.position,p.name,p.team,fd.opponent,is_st,team_qb,is_def,fd.home_or_away,fd.sacks,fd.interceptions,fd.fumbles_recovered,fd.safeties,fd.defensive_touchdowns,fd.special_teams_touchdowns,fd.fantasy_points,s.away_team,s.home_team,s.away_score,s.home_score,fd.points_allowed,fantasy_teams_roster.fantasy_team_id as fantasy_team_id,fdgp.fantasy_points as predicted_score,p.player_id as player_id,s.quarter,s.date_time,sc.game_key as game_key,fd.punt_return_yards,fd.kick_return_yards,fd.id as fantasy_defense_game_id,pl.photo_url,t.wikipedia_logo_url,fantasy_teams_roster.active as active_player,p.id as fplayer_id,fantasy_teams_roster.bench as bench_player,pl.injury_status,pl.injury_body_part,pl.injury_start_date,t.full_name,t.primary_color,t.secondary_color,t.tertiary_color,fantasy_teams_roster.season_type as season_type,fantasy_teams_roster.week as roster_week')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_roster.fantasy_player_id')
                            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
                            ->leftJoin('team as t', 't.key', '=', 'p.team')
                            ->leftJoin('fantasy_defense_game as fd', function ($join) use ($season, $seasonType, $week) {
                                $join->on('fd.player_id', '=', 'p.player_id');
                                $join->where('fd.season', $season);
                                $join->where('fd.season_type', $seasonType);
                                $join->where('fd.week', $week);
                            })
                            ->leftJoin('schedule as sc', function ($join) use ($season, $seasonType, $week) {
                                $join->on(function ($query) {
                                    $query->on('sc.home_team', '=', 'p.team');
                                    $query->orOn('sc.away_team', '=', 'p.team');
                                });
                                $join->where('sc.season', $season);
                                $join->where('sc.season_type', $seasonType);
                                $join->where('sc.week', $week);
                                $join->orWhere(function ($query) {
                                    $query->where('sc.home_team', '=', 'pl.team')
                                          ->where('sc.away_team', '=', 'pl.team');
                                });
                            })
                            ->leftJoin('score as s', 's.game_key', '=', 'sc.game_key')
                            //->leftJoin('score as s','s.game_key','=','fd.game_key')
                            ->leftJoin('fantasy_defense_game_projection as fdgp', function ($join) {
                                $join->on('s.game_key', '=', 'fdgp.game_key');
                                $join->on('fd.player_id', '=', 'fdgp.player_id');
                            })
                            ->whereIn('fantasy_teams_roster.fantasy_team_id', $teamId)
                            ->where('fantasy_teams_roster.player_transaction_type_id', 1)
                            ->where('fantasy_teams_roster.is_st', 1)
                            ->where('fantasy_teams_roster.week', $week)
                            ->where('fantasy_teams_roster.season', $season)
                            ->where('fantasy_teams_roster.season_type', $seasonType)
                            ->Where(function ($query) {
                                $query->Orwhere('fantasy_teams_roster.active', 1)
                                          ->Orwhere('fantasy_teams_roster.bench', 1);
                            })
                            ->get()->toArray();
        if (! empty($specTeams)) {
            foreach ($specTeams as $skey=>$sval) {
                $spec_points_acme = 0;
                $sval['score_object'] = self::getScoreObject($sval['game_key'], $seasonType, $season, $week);
                $sval['schedule_date_time'] = date('D H:i', strtotime($sval['date_time']));
                $predicted_score = 0;
                if ($sval['predicted_score'] > 0) {
                    $predicted_score = $sval['predicted_score'];
                }
                $sval['predicted_score'] = $predicted_score;
                $sval['position'] = 'ST';
                if ($sval['home_or_away'] == 'AWAY') {
                    $sval['opponent'] = '@'.$sval['opponent'];
                }
                if ($sval['away_team'] != '' || $sval['home_team'] != '') {
                    $sval['status'] = $sval['away_team'].' '.$sval['away_score'].' @ '.$sval['home_team'].' '.$sval['home_score'].' '.$sval['score_object']->quarter.' '.$sval['score_object']->time_remaining;
                }

                $sval['statistics'] = '';
                if ($sval['kick_return_yards'] > 0) {
                    $sval['statistics'] .= $sval['kick_return_yards'].' KRYd, ';
                }

                if ($sval['punt_return_yards'] > 0) {
                    $sval['statistics'] .= $sval['punt_return_yards'].' PRYd, ';
                }

                $fantasy_points_acme = 0;
                if ($sval['fantasy_defense_game_id'] != null) {
                    $kickoffReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'KickoffReturnTouchdown');
                    $puntReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'PuntReturnTouchdown');
                    $blockedFieldGoalReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'BlockedFieldGoalReturnTouchdown');
                    $blockedPuntReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'BlockedPuntReturnTouchdown');
                    $fieldGoalReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'FieldGoalReturnTouchdown');

                    $specialTeamsScores = $kickoffReturnTouchdown['score'] +
                                                            $puntReturnTouchdown['score'] +
                                                            $blockedFieldGoalReturnTouchdown['score'] +
                                                            $blockedPuntReturnTouchdown['score'] +
                                                            $fieldGoalReturnTouchdown['score'];

                    $kickerScores = self::getPlayerScores($sval['game_key'], $sval['team'], 'K');
                    $punterScores = self::getPlayerScores($sval['game_key'], $sval['team'], 'P');

                    //KickOffTouchbacks Data for now
                    $kickOffTouchbacksScores = self::getTeamGameScoreAndData($sval['game_key'], $sval['team']);

                    //If score is greater than 0, then we have data, show it on statistics line.
                    if ($kickOffTouchbacksScores['score'] > 0) {
                        $sval['statistics'] .= $kickOffTouchbacksScores['data']['opponent_kickoff_touchbacks'].'KTb, ';
                    }

                    //If score is greater than 0, then we have data, show it on statistics line.
                    if ($kickerScores['score'] > 0) {
                        foreach ($kickerScores['plays'] as $stScore) {
                            if ($stScore['punt_touchbacks'] > 0) {
                                $sval['statistics'] .= $stScore['punt_touchbacks'].'PTb, ';
                            }
                        }
                    }

                    $spec_points_acme =
                                                            ($sval['punt_return_yards'] * 0.015) +
                                                            ($sval['kick_return_yards'] * 0.015) +
                                                            $specialTeamsScores['score'] +
                                                            $punterScores['score'] +
                                                            $kickerScores['score'] +
                                                            $kickOffTouchbacksScores['score'];
                    if ($sval['active_player'] == 1) {
                        $active_player_spec_points_acme = $spec_points_acme;
                    }
                }

                $sval['statistics'] = rtrim($sval['statistics'], ", \t\n");

                $active_player_spec_points_acme = number_format($active_player_spec_points_acme, 2);
                $spec_points_acme = number_format($spec_points_acme, 2);
                $spec_points_acme_total += $active_player_spec_points_acme;
                $sval['fantasy_points_acme'] = $spec_points_acme;
                $specialTeams[] = $sval;
            }
        }

        // $total_home_acme_points					=	$offense_points_acme_total  + $kicker_points_acme_total + $def_points_acme_total + $spec_points_acme_total;
        $total_home_acme_points = $offense_points_acme_total + $kicker_points_acme_total + $def_points_acme_total + $spec_points_acme_total;

        $response['offenseTeams'] = self::sortTeamArray($offenseTeams);
        $response['kickerTeams'] = $kickerTeams;
        $response['diffTeams'] = $diffTeams;
        $response['specialTeams'] = $specialTeams;
        $response['total_home_acme_points'] = $total_home_acme_points;
        $response['team_name'] = $fantasy_team_details->name;

        return $response;
    }

    public static function getFantasyPlayerDataByWeek($season, $seasonType, $week, $playersId)
    {
        $offenseTeams = $kickerTeams = $qbTeams = $diffTeams = $specialTeams = [];
        $offenseArray = ['RB', 'QB', 'WR', 'TE', 'TQB'];
        $offense_points_acme = $kicker_points_acme = $def_points_acme = $spec_points_acme = 0;
        $active_player_offense_points_acme = $active_player_kicker_points_acme = $active_player_def_points_acme = $active_player_spec_points_acme = 0;
        $offense_points_acme_total = $kicker_points_acme_total = $def_points_acme_total = $spec_points_acme_total = 0;
        //$total_home_acme_points	=	0;
        //$fantasy_team_details	= FantasyTeam::where('id',$teamId)->first();
        //Get TeamQB Datastats
        $teamQB = FantasyTeamsRoster::selectRaw('p.bye_week,p.position,p.name,p.team,fd.opponent,is_st,team_qb,is_def,fd.home_or_away,s.away_team,s.home_team,s.away_score,s.home_score,fd.points_allowed,fantasy_teams_roster.fantasy_team_id as fantasy_team_id,fdgp.fantasy_points as predicted_score,p.player_id as player_id,s.quarter,s.date_time,sc.game_key as game_key,fd.id as fantasy_defense_game_id,pl.photo_url,t.wikipedia_logo_url,fantasy_teams_roster.active as active_player,p.id as fplayer_id,fantasy_teams_roster.bench as bench_player,pl.injury_status,pl.injury_body_part,pl.injury_start_date,t.full_name,t.primary_color,t.secondary_color,t.tertiary_color,fantasy_teams_roster.season_type as season_type,fantasy_teams_roster.week as roster_week')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_roster.fantasy_player_id')
                            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
                            ->leftJoin('team as t', 't.key', '=', 'p.team')
                            ->leftJoin('fantasy_defense_game as fd', function ($join) use ($season, $seasonType, $week) {
                                $join->on('fd.player_id', '=', 'p.player_id');
                                $join->where('fd.season', $season);
                                $join->where('fd.season_type', $seasonType);
                                $join->where('fd.week', $week);
                            })
                            ->leftJoin('schedule as sc', function ($join) use ($season, $seasonType, $week) {
                                $join->on(function ($query) {
                                    $query->on('sc.home_team', '=', 'p.team');
                                    $query->orOn('sc.away_team', '=', 'p.team');
                                });
                                $join->where('sc.season', $season);
                                $join->where('sc.season_type', $seasonType);
                                $join->where('sc.week', $week);
                                $join->orWhere(function ($query) {
                                    $query->where('sc.home_team', '=', 'pl.team')
                                          ->where('sc.away_team', '=', 'pl.team');
                                });
                            })
                            ->leftJoin('score as s', 's.game_key', '=', 'sc.game_key')
                            //->leftJoin('score as s','s.game_key','=','fd.game_key')
                            ->leftJoin('fantasy_defense_game_projection as fdgp', function ($join) {
                                $join->on('s.game_key', '=', 'fdgp.game_key');
                                $join->on('fd.player_id', '=', 'fdgp.player_id');
                            })
                            ->whereIn('fantasy_teams_roster.fantasy_player_id', $playersId)
                            ->where('fantasy_teams_roster.player_transaction_type_id', 1)
                            ->where('fantasy_teams_roster.team_qb', 1)
                            ->where('fantasy_teams_roster.week', $week)
                            ->where('fantasy_teams_roster.season', $season)
                            ->where('fantasy_teams_roster.season_type', $seasonType)
                            ->Where(function ($query) {
                                $query->orWhere('fantasy_teams_roster.active', 1)
                                          ->orWhere('fantasy_teams_roster.bench', 1);
                            })
                            ->get()->toArray();

        $rosterTeams = FantasyTeamsRoster::selectRaw('p.bye_week,p.position,p.name,p.team,pg.opponent,is_st,team_qb,is_def,pg.home_or_away,pg.passing_yards,
								pg.passing_touchdowns,pg.passing_interceptions,pg.rushing_yards,pg.rushing_touchdowns,pg.receiving_yards,pg.receiving_touchdowns,pg.punt_return_touchdowns ,pg.kick_return_touchdowns,pg.two_point_conversion_passes ,pg.two_point_conversion_runs ,pg.two_point_conversion_receptions,pg.fumbles_lost,pg.fantasy_points,
								pg.extra_points_made,pg.field_goals_made0to19 as fg1,pg.field_goals_made20to29 as fg2,pg.field_goals_made30to39 as fg3,pg.field_goals_made40to49 as fg4,
								pg.field_goals_made50_plus as fg5,pg.sacks,pg.interceptions,pg.fumbles_recovered,pg.safeties,pg.defensive_touchdowns,pg.special_teams_touchdowns,pg.kick_return_yards,
								pg.kick_return_fair_catches,pg.punt_return_yards,pg.punt_touchbacks,s.quarter,s.date_time,s.away_team,s.home_team,s.away_score,s.home_score,
								fantasy_teams_roster.fantasy_team_id as fantasy_team_id,pgp.fantasy_points as predicted_score,p.player_id as player_id,p.id as fplayer_id,sc.game_key as game_key,pg.extra_points_attempted,pg.id as player_game_id,pl.photo_url,t.wikipedia_logo_url,fantasy_teams_roster.active as active_player,fantasy_teams_roster.bench as bench_player,pl.injury_status,pl.injury_body_part,pl.injury_start_date,t.full_name,t.primary_color,t.secondary_color,t.tertiary_color,fantasy_teams_roster.season_type as season_type,fantasy_teams_roster.week as roster_week')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_roster.fantasy_player_id')
                            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
                            ->leftJoin('team as t', 't.key', '=', 'p.team')
                            ->leftJoin('player_game as pg', function ($join) use ($season, $seasonType, $week) {
                                $join->on('pg.player_id', '=', 'p.player_id');
                                $join->where('pg.season', $season);
                                $join->where('pg.season_type', $seasonType);
                                $join->where('pg.week', $week);
                            })
                            ->leftJoin('schedule as sc', function ($join) use ($season, $seasonType, $week) {
                                $join->on(function ($query) {
                                    $query->on('sc.home_team', '=', 'p.team');
                                    $query->orOn('sc.away_team', '=', 'p.team');
                                });
                                $join->where('sc.season', $season);
                                $join->where('sc.season_type', $seasonType);
                                $join->where('sc.week', $week);
                                $join->orWhere(function ($query) {
                                    $query->where('sc.home_team', '=', 'pl.team')
                                          ->where('sc.away_team', '=', 'pl.team');
                                });
                            })
                            ->leftJoin('score as s', 's.game_key', '=', 'sc.game_key')
                        //	->leftJoin('score as s','s.game_key2','=','pg.game_key')
                            ->leftJoin('player_game_projection as pgp', function ($join) {
                                $join->on('s.game_key', '=', 'pgp.game_key');
                                $join->on('pg.player_id', '=', 'pgp.player_id');
                            })
                            ->whereIn('fantasy_teams_roster.fantasy_player_id', $playersId)
                            ->where('fantasy_teams_roster.week', $week)
                            ->where('fantasy_teams_roster.season', $season)
                            ->where('fantasy_teams_roster.season_type', $seasonType)
                            ->where('fantasy_teams_roster.is_def', '<>', 1)
                            ->where('fantasy_teams_roster.is_st', '<>', 1)
                            ->where('fantasy_teams_roster.team_qb', '<>', 1)
                            ->where('fantasy_teams_roster.player_transaction_type_id', 1)
                           // ->where('fantasy_teams_roster.active',1)
                            ->Where(function ($query) {
                                $query->orWhere('fantasy_teams_roster.active', 1)
                                          ->orWhere('fantasy_teams_roster.bench', 1);
                            })
                            ->get()->toArray();
        if ($teamQB) {
            foreach ($teamQB as $k => $qb) {
                //Update position
                $teamQB[$k]['position'] = 'TQB';

                //Load data based on QB players that played on the team for the specific game we need data for.
                $team = $qb['team'];
                $gameKey = $qb['game_key'];
                //dd($team, $gameKey);
                $teamQBPlayerGame = self::getTqbPlayergame($team, $season, $seasonType, $week, $gameKey, $yearly = false);

                $mergeTeamQB = array_merge($teamQBPlayerGame, $teamQB[$k]);
                //dd($mergeTeamQB);
                $rosterTeams = array_merge([$mergeTeamQB], $rosterTeams);
            }
        }
        //dd($rosterTeams);
        if (! empty($rosterTeams)) {
            foreach ($rosterTeams as $key=>$val) {
                $val['score_object'] = self::getScoreObject($val['game_key'], $seasonType, $season, $week);
                $val['schedule_date_time'] = date('D H:i', strtotime($val['date_time']));
                $offense_points_acme = 0;
                $active_player_offense_points_acme = 0;
                $isTeamQbItem = $val['position'] == 'TQB';
                if ($isTeamQbItem) {
                    $offense_points_acme = number_format($val['fantasy_points_acme'], 2);
                    if ($val['active_player'] == 1) {
                        $active_player_offense_points_acme = $offense_points_acme;
                    }
                } elseif (isset($val['player_game_id']) && $val['player_game_id'] != null) {
                    $touchdownPass = self::getScores($val['game_key'], $val['player_id'], 'PassingTouchdown');
                    $touchdownRush = self::getScores($val['game_key'], $val['player_id'], 'RushingTouchdown');
                    $touchdownRec = self::getScores($val['game_key'], $val['player_id'], 'ReceivingTouchdown');
                    $touchdownPassScores = $touchdownPass['score'];
                    $touchdownRushScores = $touchdownRush['score'];
                    $touchdownRecScores = $touchdownRec['score'];

                    $offense_points_acme = ($val['passing_yards'] * 0.013) + ($val['rushing_yards'] * 0.025) + ($val['receiving_yards'] * 0.025) + ($val['passing_interceptions'] * (-0.20)) +
                                                  ($val['fumbles_lost'] * (-0.20)) + ($val['two_point_conversion_passes'] * 0.100) + ($val['two_point_conversion_runs'] * 0.250) +
                                                  ($val['two_point_conversion_receptions'] * 0.250) + $touchdownPassScores + $touchdownRushScores + $touchdownRecScores;
                    $offense_points_acme = number_format($offense_points_acme, 2);
                    if ($val['active_player'] == 1) {
                        $active_player_offense_points_acme = $offense_points_acme;
                        // $active_player_offense_points_acme	    = ($val['passing_yards']*0.013)+($val['rushing_yards']*0.025)+($val['receiving_yards']*0.025)+($val['passing_interceptions']*(-0.20))+
                    // 							  ($val['fumbles_lost']*(-0.20))+($val['two_point_conversion_passes']*0.100)+($val['two_point_conversion_runs']*0.250)+
                    // 							  ($val['two_point_conversion_receptions']*0.250)+$touchdownPassScores+$touchdownRushScores+$touchdownRecScores;
                    }
                    $val['ret_td'] = $val['punt_return_touchdowns'] + $val['kick_return_touchdowns'];
                    $val['two_pt'] = $val['two_point_conversion_passes'] + $val['two_point_conversion_runs'] + $val['two_point_conversion_receptions'];
                }
                //$active_player_offense_points_acme	= number_format($active_player_offense_points_acme,2);
                $val['statistics'] = '';
                $offense_points_acme_total += $active_player_offense_points_acme;
                $val['fantasy_points_acme'] = $offense_points_acme;

                if ($val['home_or_away'] == 'AWAY') {
                    $val['opponent'] = '@'.$val['opponent'];
                }
                if ($val['away_team'] != '' || $val['home_team'] != '') {
                    $val['status'] = $val['away_team'].' '.$val['away_score'].' @ '.$val['home_team'].' '.$val['home_score'].' '.$val['score_object']->quarter.' '.$val['score_object']->time_remaining;
                }

                if ($val['position'] == 'TQB') {
                    if ($val['passing_yards']) {
                        $val['statistics'] .= $val['passing_yards'].' PaYd, ';
                    }
                    if ($val['passing_touchdowns']) {
                        $val['statistics'] .= $val['passing_touchdowns'].' PaTD('.implode(',', array_column($val['tdPass'], 'length')).'), ';
                    }
                    if ($val['passing_interceptions']) {
                        $val['statistics'] .= $val['passing_interceptions'].' Int, ';
                    }
                    if ($val['rushing_yards']) {
                        $val['statistics'] .= $val['rushing_yards'].' RuYd, ';
                    }
                    if ($val['rushing_touchdowns']) {
                        $val['statistics'] .= $val['rushing_touchdowns'].' RuTD('.implode(',', array_column($val['tdRush'], 'length')).'), ';
                    }
                    if ($val['fumbles_lost']) {
                        $val['statistics'] .= $val['fumbles_lost'].' Fum, ';
                    }
                    if (isset($val['two_pt']) && $val['two_pt'] > 0) {
                        $val['statistics'] .= $val['two_pt'].' 2Pts, ';
                    }
                }

                if (in_array($val['position'], ['RB', 'WR', 'TE'])) {
                    if ($val['rushing_yards']) {
                        $val['statistics'] .= $val['rushing_yards'].' RuYd, ';
                    }
                    if ($val['rushing_touchdowns']) {
                        $val['statistics'] .= $val['rushing_touchdowns'].' RuTD('.implode(',', array_column($touchdownRush['plays'], 'length')).'), ';
                    }
                    if ($val['receiving_yards'] > 0) {
                        $val['statistics'] .= $val['receiving_yards'].' ReYd, ';
                    }
                    if ($val['receiving_touchdowns']) {
                        $val['statistics'] .= $val['receiving_touchdowns'].' ReTD('.implode(',', array_column($touchdownRec['plays'], 'length')).'), ';
                    }
                    if ($val['fumbles_lost']) {
                        $val['statistics'] .= $val['fumbles_lost'].' Fum, ';
                    }
                    if (isset($val['two_pt']) && $val['two_pt'] > 0) {
                        $val['statistics'] .= $val['two_pt'].' 2Pts, ';
                    }
                }

                //Strip trailing ,  (comma and space)
                $val['statistics'] = rtrim($val['statistics'], ", \t\n");

                $predicted_score = 0;
                if ($val['predicted_score'] > 0) {
                    $predicted_score = $val['predicted_score'];
                }
                $val['predicted_score'] = $predicted_score;

                if (in_array($val['position'], $offenseArray)) {
                    $offenseTeams[] = $val;
                }

                // if($isTeamQbItem){
                // 	array_unshift($offenseTeams,$mergeTeamQB);
                //                // $offenseTeams[]	=	$val;
                //             }

                if ($val['position'] == 'K') {
                    $kicker_points_acme = 0;
                    $sumValue = $val['fg1'] + $val['fg2'] + $val['fg3'] + $val['fg4'] + $val['fg5'];
                    $val['statistics'] = '';
                    if ($val['player_game_id'] != null) {
                        $fieldGoal = self::getScores($val['game_key'], $val['player_id'], 'FieldGoalMade');
                        $fieldGoalMissed = self::getScores($val['game_key'], $val['player_id'], 'FieldGoalMissed');
                        $fieldGoalScores = $fieldGoal['score'];
                        $kicker_points_acme = ($val['extra_points_made'] * 0.530) +
                                                        (($val['extra_points_attempted'] - $val['extra_points_made']) * -0.200) +
                                                        $fieldGoalScores +
                                                        $fieldGoalMissed['score'];

                        if ($fieldGoal['score'] > 0) {
                            $val['statistics'] .= ' FG('.implode(', ', array_column($fieldGoal['plays'], 'length')).'), ';
                        }
                        if ($fieldGoalMissed['score'] < 0) {
                            $val['statistics'] .= ' Miss('.implode(', ', array_column($fieldGoalMissed['plays'], 'length')).'), ';
                        }
                        if ($val['extra_points_made']) {
                            $val['statistics'] .= $val['extra_points_made'].' XP, ';
                        }
                        if ($missed = $val['extra_points_attempted'] - $val['extra_points_made']) {
                            $val['statistics'] .= $missed.'MXP, ';
                        }

                        $val['statistics'] = rtrim($val['statistics'], ", \t\n");

                        $kicker_points_acme = number_format($kicker_points_acme, 2);
                        if ($val['active_player'] == 1) {
                            $active_player_kicker_points_acme = $kicker_points_acme;
                        }
                    }
                    $val['fantasy_points_acme'] = $kicker_points_acme;
                    $kickerTeams[] = $val;
                    $kicker_points_acme_total += $active_player_kicker_points_acme;
                }
            }
        }

        $defTeams = FantasyTeamsRoster::selectRaw('p.bye_week,p.position,p.name,p.team,fd.opponent,is_st,team_qb,is_def,fd.home_or_away,fd.sacks,fd.interceptions,fd.fumbles_recovered,fd.safeties,fd.defensive_touchdowns,fd.special_teams_touchdowns,fd.fantasy_points,s.away_team,s.home_team,s.away_score,s.home_score,fd.points_allowed,fantasy_teams_roster.fantasy_team_id as fantasy_team_id,fdgp.fantasy_points as predicted_score,p.player_id as player_id,s.quarter,s.date_time,sc.game_key as game_key,fd.offensive_yards_allowed,fd.id as fantasy_defense_game_id,pl.photo_url,t.wikipedia_logo_url,fantasy_teams_roster.active as active_player,p.id as fplayer_id,fantasy_teams_roster.bench as bench_player,pl.injury_status,pl.injury_body_part,pl.injury_start_date,t.full_name,t.primary_color,t.secondary_color,t.tertiary_color,fantasy_teams_roster.season_type as season_type,fantasy_teams_roster.week as roster_week')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_roster.fantasy_player_id')
                            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
                            ->leftJoin('team as t', 't.key', '=', 'p.team')
                            ->leftJoin('fantasy_defense_game as fd', function ($join) use ($season, $seasonType, $week) {
                                $join->on('fd.player_id', '=', 'p.player_id');
                                $join->where('fd.season', $season);
                                $join->where('fd.season_type', $seasonType);
                                $join->where('fd.week', $week);
                            })
                            //->leftJoin('score as s','s.game_key','=','fd.game_key')
                            ->leftJoin('schedule as sc', function ($join) use ($season, $seasonType, $week) {
                                $join->on(function ($query) {
                                    $query->on('sc.home_team', '=', 'p.team');
                                    $query->orOn('sc.away_team', '=', 'p.team');
                                });
                                $join->where('sc.season', $season);
                                $join->where('sc.season_type', $seasonType);
                                $join->where('sc.week', $week);
                                $join->orWhere(function ($query) {
                                    $query->where('sc.home_team', '=', 'pl.team')
                                          ->where('sc.away_team', '=', 'pl.team');
                                });
                            })
                            ->leftJoin('score as s', 's.game_key', '=', 'sc.game_key')
                            ->leftJoin('fantasy_defense_game_projection as fdgp', function ($join) {
                                $join->on('s.game_key', '=', 'fdgp.game_key');
                                $join->on('fd.player_id', '=', 'fdgp.player_id');
                            })
                            ->whereIn('fantasy_teams_roster.fantasy_player_id', $playersId)
                            ->where('fantasy_teams_roster.player_transaction_type_id', 1)
                            ->where('fantasy_teams_roster.is_def', 1)
                            ->where('fantasy_teams_roster.week', $week)
                            ->where('fantasy_teams_roster.season', $season)
                            ->where('fantasy_teams_roster.season_type', $seasonType)
                            ->where(function ($query) {
                                $query->orWhere('fantasy_teams_roster.active', 1)
                                          ->orWhere('fantasy_teams_roster.bench', 1);
                            })
                            ->get()->toArray();

        if (! empty($defTeams)) {
            foreach ($defTeams as $dkey=>$dval) {
                $dval['score_object'] = self::getScoreObject($dval['game_key'], $seasonType, $season, $week);
                $dval['schedule_date_time'] = date('D H:i', strtotime($dval['date_time']));
                //$active_player_def_points_acme = 0;
                $def_points_acme = 0;
                $predicted_score = 0;
                if ($dval['predicted_score'] > 0) {
                    $predicted_score = $dval['predicted_score'];
                }
                $dval['predicted_score'] = $predicted_score;
                if ($dval['home_or_away'] == 'AWAY') {
                    $dval['opponent'] = '@'.$dval['opponent'];
                }
                if ($dval['away_team'] != '' || $dval['home_team'] != '') {
                    $dval['status'] = $dval['away_team'].' '.$dval['away_score'].' @ '.$dval['home_team'].' '.$dval['home_score'].' '.$dval['score_object']->quarter.' '.$dval['score_object']->time_remaining;
                }

                $dval['statistics'] = '';
                if ($dval['points_allowed']) {
                    $dval['statistics'] .= $dval['points_allowed'].' Pts, ';
                }
                if ($dval['sacks']) {
                    $dval['statistics'] .= $dval['sacks'].' Sck, ';
                }
                if ($dval['interceptions']) {
                    $dval['statistics'] .= $dval['interceptions'].' Int, ';
                }
                if ($dval['fumbles_recovered']) {
                    $dval['statistics'] .= $dval['fumbles_recovered'].' Fum, ';
                }

                if ($dval['fantasy_defense_game_id'] != null) {
                    $defensiveInterceptionTouchdownScores = self::getScores($dval['game_key'], $dval['team'], 'InterceptionReturnTouchdown', true);
                    $defensiveFumbleTouchdownScores = self::getScores($dval['game_key'], $dval['team'], 'FumbleReturnTouchdown', true);

                    if ($defensiveInterceptionTouchdownScores['score'] > 0) {
                        $dval['statistics'] .= count($defensiveInterceptionTouchdownScores['plays']).' DIntTD('.implode(',', array_column($defensiveInterceptionTouchdownScores['plays'], 'length')).'), ';
                    }

                    if ($defensiveFumbleTouchdownScores['score'] > 0) {
                        $dval['statistics'] .= count($defensiveFumbleTouchdownScores['plays']).' DFumTD('.implode(',', array_column($defensiveFumbleTouchdownScores['plays'], 'length')).'), ';
                    }

                    $def_points_acme = (6 + ($dval['points_allowed'] * -0.100)) + (6 + ($dval['offensive_yards_allowed'] * -0.010)) +
                                                        ($dval['interceptions'] * 0.250) + ($dval['fumbles_recovered'] * 0.250) +
                                                        ($dval['sacks'] * 0.100) + ($dval['safeties'] * 0.500) + $defensiveInterceptionTouchdownScores['score'] + $defensiveFumbleTouchdownScores['score'];

                    //					if($dval['active_player']==1){
//
//					$active_player_def_points_acme	=	(6 + ($dval['points_allowed'] * -0.100) ) + (6 + ($dval['offensive_yards_allowed'] * -0.010)) +
//														($dval['interceptions'] * 0.250) + ($dval['fumbles_recovered'] * 0.250) +
//														($dval['sacks'] * 0.100) + ($dval['safeties'] * 0.500) + $defensiveTouchdownScores;
//
//					}
                }

                $dval['statistics'] = rtrim($dval['statistics'], ", \t\n");
                $def_points_acme = number_format($def_points_acme, 2);
                if ($dval['active_player'] == 1) {

                //$active_player_def_points_acme	= 	number_format($active_player_def_points_acme,2);
                    $def_points_acme_total = $def_points_acme;
                }
                $dval['fantasy_points_acme'] = $def_points_acme;
                $diffTeams[] = $dval;
            }
        }

        $specTeams = FantasyTeamsRoster::selectRaw('p.bye_week,p.position,p.name,p.team,fd.opponent,is_st,team_qb,is_def,fd.home_or_away,fd.sacks,fd.interceptions,fd.fumbles_recovered,fd.safeties,fd.defensive_touchdowns,fd.special_teams_touchdowns,fd.fantasy_points,s.away_team,s.home_team,s.away_score,s.home_score,fd.points_allowed,fantasy_teams_roster.fantasy_team_id as fantasy_team_id,fdgp.fantasy_points as predicted_score,p.player_id as player_id,s.quarter,s.date_time,sc.game_key as game_key,fd.punt_return_yards,fd.kick_return_yards,fd.id as fantasy_defense_game_id,pl.photo_url,t.wikipedia_logo_url,fantasy_teams_roster.active as active_player,p.id as fplayer_id,fantasy_teams_roster.bench as bench_player,pl.injury_status,pl.injury_body_part,pl.injury_start_date,t.full_name,t.primary_color,t.secondary_color,t.tertiary_color,fantasy_teams_roster.season_type as season_type,fantasy_teams_roster.week as roster_week')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_roster.fantasy_player_id')
                            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
                            ->leftJoin('team as t', 't.key', '=', 'p.team')
                            ->leftJoin('fantasy_defense_game as fd', function ($join) use ($season, $seasonType, $week) {
                                $join->on('fd.player_id', '=', 'p.player_id');
                                $join->where('fd.season', $season);
                                $join->where('fd.season_type', $seasonType);
                                $join->where('fd.week', $week);
                            })
                            ->leftJoin('schedule as sc', function ($join) use ($season, $seasonType, $week) {
                                $join->on(function ($query) {
                                    $query->on('sc.home_team', '=', 'p.team');
                                    $query->orOn('sc.away_team', '=', 'p.team');
                                });
                                $join->where('sc.season', $season);
                                $join->where('sc.season_type', $seasonType);
                                $join->where('sc.week', $week);
                                $join->orWhere(function ($query) {
                                    $query->where('sc.home_team', '=', 'pl.team')
                                          ->where('sc.away_team', '=', 'pl.team');
                                });
                            })
                            ->leftJoin('score as s', 's.game_key', '=', 'sc.game_key')
                            //->leftJoin('score as s','s.game_key','=','fd.game_key')
                            ->leftJoin('fantasy_defense_game_projection as fdgp', function ($join) {
                                $join->on('s.game_key', '=', 'fdgp.game_key');
                                $join->on('fd.player_id', '=', 'fdgp.player_id');
                            })
                            ->whereIn('fantasy_teams_roster.fantasy_player_id', $playersId)
                            ->where('fantasy_teams_roster.player_transaction_type_id', 1)
                            ->where('fantasy_teams_roster.is_st', 1)
                            ->where('fantasy_teams_roster.week', $week)
                            ->where('fantasy_teams_roster.season', $season)
                            ->where('fantasy_teams_roster.season_type', $seasonType)
                            ->Where(function ($query) {
                                $query->Orwhere('fantasy_teams_roster.active', 1)
                                          ->Orwhere('fantasy_teams_roster.bench', 1);
                            })
                            ->get()->toArray();
        if (! empty($specTeams)) {
            foreach ($specTeams as $skey=>$sval) {
                $spec_points_acme = 0;
                $sval['score_object'] = self::getScoreObject($sval['game_key'], $seasonType, $season, $week);
                $sval['schedule_date_time'] = date('D H:i', strtotime($sval['date_time']));
                $predicted_score = 0;
                if ($sval['predicted_score'] > 0) {
                    $predicted_score = $sval['predicted_score'];
                }
                $sval['predicted_score'] = $predicted_score;
                $sval['position'] = 'ST';
                if ($sval['home_or_away'] == 'AWAY') {
                    $sval['opponent'] = '@'.$sval['opponent'];
                }
                if ($sval['away_team'] != '' || $sval['home_team'] != '') {
                    $sval['status'] = $sval['away_team'].' '.$sval['away_score'].' @ '.$sval['home_team'].' '.$sval['home_score'].' '.$sval['score_object']->quarter.' '.$sval['score_object']->time_remaining;
                }

                $sval['statistics'] = '';
                if ($sval['kick_return_yards'] > 0) {
                    $sval['statistics'] .= $sval['kick_return_yards'].' KRYd, ';
                }

                if ($sval['punt_return_yards'] > 0) {
                    $sval['statistics'] .= $sval['punt_return_yards'].' PRYd, ';
                }

                $fantasy_points_acme = 0;
                if ($sval['fantasy_defense_game_id'] != null) {
                    $kickoffReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'KickoffReturnTouchdown');
                    $puntReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'PuntReturnTouchdown');
                    $blockedFieldGoalReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'BlockedFieldGoalReturnTouchdown');
                    $blockedPuntReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'BlockedPuntReturnTouchdown');
                    $fieldGoalReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'FieldGoalReturnTouchdown');

                    $specialTeamsScores = $kickoffReturnTouchdown['score'] +
                                                            $puntReturnTouchdown['score'] +
                                                            $blockedFieldGoalReturnTouchdown['score'] +
                                                            $blockedPuntReturnTouchdown['score'] +
                                                            $fieldGoalReturnTouchdown['score'];

                    $kickerScores = self::getPlayerScores($sval['game_key'], $sval['team'], 'K');
                    $punterScores = self::getPlayerScores($sval['game_key'], $sval['team'], 'P');

                    //KickOffTouchbacks Data for now
                    $kickOffTouchbacksScores = self::getTeamGameScoreAndData($sval['game_key'], $sval['team']);

                    //If score is greater than 0, then we have data, show it on statistics line.
                    if ($kickOffTouchbacksScores['score'] > 0) {
                        $sval['statistics'] .= $kickOffTouchbacksScores['data']['opponent_kickoff_touchbacks'].'KTb, ';
                    }

                    //If score is greater than 0, then we have data, show it on statistics line.
                    if ($kickerScores['score'] > 0) {
                        foreach ($kickerScores['plays'] as $stScore) {
                            if ($stScore['punt_touchbacks'] > 0) {
                                $sval['statistics'] .= $stScore['punt_touchbacks'].'PTb, ';
                            }
                        }
                    }

                    $spec_points_acme =
                                                            ($sval['punt_return_yards'] * 0.015) +
                                                            ($sval['kick_return_yards'] * 0.015) +
                                                            $specialTeamsScores['score'] +
                                                            $punterScores['score'] +
                                                            $kickerScores['score'] +
                                                            $kickOffTouchbacksScores['score'];
                    if ($sval['active_player'] == 1) {
                        $active_player_spec_points_acme = $spec_points_acme;
                    }
                }

                $sval['statistics'] = rtrim($sval['statistics'], ", \t\n");

                $active_player_spec_points_acme = number_format($active_player_spec_points_acme, 2);
                $spec_points_acme = number_format($spec_points_acme, 2);
                $spec_points_acme_total += $active_player_spec_points_acme;
                $sval['fantasy_points_acme'] = $spec_points_acme;
                $specialTeams[] = $sval;
            }
        }

        // $total_home_acme_points					=	$offense_points_acme_total  + $kicker_points_acme_total + $def_points_acme_total + $spec_points_acme_total;
        $total_home_acme_points = $offense_points_acme_total + $kicker_points_acme_total + $def_points_acme_total + $spec_points_acme_total;

        $response['offenseTeams'] = self::sortTeamArray($offenseTeams);
        $response['kickerTeams'] = $kickerTeams;
        $response['diffTeams'] = $diffTeams;
        $response['specialTeams'] = $specialTeams;
        $response['total_home_acme_points'] = $total_home_acme_points;

        return $response;
    }

    public static function getFantasyProjectionTeamDataByWeek($season, $seasonType, $week, $teamId)
    {
        $offenseTeams = $kickerTeams = $qbTeams = $diffTeams = $specialTeams = [];
        $offenseArray = ['RB', 'QB', 'WR', 'TE', 'TQB'];
        $offense_points_acme = $kicker_points_acme = $def_points_acme = $spec_points_acme = 0;
        $active_player_offense_points_acme = $active_player_kicker_points_acme = $active_player_def_points_acme = $active_player_spec_points_acme = 0;
        $offense_points_acme_total = $kicker_points_acme_total = $def_points_acme_total = $spec_points_acme_total = 0;
        //$total_home_acme_points	=	0;

        //Get TeamQB Datastats
        $teamQB = FantasyTeamsRoster::selectRaw('p.position,p.name,p.team,fd.opponent,is_st,team_qb,is_def,fd.home_or_away,s.away_team,s.home_team,s.away_score,s.home_score,fd.points_allowed,fantasy_teams_roster.fantasy_team_id as fantasy_team_id,fd.fantasy_points as predicted_score,p.player_id as player_id,s.quarter,s.date_time,sc.game_key as game_key,fd.fumbles_recovered,fd.id as fantasy_defense_game_id,pl.photo_url,t.wikipedia_logo_url,fantasy_teams_roster.active as active_player,p.id as fplayer_id,fantasy_teams_roster.bench as bench_player,pl.injury_status,pl.injury_body_part,pl.injury_start_date,fd.id as projection_id')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_roster.fantasy_player_id')
                            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
                            ->leftJoin('team as t', 't.key', '=', 'p.team')
                            ->leftJoin('fantasy_defense_game_projection as fd', function ($join) use ($season, $seasonType, $week) {
                                $join->on('fd.player_id', '=', 'p.player_id');
                                $join->where('fd.season', $season);
                                $join->where('fd.season_type', $seasonType);
                                $join->where('fd.week', $week);
                            })
                            ->leftJoin('schedule as sc', function ($join) use ($season, $seasonType, $week) {
                                $join->on(function ($query) {
                                    $query->on('sc.home_team', '=', 'p.team');
                                    $query->orOn('sc.away_team', '=', 'p.team');
                                });
                                $join->where('sc.season', $season);
                                $join->where('sc.season_type', $seasonType);
                                $join->where('sc.week', $week);
                                $join->orWhere(function ($query) {
                                    $query->where('sc.home_team', '=', 'pl.team')
                                          ->where('sc.away_team', '=', 'pl.team');
                                });
                            })
                            ->leftJoin('score as s', 's.game_key', '=', 'sc.game_key')
                            ->whereIn('fantasy_teams_roster.fantasy_team_id', $teamId)
                            ->where('fantasy_teams_roster.player_transaction_type_id', 1)
                            ->where('fantasy_teams_roster.team_qb', 1)
                            ->where('fantasy_teams_roster.week', $week)
                            ->where('fantasy_teams_roster.season', $season)
                            ->where('fantasy_teams_roster.season_type', $seasonType)
                            ->orWhere(function ($query) {
                                $query->where('fantasy_teams_roster.active', 1)
                                          ->where('fantasy_teams_roster.bench', 1);
                            })
                            ->get()->toArray();

        $rosterTeams = FantasyTeamsRoster::selectRaw('p.position,p.name,p.team,pg.opponent,is_st,team_qb,is_def,pg.home_or_away,pg.passing_yards,
								pg.passing_touchdowns,pg.passing_interceptions,pg.rushing_yards,pg.rushing_touchdowns,pg.receiving_yards,pg.receiving_touchdowns,pg.punt_return_touchdowns ,pg.kick_return_touchdowns,pg.two_point_conversion_passes ,pg.two_point_conversion_runs ,pg.two_point_conversion_receptions,pg.fumbles_lost,pg.fantasy_points,
								pg.extra_points_made,pg.field_goals_made0to19 as fg1,pg.field_goals_made20to29 as fg2,pg.field_goals_made30to39 as fg3,pg.field_goals_made40to49 as fg4,pg.fumbles_recovered,
								pg.field_goals_made50_plus as fg5,pg.sacks,pg.interceptions,pg.fumbles_recovered,pg.safeties,pg.defensive_touchdowns,pg.special_teams_touchdowns,pg.kick_return_yards,
								pg.kick_return_fair_catches,pg.punt_return_yards,pg.punt_touchbacks,s.quarter,s.date_time,s.away_team,s.home_team,s.away_score,s.home_score,
								fantasy_teams_roster.fantasy_team_id as fantasy_team_id,pg.fantasy_points as predicted_score,p.player_id as player_id,p.id as fplayer_id,sc.game_key as game_key,pg.extra_points_attempted,pg.id as player_game_id,pl.photo_url,t.wikipedia_logo_url,fantasy_teams_roster.active as active_player,fantasy_teams_roster.bench as bench_player2,pl.injury_status,pl.injury_body_part,pl.injury_start_date,pg.id as projection_id')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_roster.player_id')
                            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
                            ->leftJoin('team as t', 't.key', '=', 'p.team')
                            ->leftJoin('player_game_projection as pg', function ($join) use ($season, $seasonType, $week) {
                                $join->on('pg.player_id', '=', 'p.player_id');
                                $join->where('pg.season', $season);
                                $join->where('pg.season_type', $seasonType);
                                $join->where('pg.week', $week);
                            })
                            ->leftJoin('schedule as sc', function ($join) use ($season, $seasonType, $week) {
                                $join->on(function ($query) {
                                    $query->on('sc.home_team', '=', 'p.team');
                                    $query->orOn('sc.away_team', '=', 'p.team');
                                });
                                $join->where('sc.season', $season);
                                $join->where('sc.season_type', $seasonType);
                                $join->where('sc.week', $week);
                                $join->orWhere(function ($query) {
                                    $query->where('sc.home_team', '=', 'pl.team')
                                          ->where('sc.away_team', '=', 'pl.team');
                                });
                            })
                            ->leftJoin('score as s', 's.game_key', '=', 'sc.game_key')
                            ->whereIn('fantasy_teams_roster.fantasy_team_id', $teamId)
                            ->where('fantasy_teams_roster.week', $week)
                            ->where('fantasy_teams_roster.season', $season)
                            ->where('fantasy_teams_roster.season_type', $seasonType)
                            ->where('fantasy_teams_roster.is_def', '<>', 1)
                            ->where('fantasy_teams_roster.is_st', '<>', 1)
                            ->where('fantasy_teams_roster.team_qb', '<>', 1)
                            ->where('fantasy_teams_roster.player_transaction_type_id', 1)
                            ->where('fantasy_teams_roster.active', 1)
                            ->orWhere(function ($query) {
                                $query->where('fantasy_teams_roster.bench', 1);
                            })
                            ->get()->toArray();
        if ($teamQB) {
            foreach ($teamQB as $k => $qb) {
                //Update position
                $teamQB[$k]['position'] = 'TQB';

                //Load data based on QB players that played on the team for the specific game we need data for.
                $team = $qb['team'];
                $gameKey = $qb['game_key'];
                //dd($team, $gameKey);
                $teamQBPlayerGame = self::getTqbPlayergame($team, $season, $seasonType, $week, $gameKey, $yearly = false);

                $mergeTeamQB = array_merge($teamQBPlayerGame, $teamQB[$k]);
                //dd($mergeTeamQB);
                $rosterTeams = array_merge([$mergeTeamQB], $rosterTeams);
            }
        }
        //dd($rosterTeams);
        if (! empty($rosterTeams)) {
            foreach ($rosterTeams as $key=>$val) {
                $val['score_object'] = self::getScoreObject($val['game_key'], $seasonType, $season, $week);
                $val['schedule_date_time'] = date('D H:i', strtotime($val['date_time']));
                $offense_points_acme = 0;
                $active_player_offense_points_acme = 0;
                $isTeamQbItem = $val['position'] == 'TQB';
                if ($isTeamQbItem) {
                    $offense_points_acme = number_format($val['fantasy_points_acme'], 2);
                    if ($val['active_player'] == 1) {
                        $active_player_offense_points_acme = $offense_points_acme;
                    }
                } elseif (isset($val['player_game_id']) && $val['player_game_id'] != null) {
                    $touchdownPass = self::getScores($val['game_key'], $val['player_id'], 'PassingTouchdown');
                    $touchdownRush = self::getScores($val['game_key'], $val['player_id'], 'RushingTouchdown');
                    $touchdownRec = self::getScores($val['game_key'], $val['player_id'], 'ReceivingTouchdown');
                    $touchdownPassScores = $touchdownPass['score'];
                    $touchdownRushScores = $touchdownRush['score'];
                    $touchdownRecScores = $touchdownRec['score'];

                    $offense_points_acme = ($val['passing_yards'] * 0.013) + ($val['rushing_yards'] * 0.025) + ($val['receiving_yards'] * 0.025) + ($val['passing_interceptions'] * (-0.20)) +
                                                  ($val['fumbles_lost'] * (-0.20)) + ($val['two_point_conversion_passes'] * 0.100) + ($val['two_point_conversion_runs'] * 0.250) +
                                                  ($val['two_point_conversion_receptions'] * 0.250) + $touchdownPassScores + $touchdownRushScores + $touchdownRecScores;
                    $offense_points_acme = number_format($offense_points_acme, 2);
                    if ($val['active_player'] == 1) {
                        $active_player_offense_points_acme = $offense_points_acme;
                    }
                    $val['ret_td'] = $val['punt_return_touchdowns'] + $val['kick_return_touchdowns'];
                    $val['two_pt'] = $val['two_point_conversion_passes'] + $val['two_point_conversion_runs'] + $val['two_point_conversion_receptions'];
                }
                //$active_player_offense_points_acme	= number_format($active_player_offense_points_acme,2);
                $val['statistics'] = '';
                $offense_points_acme_total += $active_player_offense_points_acme;
                $val['fantasy_points_acme'] = $offense_points_acme;

                if ($val['home_or_away'] == 'AWAY') {
                    $val['opponent'] = '@'.$val['opponent'];
                }
                if (empty($val['projection_id'])) {
                    $val['opponent'] = 'Bye Week';
                }

                if ($val['away_team'] != '' || $val['home_team'] != '') {
                    $val['status'] = $val['away_team'].' '.$val['away_score'].' @ '.$val['home_team'].' '.$val['home_score'].' '.$val['score_object']->quarter.' '.$val['score_object']->time_remaining;
                }

                if ($val['position'] == 'TQB') {
                    if ($val['passing_yards']) {
                        $val['statistics'] .= $val['passing_yards'].' PaYd, ';
                    }
                    if ($val['passing_touchdowns']) {
                        $val['statistics'] .= $val['passing_touchdowns'].' PaTD('.implode(',', array_column($val['tdPass'], 'length')).'), ';
                    }
                    if ($val['passing_interceptions']) {
                        $val['statistics'] .= $val['passing_interceptions'].' Int, ';
                    }
                    if ($val['rushing_yards']) {
                        $val['statistics'] .= $val['rushing_yards'].' RuYd, ';
                    }
                    if ($val['rushing_touchdowns']) {
                        $val['statistics'] .= $val['rushing_touchdowns'].' RuTD('.implode(',', array_column($val['tdRush'], 'length')).'), ';
                    }
                    if ($val['fumbles_lost']) {
                        $val['statistics'] .= $val['fumbles_lost'].' Fum, ';
                    }
                }

                if (in_array($val['position'], ['RB', 'WR', 'TE'])) {
                    if ($val['rushing_yards']) {
                        $val['statistics'] .= $val['rushing_yards'].' RuYd, ';
                    }
                    if ($val['rushing_touchdowns']) {
                        $val['statistics'] .= $val['rushing_touchdowns'].' RuTD('.implode(',', array_column($touchdownRush['plays'], 'length')).'), ';
                    }
                    if ($val['receiving_yards'] > 0) {
                        $val['statistics'] .= $val['receiving_yards'].' ReYd, ';
                    }
                    if ($val['receiving_touchdowns']) {
                        $val['statistics'] .= $val['receiving_touchdowns'].' ReTD('.implode(',', array_column($touchdownRec['plays'], 'length')).'), ';
                    }
                    if ($val['fumbles_lost']) {
                        $val['statistics'] .= $val['fumbles_lost'].' Fum, ';
                    }
                }

                //Strip trailing ,  (comma and space)
                $val['statistics'] = rtrim($val['statistics'], ", \t\n");

                $predicted_score = 0;
                if ($val['predicted_score'] > 0) {
                    $predicted_score = $val['predicted_score'];
                }
                $val['predicted_score'] = $predicted_score;

                if (in_array($val['position'], $offenseArray)) {
                    $offenseTeams[] = $val;
                }

                if ($val['position'] == 'K') {
                    $kicker_points_acme = 0;
                    $sumValue = $val['fg1'] + $val['fg2'] + $val['fg3'] + $val['fg4'] + $val['fg5'];
                    $val['statistics'] = '';
                    if ($val['player_game_id'] != null) {
                        $fieldGoal = self::getScores($val['game_key'], $val['player_id'], 'FieldGoalMade');
                        $fieldGoalScores = $fieldGoal['score'];
                        $kicker_points_acme = ($val['extra_points_made'] * 0.530) +
                                                        (($val['extra_points_attempted'] - $val['extra_points_made']) * -0.200) +
                                                        $fieldGoalScores;

                        if ($val['extra_points_made']) {
                            $val['statistics'] .= $val['extra_points_made'].' XP, ';
                        }
                        if ($missed = $val['extra_points_attempted'] - $val['extra_points_made']) {
                            $val['statistics'] .= $missed.'MXP, ';
                        }

                        $val['statistics'] = rtrim($val['statistics'], ", \t\n");

                        $kicker_points_acme = number_format($kicker_points_acme, 2);
                        if ($val['active_player'] == 1) {
                            $active_player_kicker_points_acme = $kicker_points_acme;
                        }
                    }
                    $val['fantasy_points_acme'] = $kicker_points_acme;
                    $kickerTeams[] = $val;
                    $kicker_points_acme_total += $active_player_kicker_points_acme;
                }
            }
        }

        $defTeams = FantasyTeamsRoster::selectRaw('p.position,p.name,p.team,fd.opponent,is_st,team_qb,is_def,fd.home_or_away,fd.sacks,fd.interceptions,fd.fumbles_recovered,fd.safeties,fd.defensive_touchdowns,fd.special_teams_touchdowns,fd.fantasy_points,s.away_team,s.home_team,s.away_score,s.home_score,fd.points_allowed,fantasy_teams_roster.fantasy_team_id as fantasy_team_id,fd.fantasy_points as predicted_score,p.player_id as player_id,s.quarter,s.date_time,sc.game_key as game_key,fd.offensive_yards_allowed,fd.id as fantasy_defense_game_id,pl.photo_url,t.wikipedia_logo_url,fantasy_teams_roster.active as active_player,p.id as fplayer_id,fantasy_teams_roster.bench as bench_player,pl.injury_status,pl.injury_body_part,pl.injury_start_date,fd.id as projection_id')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_roster.fantasy_player_id')
                            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
                            ->leftJoin('team as t', 't.key', '=', 'p.team')
                            ->leftJoin('fantasy_defense_game_projection as fd', function ($join) use ($season, $seasonType, $week) {
                                $join->on('fd.player_id', '=', 'p.player_id');
                                $join->where('fd.season', $season);
                                $join->where('fd.season_type', $seasonType);
                                $join->where('fd.week', $week);
                            })
                            //->leftJoin('score as s','s.game_key','=','fd.game_key')
                            ->leftJoin('schedule as sc', function ($join) use ($season, $seasonType, $week) {
                                $join->on(function ($query) {
                                    $query->on('sc.home_team', '=', 'p.team');
                                    $query->orOn('sc.away_team', '=', 'p.team');
                                });
                                $join->where('sc.season', $season);
                                $join->where('sc.season_type', $seasonType);
                                $join->where('sc.week', $week);
                                $join->orWhere(function ($query) {
                                    $query->where('sc.home_team', '=', 'pl.team')
                                          ->where('sc.away_team', '=', 'pl.team');
                                });
                            })
                            ->leftJoin('score as s', 's.game_key', '=', 'sc.game_key')
                            ->whereIn('fantasy_teams_roster.fantasy_team_id', $teamId)
                            ->where('fantasy_teams_roster.player_transaction_type_id', 1)
                            ->where('fantasy_teams_roster.is_def', 1)
                            ->where('fantasy_teams_roster.week', $week)
                            ->where('fantasy_teams_roster.season', $season)
                            ->where('fantasy_teams_roster.season_type', $seasonType)
                            ->orWhere(function ($query) {
                                $query->where('fantasy_teams_roster.active', 1)
                                          ->where('fantasy_teams_roster.bench', 1);
                            })
                            ->get()->toArray();

        if (! empty($defTeams)) {
            foreach ($defTeams as $dkey=>$dval) {
                $dval['score_object'] = self::getScoreObject($dval['game_key'], $seasonType, $season, $week);
                $dval['schedule_date_time'] = date('D H:i', strtotime($dval['date_time']));
                //$active_player_def_points_acme = 0;
                $def_points_acme = 0;
                $predicted_score = 0;
                if ($dval['predicted_score'] > 0) {
                    $predicted_score = $dval['predicted_score'];
                }
                $dval['predicted_score'] = $predicted_score;

                if ($dval['home_or_away'] == 'AWAY') {
                    $dval['opponent'] = '@'.$dval['opponent'];
                }
                if (empty($dval['projection_id'])) {
                    $dval['opponent'] = 'Bye Week';
                }

                if ($dval['away_team'] != '' || $dval['home_team'] != '') {
                    $dval['status'] = $dval['away_team'].' '.$dval['away_score'].' @ '.$dval['home_team'].' '.$dval['home_score'];
                }

                $dval['statistics'] = '';
                if ($dval['points_allowed']) {
                    $dval['statistics'] .= $dval['points_allowed'].' Pts, ';
                }
                if ($dval['sacks']) {
                    $dval['statistics'] .= $dval['sacks'].' Sck, ';
                }
                if ($dval['interceptions']) {
                    $dval['statistics'] .= $dval['interceptions'].' Int, ';
                }
                if ($dval['fumbles_recovered']) {
                    $dval['statistics'] .= $dval['fumbles_recovered'].' Fum, ';
                }

                $dval['statistics'] = rtrim($dval['statistics'], ", \t\n");

                if ($dval['fantasy_defense_game_id'] != null) {
                    $defensiveTouchdownScores = self::getScores($dval['game_key'], $dval['player_id'], 'InterceptionReturnTouchdown')['score'] + self::getScores($dval['game_key'], $dval['player_id'], 'FumbleReturnTouchdown')['score'];
                    $def_points_acme = (6 + ($dval['points_allowed'] * -0.100)) + (6 + ($dval['offensive_yards_allowed'] * -0.010)) +
                                                        ($dval['interceptions'] * 0.250) + ($dval['fumbles_recovered'] * 0.250) +
                                                        ($dval['sacks'] * 0.100) + ($dval['safeties'] * 0.500) + $defensiveTouchdownScores;
                }
                $def_points_acme = number_format($def_points_acme, 2);
                if ($dval['active_player'] == 1) {

                //$active_player_def_points_acme	= 	number_format($active_player_def_points_acme,2);
                    $def_points_acme_total = $def_points_acme;
                }
                $dval['fantasy_points_acme'] = $def_points_acme;
                $diffTeams[] = $dval;
            }
        }

        $specTeams = FantasyTeamsRoster::selectRaw('p.position,p.name,p.team,fd.opponent,is_st,team_qb,is_def,fd.home_or_away,fd.sacks,fd.interceptions,fd.fumbles_recovered,fd.safeties,fd.defensive_touchdowns,fd.special_teams_touchdowns,fd.fantasy_points,s.away_team,s.home_team,s.away_score,s.home_score,fd.points_allowed,fantasy_teams_roster.fantasy_team_id as fantasy_team_id,fd.fantasy_points as predicted_score,p.player_id as player_id,s.quarter,s.date_time,sc.game_key as game_key,fd.punt_return_yards,fd.kick_return_yards,fd.id as fantasy_defense_game_id,pl.photo_url,t.wikipedia_logo_url,fantasy_teams_roster.active as active_player,p.id as fplayer_id,fantasy_teams_roster.bench as bench_player,pl.injury_status,pl.injury_body_part,pl.injury_start_date,fd.id as projection_id')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_roster.fantasy_player_id')
                            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
                            ->leftJoin('team as t', 't.key', '=', 'p.team')
                            ->leftJoin('fantasy_defense_game_projection as fd', function ($join) use ($season, $seasonType, $week) {
                                $join->on('fd.player_id', '=', 'p.player_id');
                                $join->where('fd.season', $season);
                                $join->where('fd.season_type', $seasonType);
                                $join->where('fd.week', $week);
                            })
                            ->leftJoin('schedule as sc', function ($join) use ($season, $seasonType, $week) {
                                $join->on(function ($query) {
                                    $query->on('sc.home_team', '=', 'p.team');
                                    $query->orOn('sc.away_team', '=', 'p.team');
                                });
                                $join->where('sc.season', $season);
                                $join->where('sc.season_type', $seasonType);
                                $join->where('sc.week', $week);
                                $join->orWhere(function ($query) {
                                    $query->where('sc.home_team', '=', 'pl.team')
                                          ->where('sc.away_team', '=', 'pl.team');
                                });
                            })
                            ->leftJoin('score as s', 's.game_key', '=', 'sc.game_key')
                            ->whereIn('fantasy_teams_roster.fantasy_team_id', $teamId)
                            ->where('fantasy_teams_roster.player_transaction_type_id', 1)
                            ->where('fantasy_teams_roster.is_st', 1)
                            ->where('fantasy_teams_roster.week', $week)
                            ->where('fantasy_teams_roster.season', $season)
                            ->where('fantasy_teams_roster.season_type', $seasonType)
                            ->orWhere(function ($query) {
                                $query->where('fantasy_teams_roster.active', 1)
                                          ->where('fantasy_teams_roster.bench', 1);
                            })
                            ->get()->toArray();
        if (! empty($specTeams)) {
            foreach ($specTeams as $skey=>$sval) {
                $sval['score_object'] = self::getScoreObject($sval['game_key'], $seasonType, $season, $week);
                $sval['schedule_date_time'] = date('D H:i', strtotime($sval['date_time']));
                $predicted_score = 0;
                if ($sval['predicted_score'] > 0) {
                    $predicted_score = $sval['predicted_score'];
                }
                $sval['predicted_score'] = $predicted_score;
                $sval['position'] = 'ST';

                if ($sval['home_or_away'] == 'AWAY') {
                    $sval['opponent'] = '@'.$sval['opponent'];
                }
                if (empty($sval['projection_id'])) {
                    $sval['opponent'] = 'Bye Week';
                }

                if ($sval['away_team'] != '' || $sval['home_team'] != '') {
                    $sval['status'] = $sval['away_team'].' '.$sval['away_score'].' @ '.$sval['home_team'].' '.$sval['home_score'];
                }
                $sval['statistics'] = $sval['kick_return_yards'].' KRYd, '.$sval['punt_return_yards'].' PRYd ';
                $fantasy_points_acme = 0;
                if ($sval['fantasy_defense_game_id'] != null) {
                    $kickoffReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'KickoffReturnTouchdown');
                    $puntReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'PuntReturnTouchdown');
                    $blockedFieldGoalReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'BlockedFieldGoalReturnTouchdown');
                    $blockedPuntReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'BlockedPuntReturnTouchdown');
                    $fieldGoalReturnTouchdown = self::getScores($sval['game_key'], $sval['player_id'], 'FieldGoalReturnTouchdown');

                    $specialTeamsScores = $kickoffReturnTouchdown['score'] +
                                                            $puntReturnTouchdown['score'] +
                                                            $blockedFieldGoalReturnTouchdown['score'] +
                                                            $blockedPuntReturnTouchdown['score'] +
                                                            $fieldGoalReturnTouchdown['score'];

                    $punterScores = self::getPlayerGameProjectionScores($sval['game_key'], $sval['player_id'], 'P');
                    $kickerScores = self::getPlayerGameProjectionScores($sval['game_key'], $sval['player_id'], 'K');
                    $spec_points_acme = ($sval['punt_return_yards'] * 0.015) + ($sval['kick_return_yards'] * 0.015) + $specialTeamsScores + $punterScores + $kickerScores;
                    if ($sval['active_player'] == 1) {
                        $active_player_spec_points_acme = ($sval['punt_return_yards'] * 0.015) + ($sval['kick_return_yards'] * 0.015) + $specialTeamsScores + $punterScores + $kickerScores;
                    }
                }
                $active_player_spec_points_acme = number_format($active_player_spec_points_acme, 2);
                $spec_points_acme = number_format($spec_points_acme, 2);
                $spec_points_acme_total += $active_player_spec_points_acme;
                $sval['fantasy_points_acme'] = $spec_points_acme;
                $specialTeams[] = $sval;
            }
        }

        $total_home_acme_points = $offense_points_acme_total + $kicker_points_acme_total + $def_points_acme_total + $spec_points_acme_total;

        $response['offenseTeams'] = self::sortTeamArray($offenseTeams);
        $response['kickerTeams'] = $kickerTeams;
        $response['diffTeams'] = $diffTeams;
        $response['specialTeams'] = $specialTeams;
        $response['total_home_acme_points'] = $total_home_acme_points;

        return $response;
    }

    public static function getFantasyTeamDataByPlayer($player_id, $season, $seasonType, $position)
    {
        $game_stats = [];
        $game_stats2 = [];
        $offenseArray = ['RB', 'WR', 'TE'];
        $rosterTeams = PlayerSeason::selectRaw('played,receiving_yards_per_reception,season,team,receptions,position,id as Player_game_id,player_id,rushing_attempts,rushing_yards_per_attempt,receiving_targets,passing_yards,passing_touchdowns,passing_interceptions,rushing_yards,rushing_touchdowns,receiving_yards,receiving_touchdowns,passing_attempts,passing_completions,
			punt_return_touchdowns,position,field_goals_attempted,field_goals_made,extra_points_attempted,
			kick_return_touchdowns, two_point_conversion_passes,two_point_conversion_runs,two_point_conversion_receptions,fumbles_lost,fantasy_points,extra_points_made,field_goals_made0to19 as fg1,field_goals_made20to29 as fg2,field_goals_made30to39 as fg3,field_goals_made40to49 as fg4,field_goals_made50_plus as fg5,sacks,interceptions,fumbles_recovered,safeties,defensive_touchdowns,special_teams_touchdowns,kick_return_yards,kick_return_fair_catches,punt_return_yards,punt_touchbacks')
                                    ->where('player_id', $player_id)
                                    ->where('season_type', $seasonType)
                                    ->get()->toArray();
        if ($position == 'TQB') {
            $rosterTeams = FantasyDefenseSeason::selectRaw('fantasy_defense_season.team,pg.played,fantasy_defense_season.season,fantasy_defense_season.season,pg.receptions,pg.id as player_game_id,pg.player_id,pg.rushing_attempts,pg.rushing_yards_per_attempt,pg.receiving_targets,pg.passing_yards,pg.passing_touchdowns,pg.passing_interceptions,pg.rushing_yards,pg.rushing_touchdowns,pg.receiving_yards,pg.receiving_touchdowns,pg.passing_attempts,pg.passing_completions,
			pg.punt_return_touchdowns,pg.position,pg.field_goals_attempted,pg.field_goals_made,pg.extra_points_attempted,
			pg.kick_return_touchdowns, pg.two_point_conversion_passes,pg.two_point_conversion_runs,pg.two_point_conversion_receptions,pg.fumbles_lost,pg.fantasy_points,pg.extra_points_made,pg.field_goals_made0to19 as fg1,pg.field_goals_made20to29 as fg2,pg.field_goals_made30to39 as fg3,pg.field_goals_made40to49 as fg4,pg.field_goals_made50_plus as fg5,pg.sacks,pg.interceptions,pg.fumbles_recovered,pg.safeties,pg.defensive_touchdowns,pg.special_teams_touchdowns,pg.kick_return_yards,pg.kick_return_fair_catches,pg.punt_return_yards,pg.punt_touchbacks')
                                                            ->leftJoin('player_season as pg', function ($join) use ($season, $seasonType) {
                                                                $join->on('pg.id', '=', 'fantasy_defense_season.player_id');
                                                                $join->where('pg.season_type', $seasonType);
                                                            })

                                                        ->where('fantasy_defense_season.player_id', $player_id)
                                                        ->where('fantasy_defense_season.season_type', $seasonType)
                                                        ->get()->toArray();
        }
        $i = 0;
        $stats_played = 0;
        $stats_rushing_attempts = 0;
        $stats_rushing_attempts = 0;
        $stats_rushing_yards = 0;
        $stats_rushing_yards_per_attempt = 0;
        $stats_rushing_touchdowns = 0;
        $stats_receiving_targets = 0;
        $stats_receptions = 0;
        $stats_receiving_yards = 0;
        $stats_receiving_touchdowns = 0;
        $stats_fumbles_lost = 0;
        $stats_passing_attempts = 0;
        $stats_passing_completions = 0;
        $stats_passing_yards = 0;
        $stats_passing_interceptions = 0;
        $stats_receiving_yards_per_reception = 0;
        $stats_field_goals_attempted = 0;
        $stats_field_goals_made = 0;
        $stats_extra_points_attempted = 0;
        $stats_fg1 = 0;
        $stats_fg2 = 0;
        $stats_fg3 = 0;
        $stats_fg4 = 0;
        $stats_fg5 = 0;
        $stats_fantacy_points = 0;
        $stats_touchdowns_scored = 0;
        $stats_interceptions = 0;
        $stats_safeties = 0;
        $stats_sacks = 0;
        $stats_fumbles_recovered = 0;
        $stats_points_allowed = 0;
        $stats_fantacy_points = 0;

        if (! empty($rosterTeams)) {
            foreach ($rosterTeams as $key=>$val) {
                $team = $val['team'];
                $game_key = 1;
                $stats_played += $val['played'];

                $touchdownPass = self::getScores($game_key, $val['player_id'], 'PassingTouchdown');
                $touchdownRush = self::getScores($game_key, $val['player_id'], 'RushingTouchdown');
                $touchdownRec = self::getScores($game_key, $val['player_id'], 'ReceivingTouchdown');
                $touchdownPassScores = $touchdownPass['score'];
                $touchdownRushScores = $touchdownRush['score'];
                $touchdownRecScores = $touchdownRec['score'];

                $offense_points_acme = ($val['passing_yards'] * 0.013) +
                                                  ($val['rushing_yards'] * 0.025) +
                                                  ($val['receiving_yards'] * 0.025) +
                                                  ($val['passing_interceptions'] * (-0.20)) +
                                                  ($val['fumbles_lost'] * (-0.20)) +
                                                  ($val['two_point_conversion_passes'] * 0.100) +
                                                  ($val['two_point_conversion_runs'] * 0.250) +
                                                  ($val['two_point_conversion_receptions'] * 0.250)
                                                  + $touchdownPassScores + $touchdownRushScores + $touchdownRecScores;

                $offense_points_acme = number_format($offense_points_acme, 2);

                if ($position != 'TQB') {
                    if (in_array($val['position'], $offenseArray)) {
                        $stats_rushing_attempts += $val['rushing_attempts'];
                        $stats_rushing_yards += $val['rushing_yards'];
                        $stats_rushing_yards_per_attempt += $val['rushing_yards_per_attempt'];
                        $stats_rushing_touchdowns += $val['rushing_touchdowns'];
                        $stats_receiving_targets += $val['receiving_targets'];
                        $stats_receptions += $val['receptions'];
                        $stats_receiving_yards += $val['receiving_yards'];
                        $stats_receiving_touchdowns += $val['receiving_touchdowns'];
                        $stats_receiving_yards_per_reception += $val['receiving_yards_per_reception'];
                        $stats_fumbles_lost += $val['fumbles_lost'];

                        $game_stats[$i]['SEASON'] = $val['season'];
                        $game_stats[$i]['G'] = $val['played'];
                        $game_stats[$i]['RUATT'] = $val['rushing_attempts'];
                        $game_stats[$i]['RUYD'] = $val['rushing_yards'];
                        $game_stats[$i]['RUAVG'] = $val['rushing_yards_per_attempt'];
                        $game_stats[$i]['RUTD'] = $val['rushing_touchdowns'];

                        $game_stats[$i]['TAR'] = $val['receiving_targets'];
                        $game_stats[$i]['RECPT'] = $val['receptions'];
                        $game_stats[$i]['REYD'] = $val['receiving_yards'];
                        $game_stats[$i]['RETD'] = $val['receiving_touchdowns'];
                        $game_stats[$i]['REAVG'] = $val['receiving_yards_per_reception'];

                        $game_stats[$i]['FL'] = $val['fumbles_lost'];
                        $game_stats[$i]['FPTS'] = $offense_points_acme;
                        $stats_fantacy_points += $offense_points_acme;
                    }
                }

                if ($position == 'TQB') {
                    //dd($val);
                    $stats_passing_attempts += $val['passing_attempts'];
                    $stats_passing_completions += $val['passing_completions'];
                    $stats_passing_yards += $val['passing_yards'];
                    $stats_passing_interceptions += $val['passing_interceptions'];

                    $tqb_fantasy_points_acme = self::getTqbPlayergame($team, $season, $seasonType, 1, $game_key, $yearly = true);

                    if (! empty($tqb_fantasy_points_acme)) {
                        $fpts = number_format($tqb_fantasy_points_acme['fantasy_points_acme'], 2);
                        $game_stats[$i]['SEASON'] = $tqb_fantasy_points_acme['season'];
                        $game_stats[$i]['G'] = $tqb_fantasy_points_acme['played'];
                        $game_stats[$i]['PAATT'] = $tqb_fantasy_points_acme['passing_attempts'];
                        $game_stats[$i]['PACMP'] = $tqb_fantasy_points_acme['passing_completions'];
                        $game_stats[$i]['PATD'] = $tqb_fantasy_points_acme['passing_touchdowns'];
                        $game_stats[$i]['PAYD'] = $tqb_fantasy_points_acme['passing_yards'];
                        $game_stats[$i]['PAINT'] = $tqb_fantasy_points_acme['passing_interceptions'];
                        $game_stats[$i]['RUYD'] = $tqb_fantasy_points_acme['rushing_yards'];
                        $game_stats[$i]['RUTD'] = $tqb_fantasy_points_acme['rushing_touchdowns'];
                        $game_stats[$i]['FPTS'] = $fpts;
                        $stats_fantacy_points += $fpts;
                    }
                }

                if ($val['position'] == 'K') {
                    $stats_field_goals_attempted += $val['field_goals_attempted'];
                    $stats_field_goals_made += $val['field_goals_made'];
                    $stats_extra_points_attempted += $val['extra_points_attempted'];
                    $stats_fg1 += $val['fg1'];
                    $stats_fg2 += $val['fg2'];
                    $stats_fg3 += $val['fg3'];
                    $stats_fg4 += $val['fg4'];
                    $stats_fg5 += $val['fg5'];

                    $sumValue = $val['fg1'] + $val['fg2'] + $val['fg3'] + $val['fg4'] + $val['fg5'];

                    $fieldGoalScores = self::getScores($game_key, $val['player_id'], 'FieldGoalMade');
                    $kicker_points_acme = ($val['extra_points_made'] * 0.500) + (($val['extra_points_attempted'] - $val['extra_points_made']) * -0.200) + $fieldGoalScores['score'];
                    $game_stats[$i]['SEASON'] = $val['season'];
                    $game_stats[$i]['G'] = $val['played'];
                    $game_stats[$i]['FGA'] = $val['field_goals_attempted'];
                    $game_stats[$i]['FG'] = $val['field_goals_made'];
                    $game_stats[$i]['XPATT'] = $val['extra_points_attempted'];
                    $game_stats[$i]['FG19'] = $val['fg1'];
                    $game_stats[$i]['FG29'] = $val['fg2'];
                    $game_stats[$i]['FG39'] = $val['fg3'];
                    $game_stats[$i]['FG49'] = $val['fg4'];
                    $game_stats[$i]['FG50'] = $val['fg5'];
                    $game_stats[$i]['FPTS'] = number_format($kicker_points_acme, 2);
                    $stats_fantacy_points += $kicker_points_acme;
                }
                $i++;
            }
        }

        if ($position == 'DEF') {
            $defTeamslist = FantasyDefenseSeason::selectRaw('season,touchdowns_scored,sacks,player_id,interceptions,fumbles_recovered,
															safeties,defensive_touchdowns,special_teams_touchdowns,fantasy_points,points_allowed,
															offensive_yards_allowed,id as fantasy_defense_game_id')

                                                        ->where('player_id', $player_id)
                                                        ->where('season_type', $seasonType)
                                                        ->get()->toArray();
            $i = 0;
            if (! empty($defTeamslist)) {
                foreach ($defTeamslist as $key=>$val) {
                    $game_key = 1;
                    $defensiveTouchdownScores = self::getScores($game_key, $val['player_id'], 'InterceptionReturnTouchdown')['score'] + self::getScores($game_key, $val['player_id'], 'FumbleReturnTouchdown')['score'];
                    $def_points_acme = (6 + ($val['points_allowed'] * -0.100)) + (6 + ($val['offensive_yards_allowed'] * -0.010)) +
                                                                ($val['interceptions'] * 0.250) + ($val['fumbles_recovered'] * 0.250) +
                                                                ($val['sacks'] * 0.100) + ($val['safeties'] * 0.500) + $defensiveTouchdownScores;

                    $stats_touchdowns_scored += $val['touchdowns_scored'];
                    $stats_interceptions += $val['interceptions'];
                    $stats_safeties += $val['safeties'];
                    $stats_sacks += $val['sacks'];
                    $stats_fumbles_recovered += $val['fumbles_recovered'];
                    $stats_points_allowed += $val['points_allowed'];
                    $stats_fantacy_points += $def_points_acme;

                    $game_stats[$i]['SEASON'] = $val['season'];
                    //	$game_stats[$i]['G'] 			= $val['played'];
                    $game_stats[$i]['DTD'] = $val['touchdowns_scored'];
                    $game_stats[$i]['INT'] = $val['interceptions'];
                    $game_stats[$i]['STY'] = $val['safeties'];
                    $game_stats[$i]['SACK'] = $val['sacks'];
                    $game_stats[$i]['DFR'] = $val['fumbles_recovered'];
                    $game_stats[$i]['PA'] = $val['points_allowed'];
                    $game_stats[$i]['FPTS'] = number_format($def_points_acme, 2);
                    $i++;
                }
            }
        }

        if ($position == 'ST') {
            $specTeamslist = FantasyDefenseSeason::selectRaw('season,touchdowns_scored,sacks,player_id,interceptions,fumbles_recovered,safeties,defensive_touchdowns,special_teams_touchdowns,fantasy_points,points_allowed,offensive_yards_allowed,id as fantasy_defense_game_id,punt_return_yards,kick_return_yards')->where('season', $season)
                            ->where('player_id', $player_id)
                            ->where('season_type', $seasonType)
                            ->get()->toArray();
            $i = 0;
            if (! empty($specTeamslist)) {
                foreach ($specTeamslist as $key=>$val) {
                    $game_key = 1;
                    $kickoffReturnTouchdown = self::getScores($game_key, $val['player_id'], 'KickoffReturnTouchdown');
                    $puntReturnTouchdown = self::getScores($game_key, $val['player_id'], 'PuntReturnTouchdown');
                    $blockedFieldGoalReturnTouchdown = self::getScores($game_key, $val['player_id'], 'BlockedFieldGoalReturnTouchdown');
                    $blockedPuntReturnTouchdown = self::getScores($game_key, $val['player_id'], 'BlockedPuntReturnTouchdown');
                    $fieldGoalReturnTouchdown = self::getScores($game_key, $val['player_id'], 'FieldGoalReturnTouchdown');
                    $specialTeamsScores = $kickoffReturnTouchdown['score'] +
                                                                $puntReturnTouchdown['score'] +
                                                                $blockedFieldGoalReturnTouchdown['score'] +
                                                                $blockedPuntReturnTouchdown['score'] +
                                                                $fieldGoalReturnTouchdown['score'];
                    $punterScores = self::getPlayerScores($game_key, $val['player_id'], 'P');
                    $kickerScores = self::getPlayerScores($game_key, $val['player_id'], 'K');
                    $spec_points_acme = ($val['punt_return_yards'] * 0.015) + ($val['kick_return_yards'] * 0.015) + $specialTeamsScores + $punterScores['score'] + $kickerScores['score'];
                    $game_stats[$i]['SEASON'] = $val['season'];
                    $game_stats[$i]['FPTS'] = number_format($spec_points_acme, 2);

                    $stats_fantacy_points += $spec_points_acme;
                    $i++;
                }
            }
        }

        $game_stats2['SEASON'] = 'Career';
        $game_stats2['G'] = $stats_played;
        $game_stats2['RUATT'] = $stats_rushing_attempts;
        $game_stats2['RUYD'] = $stats_rushing_yards;
        $game_stats2['RUAVG'] = $stats_rushing_yards_per_attempt;
        $game_stats2['RUTD'] = $stats_rushing_touchdowns;
        $game_stats2['TAR'] = $stats_receiving_targets;
        $game_stats2['RECPT'] = $stats_receptions;
        $game_stats2['REYD'] = $stats_receiving_yards;
        $game_stats2['RETD'] = $stats_receiving_touchdowns;
        $game_stats2['REAVG'] = $stats_receiving_yards_per_reception;
        $game_stats2['FL'] = $stats_fumbles_lost;
        $game_stats2['FPTS'] = $stats_fantacy_points;

        $game_stats2['PAATT'] = $stats_passing_attempts;
        $game_stats2['PACMP'] = $stats_passing_completions;
        $game_stats2['PAINT'] = $stats_passing_interceptions;
        $game_stats2['PAYD'] = $stats_passing_yards;

        $game_stats2['FGA'] = $stats_field_goals_attempted;
        $game_stats2['FG'] = $stats_field_goals_made;
        $game_stats2['XPATT'] = $stats_extra_points_attempted;
        $game_stats2['FG19'] = $stats_fg1;
        $game_stats2['FG29'] = $stats_fg2;
        $game_stats2['FG39'] = $stats_fg3;
        $game_stats2['FG49'] = $stats_fg4;
        $game_stats2['FG50'] = $stats_fg5;

        $game_stats2['DTD'] = $stats_touchdowns_scored;
        $game_stats2['INT'] = $stats_interceptions;
        $game_stats2['STY'] = $stats_safeties;
        $game_stats2['SACK'] = $stats_sacks;
        $game_stats2['DFR'] = $stats_fumbles_recovered;
        $game_stats2['PA'] = $stats_points_allowed;

        array_push($game_stats, $game_stats2);

        return $game_stats;
    }

    public static function getScoreObject($game_key, $season_type, $season, $week)
    {
        $score_details = [];
        if ($game_key != '') {
            $score_details = Score::where('game_key', '=', $game_key)
                                ->where('season_type', '=', $season_type)
                                ->where('season', '=', $season)
                                ->where('week', '=', $week)
                                ->first();
            if (! empty($score_details)) {
                $score_details->toArray();
            }
        }

        return $score_details;
    }

    public static function getPlayerScores($game_key, $player_id, $position)
    {
        $score = 0;
        $score_details = PlayerGame::where('game_key', '=', $game_key)
                            ->where('position', '=', $position)
                            ->where('team', '=', $player_id)
                            ->get();
        if (! empty($score_details)) {
            foreach ($score_details as $value) {
                $puntTouchbacks = $value->punt_touchbacks;
                //$kickReturn		=	$value->kick_return_fair_catches;
                $score += $puntTouchbacks * -0.100;		//This is a negative thing that happens for a ST so we want to decrease points.
                //$score			+=	$kickReturn * 0.100;
            }
        }
        // if($score > 0)
        // 	dd(array('score' => $score, 'plays' => $score_details->toArray()));

        return ['score' => $score, 'plays' => $score_details->toArray()];
    }

    public static function getPlayerGameProjectionScores($game_key, $player_id, $position)
    {
        $score = 0;
        $score_details = PlayerGameProjection::where('game_key', '=', $game_key)
                            ->where('position', '=', $position)
                            ->where('team_id', '=', $player_id)
                            ->get();
        if (! empty($score_details)) {
            foreach ($score_details as $value) {
                $puntTouchbacks = $value->punt_touchbacks;
                $kickReturn = $value->kick_return_fair_catches;
                if ($position == 'P') {
                    $score += $puntTouchbacks * 0.200;
                }
                if ($position == 'K') {
                    $score += $kickReturn * 0.200;
                }
            }
        }

        return $score;
    }

    public static function getLeagueCoachRatingRank($league_id)
    {
        $year = date('Y');
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $year = $systemSettings->season;
            $seasonType = $systemSettings->seasonType;

            $week = $systemSettings->week - 1;  //Get previous week
        }

        $teamRankings = LeagueTeamRanking::where('league_id', $league_id)
                                ->where('week', $week)
                                // ->where('seasonType', $seasonType)
                                ->where('season', $year)
                                ->orderBy('overall_coach_rank', 'desc')
                                ->get();
        $returnArray = [];

        foreach ($teamRankings as $key=>$val) {
            $returnArray[$key] = $val; //array('COACH_SCORE' => $val['coach_score']);
        }

        $returnArray = (array_values($returnArray));
        $COACH_SCORE = array_column($returnArray, 'coach_score');
        array_multisort($COACH_SCORE, SORT_DESC, $returnArray);
        $team_ranks = array_values(array_chunk($returnArray, 2));
        $team_ranking = [];

        foreach ($team_ranks as $key=>$value) {
            $team_ranking[$key]['home_team'] = $value[0]['fatasy_team_id'];
            $team_ranking[$key]['away_team'] = $value[1]['fatasy_team_id'];
        }

        return $team_ranking;
    }

    public static function getTeamByRank($league_id)
    {
        $year = date('Y');
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $year = $systemSettings->season;
        }

        /*	$divisions		= DraftOrder::selectRaw("f.name as teamName,fantasy_team_id")
                            ->leftJoin('fantasy_teams as f','f.id','=','draft_order.fantasy_team_id')
                            ->where('round',1)->whereIn('round_overall_pick',array(1,2,3,4,5,6,7,8,9,10,11,12))
                            ->where('draft_order.league_id',$league_id)
                            ->whereIn('round_overall_pick',array(1,2,3,4,5,6,7,8,9,10,11,12))
                            ->orderBy('round_overall_pick')->get();

            */

        $divisions = FantasyTeam::where('league_id', $league_id)->get();
        $divisions = $divisions->toArray();
        $returnArray = [];
        if (! empty($divisions)) {
            foreach ($divisions as $key=>$val) {
                $winCount = LeagueGame::where('team_id', $val['id'])->where('year', $year)->where('win', 1)->count();
                $lossCount = LeagueGame::where('team_id', $val['id'])->where('year', $year)->where('loss', 1)->count();
                $tieCount = LeagueGame::where('team_id', $val['id'])->where('year', $year)->where('tie', 1)->count();
                $total = $winCount + $lossCount + $tieCount;
                if ($total > 0) {
                    $pct = $winCount / ($winCount + $lossCount + $tieCount);
                } else {
                    $pct = 0;
                }
                $gb = 0;
                $streak = 0;
                $div = 0;
                $wks = 0;
                $pf = LeagueGame::where('team_id', $val['id'])->where('year', $year)->sum('team_score');
                $back = 0;
                $pa = LeagueGame::where('team_id', $val['id'])->where('year', $year)->sum('opponent_score');

                $val['PCT'] = $pct;
                $val['PF'] = number_format($pf, 2);

                $returnArray[$key] = $val;
            }
        }

        $returnArray = (array_values($returnArray));
        $PCT = array_column($returnArray, 'PCT');
        $PF = array_column($returnArray, 'PF');
        array_multisort($PCT, SORT_DESC, $PF, SORT_DESC, $returnArray);
        $team_ranks = array_values(array_chunk($returnArray, 2));
        $team_ranking = [];

        foreach ($team_ranks as $key=>$value) {
            $team_ranking[$key]['home_team'] = $value[0]['id'];
            $team_ranking[$key]['away_team'] = $value[1]['id'];
        }

        return $team_ranking;
    }

    public static function getTeamByRankByWeek($team_id, $week)
    {
        $year = date('Y');
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $year = $systemSettings->season;
        }
        $week_range = range(1, $week);
        $returnArray = [];
        $total_win = 0;
        $total_loss = 0;
        $total_tie = 0;

        if (! empty($week_range)) {
            foreach ($week_range as $key=>$val) {
                $winCount = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $val)->where('win', 1)->count();
                $lossCount = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $val)->where('loss', 1)->count();
                $tieCount = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $val)->where('tie', 1)->count();
                $total_win += $winCount;
                $total_loss += $lossCount;
                $total_tie += $tieCount;
            }
        }

        $returnArray['total_win'] = $total_win;
        $returnArray['total_loss'] = $total_loss;
        $returnArray['total_tie'] = $total_tie;

        return $returnArray;
    }

    public static function getDivisionTeamByRank($league_id, $week)
    {
        $year = date('Y');
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $year = $systemSettings->season;
        }

        $divisions = FantasyTeam::where('league_id', $league_id)->get();

        /*$divisions		= DraftOrder::selectRaw("round_overall_pick,fantasy_team_id,f.name as teamName")
                        ->leftJoin('fantasy_teams as f','f.id','=','draft_order.fantasy_team_id')
                        ->where('round',1)->whereIn('round_overall_pick',array(1,2,3,4,5,6,7,8,9,10,11,12))
                        ->where('draft_order.league_id',$league_id)
                        ->whereIn('round_overall_pick',array(1,2,3,4,5,6,7,8,9,10,11,12))
                        ->orderBy('round_overall_pick')->get();

        */
        $divisions = $divisions->toArray();

        $returnArray = $northArray = $southArray = $westArray = $eastArray = [];
        if (! empty($divisions)) {
            foreach ($divisions as $key=>$val) {
                $winCount = LeagueGame::where('team_id', $val['id'])->where('year', $year)->where('week', $week)->where('win', 1)->count();
                $lossCount = LeagueGame::where('team_id', $val['id'])->where('year', $year)->where('week', $week)->where('loss', 1)->count();
                $tieCount = LeagueGame::where('team_id', $val['id'])->where('year', $year)->where('week', $week)->where('tie', 1)->count();
                $total = $winCount + $lossCount + $tieCount;
                if ($total > 0) {
                    $pct = $winCount;
                } else {
                    $pct = 0;
                }
                $gb = 0;
                $streak = 0;
                $div = 0;
                $wks = 0;
                $pf = LeagueGame::where('team_id', $val['id'])->where('year', $year)->sum('team_score');
                $back = 0;
                $pa = LeagueGame::where('team_id', $val['id'])->where('year', $year)->sum('opponent_score');

                $val['PCT'] = $pct;
                $val['PF'] = number_format($pf, 2);
                if (in_array($val['league_team_number'], [1, 2, 3])) {
                    $northArray[$key] = $val;
                } elseif (in_array($val['league_team_number'], [4, 5, 6])) {
                    $southArray[$key] = $val;
                } elseif (in_array($val['league_team_number'], [7, 8, 9])) {
                    $westArray[$key] = $val;
                } elseif (in_array($val['league_team_number'], [10, 11, 12])) {
                    $eastArray[$key] = $val;
                }
            }

            $response['north']['name'] = 'NORTH DIVISION';
            $northArray = (array_values($northArray));
            $PCT = array_column($northArray, 'PCT');
            $PF = array_column($northArray, 'PF');
            array_multisort($PCT, SORT_DESC, $PF, SORT_DESC, $northArray);
            $response['north']['teams'] = array_values($northArray);

            $response['south']['name'] = 'SOUTH DIVISION';
            $southArray = (array_values($southArray));
            $SPCT = array_column($southArray, 'PCT');
            $SPF = array_column($southArray, 'PF');
            array_multisort($SPCT, SORT_DESC, $SPF, SORT_DESC, $southArray);
            $response['south']['teams'] = array_values($southArray);

            $response['east']['name'] = 'EAST DIVISION';
            $eastArray = (array_values($eastArray));
            $EPCT = array_column($eastArray, 'PCT');
            $EPF = array_column($eastArray, 'PF');
            array_multisort($EPCT, SORT_DESC, $EPF, SORT_DESC, $eastArray);
            $response['east']['teams'] = array_values($eastArray);

            $response['west']['name'] = 'WEST DIVISION';
            $westArray = (array_values($westArray));
            $WPCT = array_column($westArray, 'PCT');
            $WPF = array_column($westArray, 'PF');
            array_multisort($WPCT, SORT_DESC, $WPF, SORT_DESC, $westArray);
            $response['west']['teams'] = array_values($westArray);

            $team_ranking = [];

            foreach ($response as $key=>$value) {
                $team_ranking[$value['name']] = $value;
            }

            return $team_ranking;
        }
    }

    //Calculate for week 16
    public static function getTeamRankForWeek16($league_id, $year, $team_id)
    {
        //$week_range=range(16, 16);

        $weeklySchedule = LeagueSchedule::selectRaw('home_team_id,away_team_id,reg_season_tourn_type')
                                    ->where('league_schedule.league_id', $league_id)
                                    ->where('league_schedule.year', $year)
                                    ->where('league_schedule.week', 16)
                                    ->get()->toArray();

        $team_category = [];
        if (! empty($weeklySchedule)) {
            foreach ($weeklySchedule as $key=>$val) {
                if (strpos($val['reg_season_tourn_type'], 'conference_championship')) {
                    $team_category['conference_championship'][$val['home_team_id']] = $val['home_team_id'];
                    $team_category['conference_championship'][$val['away_team_id']] = $val['away_team_id'];
                }

                if (strpos($val['reg_season_tourn_type'], 'cons_round_1')) {
                    $team_category['cons_round_1'][$val['home_team_id']] = $val['home_team_id'];
                    $team_category['cons_round_1'][$val['away_team_id']] = $val['away_team_id'];
                }
            }
        }
        $team_ranking = [];

        if (! empty($team_category)) {
            $reg_season_tourn_type = $team_category['conference_championship'];
            $conference_championship = in_array($team_id, $reg_season_tourn_type);
            if ($conference_championship) {
                $category_type = 'conference_championship';
                //dd($team_id, $category_type);
            }

            $reg_season_tourn_type = $team_category['cons_round_1'];
            $conference_championship = in_array($team_id, $reg_season_tourn_type);
            if ($conference_championship) {
                $category_type = 'cons_round_1';
            }

            // if ($team_id==15) {
            //     dd($team_id, $category_type);
            // }

            $week_range = range(16, 16);

            $conference_championship = [];
            $teamArray = [];

            $team_rankings = [

                'conference_championship'=>[
                    1 => [
                        'tournament_rank' => 1,
                        'tournament_pts' => 11.5,
                    ],
                    2 => [
                        'tournament_rank' => 1,
                        'tournament_pts' => 11.5,
                    ],

                    3 => [
                        'tournament_rank' => 3,
                        'tournament_pts' => 7.5,
                    ],
                    4 => [
                        'tournament_rank' => 3,
                        'tournament_pts' => 7.5,
                    ],
                ],
                'cons_round_1'           =>[
                    1 => [
                        'tournament_rank' => 3,
                        'tournament_pts' => 7.5,
                    ],
                    2 => [
                        'tournament_rank' => 3,
                        'tournament_pts' => 7.5,
                    ],
                    3 => [
                        'tournament_rank' => 3,
                        'tournament_pts' => 7.5,
                    ],
                    4 => [
                        'tournament_rank' => 3,
                        'tournament_pts' => 7.5,
                    ],
                    5 => [
                        'tournament_rank' => 9,
                        'tournament_pts' => 2.5,
                    ],
                    6 => [
                        'tournament_rank' => 9,
                        'tournament_pts' => 2.5,
                    ],
                    7 => [
                        'tournament_rank' => 9,
                        'tournament_pts' => 2.5,
                    ],
                    8 => [
                        'tournament_rank' => 9,
                        'tournament_pts' => 2.5,
                    ],
                ],
            ];

            $teamArray = [];
            if (! empty($team_category)) {
                foreach ($team_category[$category_type] as $key=>$val) {
                    $winCount = LeagueGame::where('team_id', $val)->where('year', $year)->whereIn('week', $week_range)->where('win', 1)->count();
                    $lossCount = LeagueGame::where('team_id', $val)->where('year', $year)->whereIn('week', $week_range)->where('loss', 1)->count();
                    $tieCount = LeagueGame::where('team_id', $val)->where('year', $year)->whereIn('week', $week_range)->where('tie', 1)->count();
                    $total = $winCount + $lossCount + $tieCount;
                    if ($total > 0) {
                        $pct = $winCount / ($winCount + $lossCount + $tieCount);
                    } else {
                        $pct = 0;
                    }

                    $pf = LeagueGame::where('team_id', $val)->where('year', $year)->whereIn('week', $week_range)->sum('team_score');
                    $back = 0;
                    $pa = LeagueGame::where('team_id', $val)->where('year', $year)->whereIn('week', $week_range)->sum('opponent_score');

                    $teamval['winCount'] = $winCount;
                    $teamval['lossCount'] = $lossCount;
                    $teamval['tieCount'] = $tieCount;
                    $teamval['PCT'] = $pct;
                    $teamval['PCT'] = $pct;
                    $teamval['team_id'] = $val;
                    $teamval['PF'] = number_format($pf, 2);

                    $teamArray[$key] = $teamval;
                }
            }

            //dd($teamArray);

            $teamArray = (array_values($teamArray));
            $winCount = array_column($teamArray, 'winCount');
            $pf = array_column($teamArray, 'PF');

            // if ($team_id==15) {
            //     dd($team_id, $teamArray, $category_type);
            // }

            array_multisort($winCount, SORT_DESC, $pf, SORT_DESC, $teamArray);

            $team_pct = array_column($teamArray, 'team_id');
            $rank_position = array_search($team_id, $team_pct);
            $rank_position_value = $rank_position + 1;

            $team_ranking = $team_rankings[$category_type][$rank_position_value];
        }

        // $ft = FantasyTeam::where("id", $team_id)->first();
        // dd($ft->name, $team_ranking);
        return $team_ranking;
    }

    //Calculate for week 15
    public static function getTeamRankForWeek15($league_id, $year, $team_id)
    {
        $week_range = range(15, 15);

        $winCount = LeagueGame::where('team_id', $team_id)->where('year', $year)->whereIn('week', $week_range)->where('win', 1)->count();

        if ($winCount == 2) {
            $teamRank['tournament_rank'] = 1;
            $teamRank['tournament_pts'] = 8.5;
        } else {
            $teamRank['tournament_rank'] = 5;
            $teamRank['tournament_pts'] = 5;
        }

        //dd($teamRank);
        return $teamRank;
    }

    public static function getTeamRankForWeek17($league_id, $year, $team_id)
    {
        $conference_championship = LeagueSchedule::selectRaw('home_team_id,away_team_id,reg_season_tourn_type')
                                    ->where('league_schedule.league_id', $league_id)
                                    ->where('league_schedule.year', $year)
                                    ->where('league_schedule.week', 17)
                                    ->get()->toArray();

        $team_category = [];
        if (! empty($conference_championship)) {
            foreach ($conference_championship as $key=>$val) {
                if ($val['reg_season_tourn_type'] == 'league_championship') {
                    $team_category['conference_championship'][$val['home_team_id']] = $val['home_team_id'];
                    $team_category['conference_championship'][$val['away_team_id']] = $val['away_team_id'];
                }

                if ($val['reg_season_tourn_type'] == 'cons_finals') {
                    $team_category['cons_finals'][$val['home_team_id']] = $val['home_team_id'];
                    $team_category['cons_finals'][$val['away_team_id']] = $val['away_team_id'];
                }

                if ($val['reg_season_tourn_type'] == 'toilet_bowl') {
                    $team_category['toilet_bowl'][$val['home_team_id']] = $val['home_team_id'];
                    $team_category['toilet_bowl'][$val['away_team_id']] = $val['away_team_id'];
                }
            }
        }
        $team_ranking = [];

        if (! empty($team_category)) {
            $reg_season_tourn_type = $team_category['conference_championship'];
            $conference_championship = in_array($team_id, $reg_season_tourn_type);
            if ($conference_championship) {
                $category_type = 'conference_championship';
            }

            $reg_season_tourn_type = $team_category['cons_finals'];
            $conference_championship = in_array($team_id, $reg_season_tourn_type);
            if ($conference_championship) {
                $category_type = 'cons_finals';
            }

            $reg_season_tourn_type = $team_category['toilet_bowl'];
            $conference_championship = in_array($team_id, $reg_season_tourn_type);
            if ($conference_championship) {
                $category_type = 'toilet_bowl';
            }

            $week_range = range(17, 17);

            $conference_championship = [];
            $teamArray = [];

            $team_rankings = [

                'conference_championship'=>[1 => [
                    'tournament_rank' => 1,
                    'tournament_pts' => 12,
                ],
                    2 => [
                        'tournament_rank' => 2,
                        'tournament_pts' => 11,
                    ],
                ],
                'cons_finals'			=>[1 => [
                    'tournament_rank' => 3,
                    'tournament_pts' => 10,
                ],
                    2 => [
                        'tournament_rank' => 4,
                        'tournament_pts' => 9,
                    ],
                    3 => [
                        'tournament_rank' => 5,
                        'tournament_pts' => 8,
                    ],
                    4 => [
                        'tournament_rank' => 6,
                        'tournament_pts' => 7,
                    ],
                    5 => [
                        'tournament_rank' => 7,
                        'tournament_pts' => 6,
                    ],
                    6 => [
                        'tournament_rank' => 8,
                        'tournament_pts' => 5,
                    ],
                ],
                'toilet_bowl'			=>[1 => [
                    'tournament_rank' => 9,
                    'tournament_pts' => 4,
                ],
                    2 => [
                        'tournament_rank' => 10,
                        'tournament_pts' => 3,
                    ],
                    3 => [
                        'tournament_rank' => 11,
                        'tournament_pts' => 2,
                    ],
                    4 => [
                        'tournament_rank' => 12,
                        'tournament_pts' => 1,
                    ],
                ],
            ];

            if (! empty($team_category)) {
                foreach ($team_category[$category_type] as $key=>$val) {
                    $winCount = LeagueGame::where('team_id', $val)->where('year', $year)->whereIn('week', $week_range)->where('win', 1)->count();
                    $lossCount = LeagueGame::where('team_id', $val)->where('year', $year)->whereIn('week', $week_range)->where('loss', 1)->count();
                    $tieCount = LeagueGame::where('team_id', $val)->where('year', $year)->whereIn('week', $week_range)->where('tie', 1)->count();
                    $total = $winCount + $lossCount + $tieCount;
                    if ($total > 0) {
                        $pct = $winCount / ($winCount + $lossCount + $tieCount);
                    } else {
                        $pct = 0;
                    }

                    $pf = LeagueGame::where('team_id', $val)->where('year', $year)->whereIn('week', $week_range)->sum('team_score');
                    $back = 0;
                    $pa = LeagueGame::where('team_id', $val)->where('year', $year)->whereIn('week', $week_range)->sum('opponent_score');

                    $teamval['winCount'] = $winCount;
                    $teamval['lossCount'] = $lossCount;
                    $teamval['tieCount'] = $tieCount;
                    $teamval['PCT'] = $pct;
                    $teamval['PCT'] = $pct;
                    $teamval['team_id'] = $val;
                    $teamval['PF'] = number_format($pf, 2);

                    $teamArray[$key] = $teamval;
                }
            }

            $teamArray = (array_values($teamArray));
            $winCount = array_column($teamArray, 'winCount');
            $pf = array_column($teamArray, 'PF');

            array_multisort($winCount, SORT_DESC, $pf, SORT_DESC, $teamArray);

            $team_pct = array_column($teamArray, 'team_id');
            $rank_position = array_search($team_id, $team_pct);
            $rank_position_value = $rank_position + 1;

            $team_ranking = $team_rankings[$category_type][$rank_position_value];
        }

        return $team_ranking;
    }

    public static function getTeamRankUpToWeek($league_id, $team_id, $week)
    {
        //$year			= date('Y');
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $year = $systemSettings->season;
        }

        $divisions = FantasyTeam::where('league_id', $league_id)->get();

        /*
        $divisions		= DraftOrder::selectRaw("f.name as teamName,fantasy_team_id")
                        ->leftJoin('fantasy_teams as f','f.id','=','draft_order.fantasy_team_id')
                        ->where('round',1)->whereIn('round_overall_pick',array(1,2,3,4,5,6,7,8,9,10,11,12))
                        ->where('draft_order.league_id',$league_id)
                        ->whereIn('round_overall_pick',array(1,2,3,4,5,6,7,8,9,10,11,12))
                        ->orderBy('round_overall_pick')->get();

                */
        $divisions = $divisions->toArray();

        //$week_range=range($week,$week);
        $week_range = range(1, $week);

        $returnArray = [];
        $team_ranking = [];
        $total_win = 0;
        $total_loss = 0;
        $total_tie = 0;

        if (! empty($divisions)) {
            foreach ($divisions as $key=>$val) {
                $winCount = LeagueGame::where('team_id', $val['id'])->where('year', $year)->whereIn('week', $week_range)->where('win', 1)->count();
                $lossCount = LeagueGame::where('team_id', $val['id'])->where('year', $year)->whereIn('week', $week_range)->where('loss', 1)->count();
                $tieCount = LeagueGame::where('team_id', $val['id'])->where('year', $year)->whereIn('week', $week_range)->where('tie', 1)->count();
                $total = $winCount + $lossCount + $tieCount;
                if ($total > 0) {
                    $pct = $winCount / ($winCount + $lossCount + $tieCount);
                } else {
                    $pct = 0;
                }
                $gb = 0;
                $streak = 0;
                $div = 0;
                $wks = 0;

                // Calculate PF and PA. Get first value for each week (because weeks 15,16,17 can have more than 1 game)
                $pfTotal = 0;
                $paTotal = 0;
                foreach ($week_range as $theWeek) {
                    $game = LeagueGame::where('team_id', $val['id'])
                            ->where('year', $year)
                            ->where('week', $theWeek)
                            ->first();

                    //dd($game->team_score);
                    if ($game) {
                        $pfTotal += $game->team_score;
                        $paTotal += $game->opponent_score;
                    }
                }
                //$pf				=	LeagueGame::where('team_id', $val['id'])->where('year', $year)->whereIn('week', $week_range)->sum('team_score');
                $back = 0;
                //$pa				=	LeagueGame::where('team_id', $val['id'])->where('year', $year)->whereIn('week', $week_range)->sum('opponent_score');
                $total_win += $winCount;
                $total_loss += $lossCount;
                $total_tie += $tieCount;
                $val['winCount'] = $winCount;
                $val['lossCount'] = $lossCount;
                $val['tieCount'] = $tieCount;
                $val['PCT'] = $pct;
                $val['pa'] = number_format($paTotal, 2);
                $val['PF'] = number_format($pfTotal, 2);

                $returnArray[$key] = $val;
            }
        }
        //dd($returnArray);

        // $pfTotal				=	LeagueGame::where('team_id', $team_id)->where('year', $year)->whereIn('week', $week_range)->sum('team_score');
        // $paTotal				=	LeagueGame::where('team_id', $team_id)->where('year', $year)->whereIn('week', $week_range)->sum('opponent_score');
        $pfTotal = 0;
        $paTotal = 0;
        foreach ($week_range as $theWeek) {
            $game = LeagueGame::where('team_id', $team_id)
                    ->where('year', $year)
                    ->where('week', $theWeek)
                    ->first();

            if ($game) {
                $pfTotal += $game->team_score;
                $paTotal += $game->opponent_score;
            }
        }

        $team_win_loss = [];
        $team_win_loss['total_win'] = $total_win;
        $team_win_loss['total_loss'] = $total_loss;
        $team_win_loss['total_tie'] = $total_tie;

        $returnArray = (array_values($returnArray));
        $PCT = array_column($returnArray, 'PCT');
        array_multisort($PCT, SORT_ASC, $returnArray);
        $team_ranks_by_pct = array_values($returnArray);
        //dd($team_ranks_by_pct);

        $pa = array_column($returnArray, 'pa');
        array_multisort($pa, SORT_ASC, $returnArray);
        $team_ranks_by_pa = array_values($returnArray);

        $pf = array_column($returnArray, 'PF');
        array_multisort($pf, SORT_ASC, $returnArray);
        $team_ranks_by_pf = array_values($returnArray);

        $team_ranking['team_ranks_by_pa'] = $team_ranks_by_pa;
        $team_ranking['team_ranks_by_pct'] = $team_ranks_by_pct;

        $teamPctData = $team_ranks_by_pct;

        $team_pct = array_column($team_ranks_by_pct, 'PCT', 'id');

        //Count #number of occurences of the value
        $numberOfOccurences = array_keys($team_pct, $team_pct[$team_id]);
        //echo $team_pct ."\r\n";

        //echo $team_pct[$team_id] ." has ". count($numberOfOccurences) ."\r\n";

        $sharedPts = 0;
        foreach ($numberOfOccurences as $key => $pctTeamId) {
            // Get the position (+1) to know the number of points that would be shared.
            $getKeys = array_keys($team_pct);
            $sharedPts = $sharedPts + (array_search($pctTeamId, $getKeys) + 1);
            //echo $pctTeamId .": Position " . array_search($pctTeamId, $getKeys) ."\r\n";
        }
        $perTeam = $sharedPts / count($numberOfOccurences);
        //echo "Shared Pts would be: " .$sharedPts ." | Per team: ". $perTeam ."\r\n";
        //echo "---------"."\r\n";
        //print_r($numberOfOccurences);
        //dd($team_pct);

        //dd($team_pct[$team_id]);
        $head_to_head_pts = $perTeam;

        $pct_position = array_search($team_id, $team_pct);

        //echo "pct_position ". print_r($pct_position);

        // 9/14/21: Disable this because we are not using the $points_against data anywhere.
//        if ($team_ranks_by_pct) {
        ////            echo "team_ranks_by_pct: ". print_r($team_ranks_by_pct);
        ////            echo "pct_position: ". print_r($pct_position);
//            $team_pct_score = array_column($team_ranks_by_pct, 'pa');
        ////            echo "team_pct_score: ". print_r($team_pct_score);
//            $points_against=$team_pct_score[$pct_position];
//        }

        if ($team_ranks_by_pf) {
            $team_pf_score = array_column($team_ranks_by_pf, 'id');
            $position = array_search($team_id, $team_pf_score);
            $points_for_pts = $position + 1;
        }

        $tournament_pts = 0;
        $tournament_rank = 0;
        $sim_overall_pts = 0;

        if ($week == 15) {
            $teamrank = self::getTeamRankForWeek15($league_id, $year, $team_id);
            $tournament_rank = $teamrank['tournament_rank'];
            $tournament_pts = $teamrank['tournament_pts'];
        }

        if ($week == 16) {
            $teamrank = self::getTeamRankForWeek16($league_id, $year, $team_id);
            $tournament_rank = $teamrank['tournament_rank'];
            $tournament_pts = $teamrank['tournament_pts'];
            //dd($teamrank);
        }

        if ($week == 17) {
            $teamrank = self::getTeamRankForWeek17($league_id, $year, $team_id);
            $tournament_rank = $teamrank['tournament_rank'];
            $tournament_pts = $teamrank['tournament_pts'];
            //dd($teamrank);
        }

        $sim_overall_pts = self::getTeamSimRankUpToWeek($league_id, $team_id, $week);

        $coach_score = $head_to_head_pts + $points_for_pts + $tournament_pts + $sim_overall_pts;

        $team_ranking['team_scores'] = [

            'head_to_head_pts'  =>$head_to_head_pts,
            'points_against'    =>$paTotal,
            'points_for'		=>$pfTotal,
            'points_for_pts'	=>$points_for_pts,
            'team_id'			=>$team_id,
            'sim_overall_pts'	=>$sim_overall_pts,
            'coach_score'		=>$coach_score,
            'tournament_rank'   => $tournament_rank,
            'tournament_pts'    => $tournament_pts,
        ];

        $team_win_loss = self::getLeaqueTeamRankByWeek($team_id, $week);
        $team_ranking['team_win_loss'] = $team_win_loss;
        $teamsim_win_loss = self::getTeamSimRankByWeek($team_id, $week);

        $team_ranking['teamSim_win_loss'] = $teamsim_win_loss;
        $team_ranking['sim_overall_pts'] = $sim_overall_pts;
        $team_ranking['coach_score'] = $coach_score;

        return $team_ranking;
    }

    public static function getTeamSimRankUpToWeek($league_id, $team_id, $week)
    {
        $year = date('Y');
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $year = $systemSettings->season;
        }
        $divisions = FantasyTeam::where('league_id', $league_id)->get();
        /*$divisions		= DraftOrder::selectRaw("f.name as teamName,fantasy_team_id")
                        ->leftJoin('fantasy_teams as f','f.id','=','draft_order.fantasy_team_id')
                        ->where('round',1)->whereIn('round_overall_pick',array(1,2,3,4,5,6,7,8,9,10,11,12))
                        ->where('draft_order.league_id',$league_id)
                        ->whereIn('round_overall_pick',array(1,2,3,4,5,6,7,8,9,10,11,12))
                        ->orderBy('round_overall_pick')->get();*/
        $divisions = $divisions->toArray();

        //$week_range=range($week,$week);
        $week_range = range(1, $week);
        $returnArray = [];
        $team_ranking = [];
        if (! empty($divisions)) {
            foreach ($divisions as $key=>$val) {
                $winCount = LeagueGamesSim::where('team_id', $val['id'])->where('year', $year)->whereIn('week', $week_range)->where('win', 1)->count();
                $lossCount = LeagueGamesSim::where('team_id', $val['id'])->where('year', $year)->whereIn('week', $week_range)->where('loss', 1)->count();
                $tieCount = LeagueGamesSim::where('team_id', $val['id'])->where('year', $year)->whereIn('week', $week_range)->where('tie', 1)->count();
                $total = $winCount + $lossCount + $tieCount;
                if ($total > 0) {
                    $pct = $winCount / ($winCount + $lossCount + $tieCount);
                } else {
                    $pct = 0;
                }
                $gb = 0;
                $streak = 0;
                $div = 0;
                $wks = 0;
                $pf = LeagueGamesSim::where('team_id', $val['id'])->where('year', $year)->whereIn('week', $week_range)->sum('team_score');
                $back = 0;
                $pa = LeagueGamesSim::where('team_id', $val['id'])->where('year', $year)->whereIn('week', $week_range)->sum('opponent_score');

                $val['winCount'] = $winCount;
                $val['lossCount'] = $lossCount;
                $val['tieCount'] = $tieCount;
                $val['PCT'] = $pct;
                $val['pa'] = $pa;
                $val['PF'] = number_format($pf, 2);

                $returnArray[$key] = $val;
            }
        }

        $returnArray = (array_values($returnArray));
        $PCT = array_column($returnArray, 'PCT');
        array_multisort($PCT, SORT_ASC, $returnArray);
        $team_ranks_by_pct = array_values($returnArray);

        $team_pct = array_column($team_ranks_by_pct, 'PCT', 'id');

        //Count #number of occurences of the value
        $numberOfOccurences = array_keys($team_pct, $team_pct[$team_id]);
        //echo $team_pct ."\r\n";

        // echo $team_pct[$team_id] ." has ". count($numberOfOccurences) ."\r\n";

        $sharedPts = 0;
        foreach ($numberOfOccurences as $key => $pctTeamId) {
            // Get the position (+1) to know the number of points that would be shared.
            $getKeys = array_keys($team_pct);
            $sharedPts = $sharedPts + (array_search($pctTeamId, $getKeys) + 1);
            // echo $pctTeamId .": Position " . array_search($pctTeamId, $getKeys) ."\r\n";
        }
        $perTeam = $sharedPts / count($numberOfOccurences);
        // echo "Shared Pts would be: " .$sharedPts ." | Per team: ". $perTeam ."\r\n";
        // echo "---------"."\r\n";
        //print_r($numberOfOccurences);
        //dd($team_pct);

        //dd($team_pct[$team_id]);
        $head_to_head_pts = $perTeam;

        // $team_pct = array_column($team_ranks_by_pct, 'id');
        // $pct_position = array_search($team_id, $team_pct);
        // $head_to_head_pts=$pct_position+1;

        return $head_to_head_pts;
    }

    public static function getTeamSimRankByWeek($team_id, $week)
    {
        $year = date('Y');
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $year = $systemSettings->season;
        }
        //$week_range=range($week,$week);
        $week_range = range(1, $week);

        $returnArray = [];
        $total_win = 0;
        $total_loss = 0;
        $total_tie = 0;

        if (! empty($week_range)) {
            foreach ($week_range as $key=>$val) {
                $winCount = LeagueGamesSim::where('team_id', $team_id)->where('year', $year)->where('week', $val)->where('win', 1)->count();
                $lossCount = LeagueGamesSim::where('team_id', $team_id)->where('year', $year)->where('week', $val)->where('loss', 1)->count();
                $tieCount = LeagueGamesSim::where('team_id', $team_id)->where('year', $year)->where('week', $val)->where('tie', 1)->count();
                $total_win += $winCount;
                $total_loss += $lossCount;
                $total_tie += $tieCount;
            }
        }

        $returnArray['total_win'] = $total_win;
        $returnArray['total_loss'] = $total_loss;
        $returnArray['total_tie'] = $total_tie;

        return $returnArray;
    }

    public static function getLeaqueTeamRankByWeek($team_id, $week)
    {
        $year = date('Y');
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $year = $systemSettings->season;
        }
        //$week_range=range($week,$week);
        $week_range = range(1, $week);
        $returnArray = [];
        $total_win = 0;
        $total_loss = 0;
        $total_tie = 0;

        if (! empty($week_range)) {
            foreach ($week_range as $key=>$val) {
                $winCount = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $val)->where('win', 1)->count();
                $lossCount = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $val)->where('loss', 1)->count();
                $tieCount = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $val)->where('tie', 1)->count();
                $total_win += $winCount;
                $total_loss += $lossCount;
                $total_tie += $tieCount;
            }
        }

        $returnArray['total_win'] = $total_win;
        $returnArray['total_loss'] = $total_loss;
        $returnArray['total_tie'] = $total_tie;

        return $returnArray;
    }

    public static function getConferenceChampionshipRankMatch($championShipMatchup, $year, $week)
    {
        $returnArray = [];
        if (is_array($championShipMatchup)) {
            foreach ($championShipMatchup as $team) {
                $val = [];

                $team_id = $team['team_id'];
                $winCount = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $week)->where('win', 1)->count();
                $lossCount = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $week)->where('loss', 1)->count();
                $tieCount = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $week)->where('tie', 1)->count();
                $total = $winCount + $lossCount + $tieCount;
                if ($total > 0) {
                    $pct = $winCount / ($winCount + $lossCount + $tieCount);
                } else {
                    $pct = 0;
                }

                $pf = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $week)->sum('team_score');

                $val['winCount'] = $winCount;
                $val['lossCount'] = $lossCount;
                $val['tieCount'] = $tieCount;
                $val['PCT'] = $pct;
                $val['team_id'] = $team_id;
                $val['PF'] = number_format($pf, 2);

                //dd($val);
                array_push($returnArray, $val);
            }
        }

        // dd($returnArray);
        //return $val;

        $returnArray = (array_values($returnArray));
        //dd($returnArray);
        $winCount = array_column($returnArray, 'winCount');
        $PF = array_column($returnArray, 'PF');
        array_multisort($winCount, SORT_DESC, $PF, SORT_DESC, $returnArray);
        $returnArray = array_values($returnArray);
        //dd($returnArray);

        return $returnArray;
    }

    public static function getConferenceChampionshipRank($team_id, $year, $week)
    {
        $val = [];

        if ($team_id) {
            $winCount = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $week)->where('win', 1)->count();
            $lossCount = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $week)->where('loss', 1)->count();
            $tieCount = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $week)->where('tie', 1)->count();
            $total = $winCount + $lossCount + $tieCount;
            if ($total > 0) {
                $pct = $winCount / ($winCount + $lossCount + $tieCount);
            } else {
                $pct = 0;
            }

            $pf = LeagueGame::where('team_id', $team_id)->where('year', $year)->where('week', $week)->sum('team_score');

            $val['winCount'] = $winCount;
            $val['lossCount'] = $lossCount;
            $val['tieCount'] = $tieCount;
            $val['PCT'] = $pct;
            $val['team_id'] = $team_id;
            $val['PF'] = number_format($pf, 2);
        }

        return $val;

        // $returnArray	=(array_values($returnArray));
        // $winCount 		= array_column($returnArray, 'winCount');
        // $PF 			= array_column($returnArray, 'PF');
        // array_multisort($winCount, SORT_DESC, $PF, SORT_DESC, $returnArray);
        // $returnArray = array_values($returnArray);
        // return $returnArray;
    }

    public static function getNationalConference($league_id, $year, $week)
    {
        $nationalConference = [];
        $nationalConference_best_teams = [];
        $national_conference = LeagueSchedule::where('reg_season_tourn_type', 'national_conference_cons_round_1')
                                                    ->where('league_id', $league_id)
                                                    ->where('year', $year)
                                                    ->where('week', $week)
                                                    ->get()->toArray();
        $team_ids = [];
        foreach ($national_conference as $key=>$val) {
            $team_ids[$val['home_team_id']] = $val;
            $team_ids[$val['away_team_id']] = $val;
        }

        if (! empty($team_ids)) {
            foreach ($team_ids as $key=>$val) {
                $national_leaque = LeagueGame::where('team_id', $key)
                                                ->where('year', $val['year'])
                                                ->where('week', $val['week'])
                                                ->first();

                $winCount = ! empty($national_leaque) ? $national_leaque->win : 0;
                $lossCount = ! empty($national_leaque) ? $national_leaque->loss : 0;
                $tieCount = ! empty($national_leaque) ? $national_leaque->tie : 0;
                $total = $winCount + $lossCount + $tieCount;
                if ($total > 0) {
                    $pct = $winCount / ($winCount + $lossCount + $tieCount);
                } else {
                    $pct = 0;
                }

                $pf = LeagueGame::where('team_id', $key)
                                                ->where('year', $val['year'])
                                                ->where('week', $val['week'])->sum('team_score');
                $val['winCount'] = $winCount;
                $val['lossCount'] = $lossCount;
                $val['tieCount'] = $tieCount;
                $val['PCT'] = $pct;
                $val['team_id'] = ! empty($national_leaque) ? $national_leaque->team_id : '';
                $val['PF'] = number_format($pf, 2);
                $nationalConference[$key] = $val;
            }
        }

        $nationalConference = (array_values($nationalConference));
        $winCount = array_column($nationalConference, 'winCount');
        $PF = array_column($nationalConference, 'PF');
        array_multisort($winCount, SORT_DESC, $PF, SORT_DESC, $nationalConference);
        $nationalConference_best_teams = array_values($nationalConference);

        return $nationalConference_best_teams;
    }

    public static function getAmericanConference($league_id, $year, $week)
    {
        $americanConference = [];
        $americanConference_best_teams = [];
        $american_conference = LeagueSchedule::where('reg_season_tourn_type', 'american_conference_cons_round_1')
                                                    ->where('league_id', $league_id)
                                                    ->where('year', $year)
                                                    ->where('week', $week)
                                                    ->get()->toArray();

        $team_ids = [];
        foreach ($american_conference as $key=>$val) {
            $team_ids[$val['home_team_id']] = $val;
            $team_ids[$val['away_team_id']] = $val;
        }

        if (! empty($team_ids)) {
            foreach ($team_ids as $key=>$val) {
                $american_leaque = LeagueGame::where('team_id', $key)
                                                ->where('year', $val['year'])
                                                ->where('week', $val['week'])
                                                ->first();

                $winCount = ! empty($american_leaque) ? $american_leaque->win : 0;
                $lossCount = ! empty($american_leaque) ? $american_leaque->loss : 0;
                $tieCount = ! empty($american_leaque) ? $american_leaque->tie : 0;
                $total = $winCount + $lossCount + $tieCount;
                if ($total > 0) {
                    $pct = $winCount / ($winCount + $lossCount + $tieCount);
                } else {
                    $pct = 0;
                }

                $pf = LeagueGame::where('team_id', $key)
                                                ->where('year', $val['year'])
                                                ->where('week', $val['week'])->sum('team_score');

                $val['winCount'] = $winCount;
                $val['lossCount'] = $lossCount;
                $val['tieCount'] = $tieCount;
                $val['PCT'] = $pct;
                $val['team_id'] = ! empty($american_leaque) ? $american_leaque->team_id : '';
                $val['PF'] = number_format($pf, 2);
                $americanConference[$key] = $val;
            }
        }

        $americanConference = (array_values($americanConference));
        $awinCount = array_column($americanConference, 'winCount');
        $aPF = array_column($americanConference, 'PF');
        array_multisort($awinCount, SORT_DESC, $aPF, SORT_DESC, $americanConference);

        return	$americanConference_best_teams = array_values($americanConference);
    }

    public static function getChampionshipFinals($league_id, $week)
    {
        $year = date('Y');
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $year = $systemSettings->season;
        }

        $winnner_national_conference_team = LeagueSchedule::where('league_id', $league_id)->where('year', $year)->where('week', $week)
                                                    ->where('reg_season_tourn_type', 'national_conference_championship')
                                                    ->first();
        $winnner_american_conference_team = LeagueSchedule::where('league_id', $league_id)->where('year', $year)->where('week', $week)
                                                    ->where('reg_season_tourn_type', 'american_conference_championship')
                                                    ->first();

        $national_home_team_id = $winnner_national_conference_team->home_team_id;
        $national_away_team_id = $winnner_national_conference_team->away_team_id;
        $american_home_team_id = $winnner_american_conference_team->home_team_id;
        $american_away_team_id = $winnner_american_conference_team->away_team_id;

        $national_championship = [
            [
                'team_id' => $national_home_team_id,
                'type' => 'national_team',

            ],
            [
                'team_id' => $national_away_team_id,
                'type' => 'national_team',
            ],
        ];

        $american_championship = [
            [
                'team_id' => $american_home_team_id,
                'type' => 'american_team',
            ],
            [
                'team_id' => $american_away_team_id,
                'type' => 'american_team',
            ],
        ];

        $national_team = self::getConferenceChampionshipRankMatch($national_championship, $year, $week);
        $american_team = self::getConferenceChampionshipRankMatch($american_championship, $year, $week);

        $championship_array = [
            'national_team'=>$national_team,
            'american_team'=>$american_team,
        ];

        return $championship_array;
    }

    public static function getTournamentPoints($tournament, $year, $week)
    {
        $returnArray = [];

        if (! empty($tournament)) {
            foreach ($tournament as $key=>$val) {
                $winCount = LeagueGame::where('team_id', $val['team_id'])->where('year', $year)->whereIn('week', $week)->where('win', 1)->count();
                $lossCount = LeagueGame::where('team_id', $val['team_id'])->where('year', $year)->whereIn('week', $week)->where('loss', 1)->count();
                $tieCount = LeagueGame::where('team_id', $val['team_id'])->where('year', $year)->whereIn('week', $week)->where('tie', 1)->count();
                $total = $winCount + $lossCount + $tieCount;
                if ($total > 0) {
                    $pct = $winCount / ($winCount + $lossCount + $tieCount);
                } else {
                    $pct = 0;
                }

                $pf = LeagueGame::where('team_id', $val['team_id'])->where('year', $year)->whereIn('week', $week)->sum('team_score');

                $val['winCount'] = $winCount;
                $val['lossCount'] = $lossCount;
                $val['tieCount'] = $tieCount;
                $val['PCT'] = number_format($pct, 2);
                $val['team_id'] = $val['team_id'];
                $val['PF'] = number_format($pf, 2);
                $returnArray[$key] = $val;
            }
        }

        $returnArray = (array_values($returnArray));
        $winCount = array_column($returnArray, 'winCount');
        $PCT = array_column($returnArray, 'PCT');
        array_multisort($PCT, SORT_DESC, $returnArray);
        $returnArray = array_values($returnArray);

        return $returnArray;
    }

    public static function getTournamentRank($league_id, $tournament, $year, $week)
    {
        //dd($week);
        $returnArray = [];

        if (! empty($tournament)) {
            foreach ($tournament as $key=>$val) {
                $result = LeagueTeamRanking::where('fatasy_team_id', $val['team_id'])
                                                            ->where('league_id', $league_id)->where('season', $year)->whereIn('week', $week)->first();

                $val['tournament_rank'] = (! empty($result->tournament_rank)) ? $result->tournament_rank : '';
                $val['tournament_pts'] = (! empty($result->tournament_pts)) ? $result->tournament_pts : '';

                $returnArray[$key] = $val;
            }
        }
        //dd($returnArray);

        $returnArray = (array_values($returnArray));
        $tournament_rank = array_column($returnArray, 'tournament_rank');
        $tournament_pts = array_column($returnArray, 'tournament_pts');
        array_multisort($tournament_rank, SORT_ASC, $returnArray);
        $returnArray = array_values($returnArray);

        return $returnArray;
    }

    public static function getTeamWinLossTie($teamArray, $year, $week)
    {
        $returnArray = [];
        if (! empty($teamArray)) {
            //dd($teamArray);
            foreach ($teamArray as $key=>$val) {
                $winCount = LeagueGame::where('team_id', $val['team_id'])->where('year', $year)->where('week', $week)->where('win', 1)->count();
                $lossCount = LeagueGame::where('team_id', $val['team_id'])->where('year', $year)->where('week', $week)->where('loss', 1)->count();
                $tieCount = LeagueGame::where('team_id', $val['team_id'])->where('year', $year)->where('week', $week)->where('tie', 1)->count();
                $total = $winCount + $lossCount + $tieCount;
                if ($total > 0) {
                    $pct = $winCount / ($winCount + $lossCount + $tieCount);
                } else {
                    $pct = 0;
                }

                $pf = LeagueGame::where('team_id', $val['team_id'])->where('year', $year)->where('week', $week)->sum('team_score');

                $val['winCount'] = $winCount;
                $val['lossCount'] = $lossCount;
                $val['tieCount'] = $tieCount;
                $val['PCT'] = number_format($pct, 2);
                $val['team_id'] = $val['team_id'];
                $val['PF'] = number_format($pf, 2);

                $returnArray[$key] = $val;
            }
        }

        $returnArray = (array_values($returnArray));
        $winCount = array_column($returnArray, 'winCount');
        $PF = array_column($returnArray, 'PF');
        array_multisort($winCount, SORT_DESC, $PF, SORT_DESC, $returnArray);
        $returnArray = array_values($returnArray);

        //dd($returnArray);
        return $returnArray;
    }

    public static function getSystemSettingsDetails()
    {
        $season = '';
        $seasonType = '';
        $week = '';

        $settingsArray = [];
        $seasonTypeArray = self::$seasonTypes;
        $systemSettings = SystemSetting::find(1);

        if ($systemSettings->week) {
            $week = $systemSettings->week;
        }

        if ($systemSettings->season) {
            $season = $systemSettings->season;
        }

        if ($systemSettings->season_type) {
            $seasonType = $seasonTypeArray[$systemSettings->season_type];
        }

        if ($season != '' && $seasonType != '') {
            $seasonVal = $season.strtolower($seasonType);
        }

        $settingsArray['week'] = $week;
        $settingsArray['season'] = $season;
        $settingsArray['seasonType'] = $seasonType;
        $settingsArray['season_type'] = $systemSettings->season_type;
        $settingsArray['seasonTypeInt'] = $systemSettings->season_type;
        $settingsArray['seasonVal'] = $seasonVal;
        $settingsArray['waiver_period_enabled'] = $systemSettings->waiver_period_enabled;
        $settingsArray['year_type'] = strtolower($season.$seasonType);

        return $settingsArray;
    }

    public static function getClaimStatus()
    {
        $claim_status = [

            1=>'claim_request',
            2=>'claim_reject',
            3=>'claim_approve',
        ];

        return $claim_status;
    }

    public static function identicalArrays($arrayA, $arrayB)
    {
        //dd($arrayA, $arrayB);
        sort($arrayA);
        sort($arrayB);

        return $arrayA == $arrayB;
    }

    public static function getPostSeasonScoreDetails($season, $seasonType, $week, $fatasy_team_id)
    {
        $points_for = 0;
        $tds = 0;
        for ($i = $week; $i > 0; $i -= 1) {
            $result = LeaguePostseasonScores::select('points_for', 'tds')
                                    ->where('fatasy_team_id', $fatasy_team_id)
                                    ->where('season_type', $seasonType)
                                    ->where('season', $season)
                                    ->where('week', $i)->first();
            if ($result) {
                $points_for += $result->points_for;
                $tds += $result->tds;
            }
        }
        $response['total_home_acme_points'] = $points_for;
        $response['tds'] = $tds;

        return $response;
    }

    /**
     * @$defStQbFlag: optional; string of position flag if applicable, ('is_def', 'is_st', 'team_qb')
     */
    public static function removePlayerFromFantasyTeam($fantasyPlayerId, $fantasyTeamId, $leagueId, $defStQbFlag = null)
    {
        $request = new Request(
            [
                'player_id' => $fantasyPlayerId,
                'fantasy_team_id' => $fantasyTeamId,
                'transaction_id' => 2,
            ],
            ['CONTENT_TYPE' => 'application/json']
        );

        $playerController = new PlayerController();
        $response = $playerController->insertTransactionDetails($request);

        if (isset($response['success']) && $response['success']) {
            return true;
        }

        return false;

        $result = false;
        $settings = SystemSetting::find(1);
        $week = $settings->week;
        $seasonType = $settings->season_type;
        $season = $settings->season;
        $isDef = $isSt = $teamQb = 0;

        $transaction_query = FantasyTeamsPlayerTransaction::where('fantasy_player_id', $fantasyPlayerId)
                                                                    ->Where(function ($query) {
                                                                        $query->orWhere('active', 1)
                                                                                          ->orWhere('bench', 1);
                                                                    });

        //Special case to handle NFL Post Season Scenarios.
        //Normally we don't care what week a player was added, we just want to "remove them"
        //However, if NFL Post Season we want to only remove the player for the specific week of the league season.
        if ($seasonType == 3) {
            $transaction_query->where('week', $week);
        }

        $transaction = $transaction_query->where('player_transaction_type_id', 1)
                                                    ->where('league_id', $leagueId)
                                                    ->where('fantasy_team_id', $fantasyTeamId)
                                                    ->first();

        if ($transaction) {

            //Ensure player is no longer active or on a bench
            //Sets the old add transaction to not be active anymore.
            $transaction->active = 0;
            $transaction->bench = 0;
            $transaction->save();

            //Create a "drop" record to store data of this event.
            FantasyTeamsPlayerTransaction::create([
                'league_id'						 => $leagueId,
                'fantasy_player_id'				 => $fantasyPlayerId,
                'fantasy_team_id' 				 => $fantasyTeamId,
                'player_transaction_type_id' 	 =>	2,
                'active' 						 => 0,
                'is_def'						 => $isDef,
                'is_st' 						 => $isSt,
                'team_qb'						 => $teamQb,
                'week' 							 => $week,
                'season' 						 => $season,
                'conditional_drop'				 =>	0,
                'season_type'					 => $seasonType,
            ]);

            //Not Needed
            //Create an "add" transaction that is no longer active. Helps the FillFantasyTeamsRoster command work.
            // FantasyTeamsPlayerTransaction::create([
            // 	'league_id'						 => $leagueId,
            // 	'player_id'						 => $fantasyPlayerId,
            // 	'fantasy_team_id' 				 => $fantasyTeamId,
            // 	'player_transaction_type_id' 	 =>	2,
            // 	'active' 						 => 0,
            // 	'is_def'						 => $isDef,
            // 	'is_st' 						 => $isSt,
            // 	'team_qb'						 => $teamQb,
            // 	'week' 							 => $week,
            // 	'season' 						 => $season,
            // 	'conditional_drop'				 =>	0,
            // 	'season_type'					 => $seasonType
            // ]);

            $result = true;
        }

        return $result;
    }

    public static function getThreeSystemSeasons()
    {
        $season = '';
        $seasonType = '';
        $week = '';

        $settingsArray = [];
        $seasonTypeArray = self::$seasonTypes;
        $systemSettings = SystemSetting::find(1);

        if ($systemSettings->week) {
            $week = $systemSettings->week;
        }

        if ($systemSettings->season) {
            $season = $systemSettings->season;
        }

        if ($systemSettings->season_type) {
            $seasonType = $seasonTypeArray[$systemSettings->season_type];
        }

        if ($season != '' && $seasonType != '') {
            $seasonVal = $season.strtolower($seasonType);
        }

        $start = ($season - 1) - 2;
        $collection = collect([]);

        foreach (range($start, $season - 1) as $number) {
            $collection->push($number);
        }

        $settingsArray['season'] = $collection->all();

        return $settingsArray;
    }

    /** Added 2020 **/
    public static function getUserFantasyTeamRoster($fantasyTeamId = null)
    {
        // TODO 04/04/2020: Do we need to use the request params?
        // if (isset($request->seasonType) && $request->seasonType !='') {
        //     $seasonType =   $request->seasonType;
        // }

        $settings = SystemSetting::find(1);
        $week = $settings->week;
        $season = $settings->season;
        $seasonType = $settings->season_type;

        $activeFilter = function ($query) use ($season, $seasonType, $week) {
            $query->where('season', $season);
            $query->where('season_type', $seasonType);
            $query->where('week', $week);
            $query->where('active', true);
            //$query->where('league_id', $league->id);
        };

        $benchFilter = function ($query) use ($season, $seasonType, $week) {
            $query->where('season', $season);
            $query->where('season_type', $seasonType);
            $query->where('week', $week);
            $query->where('bench', true);
            //$query->where('league_id', $league->id);
        };

        if ($fantasyTeamId) {
            $fantasyTeam = FantasyTeam::where('id', $fantasyTeamId)
                        ->with(['FantasyTeamRoster' => $activeFilter])
                        ->first();

            $benchFantasyTeam = FantasyTeam::where('id', $fantasyTeamId)
                        ->with(['FantasyTeamRoster' => $benchFilter])
                        ->first();
        } else {
            $userId = Auth::user()->id;
            $fantasyTeam = FantasyTeam::where('user_id', $userId)
                        ->with(['FantasyTeamRoster' => $activeFilter])
                        ->first();

            $benchFantasyTeam = FantasyTeam::where('user_id', $userId)
            ->with(['FantasyTeamRoster' => $benchFilter])
            ->first();
        }

        $fantasyTeam = $fantasyTeam->toArray();
        $fantasyTeamRoster = $fantasyTeam['fantasy_team_roster'];

        $benchFantasyTeamRoster = $benchFantasyTeam->toArray()['fantasy_team_roster'];

        $currentRosterPositionCount = array_count_values(array_column($fantasyTeamRoster, 'position'));
        $currentBenchRosterCount = array_count_values(array_column($benchFantasyTeamRoster, 'position'));

        //dd($currentRosterPositionCount);

        // Set the max roster counts allowed
        // TODO 04/05/20: Add in a logical check for postseason where we have more players
        // TODO 04/05/20: Add in a logical check for allowed bench players based on injury status or BYE
        $maxAllowed = [
            'TQB' => 1,
            'RB' => 2,
            'WR' => 2,
            'K' => 1,
            'TE' => 1,
            'ST' => 1,
            'DEF' => 1,
        ];

        // Check Injuries
        $injuries = [
            'TQB' => null,
            'RB' => null,
            'WR' => null,
            'K' => null,
            'TE' => null,
            'ST' => null,
            'DEF' => null,
        ];

        // If it is week 3 or 4 we need to turn on Flex Logic.
        if ($seasonType == 3 && $week > 2) {
            $maxAllowed = [
                'TQB' => 1,
                'RB' => 1,
                'WR' => 1,
                'K' => 1,
                'TE' => 1,
                'ST' => 1,
                'DEF' => 1,
                'FLEX' => 2,
            ];
        }

        $combinedRoster = array_merge($fantasyTeamRoster, $benchFantasyTeamRoster);
        foreach ($combinedRoster as $rosterPlayer) {
            if (isset($rosterPlayer['fantasy_player']['player']['injury_status'])
                && $rosterPlayer['fantasy_player']['player']['injury_status'] != null
                && $rosterPlayer['fantasy_player']['bye_week'] != $week) {    // If the player is injured but on a BYE then ignore it.
                $covered = 0;

                // Check if we have a replacement player from the same team and the same position
                // Active roster first
                foreach ($fantasyTeamRoster as $starter) {
                    if ($rosterPlayer['fantasy_player']['id'] != $starter['fantasy_player']['id'] &&
                        $starter['fantasy_player']['team'] == $rosterPlayer['fantasy_player']['team'] &&
                        $starter['fantasy_player']['position'] == $rosterPlayer['fantasy_player']['position']) {
                        $covered = 1;
                    }
                }

                // Check if we have a replacement player from the same team and the same position
                // now the Bench
                foreach ($benchFantasyTeamRoster as $bench) {
                    if ($rosterPlayer['fantasy_player']['id'] != $bench['fantasy_player']['id'] &&
                        $bench['fantasy_player']['team'] == $rosterPlayer['fantasy_player']['team'] &&
                        $bench['fantasy_player']['position'] == $rosterPlayer['fantasy_player']['position']) {
                        $covered = 1;
                    }
                }

                $injuries[$rosterPlayer['position']][$rosterPlayer['fantasy_player']['team']] = [
                    'team' => $rosterPlayer['fantasy_player']['team'],
                    'total' => 1,
                    'covered' => $covered,
                ];
            }
        }

        //Build an array with useful info
        $flexCounts = 0;

        // THIS ASSUMES FLEX IS ALWAYS THE LAST ITEM IN THE ARRAY.
        foreach ($maxAllowed as $position => $limit) {
            $currentPositionCount = isset($currentRosterPositionCount[$position]) ? $currentRosterPositionCount[$position] : 0;
            $currentBenchPositionCount = isset($currentBenchRosterCount[$position]) ? $currentBenchRosterCount[$position] : 0;

            if ($seasonType == 3 && $week > 2 && in_array($position, ['WR', 'RB', 'TE', 'FLEX'])) {

                // Keep track of how many positions over we are. This is the number that are "flex"
                if (($difference = $currentPositionCount - $limit) > 0) {
                    $flexCounts += $currentPositionCount - $limit;
                }

                // If we are greater than 0, then update the actual position count back down to the original amount.
                if ($difference > 0) {
                    $currentPositionCount = $currentPositionCount - $difference;
                }

                // If we are FLEX, we need to add up all the extra positions.
                // FLEX MUST ALWAYS BE LAST IN THE ARRAY LOOP FOR THIS TO WORK.
                if ($position == 'FLEX') {
                    $currentPositionCount = $flexCounts;
                }
            }
            $maxAllowed[$position] = [
                'currentStarters' => $currentPositionCount,
                'currentBench' => $currentBenchPositionCount,
                'maxAllowed' => $limit,
                'maxReached' => ($currentPositionCount >= $limit) ? true : false,
                'positionValid' => ($currentPositionCount == $limit) ? true : false,
            ];
        }

        $fantasyTeam['currentTeamCounts'] = null;

        // Remove a "ST" player from the array because it should never count against the user.
        foreach ($fantasyTeamRoster as $key => $value) {
            if ($value['position'] == 'ST') {
                unset($fantasyTeamRoster[$key]);
                continue;
            }
        }

        //dd($fantasyTeamRoster);
        if ($seasonType == 3) {
            $currentTeamCounts = array_count_values(array_map(function ($ar) {
                return $ar['team'];
            }, array_column($fantasyTeamRoster, 'fantasy_player')));
            $fantasyTeam['currentTeamCounts'] = $currentTeamCounts;
            //dd($currentTeamCounts);
        }

        $fantasyTeam['position'] = $maxAllowed;
        $fantasyTeam['bench_fantasy_team_roster'] = $benchFantasyTeamRoster;
        $fantasyTeam['injuries'] = $injuries;

        return $fantasyTeam;
    }
}
