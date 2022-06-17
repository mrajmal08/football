<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DraftOrder;
use App\Models\FantasyData\FantasyDefenseGame;
use App\Models\FantasyData\FantasyDefenseSeason;
use App\Models\FantasyData\FantasyDefenseSeasonProjection;
use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyData\Player;
use App\Models\FantasyData\PlayerGame;
use App\Models\FantasyData\PlayerGameProjection;
use App\Models\FantasyData\PlayerSeason;
use App\Models\FantasyData\PlayerSeasonProjection;
use App\Models\FantasyData\Schedule;
use App\Models\FantasyData\Team;
use App\Models\FantasyData\TeamFullSchedule;
use App\Models\FantasyData\TeamGame;
use App\Models\FantasyData\TeamSeason;
use App\Models\FantasyTeam;
use App\Models\FantasyTeamsPlayerTransaction;
use App\Models\League;
use App\Models\LeagueCommissioner;
use App\Models\PlayerTransactionType;
use App\Models\ScoringReview;
use App\Models\SystemSetting;
use Auth;
use Carbon\Carbon;
use DB;
use Helper;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function getPlayerEloquent(Request $request)
    {
        $userId = Auth::user()->id;

        $userTeam = FantasyTeam::where('user_id', $userId)->first();
        $userLeague = League::find($userTeam->league_id);
        $commissioner = LeagueCommissioner::where('league_id', $userLeague->league_id)->get();
        $ids = array_column($commissioner->toArray(), 'user_id');

        $isCommissioner = false;

        if (in_array($userId, $ids)) {
            $isCommissioner = true;
        }

        if (isset($request->player_id) && $request->player_id != '') {
            $player_id = $request->player_id;
        }

        $seasonType = 1;
        $systemSettings = SystemSetting::find(1);
        $season = $systemSettings->season;
        $systemSeason = [$systemSettings->season];
        $seasonType = $systemSettings->season_type;

        //Override to always show reg
        $seasonType = 1;
        $previous_season = ($systemSettings->season - 1);
        $week = $systemSettings->week;
        $current_week = $systemSettings->week;

        $seasonfilter = function ($query) use ($week, $previous_season, $seasonType) {
            $query->where('season', $previous_season);
            $query->where('season_type', $seasonType);
            //	$query->first();
        };

        $projection_seasonfilter = function ($query) use ($week, $season, $seasonType) {
            $query->where('season', $season);
            $query->where('season_type', $seasonType);
        };

        $season_filter = [];
        $season_filter[] = $previous_season;
        $season_filter[] = $season;

        $previous_seasonfilter = function ($query) use ($week, $season_filter, $seasonType) {
            $query->whereIn('season', $season_filter);
            $query->where('season_type', $seasonType);
        };

        // use systemSeason because the $season request could be data for the previous year.
        $filterPlayerTeamRoster = function ($query) use ($systemSeason, $seasonType, $userLeague, $week) {
            $query->whereIn('season', $systemSeason);
            $query->where('season_type', $seasonType);
            $query->where('week', $week);
            $query->where('league_id', $userLeague->id);
            $query->where(function ($q) {
                $q->where('active', 1)
                    ->orWhere('bench', 1);
            });
        };

        $players = FantasyPlayer::where('id', $player_id)
            ->with(['fantasyDefenseSeason' => $seasonfilter])
            ->with(['playerSeason'])
            ->with(['playerSeasonProjection' => $seasonfilter])
            ->with(['fantasyPlayerGameProjection' => $projection_seasonfilter])
            ->with(['team'])
            ->with(['teamGame.Score'])
            ->with(['fantasyTeamOwnedBy' => $filterPlayerTeamRoster])
            ->with(['PlayerGame' => $previous_seasonfilter])
            ->with(['FantasyDefenseGame' => $previous_seasonfilter])
            ->with(['fantasyPlayerNews'])
            ->with(['currentPlayerGame'])
            ->first();

        //$game_stats=Helper::getFantasyTeamDataByPlayer($players['player_id'],$previous_season,$seasonType,$players['position']);

        $collection = collect($players['playerSeason']);
        $current_season = $collection->firstWhere('season', $previous_season);
        if ($current_season != null) {
            $players['previous_seasons'] = [$current_season];
        } else {
            $players['previous_seasons'] = [];
        }
        $def_collection = collect($players['fantasyDefenseSeason']);
        $def_current_season = $def_collection->firstWhere('season', $previous_season);

        if ($def_current_season != null) {
            $players['previous_def_seasons'] = [$def_current_season];
        } else {
            $players['previous_def_seasons'] = [];
        }

        //TODO: The CheckPlayer is not working to limit to 2 team players per team during playoffs
        if (($week == 1 || $week == 2 || $week == 3 || $week == 4) && ($seasonType == 3)) {
            $checkPlayer = $this->checkPlayerSeasonAvailable($players['id']);
        } else {
            $checkPlayer = $this->checkPlayerAvailable($players['id']);
        }
        $player_injuries_result = false;
        $injury_start_date = '';
        $player_injuries = Player::select('injury_status', 'injury_body_part', 'injury_start_date', 'injury_notes')->where('player_id', '=', $players['player_id'])
            ->where('injury_status', '<>', null)->first();
        if ($player_injuries) {
            $player_injuries_result = $player_injuries->toArray();
            $injury_start_date = Carbon::parse($player_injuries_result['injury_start_date']);
            $injury_start_date = $injury_start_date->format('F d, Y');
            $player_injuries_result['injury_start_date'] = $injury_start_date;
            $player_injuries_result['replacement_team'] = $players->team;
            $player_injuries_result['replacement_position'] = $players->position;
        }
        $previous_week = 0;
        if ($current_week > 1) {
            $previous_week = $current_week - 1;
        }

        //        $selectTransQry = FantasyTeamsPlayerTransaction::where('player_transaction_type_id', 1)
        //            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_player_transactions.fantasy_player_id')
        //            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
        //            ->where('fantasy_teams_player_transactions.active', 1)
        //            ->where('fantasy_team_id', $userTeam->id)
        //            ->where('league_id', $userTeam->league_id)
        //            ->where('season', $season)
        //            ->where('season_type', $seasonType)
        //            ->where('p.position', $players['position']);

        $selectTransQry = FantasyTeamsPlayerTransaction::selectRaw('p.name,pl.team as player_team,fantasy_teams_player_transactions.id,fantasy_teams_player_transactions.fantasy_player_id,p.position')->where('player_transaction_type_id', 1)
            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_player_transactions.fantasy_player_id')
            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
            ->where('fantasy_teams_player_transactions.active', 1)
            ->where('fantasy_team_id', $userTeam->id)
            ->where('league_id', $userTeam->league_id)
            ->where('season', $season)
            ->where('season_type', $seasonType)
            ->where('p.position', $players['position']);

        $selectTrans = $selectTransQry->get()->toArray();
        $claimPlayers = [];
        if ($selectTrans) {
            $k = 1;
            foreach ($selectTrans as $list) {
                $player_position = $list['position'];

                $claimPlayers[$k]['id'] = $list['fantasy_player_id'];
                $claimPlayers[$k]['name'] = $list['name'].', '.$list['player_team'].', '.$list['position'];

                $k++;
            }
        }

        $playersData['claim_players_count'] = count($claimPlayers);
        $playersData['claim_players'] = $claimPlayers;
        $playersData['added'] = (! empty($checkPlayer)) ? $checkPlayer['added'] : 0;

        //TODO: causes undefined during nfl plays season_type = 3
        $playersData['bench'] = (! empty($checkPlayer['bench'])) ? $checkPlayer['bench'] : 0;
        //End TODO

        $playersData['remove'] = (! empty($checkPlayer)) ? $checkPlayer['remove'] : 0;
        $playersData['dropped'] = (! empty($checkPlayer)) ? $checkPlayer['dropped'] : 0;
        $playersData['traded'] = (! empty($checkPlayer)) ? $checkPlayer['traded'] : 0;
        $playersData['watched'] = (! empty($checkPlayer)) ? $checkPlayer['watched'] : 0;
        $playersData['owned_by'] = (! empty($checkPlayer)) ? $checkPlayer['owned_by'] : '';
        $playersData['max_reached'] = (! empty($checkPlayer)) ? $checkPlayer['max_reached'] : 0;
        $playersData['available'] = (! empty($checkPlayer)) ? $checkPlayer['available'] : 'NO';
        //$playersData['not_allowed']				=(!empty($checkPlayer))?$checkPlayer['not_allowed']:0;

        //TODO: causes undefined during nfl plays season_type = 3
        $playersData['claim_request'] = (! empty($checkPlayer['claim_request'])) ? $checkPlayer['claim_request'] : 0;
        $playersData['claim_removed'] = (! empty($checkPlayer['claim_removed'])) ? $checkPlayer['claim_removed'] : 0;
        $playersData['waiver_period_enabled'] = (! empty($checkPlayer['waiver_period_enabled'])) ? $checkPlayer['waiver_period_enabled'] : 0;
        //END TODO

        $playersData['player_data'] = $players;
        $playersData['player_injuries'] = $player_injuries_result;
        $playersData['target'] = 1;
        $playersData['record'] = 0;
        $playersData['system_season'] = $season;
        $playersData['draft_completed'] = $userLeague->draft_completed;
        $playersData['user_fantasy_team_roster'] = $this->_getUserFantasyTeamRoster();

        //	$playersArray['game_log']				=$game_log;
        //$playersData['game_stats']				=$game_stats;
        return response()->json($playersData);
    }

    public function getPlayersDepthChart(Request $request)
    {
        $userId = Auth::user()->id;

        $commissioner = LeagueCommissioner::where('user_id', $userId)->orWhere('is_co_commissioner', $userId)->first();
        $isCommissioner = 0;

        if (! empty($commissioner)) {
            $isCommissioner = 1;
        }
        $position = 'RB';
        if (isset($request->position) && $request->position != '') {
            $position = $request->position;
        }
        $userteam = FantasyTeam::where('user_id', $userId)->first();
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $season = $systemSettings->season;
        }
        if ($systemSettings->season_type) {
            $seasonType = $systemSettings->season_type;
        }

        $week = $systemSettings->week;
        $current_week = $systemSettings->week;

        $players = Player::whereNotNull('team')
            //->whereNotNull('fantasy_position_depth_order')
            ->wherePosition($position)
            ->whereNotNull('fantasy_position_depth_order')
            ->with(['PlayerTeam'])
            ->with(['fantasyPlayer'])
            ->orderBy('team')
            ->orderBy('fantasy_position_depth_order')
            ->get();

        $team_list = [];

        foreach ($players as $key => $playerlist) {
            if ($playerlist->fantasy_position_depth_order == 1) {
                $team_list[$playerlist->PlayerTeam->conference][$playerlist->team]['starter'][] = $playerlist;
            } elseif ($playerlist->fantasy_position_depth_order == 2) {
                $team_list[$playerlist->PlayerTeam->conference][$playerlist->team]['backup'][] = $playerlist;
            } else {
                $team_list[$playerlist->PlayerTeam->conference][$playerlist->team]['reservers'][] = $playerlist;
            }
        }

        return response()->json($team_list);
    }

    public function getPlayer(Request $request)
    {
        $userId = Auth::user()->id;

        $commissioner = LeagueCommissioner::where('user_id', $userId)->orWhere('is_co_commissioner', $userId)->first();
        $isCommissioner = 0;

        if (! empty($commissioner)) {
            $isCommissioner = 1;
        }

        $userteam = FantasyTeam::where('user_id', $userId)->first();

        $is_deffense = $is_special = $team_qb = 0;
        if (isset($request->player_id) && $request->player_id != '') {
            $player_id = $request->player_id;
        }

        if (isset($request->is_def) && $request->is_def != '') {
            $is_deffense = $request->is_def;
        }
        if (isset($request->is_st) && $request->is_st != '') {
            $is_special = $request->is_st;
        }
        if (isset($request->team_qb) && $request->team_qb != '') {
            $team_qb = $request->team_qb;
        }
        $season = 2017;
        $seasonType = 1;
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $season = $systemSettings->season;
        }
        if ($systemSettings->season_type) {
            $seasonType = $systemSettings->season_type;
        }

        $week = $systemSettings->week;
        $current_week = $systemSettings->week;

        $playersArray = [];
        $i = 0;
        $players = FantasyPlayer::where('id', '=', $player_id)->first()->toArray();

        if ($players) {
            $playersArray['added'] = 0;
            $playersArray['dropped'] = 0;
            $playersArray['traded'] = 0;
            $playersArray['watched'] = 0;
            $playersArray['max_reached'] = 0;
            $playersArray['owned_by'] = '';
            $playersArray['remove'] = 0;
            $playersArray['player_id'] = $players['id'];
            $playersArray['fantasy_player_key'] = $players['fantasy_player_key'];
            $playersArray['age'] = $players['player_age'];
            $playersArray['first_name'] = $players['player_first_name'];
            $playersArray['last_name'] = $players['player_last_name'];
            $playersArray['status'] = $players['player_status'];
            $playersArray['experience'] = $players['player_experience'];
            if ($players['position'] == 'DEF') {
                $playersArray['fantasy_position'] = 'DEF';
                $playersArray['fantasy_position_depth_order'] = 1;
            } elseif ($players['position'] == 'ST') {
                $playersArray['fantasy_position'] = 'ST';
                $playersArray['fantasy_position_depth_order'] = 1;
            } elseif ($players['position'] == 'TQB') {
                $playersArray['fantasy_position'] = 'TQB';
                $playersArray['fantasy_position_depth_order'] = 1;
            } else {
                $playersArray['fantasy_position'] = $players['player_fantasy_position'];
            }

            $playersArray['fantasy_draft_name'] = $players['player_fantasy_draft_name'];
            $playersArray['team'] = $players['team'];
            $playersArray['bye_week'] = $players['bye_week'];
            $playersArray['is_st'] = $is_special;
            $playersArray['team_qb'] = $team_qb;
            $playersArray['is_def'] = $is_deffense;
            $playersArray['photo_url'] = $players['player_photo_url'];
            $playersArray['average_draft_position'] = $players['player_average_draft_position'];
            $playersArray['fantasy_position_depth_order'] = $players['player_fantasy_position_depth_order'];
            $playersArray['upcoming_game_opponent'] = $players['player_upcoming_game_opponent'];
            $playersArray['upcoming_opponent_position_rank'] = $players['player_upcoming_opponent_position_rank'];
            $playersArray['upcoming_opponent_rank'] = $players['player_upcoming_opponent_rank'];
            if ($players['player_fantasy_position'] == 'DEF' || $players['player_fantasy_position'] == 'ST') {
                $playerStat = FantasyDefenseSeason::selectRaw('points_allowed,sacks,interceptions,fumbles_recovered,
										punt_return_touchdowns,fantasy_points')
                    ->where('player_id', $players['player_id'])
                    ->where('season', $season)
                    ->where('season_type', $seasonType)
                    ->first();
                if (! empty($playerStat)) {
                    $playersArray['points_allowed'] = $playerStat->points_allowed;
                    $playersArray['sacks'] = $playerStat->sacks;
                    $playersArray['interceptions'] = $playerStat->interceptions;
                    $playersArray['fumbles_recovered'] = $playerStat->fumbles_recovered;
                    $playersArray['punt_return_touchdowns'] = $playerStat->punt_return_touchdowns;
                    $playersArray['fantasy_points'] = $playerStat->fantasy_points;
                }
            } else {
                $playerStat = PlayerSeason::selectRaw('passing_yards,passing_completion_percentage,passing_touchdowns,passing_interceptions,
									passing_rating,rushing_attempts,rushing_yards,rushing_touchdowns,receptions,
									receiving_targets,receiving_yards,receiving_touchdowns')
                    ->where('player_id', $players['player_id'])
                    ->where('season', $season)
                    ->where('season_type', $seasonType)
                    ->first();
                if (! empty($playerStat)) {
                    $playersArray['passing_yards'] = $playerStat->passing_yards;
                    $playersArray['passing_completion_percentage'] = $playerStat->passing_completion_percentage;
                    $playersArray['passing_touchdowns'] = $playerStat->passing_touchdowns;
                    $playersArray['passing_interceptions'] = $playerStat->passing_interceptions;
                    $playersArray['passing_rating'] = $playerStat->passing_rating;
                    $playersArray['rushing_attempts'] = $playerStat->rushing_attempts;
                    $playersArray['rushing_yards'] = $playerStat->rushing_yards;
                    $playersArray['rushing_touchdowns'] = $playerStat->rushing_touchdowns;
                    $playersArray['receptions'] = $playerStat->receptions;
                    $playersArray['receiving_targets'] = $playerStat->receiving_targets;
                    $playersArray['receiving_yards'] = $playerStat->receiving_yards;
                    $playersArray['receiving_touchdowns'] = $playerStat->receiving_touchdowns;
                }
            }

            $playersArray['position'] = $players['position'];

            $i++;
        }

        //for game tab
        $offenseArray = ['RB', 'WR', 'TE'];
        $offense_points_acme = $kicker_points_acme = $def_points_acme = $spec_points_acme = 0;
        $active_player_offense_points_acme = $active_player_kicker_points_acme = $active_player_def_points_acme = $active_player_spec_points_acme = 0;
        $offense_points_acme_total = $kicker_points_acme_total = $def_points_acme_total = $spec_points_acme_total = 0;
        $total_home_acme_points = $tqb_fantasy_points_acme = 0.0;

        $game_log = [];

        $rosterTeams = PlayerGame::selectRaw('week,game_date,team,receptions,position,id as player_game_id,game_key,player_id,opponent,home_or_away,rushing_attempts,rushing_yards_per_attempt,receiving_targets,passing_yards,passing_touchdowns,passing_interceptions,rushing_yards,rushing_touchdowns,receiving_yards,receiving_touchdowns,passing_attempts,passing_completions,
			punt_return_touchdowns,position,field_goals_attempted,field_goals_made,extra_points_attempted,
			kick_return_touchdowns, two_point_conversion_passes,two_point_conversion_runs,two_point_conversion_receptions,fumbles_lost,fantasy_points,extra_points_made,field_goals_made0to19 as fg1,field_goals_made20to29 as fg2,field_goals_made30to39 as fg3,field_goals_made40to49 as fg4,field_goals_made50_plus as fg5,sacks,interceptions,fumbles_recovered,safeties,defensive_touchdowns,special_teams_touchdowns,kick_return_yards,kick_return_fair_catches,punt_return_yards,punt_touchbacks')
            ->where('player_id', $players['player_id'])
            ->where('season', $season)
            ->where('season_type', $seasonType)
            ->get()->toArray();

        if ($players['player_fantasy_position'] == 'TQB') {
            $rosterTeams = FantasyDefenseGame::selectRaw('fantasy_defense_game.week,pg.game_date,fantasy_defense_game.team,pg.receptions,pg.id as player_game_id,fantasy_defense_game.game_key,pg.player_id,pg.opponent,pg.home_or_away,pg.rushing_attempts,pg.rushing_yards_per_attempt,pg.receiving_targets,pg.passing_yards,pg.passing_touchdowns,pg.passing_interceptions,pg.rushing_yards,pg.rushing_touchdowns,pg.receiving_yards,pg.receiving_touchdowns,pg.passing_attempts,pg.passing_completions,
			pg.punt_return_touchdowns,pg.position,pg.field_goals_attempted,pg.field_goals_made,pg.extra_points_attempted,
			pg.kick_return_touchdowns, pg.two_point_conversion_passes,pg.two_point_conversion_runs,pg.two_point_conversion_receptions,pg.fumbles_lost,pg.fantasy_points,pg.extra_points_made,pg.field_goals_made0to19 as fg1,pg.field_goals_made20to29 as fg2,pg.field_goals_made30to39 as fg3,pg.field_goals_made40to49 as fg4,pg.field_goals_made50_plus as fg5,pg.sacks,pg.interceptions,pg.fumbles_recovered,pg.safeties,pg.defensive_touchdowns,pg.special_teams_touchdowns,pg.kick_return_yards,pg.kick_return_fair_catches,pg.punt_return_yards,pg.punt_touchbacks')
                ->leftJoin('player_game as pg', function ($join) use ($season, $seasonType) {
                    $join->on('pg.id', '=', 'fantasy_defense_game.player_id');
                    $join->where('pg.season', $season);
                    $join->where('pg.season_type', $seasonType);
                    //$join->where('pg.week',$week);
                })
                ->where('fantasy_defense_game.season', $season)
                ->where('fantasy_defense_game.player_id', $players['player_id'])
                ->where('fantasy_defense_game.season_type', $seasonType)
                ->get()->toArray();
        }
        $i = 0;
        if (! empty($rosterTeams)) {
            foreach ($rosterTeams as $key => $val) {
                $team = $val['team'];
                $game_key = $val['game_key'];
                $week = $val['week'];

                $touchdownPass = Helper::getScores($game_key, $val['player_id'], 'PassingTouchdown');
                $touchdownRush = Helper::getScores($game_key, $val['player_id'], 'RushingTouchdown');
                $touchdownRec = Helper::getScores($game_key, $val['player_id'], 'ReceivingTouchdown');
                $touchdownPassScores = $touchdownPass['score'];
                $touchdownRushScores = $touchdownRush['score'];
                $touchdownRecScores = $touchdownRec['score'];
                if ($val['player_game_id'] != null) {
                    $offense_points_acme = ($val['passing_yards'] * 0.013) + ($val['rushing_yards'] * 0.025) + ($val['receiving_yards'] * 0.025) + ($val['passing_interceptions'] * (-0.20)) +
                        ($val['fumbles_lost'] * (-0.20)) + ($val['two_point_conversion_passes'] * 0.100) + ($val['two_point_conversion_runs'] * 0.250) +
                        ($val['two_point_conversion_receptions'] * 0.250) + $touchdownPassScores + $touchdownRushScores + $touchdownRecScores;
                }

                $active_player_offense_points_acme = number_format($active_player_offense_points_acme, 2);
                $offense_points_acme = number_format($offense_points_acme, 2);
                $offense_points_acme_total += $active_player_offense_points_acme;
                $val['fantasy_points_acme'] = $offense_points_acme;

                if ($val['home_or_away'] == 'AWAY') {
                    $val['opponent'] = '@'.$val['opponent'];
                }
                if ($players['player_fantasy_position'] != 'TQB') {
                    if (in_array($val['position'], $offenseArray)) {
                        $game_log[$i]['WK'] = $val['week'];
                        $game_log[$i]['DATE'] = date('m/d/Y', strtotime($val['game_date']));
                        $game_log[$i]['OPP'] = $val['opponent'];
                        $game_log[$i]['RUATT'] = $val['rushing_attempts'];
                        $game_log[$i]['RUYD'] = $val['rushing_yards'];
                        $game_log[$i]['RUAVG'] = $val['rushing_yards_per_attempt'];
                        $game_log[$i]['RUTD'] = $val['rushing_touchdowns'];
                        $game_log[$i]['TAR'] = $val['receiving_targets'];
                        $game_log[$i]['RECPT'] = $val['receptions'];
                        $game_log[$i]['REYD'] = $val['receiving_yards'];
                        $game_log[$i]['RETD'] = $val['receiving_touchdowns'];
                        $game_log[$i]['FL'] = $val['fumbles_lost'];
                        $game_log[$i]['FPTS'] = $offense_points_acme;
                    }
                }

                if ($players['player_fantasy_position'] == 'TQB') {
                    $tqb_fantasy_points_acme = Helper::getTqbPlayergame($team, $season, $seasonType, $week, $game_key, $yearly = false);

                    if (! empty($tqb_fantasy_points_acme)) {
                        $game_log[$i]['WK'] = $tqb_fantasy_points_acme['week'];
                    }
                    $game_log[$i]['DATE'] = date('m/d/Y', strtotime($tqb_fantasy_points_acme['game_date']));
                    $game_log[$i]['OPP'] = $tqb_fantasy_points_acme['opponent'];
                    $game_log[$i]['PAATT'] = $tqb_fantasy_points_acme['passing_attempts'];
                    $game_log[$i]['PACMP'] = $tqb_fantasy_points_acme['passing_completions'];
                    $game_log[$i]['PAYD'] = $tqb_fantasy_points_acme['passing_yards'];
                    $game_log[$i]['PATD'] = $tqb_fantasy_points_acme['passing_touchdowns'];
                    $game_log[$i]['PAINT'] = $tqb_fantasy_points_acme['passing_interceptions'];
                    $game_log[$i]['RUYD'] = $tqb_fantasy_points_acme['rushing_yards'];
                    $game_log[$i]['RUTD'] = $tqb_fantasy_points_acme['rushing_touchdowns'];
                    $game_log[$i]['FPTS'] = number_format($tqb_fantasy_points_acme['fantasy_points_acme'], 2);
                }

                if ($val['position'] == 'K') {
                    $sumValue = $val['fg1'] + $val['fg2'] + $val['fg3'] + $val['fg4'] + $val['fg5'];

                    if ($val['player_game_id'] != null) {
                        $fieldGoalScores = Helper::getScores($val['game_key'], $val['player_id'], 'FieldGoalMade');

                        $kicker_points_acme = ($val['extra_points_made'] * 0.500) + (($val['extra_points_attempted'] - $val['extra_points_made']) * -0.200) +
                            $fieldGoalScores['score'];
                    }
                    $game_log[$i]['WK'] = $val['week'];
                    $game_log[$i]['DATE'] = date('m/d/Y', strtotime($val['game_date']));
                    $game_log[$i]['OPP'] = $val['opponent'];
                    $game_log[$i]['FGA'] = $val['field_goals_attempted'];
                    $game_log[$i]['FG'] = $val['field_goals_made'];
                    $game_log[$i]['XPATT'] = $val['extra_points_attempted'];
                    $game_log[$i]['FG19'] = $val['fg1'];
                    $game_log[$i]['FG29'] = $val['fg2'];
                    $game_log[$i]['FG39'] = $val['fg3'];
                    $game_log[$i]['FG49'] = $val['fg4'];
                    $game_log[$i]['FG50'] = $val['fg5'];
                    $game_log[$i]['FPTS'] = $kicker_points_acme;
                }
                $i++;
            }
        }

        if ($players['player_fantasy_position'] == 'DEF') {
            $defTeamslist = FantasyDefenseGame::selectRaw('week,date,opponent,touchdowns_scored,home_or_away,sacks,game_key,player_id,interceptions,fumbles_recovered,
															safeties,defensive_touchdowns,special_teams_touchdowns,fantasy_points,points_allowed,
															offensive_yards_allowed,id as fantasy_defense_game_id')
                ->where('season', $season)
                ->where('player_id', $players['player_id'])
                ->where('season_type', $seasonType)
                ->get()->toArray();
            $i = 0;
            if (! empty($defTeamslist)) {
                foreach ($defTeamslist as $key => $val) {
                    $defensiveTouchdownScores = Helper::getScores($val['game_key'], $val['player_id'], 'InterceptionReturnTouchdown')['score'] + Helper::getScores($val['game_key'], $val['player_id'], 'FumbleReturnTouchdown')['score'];
                    $def_points_acme = (6 + ($val['points_allowed'] * -0.100)) + (6 + ($val['offensive_yards_allowed'] * -0.010)) +
                        ($val['interceptions'] * 0.250) + ($val['fumbles_recovered'] * 0.250) +
                        ($val['sacks'] * 0.100) + ($val['safeties'] * 0.500) + $defensiveTouchdownScores;
                    if ($val['home_or_away'] == 'AWAY') {
                        $val['opponent'] = '@'.$val['opponent'];
                    }
                    $game_log[$i]['WK'] = $val['week'];
                    $game_log[$i]['DATE'] = date('m/d/Y', strtotime($val['date']));
                    $game_log[$i]['OPP'] = $val['opponent'];
                    $game_log[$i]['DTD'] = $val['touchdowns_scored'];
                    $game_log[$i]['INT'] = $val['interceptions'];
                    $game_log[$i]['STY'] = $val['safeties'];
                    $game_log[$i]['SACK'] = $val['sacks'];
                    $game_log[$i]['DFR'] = $val['fumbles_recovered'];
                    $game_log[$i]['PA'] = $val['points_allowed'];
                    $game_log[$i]['FPTS'] = $def_points_acme;
                    $i++;
                }
            }
        }

        if ($players['player_fantasy_position'] == 'ST') {
            $specTeamslist = FantasyDefenseGame::selectRaw('week,date,opponent,touchdowns_scored,home_or_away,sacks,game_key,player_id,interceptions,fumbles_recovered,safeties,defensive_touchdowns,special_teams_touchdowns,fantasy_points,points_allowed,offensive_yards_allowed,id as fantasy_defense_game_id,punt_return_yards,kick_return_yards')->where('season', $season)
                ->where('player_id', $players['player_id'])
                ->where('season_type', $seasonType)
                ->get()->toArray();
            $i = 0;
            if (! empty($specTeamslist)) {
                foreach ($specTeamslist as $key => $val) {
                    $kickoffReturnTouchdown = Helper::getScores($val['game_key'], $val['player_id'], 'KickoffReturnTouchdown');
                    $puntReturnTouchdown = Helper::getScores($val['game_key'], $val['player_id'], 'PuntReturnTouchdown');
                    $blockedFieldGoalReturnTouchdown = Helper::getScores($val['game_key'], $val['player_id'], 'BlockedFieldGoalReturnTouchdown');
                    $blockedPuntReturnTouchdown = Helper::getScores($val['game_key'], $val['player_id'], 'BlockedPuntReturnTouchdown');
                    $fieldGoalReturnTouchdown = Helper::getScores($val['game_key'], $val['player_id'], 'FieldGoalReturnTouchdown');
                    $specialTeamsScores = $kickoffReturnTouchdown['score'] + $puntReturnTouchdown['score'] + $blockedFieldGoalReturnTouchdown['score'] + $blockedPuntReturnTouchdown['score'] + $fieldGoalReturnTouchdown['score'];
                    $punterScores = Helper::getPlayerScores($val['game_key'], $val['player_id'], 'P');
                    $kickerScores = Helper::getPlayerScores($val['game_key'], $val['player_id'], 'K');
                    $spec_points_acme = ($val['punt_return_yards'] * 0.015) + ($val['kick_return_yards'] * 0.015) + $specialTeamsScores['score'] + $punterScores['score'] + $kickerScores['score'];
                    if ($val['home_or_away'] == 'AWAY') {
                        $val['opponent'] = '@'.$val['opponent'];
                    }
                    $game_log[$i]['WK'] = $val['week'];
                    $game_log[$i]['DATE'] = date('m/d/Y', strtotime($val['date']));
                    $game_log[$i]['OPP'] = $val['opponent'];
                    $game_log[$i]['FPTS'] = $spec_points_acme;
                    $i++;
                }
            }
        }
        //echo $players['player_id'];
        $game_stats = Helper::getFantasyTeamDataByPlayer($players['player_id'], $season, $seasonType, $players['position']);

        $is_st = $is_special;
        $is_def = $is_deffense;
        $team_qb = $team_qb;
        if (($week == 1 || $week == 2 || $week == 3 || $week == 4) && ($seasonType == 3)) {
            $checkPlayer = $this->checkPlayerAvailable($players['id'], $is_def, $is_st, $team_qb);
        } else {
            $checkPlayer = $this->checkPlayerAvailable($players['id'], $is_def, $is_st, $team_qb);
        }
        $player_injuries_result = '';
        $injury_start_date = '';
        $player_injuries = Player::select('injury_status', 'injury_body_part', 'injury_start_date', 'injury_notes')->where('player_id', '=', $players['player_id'])
            ->where('injury_status', '<>', null)->first();
        if ($player_injuries) {
            $player_injuries_result = $player_injuries->toArray();
            $injury_start_date = Carbon::parse($player_injuries_result['injury_start_date']);
            $injury_start_date = $injury_start_date->format('F d, Y');
            $player_injuries_result['injury_start_date'] = $injury_start_date;
        }
        $previous_week = 0;
        if ($current_week > 1) {
            $previous_week = $current_week - 1;
        }

        $selectTransQry = FantasyTeamsPlayerTransaction::selectRaw('p.name,pl.team as player_team,fantasy_teams_player_transactions.id,fantasy_teams_player_transactions.fantasy_player_id,p.position')->where('player_transaction_type_id', 1)
            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_player_transactions.fantasy_player_id')
            ->leftJoin('player as pl', 'pl.player_id', '=', 'p.player_id')
            ->where('fantasy_teams_player_transactions.active', 1)
            ->where('fantasy_team_id', $userteam->id)
            ->where('league_id', $userteam->league_id)
            ->where('season', $season)
            ->where('season_type', $seasonType);

        $selectTransQry->where('p.position', $players['player_fantasy_position']);

        $selectTrans = $selectTransQry->get()->toArray();
        $claimPlayers = [];
        if ($selectTrans) {
            $k = 1;
            foreach ($selectTrans as $list) {
                $player_position = $list['position'];

                $claimPlayers[$k]['id'] = $list['fantasy_player_id'];
                $claimPlayers[$k]['name'] = $list['name'].', '.$list['player_team'].', '.$list['position'];

                $k++;
            }
        }
        $playersArray['claim_players_count'] = count($claimPlayers);
        $playersArray['claim_players'] = $claimPlayers;
        $playersArray['added'] = $checkPlayer['added'];
        $playersArray['bench'] = $checkPlayer['bench'];
        $playersArray['remove'] = $checkPlayer['remove'];
        $playersArray['dropped'] = $checkPlayer['dropped'];
        $playersArray['traded'] = $checkPlayer['traded'];
        $playersArray['watched'] = $checkPlayer['watched'];
        $playersArray['owned_by'] = $checkPlayer['owned_by'];
        $playersArray['max_reached'] = $checkPlayer['max_reached'];
        $playersArray['available'] = $checkPlayer['available'];
        $playersArray['not_allowed'] = $checkPlayer['not_allowed'];
        $playersArray['claim_request'] = $checkPlayer['claim_request'];
        $playersArray['claim_removed'] = $checkPlayer['claim_removed'];
        $playersArray['waiver_period_enabled'] = $checkPlayer['waiver_period_enabled'];
        $playersArray['is_st'] = $is_st;
        $playersArray['is_def'] = $is_def;
        $playersArray['team_qb'] = $team_qb;
        $playersArray['player_injuries'] = $player_injuries_result;
        $playersArray['target'] = 1;
        $playersArray['record'] = 0;
        $playersArray['game_log'] = $game_log;
        $playersArray['game_stats'] = $game_stats;

        return response()->json($playersArray);
    }

    /**
     * Show the Players.
     *
     * @return Response
     */
    public function score_review(Request $request)
    {
        $season = 2018;
        $seasonType = 1;
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $season = $systemSettings->season;
        }
        if ($systemSettings->season) {
            $seasonType = $systemSettings->season_type;
        }

        $week = $systemSettings->week;

        if (isset($request->week) && $request->week != '') {
            $week = $request->week;
        }

        if (isset($request->season) && $request->season != '') {
            $season = $request->season;
        }
        if (isset($request->season_type) && $request->season_type != '') {
            $seasonType = $request->season_type;
        }
        if (isset($request->fantasy_player_id) && $request->fantasy_player_id != '') {
            $fantasy_player_id = $request->fantasy_player_id;
        }

        $filter = function ($query) use ($week, $season, $seasonType) {
            $query->where('season', $season);
            $query->where('week', $week);
            $query->where('season_type', $seasonType);
        };

        $fantasy_player = FantasyPlayer::where('id', $fantasy_player_id)
            ->with(['fantasyDefenseGame' => $filter])
            ->with(['teamGame.Score'])
            ->with(['teamGame' => $filter])
            ->with(['playerGame.Score'])
            ->with(['playerGame' => $filter])
            ->first();

        $score_details = [];
        if (! empty($fantasy_player)) {
            $score_details['score_card'] = ($fantasy_player->playerGame->isNotEmpty()) ? $fantasy_player->playerGame[0]->score->away_team.' @ '.$fantasy_player->playerGame[0]->score->home_team : '';
            $score_details['game_key'] = ($fantasy_player->playerGame->isNotEmpty()) ? $fantasy_player->playerGame[0]->game_key : '';
            $score_details['fantasy_points_acme'] = ($fantasy_player->playerGame->isNotEmpty()) ? $fantasy_player->playerGame[0]->fantasy_points_acme : '';
        } else {
            $score_details['score_card'] = ($fantasy_player->teamGame->isNotEmpty()) ? $fantasy_player->teamGame[0]->Score->away_team.' @ '.$fantasy_player->teamGame[0]->Score->home_team : '';
            $score_details['game_key'] = ($fantasy_player->fantasyDefenseGame->isNotEmpty()) ? $fantasy_player->fantasyDefenseGame[0]->game_key : '';
            $score_details['fantasy_points_acme'] = ($fantasy_player->fantasyDefenseGame->isNotEmpty()) ? $fantasy_player->fantasyDefenseGame[0]->fantasy_points_acme : '';
        }

        return response()->json($score_details);
    }

    public function save_score_review(Request $request)
    {
        if (isset($request->game_key) && $request->game_key != '') {
            $game_key = $request->game_key;
        }
        if (isset($request->week) && $request->week != '') {
            $week = $request->week;
        }
        if (isset($request->season) && $request->season != '') {
            $season = $request->season;
        }
        if (isset($request->season_type) && $request->season_type != '') {
            $seasonType = $request->season_type;
        }
        if (isset($request->fantasy_player_id) && $request->fantasy_player_id != '') {
            $fantasy_player_id = $request->fantasy_player_id;
        }
        if (isset($request->adjustment_amount) && $request->adjustment_amount != '') {
            $adjustment_amount = $request->adjustment_amount;
        }
        if (isset($request->comment) && $request->comment != '') {
            $comment = $request->comment;
        }
        $returnArray = [];
        $settings = SystemSetting::find(1);

        $scoring_data = [
            'game_key'            => $game_key,
            'week'                => $week,
            'season'            => $season,
            'season_type'        => $seasonType,
            'fantasy_player_id' => $fantasy_player_id,
            'adjustment_amount' => $adjustment_amount,
            'comment' => $comment,
        ];
        if (isset($request->game_key) && $request->game_key != '') {
            //Save the data
            $model = \App\Models\ScoringReview::updateOrCreate(
                [
                    'game_key'            => $game_key,
                    'week'                => $week,
                    'season'            => $season,
                    'season_type'        => $seasonType,
                    'fantasy_player_id' => $fantasy_player_id,

                ],
                $scoring_data
            );
            $returnArray['status'] = 'success';
        } else {
            $returnArray['status'] = 'failure';
        }

        return response()->json($returnArray);
    }

    /**
     * Show the Players.
     *
     * @return Response
     *
     * This route is used to get player data in the NFL Playoff Structure
     */
    public function showPlayers(Request $request)
    {
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $season = $systemSettings->season;
        }
        if ($systemSettings->season_type) {
            $seasonType = $systemSettings->season_type;
        }

        $week = $systemSettings->week;

        $is_deffense = $is_special = $team_qb = 0;
        $userId = Auth::user()->id;
        $teamIn = FantasyTeam::where('user_id', $userId)->first();
        $league = League::find($teamIn->league_id);

        $positionArray = ['RB', 'K', 'WR', 'TE'];

        $player_query = FantasyPlayer::where('team', '<>', '');
        $available = 0;
        if (isset($request->selectedVal) && $request->selectedVal != '') {
            $available = $request->selectedVal;
        }
        if (isset($request->selectedTeam) && $request->selectedTeam != '') {
            $team = $request->selectedTeam;
            //dd($team);
            $player_query->where('fantasy_player.team', '=', $team);
        }

        if (isset($request->selectedPosition) && $request->selectedPosition != '') {
            $position = $request->selectedPosition;

            if ($position == 'RB') {
                $positionArray = ['RB'];
            } elseif ($position == 'DEF') {
                $positionArray = ['DEF'];
            } elseif ($position == 'ST') {
                $positionArray = ['ST'];
            } elseif ($position == 'TQB') {
                $positionArray = ['TQB'];
            } elseif ($position == 'K') {
                $positionArray = ['K'];
            } elseif ($position == 'WR') {
                $positionArray = ['WR'];
            } elseif ($position == 'TE') {
                $positionArray = ['TE'];
            } elseif ($position == 'K') {
                $positionArray = ['K'];
            } elseif ($position == 'RWT') {
                $positionArray = ['RB', 'WR', 'TE'];
            } else {
                $positionArray = ['RB', 'TQB', 'K', 'WR', 'TE', 'DEF', 'ST'];
            }
        }

        //update player table to only show players that are playing that week (NFL Playoffs)
        if ($seasonType == 3) {
            //dd('here');
            $playerSchedule = Schedule::selectRaw('away_team,home_team')
                ->where('week', $week)
                ->where('season', $season)
                ->where('season_type', $seasonType)
                ->get()->toArray();

            //dd($playersArray);
            $playersTeam = [];
            if ($playerSchedule) {
                foreach ($playerSchedule as $key => $val) {
                    $playersTeam[] = $val['away_team'];
                    $playersTeam[] = $val['home_team'];
                }
            }

            // Update the Query to only select players based on the ones that are playing.
            $player_query->whereIn('team', $playersTeam);
        }

        //dd($positionArray);

        $players = $player_query->whereIn('fantasy_player.position', $positionArray)
            ->get()->toArray();

        $playersListArray = $players;
        //dd($playersListArray);

        $playersArray = [];
        $i = 0;
        if ($playersListArray) {
            foreach ($playersListArray as $key => $val) {
                $is_deffense = $is_special = 0;
                if ($val['position'] == 'DEF') {
                    $is_deffense = 1;
                }
                if ($val['position'] == 'ST') {
                    $is_special = 1;
                }
                if ($val['position'] == 'TQB') {
                    $team_qb = 1;
                }

                $playersArray[$i]['player_id'] = $val['id'];
                $playersArray[$i]['fantasy_player_key'] = $val['fantasy_player_key'];
                $playersArray[$i]['age'] = $val['player_age'];
                $playersArray[$i]['name'] = $val['name'];
                $playersArray[$i]['first_name'] = $val['player_first_name'];
                $playersArray[$i]['last_name'] = $val['player_last_name'];
                $playersArray[$i]['status'] = $val['player_status'];
                $playersArray[$i]['experience'] = $val['player_experience'];
                $playersArray[$i]['fantasy_draft_name'] = $val['player_fantasy_draft_name'];
                $playersArray[$i]['team'] = $val['team'];
                $playersArray[$i]['bye_week'] = $val['bye_week'];
                $playersArray[$i]['photo_url'] = $val['player_photo_url'];
                $playersArray[$i]['average_draft_position'] = $val['player_average_draft_position'];
                $playersArray[$i]['fantasy_position_depth_order'] = $val['player_fantasy_position_depth_order'];
                $playersArray[$i]['upcoming_game_opponent'] = $val['player_upcoming_game_opponent'];
                $playersArray[$i]['upcoming_opponent_position_rank'] = $val['player_upcoming_opponent_position_rank'];
                $playersArray[$i]['upcoming_opponent_rank'] = $val['player_upcoming_opponent_rank'];
                $playersArray[$i]['fantasy_position'] = $val['player_fantasy_position'];

                //Set data that is specific for team playes because it is not in FantasyData API.
                if ($val['position'] == 'DEF') {
                    $playersArray[$i]['fantasy_position'] = 'DEF';
                    $playersArray[$i]['fantasy_position_depth_order'] = 1;
                }
                if ($val['position'] == 'TQB') {
                    $playersArray[$i]['fantasy_position'] = 'TQB';
                    $playersArray[$i]['fantasy_position_depth_order'] = 1;
                }
                if ($val['position'] == 'ST') {
                    $playersArray[$i]['fantasy_position'] = 'ST';
                    $playersArray[$i]['fantasy_position_depth_order'] = 1;
                }

                $player_injuries_result = '';
                $injury_start_date = '';
                $player_injuries = Player::select('injury_status', 'injury_body_part', 'injury_start_date', 'injury_notes')->where('player_id', '=', $val['player_id'])
                    ->where('injury_status', '<>', null)->first();
                if ($player_injuries) {
                    $player_injuries_result = $player_injuries->toArray();
                    $player_injuries_result = $player_injuries_result['injury_status'];
                }
                $playersArray[$i]['injury_status'] = $player_injuries_result;
                //$playersArray[$i]['injury_start_date']	    = $injury_start_date;

                // if ($is_deffense == 1 || $is_special == 1|| $team_qb == 1) {
                //     $playerStat	=	FantasyDefenseSeason::selectRaw('points_allowed,sacks,interceptions,fumbles_recovered,
                //                         punt_return_touchdowns,fantasy_points')
                //                     ->where('player_id', $val['player_id'])
                //                     ->where('season', $season)
                //                     ->where('season_type', $seasonType)
                //                     ->first();
                //     if (!empty($playerStat)) {
                //         $playersArray[$i]['points_allowed'] 				= $playerStat->points_allowed;
                //         $playersArray[$i]['sacks'] 							= $playerStat->sacks;
                //         $playersArray[$i]['interceptions'] 					= $playerStat->interceptions;
                //         $playersArray[$i]['fumbles_recovered'] 				= $playerStat->fumbles_recovered;
                //         $playersArray[$i]['punt_return_touchdowns'] 		= $playerStat->punt_return_touchdowns;
                //         $playersArray[$i]['fantasy_points'] 				= $playerStat->fantasy_points;
                //     }
                // } else {
                //     $playerStat	=	PlayerSeason::selectRaw('passing_yards,passing_completion_percentage,passing_touchdowns,passing_interceptions,
                //                     passing_rating,rushing_attempts,rushing_yards,rushing_touchdowns,receptions,
                //                     receiving_targets,receiving_yards,receiving_touchdowns')
                //                     ->where('player_id', $val['player_id'])
                //                     ->where('season', $season)
                //                     ->where('season_type', $seasonType)
                //                     ->first();
                //     if (!empty($playerStat)) {
                //         $playersArray[$i]['passing_yards'] 					= $playerStat->passing_yards;
                //         $playersArray[$i]['passing_completion_percentage'] 	= $playerStat->passing_completion_percentage;
                //         $playersArray[$i]['passing_touchdowns'] 			= $playerStat->passing_touchdowns;
                //         $playersArray[$i]['passing_interceptions'] 			= $playerStat->passing_interceptions;
                //         $playersArray[$i]['passing_rating'] 				= $playerStat->passing_rating;
                //         $playersArray[$i]['rushing_attempts'] 				= $playerStat->rushing_attempts;
                //         $playersArray[$i]['rushing_yards'] 					= $playerStat->rushing_yards;
                //         $playersArray[$i]['rushing_touchdowns'] 			= $playerStat->rushing_touchdowns;
                //         $playersArray[$i]['receptions'] 					= $playerStat->receptions;
                //         $playersArray[$i]['receiving_targets'] 				= $playerStat->receiving_targets;
                //         $playersArray[$i]['receiving_yards'] 				= $playerStat->receiving_yards;
                //         $playersArray[$i]['receiving_touchdowns'] 			= $playerStat->receiving_touchdowns;
                //     }
                // }

                $chkPlayerAdded = $this->checkPlayerAvailable($val['id'], $is_deffense);
                $playersArray[$i]['details'] = $chkPlayerAdded;
                $i++;
            }
        }

        if (isset($request->player_id) && $request->player_id != '') {
            $collection = collect($playersArray);
            $player = $collection->where('player_id', $request->player_id)->values()->all();

            return response()->json($player);
        }

        $return = [];
        $return['players'] = array_values($playersArray);

        return response()->json($return);
    }

    /** PlayersTable Query **/
    public function showPlayersEloquent(Request $request)
    {
        $systemSettings = SystemSetting::find(1);
        //dd($systemSettings);
        $season = [$systemSettings->season];
        $seasonType = $systemSettings->season_type;
        $week = $systemSettings->week;
        $systemSeason = [$systemSettings->season];
        $takeLimit = 70;
        $team = null;

        if (isset($request->season) && $request->season != '') {
            $season = [$request->season];
        }

        // TODO: Remove this after testing
        //$season = array(2018, 2019);

        //dd($request->isProjection);

        // Disable passing the seasonType because we ant to use the system settings
        // if (isset($request->seasonType) && $request->seasonType != '') {
        //     $seasonType =   $request->seasonType;
        // }
        //dd($request->seasonType);

        if (isset($request->isProjection) && $request->isProjection != '') {
            $isProjection = $request->boolean('isProjection');
        }

        $userId = Auth::user()->id;
        $teamIn = FantasyTeam::where('user_id', $userId)->first();
        $league = League::find($teamIn->league_id);

        $positionArray = ['RB', 'TQB', 'K', 'WR', 'TE', 'DEF', 'ST'];

        $available = 0;
        if (isset($request->status) && $request->status != '') {
            $available = $request->status;
        }

        if (isset($request->selectedTeam) && $request->selectedTeam != '') {
            if ($request->selectedTeam == 'ALL') {
                $team = Team::all()->pluck('key')->toArray();
            } else {
                $team = [$request->selectedTeam];
            }
        }

        if (isset($request->selectedPosition) && $request->selectedPosition != '') {
            $position = $request->selectedPosition;
            if ($position == 'DEF') {
                $positionArray = ['DEF'];
            } elseif ($position == 'ST') {
                $positionArray = ['ST'];
            } elseif ($position == 'TQB') {
                $positionArray = ['TQB'];
            } elseif ($position == 'RB') {
                $positionArray = ['RB'];
                $takeLimit = 201;
            } elseif ($position == 'QB') {
                $positionArray = ['QB'];
            } elseif ($position == 'K') {
                $positionArray = ['K'];
            } elseif ($position == 'WR') {
                $takeLimit = 150;
                $positionArray = ['WR'];
            } elseif ($position == 'TE') {
                $takeLimit = 70;
                $positionArray = ['TE'];
            } elseif ($position == 'K') {
                $positionArray = ['K'];
            } elseif ($position == 'RWT') {
                $takeLimit = 150;
                $positionArray = ['RB', 'WR', 'TE'];
            } else {
                $positionArray = ['RB', 'TQB', 'K', 'WR', 'TE', 'DEF'];
                $takeLimit = 300;
            }
        }

        //dd($positionArray);

        // TODO: 3/29/20 set this to return all players because filters in the b-table are faster then multiple requeries.
        // NOTE: We currently query for all player positions and let the vuejs b-table handle the position filtering.
        // This allows it to be much more responsive and less querying on the server as well. One request and done.
        // TODO: Would we ever want to limit the query by position though? If so, need to clean up above logic
        //$positionArray  =   array("RB", "TQB", "K", "WR", "TE", "DEF", "ST");

        $filter = function ($query) use ($season, $seasonType) {
            $query->whereIn('season', $season);
            $query->where('season_type', $seasonType);
        };

        // use systemSeason because the $season request could be data for the previous year.
        $filterPlayerTeamRoster = function ($query) use ($systemSeason, $seasonType, $league, $week) {
            $query->whereIn('season', $systemSeason);
            $query->where('season_type', $seasonType);
            $query->where('week', $week);
            $query->where('league_id', $league->id);
            $query->where(function ($q) {
                $q->where('active', 1)
                    ->orWhere('bench', 1);
            });
        };

        $latestGameFilter = function ($query) use ($systemSeason, $seasonType, $week) {
            $query->whereIn('season', $systemSeason);
            $query->where('season_type', $seasonType);
            $query->where('week', $week);
        };

        //dd($isProjection);
        if ($isProjection) {
            $players = FantasyPlayer::whereIn('fantasy_player.position', $positionArray)
                ->whereIn('team', $team)
                ->whereNotNull('fantasy_player.team')
                ->with(['fantasyTeamOwnedBy' => $filterPlayerTeamRoster])
                ->with(['fantasyPlayerNews'])
                ->with(['playerSeasonProjection' => $filter])
                ->when(in_array('DEF', $positionArray), function ($query) use ($filter) {
                    $query->with(['fantasyDefenseSeasonProjection' => $filter]);
                })
                ->take($takeLimit)
                ->get();
        } else {
            $players = FantasyPlayer::whereIn('fantasy_player.position', $positionArray)
                ->whereIn('team', $team)
                ->whereNotNull('fantasy_player.team')
                ->with(['fantasyTeamOwnedBy' => $filterPlayerTeamRoster])
                // ->with(['fantasyTeamOwnedBy' => function ($query) use ($systemSeason,$seasonType,$league,$week) {
                //     $query->select('id');
                //     $query->whereIn('season', $systemSeason);
                //     $query->where('season_type', $seasonType);
                //     $query->where('week', $week);
                //     $query->where('league_id', $league->id);
                //     $query->where(function ($q) {
                //         $q->where('active', 1)
                //         ->orWhere('bench', 1);
                //     });
                //     $query->select('id');
                // }])
                ->with(['fantasyPlayerNews'])
                // ->with(['teamSeason' => $filter])
                ->with(['currentPlayerGame'])
                ->with(['playerSeason' => $filter])
                ->when(in_array('DEF', $positionArray), function ($query) use ($filter) {
                    $query->with(['fantasyDefenseSeason' => $filter]);
                })
                ->take($takeLimit)
                ->get();
        }

        //dd($players);

        //update player table to only show players that are playing that week (NFL Playoffs)
        //TODO: Probably can turn this on for all seasons..?
        // if ($seasonType==3) {
        //     $playerSchedule =   Schedule::selectRaw('away_team,home_team')
        //                                 ->where('week', $week)
        //                                 ->where('season', $season)
        //                                 ->where('season_type', $seasonType)
        //                                 ->get()->toArray();

        //     $playersTeam=array();
        //     if ($playerSchedule) {
        //         foreach ($playerSchedule as $key=>$val) {
        //             $playersTeam[]      =   $val['away_team'];
        //             $playersTeam[]      =   $val['home_team'];
        //         }
        //     }
        //     //$players is an object
        //     if ($players) {
        //         $filtered = $players->whereIn('team', $playersTeam);
        //         $players = $filtered->all();
        //     }
        // }

        // $players_list=array();
        // $new_collection = collect([]);

        // if ($players) {
        //     foreach ($players as $list) {
        //         //Get status array
        //         $chkPlayerAdded		= $this->checkPlayerAvailable($list->id);
        //         dd($chkPlayerAdded);
        //         //Merge with data
        //         $new_collection = $new_collection->merge($list);
        //         $concatenated = $new_collection->concat($chkPlayerAdded);
        //         dd($concatenated);
        //     }
        // }

        //TODO: Is this needed?
        // if ($players_list) {
        //     if ($available=='available') {
        //         $collection = collect(array_values($players_list));
        //         $filtered = $collection->whereIn('available_status', 'Yes');
        //         $filtered->all();
        //         $players_list =	$filtered->values()->toArray();
        //     }
        // }

        // if (isset($request->player_id) && $request->player_id !='') {
        //     $collection=collect($players_list);
        //     $player =$collection->where('player_id', $request->player_id)->values()->all();
        //     return response()->json($player);
        // }

        $response = [];
        $response['players'] = $players;

        return response()->json($response);
    }

    /**
     * get teams.
     *
     * @return Response
     */
    public function getPlayerTeams()
    {
        $teams = Team::all()->pluck('key')->toArray();
        //        $return['teams']	=	$teams;
        return response()->json($teams);
    }

    /**
     * get positions.
     *
     * @return Response
     */
    public function getPlayerPositions()
    {
        $positions = ['RB', 'QB', 'K', 'WR', 'TE', 'DEF', 'ST'];
        $return['positions'] = $positions;

        return response()->json($return);
    }

    public function _getUserFantasyTeamRoster($fantasyTeamId = null)
    {
        return Helper::getUserFantasyTeamRoster($fantasyTeamId);
    }

    /**
     * getUserFantasyTeamRoster - specifically used during the draft and for the PlayersTable because it has position_count info
     *
     * @return Response
     */
    public function getUserFantasyTeamRoster(Request $request)
    {
        $fantasyTeamId = $request->fantasyTeamId;
        $fantasyTeam = $this->_getUserFantasyTeamRoster($fantasyTeamId);

        return response()->json($fantasyTeam);
    }

    private function checkMaxReached($player_id, $team_id)
    {
        $settings = SystemSetting::find(1);
        $week = $settings->week;
        $season = $settings->season;
        $seasonType = $settings->season_type;

        $thePlayer = FantasyPlayer::where('id', $player_id)->first();
        $thePosition = $thePlayer->position;
        $max_reached = '';
        $message = '';
        $selectTrans = FantasyTeamsPlayerTransaction::selectRaw('count(*) as counts,position')
            ->where('player_transaction_type_id', 1)
            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_player_transactions.fantasy_player_id')
            ->where('fantasy_teams_player_transactions.active', 1)
            ->where('fantasy_team_id', $team_id)
            ->where('week', $week)
            ->groupBy('position')
            ->get();

        if ($selectTrans->count() > 0) {
            $playerArray = $selectTrans->toArray();

            $countArray = array_column($playerArray, 'counts', 'position');

            if ($thePosition == 'RB' && isset($countArray['RB']) && $countArray['RB'] >= 2) {
                $max_reached = 1;
                $message = 'You already have the max number of players for RB';
            } elseif ($thePosition == 'WR' && isset($countArray['WR']) && $countArray['WR'] >= 2) {
                $max_reached = 1;
                $message = 'You already have the max number of players for WR';
            } elseif ($thePosition == 'TE' && isset($countArray['TE']) && $countArray['TE'] >= 1) {
                $max_reached = 1;
                $message = 'You already have the max number of players for TE';
            } elseif ($thePosition == 'K' && isset($countArray['K']) && $countArray['K'] >= 1) {
                $max_reached = 1;
                $message = 'You already have the max number of players for K';
            } elseif ($thePosition == 'TQB' && isset($countArray['TQB']) && $countArray['TQB'] >= 1) {
                $max_reached = 1;
                $message = 'You already have the max number of players for TQB';
            } elseif ($thePosition == 'DEF' && isset($countArray['DEF']) && $countArray['DEF'] >= 1) {
                $max_reached = 1;
                $message = 'You already have the max number of players for DEF';
            } elseif ($thePosition == 'ST' && isset($countArray['ST']) && $countArray['ST'] >= 1) {
                $max_reached = 1;
                $message = 'You already have the max number of players for ST';
            }
        }

        if ($max_reached) {
            return $message;
        } else {
            return false;
        }
    }

    public function getFantasy_points_acme()
    {
        $player_id = 6;
        $team_id = 501;
        $message = $this->checkMaxReached($player_id, $team_id);

        echo $message;
        die;
        echo '<pre>';
        print_r($selectTrans->toArray());
        echo '</pre>';

        die;
        $fantasy_player_transaction = FantasyTeamsPlayerTransaction::select('id', 'fantasy_player_id', 'fantasy_team_id')->with(['fantacyPlayer'])
            ->where('league_id', 1)
            ->where('active', 1)->orderBy('week', 'desc')->get()->toArray();

        $season = 2018;
        $seasonType = 1;
        $week = 1;
        $filter = function ($query) use ($week, $season, $seasonType) {
            $query->where('season', $season);
            $query->where('week', $week);
            $query->where('season_type', $seasonType);
        };

        $teamQB = FantasyPlayer::where('position', 'QB')->where('team', 'KC')
            ->with(['playerGame' => $filter])
            ->get()->toArray();
        //dd($teamQB);

        $fantasy_player_id = 1;
        $fantasy_player = FantasyPlayer::find(281);
        $player_games = Helper::getTqbPlayergame($fantasy_player->team, $season, $seasonType, $week, $yearly = false, $isProjection = true);

        // $player_game	 			= 	Team::where('id',1)->first();

        $fantasy_points = Helper::calculateFantasyPlayerGameFantasyPoints($week, $season, $seasonType, 145);

        // $player_game	 			= 	FantasyDefenseSeasonProjection::find(11);
        // $player_game	 			= 	FantasyDefenseGame::find(30);
        //$player_game	 			= 	PlayerGameProjection::find(24);
        //$player_game	 			= 	PlayerSeasonProjection::find(4);
        // $player_game	 			= 	PlayerSeason::find(1844);

        //	 $player_game	 			= 	FantasyPlayer::find(259);

        //  $player_game	 			= 	PlayerGame::find(1023);
        ///	$result=Helper::calculateFantasyPlayerGameFantasyPoints($week,$season,$seasonType,$fantasy_player_id,$isProjection=false);

        /*



              $player_game	 			= 	TeamGame::find(55);

                */
        //
        return response()->json($fantasy_points);
    }

    /**
     * Show the Players Stats.
     *
     * @return Response
     */
    public function showPlayerStats()
    {
        // $userId = 	Auth::user()->id;
        $user = Auth::user();
        $userId = $user->id;
        $fantasyteam = $user->teams->first();
        $league = $fantasyteam->league;
        // $fantasy_league_id = $league->id;
        $commissioner = $league->leagueCommissioner;
        $commissionerUserIds = $commissioner->pluck('id')->toArray();
        $systemSettings = SystemSetting::find(1);

        //TODO: Add in coCommissioner
        //$coCommissioner = $fantasyLeague->leagueCommissioner;
        //dd($commissioner);

        $seasons = Helper::getThreeSystemSeasons();

        $is_commissioner = $show_draft_user = false;
        $draft_complete = $league->draft_completed ? true : false;    //Force Boolean | TODO: Update to get real league draft status.
        $waiver_period_enabled = $systemSettings->waiver_period_enabled ? true : false;    //Force Boolean | TODO: Update to get real league draft status.
        //dd($fantasyLeague);
        if (in_array($userId, $commissionerUserIds)) {
            $is_commissioner = true;
        }
        // if (($userId == $commissioner->user_id || $userId == $commissioner->is_co_commissioner) && !$draft_complete) {
        //     //Only do it if the draft isn't complete.
        //     $show_draft_user = true;
        // }

        return view('players.stats', compact('userId', 'league', 'is_commissioner', 'draft_complete', 'waiver_period_enabled'));
    }

    /**
     * Get the Player Injury Report.
     *
     * @return Response
     */
    public function getPlayerInjuryReport(Request $request)
    {
        $systemSettings = Helper::getSystemSettingsDetails();
        $week = $systemSettings['week'];
        $season = $systemSettings['season'];
        $seasonType = $systemSettings['season_type'];
        $players_details = [];
        if (isset($request->position)) {
            $position = $request->position;
        }

        $players_qry = Player::where('injury_status', '!=', null)->whereIn('position', ['RB', 'WR', 'QB', 'K', 'TE', 'ST', 'DEF']);

        if (isset($position)) {
            if ($position != 'all') {
                $players_qry->where('position', $position);
            }
        }
        $players = $players_qry->get();
        // foreach ($players as $key=>$val) {
        //     (!empty($val->fantasy_player->teamRoster->fantasyTeam))?$val->fantasy_player->teamRoster->fantasyTeam->name:'';
        //     $players_details[$key]=$val;
        // }

        return response()->json($players);
    }

    /**
     * Show the Player Injury Report.
     *
     * @return Response
     */
    public function showPlayerInjuryReport()
    {
        return view('players.injury-report');
    }

    /**
     * Show the Player Depth Charts
     *
     * @return Response
     */
    public function showPlayerDepthCharts()
    {
        return view('players.depth-charts');
    }

    /**
     * Insert the Player Transaction
     *
     * @return Response
     */
    // public function insertDraftTransactionDetails(Request $request)
    // {

    //     //Preset data
    //     $success = 2;
    //     $allowed =  1;
    //     $message = "You have already picked ";

    //     $userId    = Auth::user()->id;

    //     $commissioner  =  LeagueCommissioner::where('user_id', $userId)->orWhere('is_co_commissioner', $userId)->first();
    //     $isCommissioner  =  0;

    //     if (!empty($commissioner)) {
    //         $isCommissioner = 1;
    //     }
    //     if (isset($request->current_team_id)) {
    //         $current_team_id=$request->current_team_id;
    //     }

    //     $claim_request=0;
    //     if (isset($request->claim_request) && ($request->claim_request==1)) {
    //         $claim_request=1;
    //     }

    //     $waiver_period_enabled=0;
    //     if (isset($request->waiver_period_enabled) && ($request->waiver_period_enabled==1)) {
    //         $waiver_period_enabled=1;
    //     }

    //     $conditional_drop=0;

    //     $team    			= 	FantasyTeam::where('user_id', $userId)->first();
    //     $leagueDetails  	= 	League::find($team->league_id);
    //     $draftPickTime		=	$leagueDetails->draft_pick_max_time;
    //     $draft_date   		= 	Carbon::parse($leagueDetails->draft_date)->timezone($leagueDetails->timezone);
    //     $draftCompleted 	= 	$leagueDetails->draft_completed;

    //     $settings   =  SystemSetting::find(1);
    //     if (!empty($leagueDetails)) {
    //         $override_system = $leagueDetails->override_system;
    //         if ($override_system) {
    //             $week  = $leagueDetails->week;
    //             $season  = $leagueDetails->season;
    //             $seasonType = $leagueDetails->season_type;
    //         } else {
    //             $week  = $settings->week;
    //             $season  = $settings->season;
    //             $seasonType = $settings->season_type;
    //         }
    //     }

    //     if ($request->player_id != '') {
    //         $player_id	= $request->player_id;
    //         $team_id    = $current_team_id;
    //         $checkmessage	= $this->checkMaxReached($player_id, $team_id);

    //         if ($checkmessage != '') {
    //             $returnArray['message']   	= $checkmessage;
    //             $returnArray['success'] 	= 0;
    //             $returnArray['owned_by']  	= $team->name;
    //             return response()->json($returnArray);
    //         }

    //         //Non draft pick. Just a regular transaction once league started.
    //         if ($draftCompleted) {
    //             FantasyTeamsPlayerTransaction::create([
    //                 'league_id' => $team->league_id,
    //                 'fantasy_player_id' => $request->player_id,
    //                 'fantasy_team_id' => $team->id,
    //                 'player_transaction_type_id' => $request->transaction_id,
    //                 'active' => 1,
    //                 'week' => $week,
    //                 'season' => $season,
    //                 'conditional_drop' => $conditional_drop,
    //                 'season_type' => $seasonType
    //             ]);

    //             if ($request->transaction_id == 1) {
    //                 $message  = 'Player has been added successfully';
    //                 $success  = 1;
    //             }
    //             if ($request->transaction_id == 4) {
    //                 $message  = 'Player has been watched successfully';
    //                 $success  = 1;
    //             }
    //         } else {

    //             //Draft only

    //             if ($request->transaction_id == 1) {

    //                 //See if we have a current draft pick
    //                 $current_draft = DraftOrder::where('draft_order.league_id', $team->league_id)
    //                     ->where('fantasy_team_id', $current_team_id)
    //                     ->where('fantasy_player_id', null)
    //                     ->where('deadline', '<>', null)
    //                     //->where('deadline','>=',$draft_date)
    //                     ->first();

    //                 //If we don't have a current draft pick for the user, then see if this is a commissioner and allow the pick.
    //                 if (empty($current_draft)) {
    //                     if ($isCommissioner == 1) {
    //                         $current_draft = DraftOrder::where('draft_order.league_id', $team->league_id)
    //                             ->where('fantasy_player_id', null)
    //                             ->where('deadline', '<>', null)
    //                             ->where('deadline', '>=', $draft_date)
    //                             ->first();

    //                         $allowed = 1;
    //                     } else {
    //                         $allowed = 0;
    //                         $message  = 'You are not allowed to add player now. Please wait for your turn';
    //                         $success  = 0;
    //                     }
    //                 } elseif (!empty($current_draft) && $request->transaction_id == 1) {
    //                     $selectTrans = FantasyTeamsPlayerTransaction::where('player_transaction_type_id', 1)
    //                         ->where('fantasy_player_id', $request->player_id)
    //                         ->where('fantasy_teams_player_transactions.active', 1)
    //                         ->where('league_id', $team->league_id)
    //                         ->first();

    //                     if (empty($selectTrans)) {

    //                         //Make the draft pick.
    //                         FantasyTeamsPlayerTransaction::create([
    //                             'league_id' => $current_draft->league_id,
    //                             'fantasy_player_id' => $request->player_id,
    //                             'fantasy_team_id' => $current_team_id,
    //                             'player_transaction_type_id' => $request->transaction_id,
    //                             'active' => 1,
    //                             'week' => $week,
    //                             'season' => $season,
    //                             'conditional_drop' => $conditional_drop,
    //                             'season_type' => $seasonType
    //                         ]);

    //                         //Set draft data
    //                         $current_draft->fantasy_player_id = $request->player_id;
    //                         $current_draft->deadline = null;
    //                         $current_draft->save();

    //                         $date  =  Carbon::parse('now');
    //                         $f_date  =  $date->addSeconds($draftPickTime)->format('Y-m-d H:i:s');

    //                         $next_draft = DraftOrder::where('draft_order.league_id', $current_draft->league_id)
    //                             ->where('fantasy_player_id', null)
    //                             ->where('deadline', '=', null)
    //                             ->first();
    //                         if (!empty($next_draft)) {
    //                             $next_draft->deadline = $f_date;
    //                             $next_draft->save();
    //                         } else {
    //                             $leagueDetails->draft_completed = 1;
    //                             $leagueDetails->save();
    //                         }
    //                         $message  = 'Player has been added';
    //                         $success  = 1;
    //                     } else {
    //                         $success  = 0;
    //                         $message  = 'Player has been already added';
    //                     }
    //                 }
    //             }
    //         }
    //     } else {
    //         $success  = 1;
    //         $message = "No player id selected";
    //     }

    //     if ($waiver_period_enabled==0) {
    //         //call the FillFantasyTeamsRoster console command
    //         \Artisan::call('FillFantasyTeamsRoster', ['--league_id'=>$team->league_id]);
    //     }
    //     $returnArray['message']   = $message;
    //     $returnArray['success'] = $success;
    //     $returnArray['owned_by']  = $team->name;
    //     return response()->json($returnArray);
    // }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 1=add 2=drop 3=trade 4=watch 5=claim, 6=claim reject, 7=claim approve, 8=active to bench, 9=bench to active, 10 = Cancel Claim, 11 = Add Straight to Bench
     */
    public function insertTransactionDetails(Request $request)
    {
        //Preset data
        $already_added = 0;
        $allowed = 0;
        $message = '';
        $success = false;
        $conditional_drop = 0;
        $proceed = true;
        $transLocator = null;
        // $waiver_period_enabled = false;

        // For now we will turn this on to allow transactions as needed to fix issues. But we need this to be based on commissioner as "god power"
        $overrideGameStarted = false;

        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $season = $systemSettings->season;
        }
        if ($systemSettings->season_type) {
            $seasonType = $systemSettings->season_type;
        }
        if ($systemSettings->season) {
            $week = $systemSettings->week;
        }
        $waiver_period_enabled = $systemSettings->waiver_period_enabled;

        $latestGameFilter = function ($query) use ($season, $seasonType, $week) {
            $query->where('season', $season);
            $query->where('season_type', $seasonType);
            $query->where('week', $week);
        };

        // Default to make the transaction immediately active.
        // TODO: Update this to look at system settings
        $active = 1;
        $bench = 0;

        // 1=add 2=drop 3=trade 4=watch 5=claim, 6=claim reject 7=claim approve, 8=active to bench, 9=bench to active
        $transType = $request->transaction_id;

        if (! $waiver_period_enabled) {
            // We need to check for claims and process immediately.
        }

        if (isset($request->conditional_drop) && ($request->conditional_drop)) {
            $conditional_drop = $request->conditional_drop;
        }

        if (isset($request->transaction_locator) && ($request->transaction_locator)) {
            $transLocator = $request->transaction_locator;
        }

        // Check if we have a fantasy_team_id that was passed. If we do, use it. Otherwise look up based on logged in user
        if ($request->fantasy_team_id) {
            $user = FantasyTeam::findOrFail($request->fantasy_team_id)->teamOwner;
        } elseif ($transLocator) {
            $previousTransaction = FantasyTeamsPlayerTransaction::findOrFail($transLocator);
            $user = FantasyTeam::findOrFail($previousTransaction->fantasy_team_id)->teamOwner;
        } else {
            $user = Auth::user();
        }
        //dd($request->fantasy_team_id);

        // TODO 05-10-20: This really needs to look at the passed in fantasy team id to be more sound because a user could have more than one fantasy team id if they played in different leagues.
        $user_id = $user->id;
        $fantasyteam = $user->teams->first();
        $fantasyLeague = $fantasyteam->league;
        $commissioner = $fantasyLeague->leagueCommissioner;
        $commissionerUserIds = $commissioner->pluck('id')->toArray();
        $isCommissioner = true;

        // Get a record of the current fantasyTeamRoster and confirm max players aren't already

        $fantasyTeamRoster = $this->_getUserFantasyTeamRoster($fantasyteam->id);

        //        dd($fantasyTeamRoster);

        if (in_array($user_id, $commissionerUserIds)) {
            $isCommissioner = true;
        }

        //         $claim_request=0;
        //         if (isset($request->claim_request) && ($request->claim_request==1)) {
        //             $claim_request=1;
        //         }

        $draftCompleted = $fantasyLeague->draft_completed;

        $settings = SystemSetting::find(1);
        $week = $settings->week;
        $season = $settings->season;
        $seasonType = $settings->season_type;

        $tempProceed = true;

        if (! $tempProceed) {
            $message = 'under maintenance';
            $proceed = false;
        }

        if ($request->player_id != '' || $transLocator) {

            //Non draft pick. Just a regular transaction once league started.
            if ($draftCompleted) {

                // CASE 1: ADD AVAILABLE PLAYER
                $fantasyPlayer = FantasyPlayer::where('id', $request->player_id)->with(['teamGame.score'])->first();
                if ($transType == 1 || $transType == 11) {
                    if ($tempProceed) {

                        // If it isn't the Playoffs, do the check.
                        if ($seasonType != 3) {
                            $searchId = $request->player_id;
                            // Check if the player is already added on a team.
                            // TODO: 04/20/20 Move this to the model to actually protect it there across the board.
                            $selectTrans = FantasyTeamsPlayerTransaction::where('player_transaction_type_id', 1)
                                ->where('fantasy_player_id', $searchId)
                                ->where('league_id', $fantasyteam->league_id)
                                ->where(function ($q) {
                                    $q->where('active', 1)
                                        ->orWhere('bench', 1);
                                })
                                ->first();

                            if ($selectTrans) {
                                $message .= 'Denied. The player is already on a team. ';
                                $success = false;
                                $proceed = false;
                            }

                            // If the player isn't already on a team AND if we have a max reached, check to see if this is an injured player situation
                            if (! $selectTrans && $fantasyTeamRoster['position'][$fantasyPlayer->position]['maxReached']) {
                                // Check if we have an injured player to deal with
                                if (isset($fantasyTeamRoster['injuries'][$fantasyPlayer->position]) && ! $waiver_period_enabled) {
                                    // Check if the selected player is the same position and from the same team
                                    if (isset($fantasyTeamRoster['injuries'][$fantasyPlayer->position][$fantasyPlayer->team]) && ! $fantasyTeamRoster['injuries'][$fantasyPlayer->position][$fantasyPlayer->team]['covered']) {
                                        //$message = 'This would be approved';
                                        $success = true;
                                        $proceed = true;
                                    } else {
                                        $message = 'Denied. Select replacement from same injured player team.';
                                        $success = false;
                                        $proceed = false;
                                    }
                                }
                            }
                        }
                        if ($seasonType == 3) {
                            $playerCheck = $this->checkPlayerAvailable($fantasyPlayer->id);

                            if ($playerCheck['matches_team']) {
                                $message = 'Denied. This will match another fantasy team.';
                                $success = false;
                                $proceed = false;
                            }
                        }

                        //dd($playerCheck);

                        $fantasyPlayer = FantasyPlayer::where('id', $request->player_id)
                            ->with(['teamGame.Score' => $latestGameFilter])
                            ->with(['teamGame' => $latestGameFilter])
                            ->first();

                        // If this has a 'waiver_add_with_drop' true condition then we will NOT DENY IT. The system will drop a player next.
                        if ($fantasyTeamRoster['position'][$fantasyPlayer->position]['maxReached'] && ! $request->waiver_add_with_drop) {
                            if (isset($fantasyTeamRoster['injuries'][$fantasyPlayer->position][$fantasyPlayer->team]) && ! $fantasyTeamRoster['injuries'][$fantasyPlayer->position][$fantasyPlayer->team]['covered']) {
                                // Do nothing
                            } else {
                                $message = 'Denied. Max reached at the current position.';
                                $success = false;
                                $proceed = false;
                            }
                        }

                        // If we are in week 3 or 4 of playoffs then we need another check.
                        if ($seasonType == 3) {
                            if ($week > 2 && in_array($fantasyPlayer->position, ['RB', 'WR', 'TE'])) {
                                // Check if flex is used or not.
                                if ($fantasyTeamRoster['position'][$fantasyPlayer->position]['maxReached']) {
                                    $flexMaxReached = isset($fantasyTeamRoster['FLEX']['maxReached']) ? $fantasyTeamRoster['FLEX']['maxReached'] : 0;

                                    if (! $flexMaxReached) {
                                        $message = '';
                                        $success = true;
                                        $proceed = true;
                                    }
                                }
                            }

                            // Only do this logic for weeks 1->3 of NFL Playoffs. DO NOT run on week 4 (SuperBowl Sunday)
                            if ($week < 4 && isset($fantasyTeamRoster['currentTeamCounts'][$fantasyPlayer->team]) && $fantasyTeamRoster['currentTeamCounts'][$fantasyPlayer->team] > 1 && $fantasyPlayer->position != 'ST') {
                                $message = 'Denied. Max reached for NFL team: '.$fantasyPlayer->team;
                                $success = false;
                                $proceed = false;
                            }
                        }

                        //dd($fantasyTeamRoster['injuries'][$fantasyPlayer->position][$fantasyPlayer->team]);
                        if ($transType == 11 && isset($fantasyTeamRoster['injuries'][$fantasyPlayer->position][$fantasyPlayer->team]) && ! $fantasyTeamRoster['injuries'][$fantasyPlayer->position][$fantasyPlayer->team]['covered'] && ! $waiver_period_enabled) {
                            //$message = 'THIS WOULD HAVE APPROVED';
                            $success = true;
                            $proceed = true;
                        }

                        $tg = $fantasyPlayer->teamGame;
                        $score = isset($tg) ? $tg->Score : null;
                        // $score = $tg->Score->first() ?? null;
                        //dd($score);
                        if ($score && ! $overrideGameStarted) {
                            if ($score['has_started']) {
                                $message .= 'Denied. The current game has already started. ';
                                $success = false;
                                $proceed = false;
                            }
                        }

                        if ($fantasyPlayer->bye_week == $week) {
                            $message .= 'Denied. This player is on a bye this week.';
                            $success = false;
                            $proceed = false;
                        }
                    }
                    // Proceed to "create" the transaction to track the activity
                }

                //dd($message);

                // CASE 2: DROP PLAYER
                if ($transType == 2) {
                    $message = 'under maintenance';
                    if ($tempProceed) {
                        //Set to 0 because we are dropping a player. no need to make that an "active" drop
                        $active = 0;
                        // Otherwise, above query gets the player and sets to active.
                        $previousTransactionQuery = FantasyTeamsPlayerTransaction::where('fantasy_player_id', $request->player_id)
                            ->where('fantasy_team_id', $fantasyteam->id)
                            ->where('league_id', $fantasyteam->league_id)
                            ->where('player_transaction_type_id', 1)
                            ->where('season_type', $seasonType)
                            ->where(function ($q) {
                                $q->where('active', 1)
                                    ->orWhere('bench', 1);
                            });

                        // Postseason
                        // If this is the post season we need to only drop for a specific week.
                        if ($seasonType == 3) {
                            $previousTransactionQuery->where('week', $week);
                        }

                        $previousTransaction = $previousTransactionQuery->first();

                        if ($previousTransaction) {
                            // Check that the player game did not start already
                            $fantasyPlayer = FantasyPlayer::where('id', $request->player_id)
                                ->with(['teamGame.Score' => $latestGameFilter])
                                ->with(['teamGame' => $latestGameFilter])
                                ->first();
                            $tg = $fantasyPlayer->teamGame;

                            $score = isset($tg) ? $tg->Score : null;
                            // $score = $tg->Score->first() ?? null;
                            //dd($score);
                            if ($score && ! $overrideGameStarted) {
                                if ($score['has_started']) { // if ($fantasyPlayer->currentPlayerGame->started);
                                    $message = 'Denied. The current game has already started.';
                                    $proceed = false;
                                    $success = false;
                                }
                            } else {
                                // Set to not active and not on bench
                                $active = 0;
                                $bench = 0;
                                $previousTransaction->active = $active;
                                $previousTransaction->bench = $bench;
                                $previousTransaction->save();
                            }
                        }
                        // Proceed to "create" the dropped transaction
                        // We then create a "dropped" record to store this as an official transaction.
                    }
                }

                // CASE: Claim Player
                // CASE: Trans type = 5 (submitting claim only) We go ahead and allow the transaction

                // CASE: Claim Player Cancel
                // CASE: Trans type = 10. User is cancelling claim
                if ($transType == 10) {
                    $active = 0;
                    // If this is the post season we need to only drop for a specific week.
                    // Otherwise, above query gets the player and sets to active.
                    // We then create a "dropped" record to store this as an official transaction.

                    $transaction_query = FantasyTeamsPlayerTransaction::where('fantasy_player_id', $request->player_id)
                        ->where('player_transaction_type_id', 5)
                        ->where('week', $week);

                    // if ($seasonType==3) {
                    //     $transaction_query->where('week', $week);
                    // }

                    $previousTransaction = $transaction_query->where('player_transaction_type_id', 5)
                        ->where('league_id', $fantasyteam->league_id)
                        ->where('fantasy_team_id', $fantasyteam->id)
                        ->first();

                    // Postseason
                    if ($seasonType == 3) {
                        $previousTransaction->where('week', $week);
                    }

                    if ($previousTransaction) {
                        // Set to not active and not on bench
                        // This marks the claim as inactive for the processor.
                        $previousTransaction->active = 0;
                        $previousTransaction->bench = 0;
                        $previousTransaction->save();
                    }
                    //Proceed to "create" the dropped transaction
                }

                // CASE: REJECT CLAIM
                if ($transType == 6) {
                    $active = 0;
                    $bench = 0;

                    // If this is the post season we need to only drop for a specific week.
                    // Otherwise, above query gets the player and sets to active.
                    // We then create a "dropped" record to store this as an official transaction.
                    $previousTransaction = FantasyTeamsPlayerTransaction::findOrFail($transLocator);

                    // Postseason
                    /*if ($seasonType==3) {
                        $previousTransaction->where('week', $week);
                    }*/

                    if ($previousTransaction) {

                        // Check that the player game did not start already
                        $fantasyPlayer = FantasyPlayer::where('id', $previousTransaction->fantasy_player_id)
                            ->with(['teamGame.Score' => $latestGameFilter])
                            ->with(['teamGame' => $latestGameFilter])
                            ->first();
                        $tg = $fantasyPlayer->teamGame;
                        $score = isset($tg) ? $tg->Score : null;
                        if ($score && ! $overrideGameStarted) {
                            if ($score['has_started']) { // if ($fantasyPlayer->currentPlayerGame->started);
                                $message = 'Denied. The current game has already started.';
                                $proceed = false;
                                $success = false;
                            }
                        }
                    }

                    // Proceed to "reject" the transaction to track the activity

                    if ($proceed) {
                        //create a transaction for claim_reject that is the player_id
                        $rejectedTrans = FantasyTeamsPlayerTransaction::create([
                            'league_id'                         => $previousTransaction->league_id,
                            'fantasy_player_id'                 => $previousTransaction->fantasy_player_id,
                            'fantasy_team_id'                  => $previousTransaction->fantasy_team_id,
                            'player_transaction_type_id'      =>    6,
                            'active'                          => 0,
                            'week'                              => $week,
                            'season'                          => $season,
                            'conditional_drop'                 =>    0,
                            'season_type'                     => $seasonType,
                        ]);

                        // set the original Claim Request to not active and no bench
                        $previousTransaction->active = 0;
                        $previousTransaction->bench = 0;
                        $previousTransaction->approved = 0;
                        $previousTransaction->rejected = 1;
                        $previousTransaction->save();

                        $success = true;
                        $message = 'The claim was rejected';
                    }
                }

                // CASE: APPROVE CLAIM
                if ($transType == 7) {
                    $active = 0;
                    $bench = 0;

                    // If this is the post season we need to only drop for a specific week.
                    // Otherwise, above query gets the player and sets to active.
                    // We then create a "dropped" record to store this as an official transaction.
                    $previousTransaction = FantasyTeamsPlayerTransaction::findOrFail($transLocator);

                    // Postseason
                    /*if ($seasonType==3) {
                        $previousTransaction->where('week', $week);
                    }*/

                    if ($previousTransaction) {

                        // Check that the player game did not start already
                        $fantasyPlayer = FantasyPlayer::where('id', $previousTransaction->fantasy_player_id)
                            ->with(['teamGame.Score' => $latestGameFilter])
                            ->with(['teamGame' => $latestGameFilter])
                            ->first();
                        $tg = $fantasyPlayer->teamGame;
                        $score = isset($tg) ? $tg->Score : null;
                        if ($score) {
                            if ($score['has_started']) { // if ($fantasyPlayer->currentPlayerGame->started);
                                $message = 'Denied. The current game has already started.';
                                $proceed = false;
                                $success = false;
                            }
                        }
                    }
                    //Proceed to "create" the transaction to track the activity

                    if ($proceed) {
                        // Add the request
                        $addRequest = new Request(
                            [
                                'player_id' => $previousTransaction->fantasy_player_id,
                                'fantasy_team_id' => $previousTransaction->fantasy_team_id,
                                'transaction_id' => 1,
                                'waiver_add_with_drop' => $previousTransaction->conditional_drop ? true : false,
                            ],
                            ['CONTENT_TYPE' => 'application/json']
                        );
                        //$playerController = new PlayerController();
                        $response = $this->insertTransactionDetails($addRequest)->getData();

                        if ($response->success) {
                            //create a transaction for claim_approve that is the player_id
                            $approvedTrans = FantasyTeamsPlayerTransaction::create([
                                'league_id'                         => $previousTransaction->league_id,
                                'fantasy_player_id'                 => $previousTransaction->fantasy_player_id,
                                'fantasy_team_id'                  => $previousTransaction->fantasy_team_id,
                                'player_transaction_type_id'      =>    7,
                                'active'                          => 0,
                                'week'                              => $week,
                                'season'                          => $season,
                                'conditional_drop'                 =>    0,
                                'season_type'                     => $seasonType,
                            ]);

                            // set the original Claim Request to not active and no bench
                            $previousTransaction->active = 0;
                            $previousTransaction->bench = 0;
                            $previousTransaction->approved = 1;
                            $previousTransaction->save();

                            // Check for a conditional drop and do it
                            if ($previousTransaction->conditional_drop) {
                                // Add the request
                                $dropRequest = new Request(
                                    [
                                        'player_id' => $previousTransaction->conditional_drop,
                                        'fantasy_team_id' => $previousTransaction->fantasy_team_id,
                                        'transaction_id' => 2,
                                    ],
                                    ['CONTENT_TYPE' => 'application/json']
                                );
                                //$playerController = new PlayerController();
                                $responseDrop = $this->insertTransactionDetails($dropRequest)->getData();

                                if ($responseDrop->success) {
                                    $success = true;
                                    $message = 'Request Approved. Player was added to team. Dropped Conditional';
                                } else {
                                    $success = false;
                                    $message = $responseDrop->message;
                                }
                            } else {
                                $success = true;
                                $message = 'Request Approved. Player was added to team.';
                            }
                        } else {
                            $success = false;
                            $message = $response->message;
                            $proceed = false;
                        }
                    }
                }

                // CASE: ACTIVE -> BENCH
                if ($transType == 8) {
                    $active = 0;
                    $bench = 1;
                    // If this is the post season we need to only drop for a specific week.
                    // Otherwise, above query gets the player and sets to active.
                    // We then create a "dropped" record to store this as an official transaction.
                    $previousTransaction = FantasyTeamsPlayerTransaction::where('fantasy_player_id', $request->player_id)
                        ->where('player_transaction_type_id', 1)
                        ->where('league_id', $fantasyteam->league_id)
                        ->where('fantasy_team_id', $fantasyteam->id)
                        ->where('active', 1)
                        ->first();

                    // Postseason
                    if ($seasonType == 3) {
                        $previousTransaction->where('week', $week);
                    }
                    if ($previousTransaction) {
                        // Check that the player game did not start already
                        $fantasyPlayer = FantasyPlayer::where('id', $request->player_id)
                            ->with(['teamGame.Score' => $latestGameFilter])
                            ->with(['teamGame' => $latestGameFilter])
                            ->first();
                        $tg = $fantasyPlayer->teamGame;
                        $score = isset($tg) ? $tg->Score : null;
                        if ($score && ! $overrideGameStarted) {
                            if ($score['has_started']) { // if ($fantasyPlayer->currentPlayerGame->started);
                                $message = 'Denied. The current game has already started.';
                                $proceed = false;
                                $success = false;
                            }
                        } else {
                            // set to not active
                            // Set bench to true
                            $previousTransaction->active = $active;
                            $previousTransaction->bench = $bench;
                            $previousTransaction->save();
                            $proceed = true;
                        }
                    }
                    //Proceed to "create" the transaction to track the activity
                }

                // CASE: BENCH -> ACTIVE
                if ($transType == 9) {
                    $active = 1;
                    $bench = 0;
                    // If this is the post season we need to only drop for a specific week.
                    // Otherwise, above query gets the player and sets to active.
                    // We then create a "dropped" record to store this as an official transaction.
                    $previousTransaction = FantasyTeamsPlayerTransaction::where('fantasy_player_id', $request->player_id)
                        ->where('player_transaction_type_id', 1)
                        ->where('fantasy_team_id', $fantasyteam->id)
                        ->where('league_id', $fantasyteam->league_id)
                        ->where('bench', 1)
                        ->first();

                    // Postseason
                    if ($seasonType == 3) {
                        $previousTransaction->where('week', $week);
                    }

                    if ($previousTransaction) {
                        // Check that the player game did not start already
                        $fantasyPlayer = FantasyPlayer::where('id', $request->player_id)
                            ->with(['teamGame.Score' => $latestGameFilter])
                            ->with(['teamGame' => $latestGameFilter])
                            ->first();
                        $tg = $fantasyPlayer->teamGame;
                        $score = isset($tg) ? $tg->Score : null;
                        if ($score && ! $overrideGameStarted) {
                            if ($score['has_started']) { // if ($fantasyPlayer->currentPlayerGame->started);
                                $message = 'Denied. The current game has already started.';
                                $proceed = false;
                                $success = false;
                            }
                        } else {
                            // set active roster
                            // Set bench to false
                            $previousTransaction->active = $active;
                            $previousTransaction->bench = $bench;
                            $previousTransaction->save();
                        }
                    }
                    //Proceed to "create" the transaction to track the activity
                }

                // CASE: ADD PLAYER STRAIGHT TO BENCH
                if ($transType == 11) {
                    $active = 0;
                    $bench = 1;

                    //Update to an "add" transaction now.
                    // We do not create a transaction with id type of 11. We create it as an "add" but with a bench designation
                    $transType = 1;
                }

                // If we are allowed to proceed and it is not a claim reject or claim approve (Done above)
                if ($proceed && ! in_array($transType, [6, 7])) {
                    // Create a transaction as specified.
                    FantasyTeamsPlayerTransaction::create([
                        'league_id' => $fantasyteam->league_id,
                        'fantasy_player_id' => $request->player_id,
                        'fantasy_team_id' => $fantasyteam->id,
                        'player_transaction_type_id' => $transType,
                        'active' => in_array($transType, [8, 9]) ? 0 : $active,  //Fudging this so we keep track of when people move to bench or not. if transaction is an 8 or 9, set it as not active. We just want to log that the user moved the player on this week and time.,
                        'bench' => in_array($transType, [8, 9]) ? 0 : $bench,  //Fudging this so we keep track of when people move to bench or not. if transaction is an 8 or 9, set it as not active. We just want to log that the user moved the player on this week and time.,
                        'week' => $week,
                        'season' => $season,
                        'conditional_drop' => $conditional_drop,
                        'season_type' => $seasonType,
                    ]);

                    // If we are adding, moving to bench or starter, or adding straight to the bench we need to update the roster record immediately
                    if (in_array($transType, [1, 8, 9])) {
                        //Update the roster record
                        $transactions_data = [
                            'fantasy_player_id'             => $request->player_id,
                            'fantasy_team_id'               => $fantasyteam->id,
                            'player_transaction_type_id'    => 1,   // Always a 1. This lets us know this is player is tied to the roster for this week.
                            'league_id'                     => $fantasyteam->league_id,
                            'active'                        => $active,
                            'week'                          => $week,
                            'season'                        => $season,
                            'season_type'                   => $seasonType,
                            'bench'                         => $bench,
                        ];
                        \App\Models\FantasyTeamsRoster::updateOrCreate(
                            [
                                'fantasy_team_id'               => $fantasyteam->id,
                                'league_id'                     => $fantasyteam->league_id,
                                'week'                          => $week,
                                'season'                        => $season,
                                'season_type'                   => $seasonType,
                                'fantasy_player_id'             => $request->player_id,
                                //'player_transaction_type_id'    => $sval->player_transaction_type_id
                            ],
                            $transactions_data
                        );
                    }

                    // If dropping we need to delete the old record.
                    if (in_array($transType, [2])) {
                        $transaction = \App\Models\FantasyTeamsRoster::where('fantasy_team_id', $fantasyteam->id)
                            ->where('league_id', $fantasyteam->league_id)
                            ->where('week', $week)
                            ->where('season', $season)
                            ->where('season_type', $seasonType)
                            ->where('fantasy_player_id', $request->player_id)
                            ->first();
                        $transaction->delete();
                    }

                    //Set Alert Messages
                    $success = true;
                    // Add
                    if ($transType == 1) {
                        $message = $fantasyPlayer->name.' added successfully.';
                    }

                    // Dropped
                    if ($transType == 2) {
                        $message = $fantasyPlayer->name.' dropped from your team.';
                    }

                    //Watch
                    if ($transType == 4) {
                        $message = $fantasyPlayer->name.' watched successfully.';
                    }

                    // Claim #5
                    if ($transType == 5) {
                        $message = $fantasyPlayer->name.' claim request was submitted.';
                    }

                    //Move to bench
                    if ($transType == 8) {
                        $message = $fantasyPlayer->name.' moved to the bench.';
                    }

                    //move to Active
                    if ($transType == 9) {
                        $message = $fantasyPlayer->name.' moved to starting lineup.';
                    }

                    //move to Active
                    if ($transType == 10) {
                        $message = $fantasyPlayer->name.' claim request was cancelled.';
                    }
                }
            } else {
                //Draft only
                //dd($request->transaction_id);
                $draft_date = Carbon::parse($fantasyLeague->draft_date);
                if ($request->transaction_id == 1) {

                    // Safeguard: See if we have a current draft pick for this specific fantasy team
                    $current_draft = DraftOrder::where('draft_order.league_id', $fantasyteam->league_id)
                        ->where('fantasy_team_id', $fantasyteam->id)
                        ->where('fantasy_player_id', null)
                        ->where('deadline', '<>', null)
                        ->where('deadline', '>=', $draft_date)
                        ->first();

                    // Check Commissioner: If we don't have a current draft pick for the user, then see if this is a commissioner and allow the pick.
                    if (empty($current_draft)) {
                        if ($isCommissioner) {
                            $current_draft = DraftOrder::where('draft_order.league_id', $fantasyteam->league_id)
                                ->where('fantasy_player_id', null)
                                ->where('deadline', '<>', null)
                                ->where('deadline', '>=', $draft_date)
                                ->first();
                            $allowed = 1;
                        } else {    //Somehow they managed to hit a draft button? Bug? But we will deny it anyways. :)
                            $allowed = 0;
                            $message = 'You are not allowed to draft yet.';
                            $success = false;
                        }
                    }
                    if (! empty($current_draft)) {

                        // TODO: 07/30/2020 : Check that this fantasyTeam is not at their max.

                        $positions = $this->_getUserFantasyTeamRoster($current_draft->fantasy_team_id);
                        $positionData = isset($positions['position']) ? $positions['position'] : [];
                        // dd($positionData);

                        $fantasyPlayer = FantasyPlayer::where('id', $request->player_id)->first();
                        //dd($fantasyPlayer);
                        $checkPosition = $fantasyPlayer->position;
                        if (isset($positionData[$checkPosition]['maxReached']) && $positionData[$checkPosition]['maxReached']) {
                            $message = $checkPosition.' max already reached';
                            $allowed = 0;
                            $success = false;
                        } else {
                            // Check that the player did not already get drafted on the team ? Maybe computer did it?
                            // TODO: 04/20/20 Move this to the model to actually protect it there across the board.
                            $selectTrans = FantasyTeamsPlayerTransaction::where('player_transaction_type_id', 1)
                                ->where('fantasy_player_id', $request->player_id)
                                ->where('league_id', $fantasyteam->league_id)
                                ->where(function ($q) {
                                    $q->where('active', 1)
                                        ->orWhere('bench', 1);
                                })
                                ->first();

                            if (! empty($selectTrans)) {
                                $already_added = 1;
                                $message = 'Player has been already been drafted.';
                            } else {
                                // Make the draft pick.
                                FantasyTeamsPlayerTransaction::create([
                                    'league_id' => $current_draft->league_id,
                                    'fantasy_player_id' => $request->player_id,
                                    'fantasy_team_id' => $current_draft->fantasy_team_id,
                                    'player_transaction_type_id' => 1,
                                    'active' => 1,
                                    'week' => 1,
                                    'season' => $season,
                                    'conditional_drop' => 0,
                                    'season_type' => 1,
                                ]);

                                // Update the roster record
                                $transactions_data = [
                                    'fantasy_player_id'             => $request->player_id,
                                    'fantasy_team_id'               => $current_draft->fantasy_team_id,
                                    'player_transaction_type_id'    => 1,   // Always a 1. This lets us know this is active for the week.
                                    'league_id'                     => $current_draft->league_id,
                                    'active'                        => 1,
                                    'week'                          => 1,
                                    'season'                        => $season,
                                    'season_type'                   => 1,
                                    'bench'                         => 0,
                                ];
                                \App\Models\FantasyTeamsRoster::updateOrCreate(
                                    [
                                        'fantasy_team_id'               => $current_draft->fantasy_team_id,
                                        'league_id'                     => $current_draft->league_id,
                                        'week'                          => 1,
                                        'season'                        => $season,
                                        'season_type'                   => 1,
                                        'fantasy_player_id'             => $request->player_id,
                                    ],
                                    $transactions_data
                                );
                                $success = true;
                                // Save the current draft transaction with the player and deadline as complete.
                                $current_draft->fantasy_player_id = $request->player_id;
                                $current_draft->deadline = null;
                                $current_draft->save();
                                $message = 'Player drafted successfully.';

                                // Look if we have a next draft pick of data to set the time.
                                $draftPickTime = $fantasyLeague->draft_pick_max_time + 3;
                                $next_draft = DraftOrder::where('draft_order.league_id', $current_draft->league_id)
                                    ->where('fantasy_player_id', null)
                                    ->where('deadline', '=', null)
                                    ->first();
                                // Set the next draft transaction data.
                                if (! empty($next_draft)) {
                                    $next_draft->deadline = Carbon::now()->addSeconds($draftPickTime);
                                    $next_draft->save();
                                // Complete the draft.
                                } else {
                                    $fantasyLeague->draft_completed = 1;
                                    $fantasyLeague->save();
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $message = 'No player id selected';
        }

        // if ($waiver_period_enabled==0) {
        //     //call the FillFantasyTeamsRoster console command
        //     \Artisan::call('FillFantasyTeamsRoster', ['--league_id'=>$team->league_id]);
        // }
        //call the FillFantasyTeamsRoster console command
        // \Artisan::call('FillFantasyTeamsRoster', ['--league_id'=>$fantasyteam->league_id]);

        $returnArray['message'] = $message;
        $returnArray['already_added'] = $already_added;
        $returnArray['owned_by'] = $fantasyteam->name;
        $returnArray['success'] = $success;

        return response()->json($returnArray);
    }

    public function LeagueinsertTransactionDetails(Request $request)
    {
        $fantasy_player = $request->players_id;

        //Preset data
        $already_added = 0;
        $allowed = 1;
        $message = 'Claim request submitted. Requests are approved on Wednesday morning.';

        $conditional_drop = 0;
        $userId = Auth::user()->id;

        $commissioner = LeagueCommissioner::where('user_id', $userId)->orWhere('is_co_commissioner', $userId)->first();
        $isCommissioner = 0;

        $team_id = 0;
        if (isset($request->team_id) && ($request->team_id)) {
            $team_id = $request->team_id;
        }
        $team = FantasyTeam::where('user_id', $userId)->first();
        $leagueDetails = League::find($team->league_id);
        $draft_date = Carbon::parse($leagueDetails->draft_date)->timezone($leagueDetails->timezone);
        $draftCompleted = $leagueDetails->draft_completed;

        $settings = SystemSetting::find(1);
        if (! empty($leagueDetails)) {
            $override_system = $leagueDetails->override_system;
            if ($override_system) {
                $week = $leagueDetails->week;
                $season = $leagueDetails->season;
                $seasonType = $leagueDetails->season_type;
            } else {
                $week = $settings->week;
                $season = $settings->season;
                $seasonType = $settings->season_type;
            }
        }
        $fantasy_player = array_filter($fantasy_player);
        $existing_players = FantasyTeamsPlayerTransaction::select('fantasy_player_id')->whereIn('fantasy_player_id', $fantasy_player)->where('week', $week)
            ->where('season', $season)->where('season_type', $seasonType)
            ->where('fantasy_team_id', '!=', $team_id)->get()->toArray();

        if ($existing_players) {
            $collection = collect($existing_players);
            $plucked = $collection->pluck('fantasy_player_id');
            $collection2 = collect($plucked);
            $intersect = $collection2->intersect($fantasy_player);
            $intersect = $intersect->all();
            $total_players = FantasyPlayer::select('name')->whereIn('id', $intersect)->get()->toArray();

            $collection = collect($total_players);
            $plucked = $collection->pluck('name');
            $res = collect($plucked)->join(', ');

            $returnArray['message'] = $res.' is already on a different team.';
            $returnArray['status'] = 'failure';

            return response()->json($returnArray);
        }

        if ($fantasy_player) {
            $existing_players = FantasyTeamsPlayerTransaction::where('week', $week)
                ->where('season', $season)->where('season_type', $seasonType)
                ->where('fantasy_team_id', '=', $team_id)->delete();

            //Non draft pick. Just a regular transaction once league started.
            foreach ($fantasy_player as $val) {
                if (! empty($val)) {
                    FantasyTeamsPlayerTransaction::create([
                        'league_id' => $team->league_id,
                        'fantasy_player_id' => $val,
                        'fantasy_team_id' => $team_id,
                        'player_transaction_type_id' => 1,
                        'active' => 1,
                        'week' => $week,
                        'season' => $season,
                        'conditional_drop' => $conditional_drop,
                        'season_type' => $seasonType,
                    ]);

                    if ($request->transaction_id == 1) {
                        $message = 'Player has been added successfully';
                    }
                    $returnArray['status'] = 'success';
                }
            }
            $returnArray['status'] = 'success';
        } else {
            $message = 'No player id selected';
            $returnArray['status'] = 'failure';
        }

        $returnArray['message'] = $message;
        $returnArray['already_added'] = $already_added;
        $returnArray['owned_by'] = $team->name;

        return response()->json($returnArray);
    }

    public function unwatchPlayer(Request $request)
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        if ($request->player_id != '') {
            $transaction_query = FantasyTeamsPlayerTransaction::where('fantasy_player_id', $request->player_id)->where('active', 1);

            $transaction = $transaction_query->where('player_transaction_type_id', 4)->where('league_id', $team->league_id)->where('fantasy_team_id', $team->id)->first();
            $transaction->active = 0;
            $transaction->save();

            //call the FillFantasyTeamsRoster console command
            //	\Artisan::call('FillFantasyTeamsRoster');
            \Artisan::call('FillFantasyTeamsRoster', ['--league_id' => $team->league_id]);
            $message = 'Player has been unwatched successfully';
        } else {
            $message = 'Some error has been occured. Please try again.';
        }

        return response()->json($message);
    }

    public function getClaimPlayers(Request $request)
    {
        $userId = Auth::user()->id;

        $commissioner = LeagueCommissioner::where('user_id', $userId)->orWhere('is_co_commissioner', $userId)->first();
        $isCommissioner = 0;

        if (! empty($commissioner)) {
            $isCommissioner = 1;
        }

        $team = FantasyTeam::where('user_id', $userId)->first();
        $leagueDetails = League::find($team->league_id);
        $draft_date = Carbon::parse($leagueDetails->draft_date)->timezone($leagueDetails->timezone);
        $draftCompleted = $leagueDetails->draft_completed;

        $settings = SystemSetting::find(1);
        if (! empty($leagueDetails)) {
            $override_system = $leagueDetails->override_system;
            if ($override_system) {
                $week = $leagueDetails->week;
                $season = $leagueDetails->season;
                $seasonType = $leagueDetails->season_type;
            } else {
                $week = $settings->week;
                $season = $settings->season;
                $seasonType = $settings->season_type;
            }
        }

        $selectTrans = FantasyTeamsPlayerTransaction::selectRaw('p.name,fantasy_teams_player_transactions.id,fantasy_teams_player_transactions.fantasy_player_id,position')->where('player_transaction_type_id', 1)
            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_player_transactions.fantasy_player_id')
            ->where('fantasy_teams_player_transactions.active', 1)
            ->where('fantasy_team_id', $team->id)
            ->where('league_id', $team->league_id)
            ->where('season', $season)
            ->where('week', $week)
            ->where('season_type', $seasonType)
            ->where('active', 1)
            ->get()->toArray();

        $players = [];
        if ($selectTrans) {
            foreach ($selectTrans as $list) {
                $players[$list['id']] = $list['name'].', '.$team->name.', '.$list['position'];
            }
        }

        return response()->json($players);
    }

    public function checkPlayerMaximumPositionReached(Request $request)
    {
        $checkPlayer = $this->checkPlayerAvailable($request->player_id);

        return response()->json($checkPlayer);
    }

    public function checkPlayerAvailable($player_id)
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $max_reached = 0;
        $waiver_period_enabled = 0;
        $added = $remove = $dropped = $traded = $watched = $claim_request = $bench = $matches_team = 0;
        $claim_removed = 0;
        $owned_by = '';
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $season = $systemSettings->season;
        }
        if ($systemSettings->season) {
            $seasonType = $systemSettings->season_type;
        }
        if ($systemSettings->season) {
            $week = $systemSettings->week;
        }
        if ($systemSettings->waiver_period_enabled) {
            $waiver_period_enabled = $systemSettings->waiver_period_enabled;
        }

        $previous_week = 0;
        if ($week > 1) {
            $previous_week = $week - 1;
        }

        if ($player_id != '') {
            $transactions = [];
            $selectTransQry = FantasyTeamsPlayerTransaction::where('fantasy_player_id', $player_id)
                ->where('league_id', $team->league_id)
                ->where('season', $season)
                ->where('season_type', $seasonType)
                ->where('week', $week)
                ->where(function ($query) {
                    $query->orWhere('active', 1)
                        ->orWhere('bench', 1);
                });
            if ($previous_week) {
                // $selectTransQry->where('week',$previous_week);
            }

            $transactionExists = $selectTransQry->first();

            if ($transactionExists) {

                //Add transaction
                if ($transactionExists->player_transaction_type_id == 1) {
                    $teamOwn = FantasyTeam::where('id', $transactionExists->fantasy_team_id)->first();
                    //If someone own's player
                    if ($transactionExists->bench == 1) {
                        $bench = 1;
                    }
                    if ($teamOwn) {
                        if ($seasonType != 3) {
                            $added = 1;
                            $owned_by = $teamOwn->name;
                        }

                        if ($seasonType == 3) {
                            //dd('here 1');
                            /****** Post Season Competition: Add Players Logic***********/

                            //if (($week==1 || $week==2 || $week==3 || $week==4) && ($seasonType == 3)) {
                            $teamIds = $playerIds = '';
                            $teamIdsArray = $playerIdsArray = $checkPlayersArray = [];

                            $addedPlayers = FantasyTeamsPlayerTransaction::select('fantasy_player_id')
                                ->where('active', 1)
                                ->where('league_id', $team->league_id)
                                ->where('fantasy_team_id', $team->id)
                                ->where('week', $week)
                                ->where('season', $season)
                                ->where('season_type', 3)
                                ->get();
                            if (! empty($addedPlayers)) {
                                foreach ($addedPlayers as $key => $val) {
                                    $playerIdsArray[] = $val->fantasy_player_id;
                                }
                                if (! empty($playerIdsArray)) {
                                    array_push($playerIdsArray, $player_id);
                                    $playerIdsArray = $playerIdsArray;
                                }
                            }
                            //dd($playerIdsArray);

                            // If the user currently has 8 transactions already, this is the attempted 9.
                            // Add the potential 9th player to the ID and do a check that it does not match
                            // We only do this on Weeks 1 -> 3. WE DO NOT DO ON WEEK 4 (SUPERBOWL SUNDAY)
                            if (count($playerIdsArray) == 9 && $week < 4) {
                                //$playerIdsArray[] = $player_id;
                                // dd($playerIdsArray);
                                $checkTeams = FantasyTeamsPlayerTransaction::select('fantasy_team_id')
                                    ->where('fantasy_player_id', $player_id)
                                    ->where('active', 1)
                                    ->where('league_id', $team->league_id)
                                    ->where('fantasy_team_id', '<>', $team->id)
                                    ->where('week', $week)
                                    ->where('season', $season)
                                    ->where('season_type', 3)
                                    ->get();
                                if (! empty($checkTeams)) {
                                    foreach ($checkTeams as $key => $val) {
                                        $teamIdsArray[] = $val->fantasy_team_id;
                                    }
                                    if (! empty($teamIdsArray)) {
                                        $teamIds = implode(',', $teamIdsArray);
                                    }
                                    //dd($teamIdsArray);
                                    if ($teamIds != '') {
                                        $checkPlayers = FantasyTeamsPlayerTransaction::select('fantasy_team_id', 'fantasy_player_id')
                                            ->where('active', 1)
                                            ->where('league_id', $team->league_id)
                                            ->whereIn('fantasy_team_id', $teamIdsArray)
                                            ->where('week', $week)
                                            ->where('season', $season)
                                            ->where('season_type', 3)
                                            ->get();
                                        //dd($checkPlayers);
                                        if (! empty($checkPlayers)) {
                                            foreach ($checkPlayers as $key => $val) {
                                                $checkPlayersArray[$val->fantasy_team_id][] = $val->fantasy_player_id;
                                            }
                                        }
                                    }
                                }

                                if (! empty($checkPlayersArray)) {
                                    //dd($checkPlayersArray);
                                    foreach ($checkPlayersArray as $key => $val) {
                                        if (count($val) == 9) {
                                            $identcal = Helper::identicalArrays($playerIdsArray, $val);
                                            //dd($identcal);
                                            if ($identcal) {
                                                $matches_team = 1;
                                                $added = 0;
                                                $remove = 0;
                                            }
                                        }
                                    }
                                }
                            }
                            //}

                            /****** Post Season Competition: Add Players***********/

                            // Look for the player again to see if the user owns them and show the remove option flag.
                            $postSeasonLookup = FantasyTeamsPlayerTransaction::where('fantasy_player_id', $player_id)
                                ->where('league_id', $team->league_id)
                                ->where('season', $season)
                                ->where('fantasy_team_id', $team->id)
                                ->where('season_type', $seasonType)
                                ->where('week', $week)
                                ->where(function ($query) {
                                    $query->orWhere('active', 1)
                                        ->orWhere('bench', 1);
                                })
                                ->first();

                            if ($postSeasonLookup) {
                                $teamOwn = FantasyTeam::where('id', $postSeasonLookup->fantasy_team_id)->first();
                            }
                        }

                        //If the owning team == the team id of logged in user then this user owns team
                        //dd($teamOwn->id, $team->id);
                        if ($teamOwn->id == $team->id) {
                            $remove = 1;
                        }
                    }
                }

                //Dropped transaction
                if ($transactionExists->player_transaction_type_id == 2) {
                    $dropped = 1;
                }

                //Traded Transaction
                if ($transactionExists->player_transaction_type_id == 3) {
                    $traded = 1;
                }

                //Watched Transaction
                if ($transactionExists->player_transaction_type_id == 4) {
                    $watched = 1;
                }

                if ($transactionExists->player_transaction_type_id == 5) {
                    if ($transactionExists->league_id == $team->league_id && $transactionExists->fantasy_team_id == $team->id) {
                        $claim_request = 1;
                        $claim_removed = 1;
                    }
                }
            }
        }

        //Check on the fantasy team's maxed player threshold for the position
        //dd($player_id);
        $thePlayer = FantasyPlayer::where('id', $player_id)->first()->toArray();

        $thePosition = $thePlayer['position'];
        $fantasyTeam = $this->_getUserFantasyTeamRoster($team->id);

        $positionCounts = $fantasyTeam['position'];
        $max_reached = isset($positionCounts[$thePosition]['maxReached']) ? $positionCounts[$thePosition]['maxReached'] : 0;

        $team_max_reached = 0;
        $flexMaxReached = 1;

        if ($seasonType == 3 && $thePlayer['position'] != 'ST') {
            // We only use Team Max Reached for weeks 1 -> 3 in the Playoffs. We DO NOT use it for week 4 (SuperBowl Sunday)
            if ($week < 4) {
                $team_max_reached = isset($fantasyTeam['currentTeamCounts'][$thePlayer['team']]) && $fantasyTeam['currentTeamCounts'][$thePlayer['team']] > 1 ? 1 : 0;
            } else {
                $team_max_reached = 0;
            }
        }

        if ($seasonType == 3 && in_array($thePlayer['position'], ['RB', 'WR', 'TE'])) {

            // Check if flex is used or not.
            if ($max_reached) {
                $flexMaxReached = isset($positionCounts['FLEX']['maxReached']) ? $positionCounts['FLEX']['maxReached'] : 0;
            }
        }

        //dd($team_max_reached);

        //        if ($selectTrans->count() > 0) {
        //            $playerArray	=	$selectTrans->toArray();
        //
        //
        //
        //            $countArray		=	array_column($playerArray, 'counts', 'position');
        //
        //            if ($thePosition == 'RB' && isset($countArray['RB']) && $countArray['RB'] >= 2) {
        //                $max_reached = 1;
        //            } elseif ($thePosition == 'WR' && isset($countArray['WR']) && $countArray['WR'] >= 2) {
        //                $max_reached = 1;
        //            } elseif ($thePosition == 'TE' && isset($countArray['TE']) && $countArray['TE'] >= 1) {
        //                $max_reached = 1;
        //            } elseif ($thePosition == 'K' && isset($countArray['K']) && $countArray['K'] >= 1) {
        //                $max_reached = 1;
        //            } elseif ($thePosition == 'TQB' && isset($countArray['TQB']) && $countArray['TQB'] >= 1) {
        //                $max_reached = 1;
        //            } elseif ($thePosition == 'DEF' && isset($countArray['DEF']) && $countArray['DEF'] >= 1) {
        //                $max_reached = 1;
        //            } elseif ($thePosition == 'ST' && isset($countArray['ST']) && $countArray['ST'] >= 1) {
        //                $max_reached = 1;
        //            }
        //        }

        $response['added'] = $added;
        $response['remove'] = $remove;
        $response['bench'] = $bench;
        $response['dropped'] = $dropped;
        $response['traded'] = $traded;
        $response['watched'] = $watched;
        $response['owned_by'] = $owned_by;
        //$response['max_reached']	=	$max_reached;

        // If the positoin max is reached otherwise use the team_max_reached (which is 0 during reg season)
        $response['max_reached'] = $max_reached; // ? $max_reached : $team_max_reached;

        $response['team_max_reached'] = $team_max_reached;
        //TODO: See if this not_allowed is needed?
        $response['matches_team'] = $matches_team;
        //END TODO
        $response['claim_request'] = $claim_request;
        $response['claim_removed'] = $claim_removed;
        $response['waiver_period_enabled'] = $waiver_period_enabled;

        //If max is reached or already added we can't allow the add.
        $response['allow_add'] = $added || $max_reached || $team_max_reached || $matches_team ? 0 : 1;

        $response['allow_flex_add'] = $remove || $flexMaxReached ? 0 : 1;

        $response['available'] = $added ? 0 : 1;

        return $response;
    }

    public function checkPlayerSeasonAvailable($player_id)
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $max_reached = 0;
        $not_allowed = 0;
        $added = $remove = $dropped = $traded = $watched = 0;

        $owned_by = '';

        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $season = $systemSettings->season;
        }
        if ($systemSettings->season) {
            $seasonType = $systemSettings->season_type;
        }
        if ($systemSettings->season) {
            $week = $systemSettings->week;
        }

        if ($player_id != '') {
            $transactions = [];
            //dd('have player id of '. $player_id .' and is team qb is '. $team_qb);
            $transactions = FantasyTeamsPlayerTransaction::where('fantasy_player_id', $player_id)
                ->where('league_id', $team->league_id)
                ->where('fantasy_team_id', $team->id)
                ->where('active', 1)
                ->where('season', $season)
                ->where('week', $week)
                ->get();

            /** Might not be needed anymore.. */
            if (! empty($transactions)) {
                foreach ($transactions as $tkey => $tval) {
                    if ($tval->player_transaction_type_id == 1) {
                        $teamOwn = FantasyTeam::where('id', $tval->fantasy_team_id)->first();
                        //Only marked owned_by if the def/st/tqb stuff match.
                        if ($teamOwn) {
                            $owned_by = $teamOwn->name;
                        }
                        //This player is owned by the fantasy
                        if ($tval->league_id == $team->league_id && $tval->fantasy_team_id == $team->id) {
                            $added = 1;
                            $remove = 1;
                        }
                        //Owned by another team. Mark added but this user cannot remove.
                        if ($tval->league_id == $team->league_id && $tval->fantasy_team_id != $team->id) {
                            $added = 1;
                            $remove = 0;
                        }
                    } elseif ($tval->player_transaction_type_id == 2) {
                        $dropped = 1;
                    } elseif ($tval->player_transaction_type_id == 3) {
                        $traded = 1;
                    } elseif ($tval->player_transaction_type_id == 4 && ($tval->league_id == $team->league_id) && ($tval->fantasy_team_id == $team->id)) {
                        $watched = 1;
                    }
                }
            }
            $selectTrans = FantasyTeamsPlayerTransaction::selectRaw('count(*) as counts,position')->where('player_transaction_type_id', 1)
                ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_player_transactions.fantasy_player_id')
                ->where('fantasy_teams_player_transactions.active', 1)
                ->where('fantasy_team_id', $team->id)
                ->where('league_id', $team->league_id)
                ->where('season', $season)
                ->where('week', $week)
                ->groupBy('position')
                ->get();
        }

        if (! empty($selectTrans)) {
            $playerArray = $selectTrans->toArray();
            $countArray = array_column($playerArray, 'counts', 'position');

            if (! empty($player_id)) {
                $player = FantasyPlayer::find($player_id);
                if (! empty($player)) {
                    if ($player->player_fantasy_position == 'TQB') {
                        if (isset($countArray['TQB']) && $countArray['TQB'] >= 1) {
                            $max_reached = 1;
                        }
                    } elseif ($player->player_fantasy_position == 'ST') {
                        if (isset($countArray['ST']) && $countArray['ST'] >= 1) {
                            $max_reached = 1;
                        }
                    } elseif ($player->player_fantasy_position == 'DEF') {
                        if (isset($countArray['DEF']) && $countArray['DEF'] >= 1) {
                            $max_reached = 1;
                        }
                    } elseif ($player->player_fantasy_position == 'RB') {
                        if (isset($countArray['RB']) && $countArray['RB'] >= 2) {
                            $max_reached = 1;
                        }
                    } elseif ($player->player_fantasy_position == 'WR') {
                        if (isset($countArray['WR']) && $countArray['WR'] >= 2) {
                            $max_reached = 1;
                        }
                    } elseif ($player->player_fantasy_position == 'TE') {
                        if (isset($countArray['TE']) && $countArray['TE'] >= 1) {
                            $max_reached = 1;
                        }
                    } elseif ($player->player_fantasy_position == 'K') {
                        if (isset($countArray['K']) && $countArray['K'] >= 1) {
                            $max_reached = 1;
                        }
                    }
                }
            }

            /****** Post Season Competition: Add Players Logic***********/

            if (($week == 1 || $week == 2 || $week == 3 || $week == 4) && ($seasonType == 3)) {
                $teamIds = $playerIds = '';
                $teamIdsArray = $playerIdsArray = $checkPlayersArray = [];

                $addedPlayers = FantasyTeamsPlayerTransaction::select('fantasy_player_id')
                    ->where('active', 1)
                    ->where('league_id', $team->league_id)
                    ->where('fantasy_team_id', $team->id)
                    ->where('week', $week)
                    ->where('season', $season)
                    ->where('season_type', 3)
                    ->get();
                if (! empty($addedPlayers)) {
                    foreach ($addedPlayers as $key => $val) {
                        $playerIdsArray[] = $val->fantasy_player_id;
                    }
                    if (! empty($playerIdsArray)) {
                        array_push($playerIdsArray, $player_id);
                        $playerIdsArray = $playerIdsArray;
                    }
                }
                if (count($playerIdsArray) == 9) {
                    $checkTeams = FantasyTeamsPlayerTransaction::select('fantasy_team_id')
                        ->where('fantasy_player_id', $player_id)
                        ->where('active', 1)
                        ->where('league_id', $team->league_id)
                        ->where('fantasy_team_id', '<>', $team->id)
                        ->where('week', $week)
                        ->where('season', $season)
                        ->where('season_type', 3)
                        ->get();
                    if (! empty($checkTeams)) {
                        foreach ($checkTeams as $key => $val) {
                            $teamIdsArray[] = $val->fantasy_team_id;
                        }
                        if (! empty($teamIdsArray)) {
                            $teamIds = implode(',', $teamIdsArray);
                        }
                        if ($teamIds != '') {
                            $checkPlayers = FantasyTeamsPlayerTransaction::select('fantasy_team_id', 'fantasy_player_id')
                                ->where('active', 1)
                                ->where('league_id', $team->league_id)
                                ->whereIn('fantasy_team_id', $teamIdsArray)
                                ->where('week', $week)
                                ->where('season', $season)
                                ->where('season_type', 3)
                                ->get();
                            if (! empty($checkPlayers)) {
                                foreach ($checkPlayers as $key => $val) {
                                    $checkPlayersArray[$val->fantasy_team_id][] = $val->fantasy_player_id;
                                }
                            }
                        }
                    }

                    if (! empty($checkPlayersArray)) {
                        foreach ($checkPlayersArray as $key => $val) {
                            if (count($val) == 9) {
                                $identcal = Helper::identicalArrays($playerIdsArray, $val);
                                if ($identcal) {
                                    $not_allowed = 1;
                                    $added = 0;
                                    $remove = 0;
                                }
                            }
                        }
                    }
                }
                if (! empty($transactions)) {
                    $player = FantasyPlayer::find($player_id);
                    $player_team = $player->team;
                    $selectTrans = FantasyTeamsPlayerTransaction::selectRaw('count(*) as counts,position')->where('player_transaction_type_id', 1)
                        ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_player_transactions.fantasy_player_id')
                        ->where('fantasy_teams_player_transactions.active', 1)
                        ->where('fantasy_team_id', $team->id)
                        ->where('league_id', $team->league_id)
                        ->where('season', $season)
                        ->where('week', $week)
                        ->where('season_type', 3)
                        ->where('active', 1)
                        ->groupBy('position')
                        ->get();

                    $selectPlayerTrans = FantasyTeamsPlayerTransaction::selectRaw('count(*) as counts,p.team')->where('player_transaction_type_id', 1)
                        ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_player_transactions.fantasy_player_id')
                        ->where('fantasy_teams_player_transactions.active', 1)
                        ->where('fantasy_team_id', $team->id)
                        ->where('league_id', $team->league_id)
                        ->where('season', $season)
                        ->where('week', $week)
                        ->where('season_type', 3)
                        ->where('p.team', $player_team)
                        ->where('active', 1)
                        ->groupBy('team')
                        ->get()->toArray();

                    $total_count = 0;
                    $total_counts = array_column($selectPlayerTrans, 'counts');

                    if ($total_counts) {
                        $total_count = $total_counts[0];
                    }

                    if (! empty($selectTrans)) {
                        $playerArray = $selectTrans->toArray();
                        $countArray = array_column($playerArray, 'counts', 'position');
                        $countArray[0] = count($playerArray);

                        $max_reached = 0;

                        //Check the player counts
                        if (! empty($player_id)) {
                            if (! empty($player)) {
                                if ($player->player_fantasy_position == 'TQB') {
                                    if (isset($countArray['TQB']) && $countArray['TQB'] >= 1 && $total_count <= 2) {
                                        $max_reached = 1;
                                        $added = 1;
                                    }
                                } elseif ($player->player_fantasy_position == 'DEF') {
                                    if (isset($countArray['DEF']) && $countArray['DEF'] >= 1 && $total_count <= 2) {
                                        $max_reached = 1;
                                        $added = 1;
                                    }
                                } elseif ($player->player_fantasy_position == 'ST') {
                                    if (isset($countArray['ST']) && $countArray['ST'] >= 1 && $total_count <= 2) {
                                        $max_reached = 1;
                                        $added = 1;
                                    }
                                } elseif ($player->player_fantasy_position == 'RB') {
                                    if (isset($countArray['RB']) && $countArray['RB'] >= 2 && $total_count <= 2) {
                                        $max_reached = 1;
                                        $added = 1;
                                    }
                                } elseif ($player->player_fantasy_position == 'WR') {
                                    if (isset($countArray['WR']) && $countArray['WR'] >= 2 && $total_count <= 2) {
                                        $max_reached = 1;
                                        $added = 1;
                                    }
                                } elseif ($player->player_fantasy_position == 'TE') {
                                    if (isset($countArray['TE']) && $countArray['TE'] >= 1 && $total_count <= 2) {
                                        $max_reached = 1;
                                        $added = 1;
                                    }
                                } elseif ($player->player_fantasy_position == 'K') {
                                    if (isset($countArray['K']) && $countArray['K'] >= 1 && $total_count <= 2) {
                                        $max_reached = 1;
                                        $added = 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            /****** Post Season Competition: Add Players***********/

            $response['added'] = $added;
            $response['remove'] = $remove;
            $response['dropped'] = $dropped;
            $response['traded'] = $traded;
            $response['watched'] = $watched;
            $response['owned_by'] = $owned_by;
            $response['max_reached'] = $max_reached;
            $response['not_allowed'] = $not_allowed;
            if ($added == 1) {
                $response['available'] = 'No';
            } else {
                $response['available'] = 'Yes';
            }

            return $response;
        }
    }

    public function conditionalRemovePlayer(Request $request)
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $settings = SystemSetting::find(1);
        $week = $settings->week;
        $seasonType = $settings->season_type;

        if ($request->player_id != '') {
            $transaction_query = FantasyTeamsPlayerTransaction::where('fantasy_player_id', $request->player_id)
                ->Where(function ($query) {
                    $query->orWhere('active', 1)
                        ->orWhere('bench', 1);
                });

            if ($seasonType == 3) {
                $transaction_query->where('week', $week);
            }

            $transaction = $transaction_query->where('player_transaction_type_id', 1)
                ->where('league_id', $team->league_id)
                ->where('fantasy_team_id', $team->id)
                ->first();

            if ($transaction) {
                $transaction->conditional_remove = $request->player_id;
                $transaction->save();
            }

            $message = 'Player has been removed successfully';
            $status = 1;
        } else {
            $status = 0;
            $message = 'Some error has been occured. Please try again.';
        }

        $returnArray['message'] = $message;
        $returnArray['status'] = $status;

        return response()->json($returnArray);
    }

    public function removePlayer(Request $request)
    {
        $status = 0;
        $message = 'Some error has been occured. Please try again.';

        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $leagueId = $team->league_id;
        $teamId = $team->id;

        if ($request->player_id != '') {

            /** get any position flags. */
            $positionFlag = null;

            // Call the helper method.
            $result = Helper::removePlayerFromFantasyTeam($request->player_id, $teamId, $leagueId, $positionFlag);

            if ($result) {
                //call the FillFantasyTeamsRoster console command
                //\Artisan::call('FillFantasyTeamsRoster');
                \Artisan::call('FillFantasyTeamsRoster', ['--league_id' => $leagueId]);
                $message = 'Player has been removed successfully';
                $status = 1;
            }
        }

        $returnArray['message'] = $message;
        $returnArray['status'] = $status;

        return response()->json($returnArray);
    }

    public function removeClaimPlayer(Request $request)
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $settings = SystemSetting::find(1);
        $week = $settings->week;
        $seasonType = $settings->season_type;

        if ($request->player_id != '') {
            $transaction_query = FantasyTeamsPlayerTransaction::where('fantasy_player_id', $request->player_id)
                ->where('player_transaction_type_id', 5)
                ->Where(function ($query) {
                    $query->orWhere('active', 1)
                        ->orWhere('bench', 1);
                });

            if ($seasonType == 3) {
                $transaction_query->where('week', $week);
            }

            $transaction = $transaction_query->where('player_transaction_type_id', 5)
                ->where('league_id', $team->league_id)
                ->where('fantasy_team_id', $team->id)
                ->first();

            if ($transaction) {
                $transaction->active = 0;
                $transaction->save();
            }
            //call the FillFantasyTeamsRoster console command
            //  \Artisan::call('FillFantasyTeamsRoster');
            \Artisan::call('FillFantasyTeamsRoster', ['--league_id' => $team->league_id]);

            $message = 'Player has been removed successfully';
            $status = 1;
        } else {
            $status = 0;
            $message = 'Some error has been occured. Please try again.';
        }

        $returnArray['message'] = $message;
        $returnArray['status'] = $status;

        return response()->json($returnArray);
    }

    public function addPlayerOnTimeout(Request $request)
    {
        $qb_reached = $rb_reached = $wr_reached = $te_reached = $k_reached = $def_reached = $st_reached = $tqb_reached = $is_def = $is_st = $team_qb = $success = 0;
        $team_id = $request->team_id;
        $rounds = $request->rounds;
        $current_draft = DraftOrder::where('fantasy_player_id', null)
            ->where('deadline', '<>', null)
            ->where('fantasy_team_id', '=', $team_id)
            ->where('round', '=', $rounds)
            ->first();
        if (! empty($current_draft)) {
            $current_draft->deadline = null;
            $current_draft->save();
            $team = FantasyTeam::where('id', $team_id)->first();
            $leagueDetails = League::find($team->league_id);
            $settings = SystemSetting::find(1);
            if (! empty($leagueDetails)) {
                $override_system = $leagueDetails->override_system;
                if ($override_system) {
                    $week = $leagueDetails->week;
                    $season = $leagueDetails->season;
                    $seasonType = $leagueDetails->season_type;
                } else {
                    $week = $settings->week;
                    $season = $settings->season;
                    $seasonType = $settings->season_type;
                }
            }

            $draft_date = Carbon::parse($leagueDetails->draft_date)->timezone($leagueDetails->timezone);
            $selectTrans = FantasyTeamsPlayerTransaction::selectRaw('count(*) as counts,position')->where('player_transaction_type_id', 1)
                ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_player_transactions.fantasy_player_id')
                ->where('fantasy_teams_player_transactions.active', 1)
                ->where('fantasy_team_id', $team_id)
                ->groupBy('position')
                ->get();
            $selectDef = FantasyTeamsPlayerTransaction::where('player_transaction_type_id', 1)
                ->where('fantasy_teams_player_transactions.active', 1)
                ->where('fantasy_team_id', $team_id)
                ->where('is_def', 1)
                ->first();
            $selectSt = FantasyTeamsPlayerTransaction::where('player_transaction_type_id', 1)
                ->where('fantasy_teams_player_transactions.active', 1)
                ->where('fantasy_team_id', $team_id)
                ->where('is_st', 1)
                ->first();
            $selectTQB = FantasyTeamsPlayerTransaction::where('player_transaction_type_id', 1)
                ->where('fantasy_teams_player_transactions.active', 1)
                ->where('fantasy_team_id', $team_id)
                ->where('team_qb', 1)
                ->first();

            if (! empty($selectTrans)) {
                $playerArray = $selectTrans->toArray();
                $countArray = array_column($playerArray, 'counts', 'position');
                if (isset($countArray['QB']) && $countArray['QB'] >= 1) {
                    $qb_reached = 1;
                }
                if (isset($countArray['RB']) && $countArray['RB'] >= 2) {
                    $rb_reached = 1;
                }
                if (isset($countArray['WR']) && $countArray['WR'] >= 2) {
                    $wr_reached = 1;
                }
                if (isset($countArray['TE']) && $countArray['TE'] >= 1) {
                    $te_reached = 1;
                }
                if (isset($countArray['K']) && $countArray['K'] >= 1) {
                    $k_reached = 1;
                }
                if (! empty($selectDef)) {
                    $def_reached = 1;
                }
                if (! empty($selectSt)) {
                    $st_reached = 1;
                }
                if (! empty($selectTQB)) {
                    $tqb_reached = 1;
                }
            }

            $alreadyAddedIds = FantasyTeamsPlayerTransaction::select('fantasy_player_id')->where('league_id', $team->league_id)
                ->where('active', 1)
                ->where('player_transaction_type_id', 1)
                ->get();
            $addedIds = [];
            if (! empty($alreadyAddedIds)) {
                foreach ($alreadyAddedIds as $key => $val) {
                    $addedIds[] = $val->fantasy_player_id;
                }
                if (! empty($addedIds)) {
                    $ids = implode(',', $addedIds);
                }
            }

            $player = FantasyPlayer::select('position', 'id')->whereIn('position', ['RB', 'QB', 'WR', 'TE', 'K', 'DEF'])
                ->whereNotIn('id', $addedIds)
                ->orderBy('average_draft_position')
                ->get();

            $player_id = null;

            if (! empty($player)) {
                foreach ($player as $pkey => $pval) {
                    if ($pval->position == 'RB' && $rb_reached == 0) {
                        $player_id = $pval->id;
                        break;
                    }
                    if ($pval->position == 'QB' && $qb_reached == 0) {
                        $player_id = $pval->id;
                        break;
                    }
                    if ($pval->position == 'WR' && $wr_reached == 0) {
                        $player_id = $pval->id;
                        break;
                    }
                    if ($pval->position == 'TE' && $te_reached == 0) {
                        $player_id = $pval->id;
                        break;
                    }
                    if ($pval->position == 'K' && $k_reached == 0) {
                        $player_id = $pval->id;
                        break;
                    }
                    if ($pval->position == 'DEF' && $def_reached == 0) {
                        $player_id = $pval->id;
                        $is_def = 1;
                        break;
                    }
                    if ($pval->position == 'DEF' && $st_reached == 0) {
                        $player_id = $pval->id;
                        $is_st = 1;
                        break;
                    }
                    if ($pval->position == 'DEF' && $tqb_reached == 0) {
                        $player_id = $pval->id;
                        $team_qb = 1;
                        break;
                    }
                }
            }
            if ($player_id != null) {
                FantasyTeamsPlayerTransaction::create([
                    'league_id' => $team->league_id,
                    'fantasy_player_id' => $player_id,
                    'fantasy_team_id' => $team->id,
                    'player_transaction_type_id' => 1,
                    'active' => 1,
                    'week' => $week,
                    'season' => $season,
                    'season_type' => $seasonType,
                ]);

                if (! empty($current_draft)) {
                    $current_draft->fantasy_player_id = $player_id;
                    $current_draft->deadline = null;
                    $current_draft->save();
                }

                $date = Carbon::parse('now')->timezone($leagueDetails->timezone);
                $f_date = $date->addSeconds(30)->format('Y-m-d H:i:s');

                $next_draft = DraftOrder::where('league_id', $team->league_id)
                    ->where('fantasy_player_id', null)
                    ->where('deadline', '=', null)
                    ->first();
                if (! empty($next_draft)) {
                    $next_draft->deadline = $f_date;
                    $next_draft->save();
                } else {
                    $leagueDetails->draft_completed = 1;
                    $leagueDetails->save();
                }
                $success = $team->id;
            }

            \Artisan::call('FillFantasyTeamsRoster', ['--league_id' => $team->league_id]);
        }
        //call the FillFantasyTeamsRoster console command
        //\Artisan::call('FillFantasyTeamsRoster');

        return response()->json($success);
    }

    public function addBenchPlayer(Request $request)
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $leagueDetails = League::find($team->league_id);
        $settings = SystemSetting::find(1);
        $already_added = 0;
        if (! empty($leagueDetails)) {
            $override_system = $leagueDetails->override_system;
            if ($override_system) {
                $week = $leagueDetails->week;
                $season = $leagueDetails->season;
                $seasonType = $leagueDetails->season_type;
            } else {
                $week = $settings->week;
                $season = $settings->season;
                $seasonType = $settings->season_type;
            }
        }

        if ($request->player_id != '') {
            $player_id = $request->player_id;
            $transaction = FantasyTeamsPlayerTransaction::where('fantasy_player_id', $request->player_id)->where('active', 0)->where('bench', 1)->where('league_id', $team->league_id)->first();
            if (empty($transaction)) {
                FantasyTeamsPlayerTransaction::create([
                    'league_id' => $team->league_id,
                    'fantasy_player_id' => $request->player_id,
                    'fantasy_team_id' => $team->id,
                    'player_transaction_type_id' => 1,
                    'active' => 0,
                    'bench' => 1,
                    'week' => $week,
                    'season' => $season,
                    'season_type' => $seasonType,
                ]);

                //call the FillFantasyTeamsRoster console command
                \Artisan::call('FillFantasyTeamsRoster', ['--league_id' => $team->league_id]);

                $message = 'Player has been added successfully';
            } else {
                $message = 'Player has been already in bench';
                $already_added == 1;
            }
        } else {
            $message = 'Some error has been occured. Please try again.';
        }

        $returnArray['message'] = $message;
        $returnArray['already_added'] = $already_added;
        $returnArray['owned_by'] = $team->name;

        return response()->json($returnArray);
    }

    public function getFantasyPlayerNews()
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $transaction_players = FantasyTeamsPlayerTransaction::where('fantasy_team_id', $team->id)->pluck('fantasy_player_id');
        $fantasy_player = FantasyPlayer::whereIn('id', $transaction_players)->with(['fantasyPlayerNews'])->get();

        return response()->json($fantasy_player);
    }

    public function getAllFantasyPlayers()
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $leagueDetails = League::find($team->league_id);
        $systemSettings = SystemSetting::first();

        $fantasy_player_transaction = FantasyTeamsPlayerTransaction::where('league_id', $leagueDetails->id)
            ->where('week', $systemSettings->week)
            ->where('season', $systemSettings->season)
            ->where('season_type', $systemSettings->season_type)
            ->where('active', 1)->orderBy('week', 'desc')->get()->pluck('fantasy_player_id');
        $fantasy_player = FantasyPlayer::select('id', 'team', 'position', 'name', 'average_draft_position')->whereNotIn('id', $fantasy_player_transaction)->orderBy('average_draft_position')->get();
        $collection = collect($fantasy_player);
        $grouped = $collection->groupBy('position');
        //keyed = $collection->keyBy('product_id');

        return response()->json($grouped);
    }
}
