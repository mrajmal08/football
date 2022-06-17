<?php

namespace App\Helpers;

// use App\Models\FantasyTeamsRoster;
// use App\Models\FantasyData\Score;
// use App\Models\FantasyTeamsPlayerTransaction;
use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyData\PlayerGame;
// use App\Models\FantasyData\FantasyDefenseSeason;
use App\Models\FantasyData\PlayerGameProjection;
use App\Models\FantasyData\PlayerSeason;
// use App\Models\FantasyData\FantasyDefenseGame;
// use App\Models\DraftOrder;
// use App\Models\LeagueGame;
// use App\Models\LeagueGamesSim;
// use App\Models\LeagueSchedule;
// use App\Models\LeagueTeamRanking;
// use App\Models\FantasyTeam;
// use App\Models\LeaguePostseasonScores;

use App\Models\FantasyData\PlayerSeasonProjection;
use App\Models\FantasyData\ScoringDetail;
use App\Models\FantasyData\TeamGame;
use App\Models\FantasyPlayerGameFantasyPoint;
use App\Models\SystemSetting;

class FantasyPointsHelper
{
    public static function calculateFantasyPlayerGameFantasyPoints($week, $season, $seasonType, $fantasy_player, $isProjection = false)
    {
        //dd($fantasy_player);
        // Assume we can pass a full FantasyPlayer object to reduce unnecessary queries
        // Or we can run this as a mass command and get just a player_id
        // not an object? Look up the player we need.
        if (! is_object($fantasy_player)) {
            $fantasy_player = FantasyPlayer::where('player_id', $fantasy_player)->first();
        }

        $filter = function ($query) use ($week, $season, $seasonType) {
            $query->where('season', $season);
            $query->where('week', $week);
            $query->where('season_type', $seasonType);
        };

        //Ensure we have a fantasy player before proceeding.
        if (! $fantasy_player) {
            return 0;
        }
        //dd($filter);

        //echo "Got: ". $fantasy_player->name ." ". $fantasy_player->id."\r\n";

        $offenseArray = ['RB', 'QB', 'WR', 'TE', 'TQB', 'K', 'ST'];    //Array of individual player positions (Not "Team" based)

        //If offense player load the records we need
        if (in_array($fantasy_player->position, $offenseArray)) {
            if ($isProjection) {
                $fantasy_player->load(['playerGameProjection' => $filter]);
            } else {
                $fantasy_player->load(['playerGame' => $filter]);
            }
        } else {
            if ($isProjection) {
                $fantasy_player->load(['fantasyDefenseGameProjection' => $filter]);
            } else {
                $fantasy_player->load(['fantasyDefenseGame' => $filter], ['teamGame' => $filter]);
            }
        }

        // ST Load the correct TeamGame model
        if ($fantasy_player->position == 'ST') {
            if ($isProjection) {
                $fantasy_player->load(['playerGameProjection' => $filter]);
            } else {
                $fantasy_player->load(['teamGame' => $filter]);
            }
        }

        //dd($fantasy_player);
        $game_key = '';
        $fantasy_points = 0;
        $team = $fantasy_player->team;
        $player_id = $fantasy_player->player_id;

        //Make sure we have a game_key and if we do then process to calculate points
        //if we don't have a record that means game hasn't started or player didn't play
        //Handle regular individual player positions; RB, WR, TE, QB, K
        $player_game = [];
        //dd($fantasy_player);
        if ((count($fantasy_player->playerGame) > 0 || count($fantasy_player->playerGameProjection) > 0) && $fantasy_player->position != 'ST' && $fantasy_player->position != 'TQB') {
            //echo "have this many records: ". count($fantasy_player->playerGame) ."\r\n";

            if ($isProjection) {
                if (count($fantasy_player->fantasyPlayerGameProjection) > 0) {
                    $player_game = $fantasy_player->playerGameProjection[0];
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

                $fantasy_points = 0;
                if (in_array($fantasy_player->position, $offenseArray)) {
                    $touchdownPass = self::getScores($game_key, $player_id, 'PassingTouchdown', $isProjection);
                    $touchdownRush = self::getScores($game_key, $player_id, 'RushingTouchdown', $isProjection);
                    $touchdownRec = self::getScores($game_key, $player_id, 'ReceivingTouchdown', $isProjection);

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
                        $fieldGoal = self::getScores($game_key, $player_id, 'FieldGoalMade', $isProjection);
                        $fieldGoalMissed = self::getScores($game_key, $player_id, 'FieldGoalMissed', $isProjection);
                        $fieldGoalScores = $fieldGoal['score'];
                        $fantasy_points = ($extra_points_made * 0.530) +
                                                                (($extra_points_attempted - $extra_points_made) * -0.200) +
                                                                $fieldGoalScores +
                                                                $fieldGoalMissed['score'];
                    }
                }
                $player_game->fantasy_points_acme = $fantasy_points;
                $player_game->save();
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
                //$fantasy_defense_game     = $fantasy_player->fantasyDefenseGame[0];
                $points_allowed = $fantasy_defense_game->points_allowed;
                $offensive_yards_allowed = $fantasy_defense_game->offensive_yards_allowed;
                $interceptions = $fantasy_defense_game->interceptions;
                $fumbles_recovered = $fantasy_defense_game->fumbles_recovered;
                $sacks = $fantasy_defense_game->sacks;
                $safeties = $fantasy_defense_game->safeties;
                $game_key = $fantasy_defense_game->game_key;
                //dd($game_key);
                $defensiveInterceptionTouchdownScores = self::getScores($game_key, $team, 'InterceptionReturnTouchdown', $team, $isProjection);
                $defensiveFumbleTouchdownScores = self::getScores($game_key, $team, 'FumbleReturnTouchdown', $team, $isProjection);

                //dd($defensiveFumbleTouchdownScores);
                //dd($defensiveFumbleTouchdownScores['score']);
                $fantasy_points = (6 + ($points_allowed * -0.100)) + (6 + ($offensive_yards_allowed * -0.010)) +
                                                ($interceptions * 0.250) + ($fumbles_recovered * 0.250) +
                                                ($sacks * 0.100) + ($safeties * 0.500) + $defensiveInterceptionTouchdownScores['score'] + $defensiveFumbleTouchdownScores['score'];
                $fantasy_defense_game->fantasy_points_acme = $fantasy_points;
                $fantasy_defense_game->save();
            }
        }

        //Handle "ST"
        if ((count($fantasy_player->playerGame) > 0 || count($fantasy_player->playerGameProjection) > 0) && $fantasy_player->position == 'ST') {
            //dd($fantasy_player->fantasy);
            if ($isProjection) {
                //dd($fantasy_player);
                if (count($fantasy_player->playerGameProjection) > 0) {
                    $playerGame = $fantasy_player->playerGameProjection[0];
                }
            } else {
                if (count($fantasy_player->playerGame) > 0) {
                    $playerGame = $fantasy_player->playerGame[0];
                }
            }
            // $teamGame                   = $fantasy_player->teamGame[0];
            // $playerGame                 = $fantasy_player->playerGame[0];
            // dd($playerGame);
            $game_key = $playerGame->game_key;
            $punt_return_yards = $playerGame->punt_return_yards;
            $kick_return_yards = $playerGame->kick_return_yards;

            //This is required because some scoring is related to individual plays and the amount of yards related on that play.
            //Note: TODO - Update to not use player_id but to pass the team key at the end. These Score records can be assigned
            //to  many different player_ids. So we need to get them by the "whole TEAM"

            $kickoffReturnTouchdown = self::getScores($game_key, $player_id, 'KickoffReturnTouchdown', $fantasy_player->team, $isProjection);
            $puntReturnTouchdown = self::getScores($game_key, $player_id, 'PuntReturnTouchdown', $fantasy_player->team, $isProjection);
            $blockedFieldGoalReturnTouchdown = self::getScores($game_key, $player_id, 'BlockedFieldGoalReturnTouchdown', $fantasy_player->team, $isProjection);
            $blockedPuntReturnTouchdown = self::getScores($game_key, $player_id, 'BlockedPuntReturnTouchdown', $fantasy_player->team, $isProjection);
            $fieldGoalReturnTouchdown = self::getScores($game_key, $player_id, 'FieldGoalReturnTouchdown', $fantasy_player->team, $isProjection);

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
                        $specialTeamsScores +
                        $punterScores['score'] +
                        $kickerScores['score'] +
                        $kickOffTouchbacksScores['score'];

            // if($fantasy_player->team == "KC")
            // {
            //     echo "Punt Return Yards: ".$punt_return_yards ."\r\n";
            //     echo "Kick Return Yards: ".$kick_return_yards ."\r\n";
            //     echo "Kick Off Touchback Scores: ".$kickOffTouchbacksScores['score'] ."\r\n";
            //     echo "Punter Scores: ".$punterScores['score'] ."\r\n";
            //     echo "Kicker Scores: ".$kickerScores['score'] ."\r\n";
            // }

            $playerGame->fantasy_points_acme = $fantasy_points;
            $playerGame->save();
        }

        if ((count($fantasy_player->playerGame) > 0 || count($fantasy_player->fantasyPlayerGameProjection) > 0) && $fantasy_player->position == 'TQB') {
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

            $teamQbData = self::getTqbPlayergame($fantasy_player->team, $season, $seasonType, $week, $yearly = false, $isProjection = false);
            $player_game->fantasy_points_acme = isset($teamQbData['fantasy_points_acme']) ? $teamQbData['fantasy_points_acme'] : 0.000;
            $player_game->save();
        }
        // if ($game_key) {
        //     $transactions_data=array(
        //             'fantasy_player_id'           => $fantasy_player->id,
        //             'week'                        => $week,
        //             'season'                      => $season,
        //             'season_type'                 => $seasonType,
        //             'fantasy_points'              => $fantasy_points,
        //             'game_key'                    => $game_key
        //           );
        //     if ($isProjection) {
        //         //Save the data
        //         \App\Models\FantasyPlayerProjectedGameFantasyPoint::updateOrCreate(
        //             [
        //         'week'=>$week,
        //         'season'=>$season,
        //         'season_type'=>$seasonType,
        //         'fantasy_player_id'=>$fantasy_player->id
        //         ],
        //             $transactions_data
        //         );
        //     } else {
        //         //Save the data
        //         $result = FantasyPlayerGameFantasyPoint::updateOrCreate(
        //             [
        //                 'week'=>$week,
        //                 'season'=>$season,
        //                 'season_type'=>$seasonType,
        //                 'fantasy_player_id'=>$fantasy_player->id,
        //             ],
        //             $transactions_data
        //         );
        //         // if ($fantasy_player->name == "Todd Gurley II") {
        //         //     dd($result);
        //         // }
        //     }
        // }
        unset($fantasy_player); //Help to unload memory in the app.
        unset($transactions_data);  //Help to unload memory in the app.
        unset($fantasy_defense_game); //Help to unload memory in the app.

        //return the points value for this fantasy_player.
        //dd($fantasy_points);
        return $fantasy_points;
    }

    public static function calculateFantasyPlayerSeasonFantasyPoints($season, $seasonType, $fantasy_player, $isProjection = false)
    {
        $filter = function ($query) use ($season, $seasonType) {
            $query->where('season', $season);
            $query->where('season_type', $seasonType);
        };

        if (! is_object($fantasy_player)) {
            $fantasy_player = FantasyPlayer::where('player_id', $fantasy_player)->first();
        }

        $fantasy_points = 0;
        if ($isProjection) {
            if ($fantasy_player->position == 'DEF') {
                // $fantasy_player->with(['fantasyDefenseGameProjection' => $filter])->get();
                // $fantasy_player->with(['fantasyDefenseSeasonProjection' => $filter])->get();
                $fantasy_player->load(['fantasyDefenseGameProjection' => $filter])
                                ->load(['fantasyDefenseSeasonProjection' => $filter])->get();
                $fantasy_points = $fantasy_player->fantasyDefenseGameProjection->sum('fantasy_points_acme');
                //dd($fantasy_player->fantasyDefenseGameProjection->count());
                //dd($fantasy_player->fantasyDefenseGameProjection->first()->fantasy_points_acme);
                //dd($fantasy_points);
                $fantasyDefenseSeasonProjection = $fantasy_player->fantasyDefenseSeasonProjection->first();
                if ($fantasyDefenseSeasonProjection) {
                    echo $fantasyDefenseSeasonProjection->season.' '.$fantasy_player->name.' | Pts: '.$fantasy_points."\r\n";
                    $fantasyDefenseSeasonProjection->fantasy_points_acme = $fantasy_points;
                    $fantasyDefenseSeasonProjection->save();
                }
            } else {
                // $fantasy_player->with(['playerGameProjection' => $filter])->get();
                // $fantasy_player->with(['playerSeasonProjection' => $filter])->get();
                $fantasy_player->load(['playerGameProjection' => $filter])
                                ->load(['playerSeasonProjection' => $filter])->get();
                $fantasy_points = $fantasy_player->playerGameProjection->sum('fantasy_points_acme');
                $playerSeasonProjection = $fantasy_player->playerSeasonProjection->first();
                if ($playerSeasonProjection) {
                    echo $playerSeasonProjection->season.' '.$fantasy_player->name.' | Pts: '.$fantasy_points."\r\n";
                    $playerSeasonProjection->fantasy_points_acme = $fantasy_points;
                    $playerSeasonProjection->save();
                }
            }
        } else {
            //Get the FantasyPlayer record for the player_id we were passed.
            if ($fantasy_player->position == 'DEF') {
                // $fantasy_player->with(['fantasyDefenseGame' => $filter])->get();
                // $fantasy_player->with(['fantasyDefenseSeason' => $filter])->get();
                $fantasy_player->load(['fantasyDefenseGame' => $filter])
                                ->load(['fantasyDefenseSeason' => $filter])->get();
                $fantasy_points = $fantasy_player->fantasyDefenseGame->sum('fantasy_points_acme');
                $fantasyDefenseSeason = $fantasy_player->fantasyDefenseSeason->first();
                if ($fantasyDefenseSeason) {
                    echo $fantasyDefenseSeason->season.' '.$fantasy_player->name.' | Pts: '.$fantasy_points."\r\n";
                    $fantasyDefenseSeason->fantasy_points_acme = $fantasy_points;
                    $fantasyDefenseSeason->save();
                }
            } else {
                // $fantasy_player->with(['playerGame' => $filter])->get();
                // $fantasy_player->with(['playerSeason' => $filter])->get();
                $fantasy_player->load(['playerGame' => $filter])
                                ->load(['playerSeason' => $filter])->get();
                $fantasy_points = $fantasy_player->playerGame->sum('fantasy_points_acme');
                $playerSeason = $fantasy_player->playerSeason->first();
                // dd($playerSeason);
                if ($playerSeason) {
                    echo $playerSeason->season.' '.$fantasy_player->name.' | Pts: '.$fantasy_points."\r\n";
                    $playerSeason->fantasy_points_acme = $fantasy_points;
                    $playerSeason->save();
                }
            }
        }

        //Sum all the games individual values to get the season value
        // if (!empty($fantasy_player)) {
        //     if ($isProjection) {
        //         if ($fantasy_player->position == "DEF") {

        //         } else {

        //         }
        //     } else {

        //         } else {

        //             //echo $fantasy_player->name." | Pts: ". $fantasy_points ."\r\n";
        //             //count($fantasy_player->playerGame);
        //             //echo $fantasy_player->name." | Count: ". count($fantasy_player->playerGame) ."\r\n";
        //             //count($fantasy_player->playerGame);

        //             // if ($fantasy_player->name == "Travis Kelce") {
        //             //     //dd($fantasy_player->playerGame->first()->toArray());
        //             //     //dd(count($fantasy_player->playerGame));
        //             //     //echo $fantasy_player->name." | Pts: ". $fantasy_points ."\r\n";
        //             // }
        //         }
        //     }
        // }
        //Save the data
        // $unique = [
        //     'season'=>$season,
        //     'season_type'=>$seasonType,
        //     'fantasy_player_id'=>$fantasy_player->id
        // ];
        // $transactionData = ['fantasy_points' => $fantasy_points];
        // //Save the data
        // if ($isProjection) {
        //     \App\Models\FantasyPlayerProjectedSeasonFantasyPoint::updateOrCreate($unique, $transactionData);
        // } else {
        //     \App\Models\FantasyPlayerSeasonFantasyPoint::updateOrCreate($unique, $transactionData);
        // }
        return $fantasy_points;
    }

    // This is used to get all scores for QB's on team.
    public static function getTqbPlayergame($team, $season, $season_type, $week, $yearly = false, $isProjection = false)
    {
        if ($yearly == true) {
            $playerTeams = PlayerSeason::where('team', $team)
                                                        ->where('season_type', $season_type)
                                                        ->where('played', 1)
                                                        ->where('position', 'QB')
                                                        ->get()
                                                        ->toArray();

            if ($isProjection == 'true') {
                $playerTeams = PlayerSeasonProjection::where('team', $team)
                                                        ->where('season_type', $season_type)
                                                        ->where('played', 1)
                                                        ->where('position', 'QB')
                                                        ->get()
                                                        ->toArray();
            }
        } else {
            $playerTeams = PlayerGame::where('team', $team)
                                                        ->where('season', $season)
                                                        ->where('season_type', $season_type)
                                                        ->where('week', $week)
                                                        ->where('played', 1)
                                                        ->where('position', 'QB')
                                                        ->get()
                                                        ->toArray();

            if ($isProjection) {
                $playerTeams = PlayerGameProjection::where('team', $team)
                                                        ->where('season', $season)
                                                        ->where('season_type', $season_type)
                                                        ->where('week', $week)
                                                        ->where('played', 1)
                                                        ->where('position', 'QB')
                                                        ->get()
                                                        ->toArray();
            }
        }
        //dd($playerTeams);

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
        $teamQB['played'] = '';
        $teamQB['tdPass'] = [];
        $teamQB['tdRush'] = [];
        $teamQB['tdRec'] = [];
        if ($playerTeams) {
            //$teamQB = array_merge($teamQB, $playerTeams[0]);

            $ignoredKeys = ['game_key', 'player_id', 'player_game_id', 'id', 'season', 'week', 'number', 'played', 'activated', 'started', 'game_date', 'opponent'];

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

            foreach ($playerTeams as $key=>$val) {
                if ($yearly) {
                    $val['game_key'] = 1;
                }

                $touchdownPass = self::getScores($val['game_key'], $val['player_id'], 'PassingTouchdown', $isProjection);
                $touchdownRush = self::getScores($val['game_key'], $val['player_id'], 'RushingTouchdown', $isProjection);
                $touchdownRec = self::getScores($val['game_key'], $val['player_id'], 'ReceivingTouchdown', $isProjection);
                $touchdownPassScores = $touchdownPass['score'];
                $touchdownRushScores = $touchdownRush['score'];
                $touchdownRecScores = $touchdownRec['score'];

                $tqb_fantasy_points_acme += ($val['passing_yards'] * 0.011)
                        + ($val['rushing_yards'] * 0.025)
                        + ($val['receiving_yards'] * 0.025)
                        + ($val['passing_interceptions'] * (-0.20))
                        + ($val['fumbles_lost'] * (-0.20))
                        + ($val['two_point_conversion_passes'] * 0.100)
                        + ($val['two_point_conversion_runs'] * 0.250)
                        + ($val['two_point_conversion_receptions'] * 0.250)
                        + $touchdownPassScores
                        + $touchdownRushScores
                        + $touchdownRecScores;

                $teamQB['tdPass'] = array_merge($teamQB['tdPass'], $touchdownPass['plays']);
                $teamQB['tdRush'] = array_merge($teamQB['tdRush'], $touchdownRush['plays']);
                $teamQB['tdRec'] = array_merge($teamQB['tdRec'], $touchdownRec['plays']);
            }
            unset($playerTeams);

            $teamQB['fantasy_points_acme'] = number_format($tqb_fantasy_points_acme, 2);
            $teamQB['two_pt'] = $teamQB['two_point_conversion_passes'] + $teamQB['two_point_conversion_runs'] + $teamQB['two_point_conversion_receptions'];
            $teamQB['touchdownPass'] = $touchdownPass;
            $teamQB['touchdownRush'] = $touchdownRush;
        }

        //dd($teamQB);
        return $teamQB;
    }

    public static function getScores($game_key, $player_id, $scoring_type, $team = null, $isProjection = false)
    {
        //dd($game_key, $player_id, $scoring_type);
        //Return empty data because we don't have scores projections.
        if ($isProjection) {
            return ['score' => 0.00, 'plays' => []];
        }

        //If we have the team then this is a defense and we need to query differently.
        if ($team) {
            //dd($scoring_type, $game_key, $team);
            $score_details = ScoringDetail::where('game_key', '=', $game_key)
                            ->where('team', '=', $team)
                            ->where('scoring_type', 'like', '%'.$scoring_type.'%')
                            ->get();
        } else {
            $score_details = ScoringDetail::where('game_key', '=', $game_key)
                            ->where('player_id', '=', $player_id)
                            //>where('scoring_type','contains',$scoring_type)
                            ->where('scoring_type', 'like', '%'.$scoring_type.'%')
                            ->get();
        }
        $score = 0;

        //dd($score_details->toArray());

        if (! empty($score_details)) {
            foreach ($score_details as $list) {
                $length = $list->length;
                if ($scoring_type == 'PassingTouchdown') {
                    $score += (0.3 + (0.02 * $length));
                }
                if ($scoring_type == 'RushingTouchdown') {
                    $score += (0.6 + (0.02 * $length));
                }
                if ($scoring_type == 'ReceivingTouchdown') {
                    $score += (0.6 + (0.02 * $length));
                }
                if ($scoring_type == 'FieldGoalMade') {
                    /** Note: The -16 is a hack to help things score more accurately to what client wants */
                    $score += (0.50 + (0.02 * ($length - 16)));
                }
                if ($scoring_type == 'FieldGoalMissed') {
                    $score += (-.2);
                }
                if ($scoring_type == 'InterceptionReturnTouchdown') {
                    $score += (0.5 + (0.02 * $length));
                }
                if ($scoring_type == 'FumbleReturnTouchdown') {
                    $score += (0.5 + (0.02 * $length));
                }
                if ($scoring_type == 'KickoffReturnTouchdown') {
                    $score += (0.5 + (0.02 * $length));
                }
                if ($scoring_type == 'PuntReturnTouchdown') {
                    $score += (0.5 + (0.02 * $length));
                }
                if ($scoring_type == 'BlockedFieldGoalReturnTouchdown') {
                    $score += (0.5 + (0.02 * $length));
                }
                if ($scoring_type == 'BlockedPuntReturnTouchdown') {
                    $score += (0.5 + (0.02 * $length));
                }
                if ($scoring_type == 'FieldGoalReturnTouchdown') {
                    $score += (0.5 + (0.02 * $length));
                }
            }
        }

        return ['score' => $score, 'plays' => $score_details->toArray()];
    }

    /** This is used for Special Teams. It has a majority of the data we need to score a game **/
    public static function getTeamGameScoreAndData($game_key, $team)
    {
        $score = 0;
        $data = [];
        $team_game = TeamGame::where('game_key', '=', $game_key)
                            ->where('team', '=', $team)
                            ->first();
        if (! empty($team_game)) {
            $data = $team_game->toArray();
            $kickTouchBacks = $data['opponent_kickoff_touchbacks'];
            $score += $kickTouchBacks * 0.100;
        }

        return ['score' => $score, 'data' => $data];
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
                //$kickReturn       =   $value->kick_return_fair_catches;
                $score += $puntTouchbacks * -0.100;       //This is a negative thing that happens for a ST so we want to decrease points.
                //$score            +=  $kickReturn * 0.100;
            }
        }
        // if($score > 0)
        //  dd(array('score' => $score, 'plays' => $score_details->toArray()));

        return ['score' => $score, 'plays' => $score_details->toArray()];
    }
}
