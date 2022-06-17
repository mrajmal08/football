<?php

namespace App\Http\Controllers;

use App\Helpers\FantasyPointsHelper;
use App\Http\Controllers\Controller;
use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyData\PlayerGame;
use App\Models\FantasyData\Schedule;
use App\Models\FantasyData\Score;
use App\Models\FantasyData\ScoringDetail;
use App\Models\FantasyData\Team;
use App\Models\FantasyData\Timeframe;
use App\Models\FantasyTeam;
use App\Models\FantasyTeamsPlayerTransaction;
use App\Models\FantasyTeamsRoster;
use App\Models\League;
use App\Models\LeagueCommissioner;
use App\Models\LeagueGame;
use App\Models\LeagueSchedule;
use App\Models\SystemSetting;
use App\Models\User;
use Auth;
use DB;
use Helper;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Show the Scores.
     *
     * @return Response
     */
    public function showScores()
    {
        return view('scores.index');
    }

    /**
     * Show the Score Leaue Games.
     *
     * @return Response
     */
    public function showScoreLeaueGames()
    {
        return view('scores.league-games');
    }

    /**
     * Show the Score Leaue Playoffs.
     *
     * @return Response
     */
    public function showScoreLeauePlayoffs(Request $request)
    {
        $week = 1;
        if (isset($request->week)) {
            $week = $request->week;
        }

        return view('scores.league-playoffs', compact('week'));
    }

    /**
     * Show the Score Leaue Playoffs.
     *
     * @return Response
     */
    public function getScoreLeauePlayoffs(Request $request)
    {
        $week = 1;
        $settings = SystemSetting::find(1);
        $week = $settings->week;

        return redirect()->route('league.playoffs', ['week' => $week]);
    }

    /**
     * Show the Score NflGames.
     *
     * @return Response
     */
    public function showScoreNflGames()
    {
        return view('scores.nflgame');
    }

    /**
     * get the fantasy game parameters.
     *
     * @return Response
     */
    public function getFantasyGames(Request $request)
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();
        $settings = SystemSetting::find(1);

        $seasonTypeArray = Helper::getSystemSettingsDetails();

        if (isset($request->week)) {
            $week = $request->week;
        } else {
            $week = $settings->week;
        }

        // if (isset($request->season)) {
        //     $season	=	$request->season;
        // } else {
        //     $season	=	$settings->season_type;
        // }

        $season = $settings->season;

        //Hard code for now
        $season_type = 'REG';

        // $seasonType = $seasonTypeArray['seasonType'];

        return redirect()->route('scores.fantasy-games', ['week' => $week, 'season' => $season, 'season_type' => $season_type]);
    }

    /**
     * Show the Fantasy Game.
     *
     * @return Response
     */
    public function showFantasyGames(Request $request)
    {
        $game = '';
        $week = 1;
        $season = 2019;
        $settings = SystemSetting::find(1);
        $seasonTypeArray = Helper::getSystemSettingsDetails();
        $league_setting_week = $settings->week;
        if (isset($request->week)) {
            $week = $request->week;
        }
        if (isset($request->season)) {
            $season = (int) $request->season;
        }
        if (isset($request->game)) {
            $game = $request->game;
        }
        if (isset($request->season_type)) {
            $season_type = $request->season_type;
        }
        //If the league is in the post season, update to allow user to see all 17 games from the regular season
        if ($seasonTypeArray['seasonTypeInt'] == 3) {
            $league_setting_week = 17;
        }

        return view('scores.live-game-scoreboard', compact('week', 'season', 'game', 'season_type', 'league_setting_week'));
    }

    /**
     * Show the live game scoreboard.
     *
     * @return Response
     */
    public function getLiveTeamScoreboard(Request $request)
    {
        $userId = Auth::user()->id;
        $teamOne = FantasyTeam::where('user_id', $userId)->first();

        $league = League::where('id', $teamOne->league_id)->first();

        $teamOneManager = User::where('id', $userId)->first();

        $teamOneId = $teamOne->id;

        // $week 		= '1';
        // $seasonType	= 'POST';

        $settings = SystemSetting::find(1);

        if (isset($request->week)) {
            $week = $request->week;
        }
        if (isset($request->season_type)) {
            $seasonType = $request->season_type;
        }

        $year = $settings->season;
        $seasonTypeArray = Helper::$seasonTypes;
        $revArray = array_flip($seasonTypeArray);
        $seasonType = $revArray[$seasonType];

        $seasonTypeArray = Helper::$seasonTypes;
        $awayTeam = LeagueSchedule::where(function ($query) use ($teamOneId) {
            $query->where('home_team_id', $teamOneId)
                                    ->orWhere('away_team_id', $teamOneId);
        })
                                ->where('week', $week)
                                ->where('year', $year)
                                ->where('game_type_id', $seasonType)
                                ->first();

        if (isset($request->game) && ! empty($request->game)) {
            $league_schedule_id = $request->game;
            $awayTeam = LeagueSchedule::find($league_schedule_id);
            $teamOneId = $awayTeam->home_team_id;
            $teamOne = FantasyTeam::find($teamOneId);

            $teamOneManager = User::where('id', $teamOne->user_id)->first();
        }
        $response = [];
        if (! empty($awayTeam)) {
            if ($awayTeam->home_team_id != $teamOneId) {
                $teamTwoId = $awayTeam->home_team_id;
            } else {
                $teamTwoId = $awayTeam->away_team_id;
            }

            $teamTwo = FantasyTeam::where('id', $teamTwoId)->first();
            $teamTwoManager = User::where('id', '=', $teamTwo->user_id)->first();
            $teamOneScore = $teamTwoScore = 0;

            $teamOneGame = LeagueGame::where('week', $week)
                                ->where('team_id', $teamOneId)
                                ->where('year', $year)
                                ->where('game_type_id', $seasonType)
                                ->first();
            if ($teamOneGame) {
                $teamOneScore = $teamOneGame->team_score;
            }

            $teamTwoGame = LeagueGame::where('week', $week)
                                ->where('team_id', $teamTwoId)
                                ->where('year', $year)
                                ->where('game_type_id', $seasonType)
                                ->first();
            if ($teamTwoGame) {
                $teamTwoScore = $teamTwoGame->team_score;
            }
            $ressult_teamone = Helper::getTeamByRankByWeek($teamOneId, $week);
            $ressult_teamtwo = Helper::getTeamByRankByWeek($teamTwoId, $week);

            /** TODO: Update the "0" values below to use the real data like the team record. */
            $response['teamOneId'] = $teamOne->id;
            $response['teamOneName'] = $teamOne->name;
            $response['teamOneLogo'] = $teamOne->logo_url;
            $response['teamOneManager'] = $teamOneManager->name;
            $response['teamOneRecord'] = $ressult_teamone['total_win'].'-'.$ressult_teamone['total_loss'].'-'.$ressult_teamone['total_tie'];
            $response['teamOneCurrentScore'] = number_format($teamOneScore, 2);
            $response['teamOnePredictedScore'] = '27.54';
            $response['teamOneP'] = '0';
            $response['teamOneYTP'] = '0';
            $response['teamOnePMR'] = '0';
            $response['teamTwoId'] = $teamTwo->id;
            $response['teamTwoName'] = $teamTwo->name;
            $response['teamTwoLogo'] = $teamTwo->logo_url;
            $response['teamTwoManager'] = $teamTwoManager->name;
            $response['teamTwoRecord'] = $ressult_teamtwo['total_win'].'-'.$ressult_teamtwo['total_loss'].'-'.$ressult_teamtwo['total_tie'];
            $response['teamTwoCurrentScore'] = number_format($teamTwoScore, 2);
            $response['teamTwoPredictedScore'] = '27.84';
            $response['teamTwoP'] = '0';
            $response['teamTwoYTP'] = '0';
            $response['teamTwoPMR'] = '0';
        }

        return response()->json($response);
    }

    private function getPlayerScores($game_key, $player_id, $position)
    {
        $score = 0;
        $score_details = PlayerGame::where('game_key', '=', $game_key)
                            ->where('position', '=', $position)
                            ->where('player_id', '=', $player_id)
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

    private function getScores($game_key, $player_id, $scoring_type)
    {
        return FantasyPointsHelper::getScores($game_key, $player_id, $scoring_type);
        // $score			=	0;
        // $score_details	= 	ScoringDetail::where('game_key','=',$game_key)
        // 					->where('player_id','=',$player_id)
        // 					->where('scoring_type','LIKE',$scoring_type)
        // 					->get();
        // if(!empty($score_details)){
        // 	foreach($score_details as $list){
        // 		$length	=	$list->length;
        // 		if($scoring_type == 'PassingTouchdown'){
        // 			$score	+=	(0.3 + (0.02 * $length));
        // 		}
        // 		if($scoring_type == 'RushingTouchdown'){
        // 			$score	+=	(0.6 + (0.02 * $length));
        // 		}
        // 		if($scoring_type == 'ReceivingTouchdown'){
        // 			$score	+=	(0.6 + (0.02 * $length));
        // 		}
        // 		if($scoring_type == 'FieldGoalMade'){
        // 			$score	+=	(0.5 + (0.02 * $length));
        // 		}
        // 		if($scoring_type == 'InterceptionReturnTouchdown'){
        // 			$score	+=	(0.5 + (0.02 * $length));
        // 		}
        // 		if($scoring_type == 'FumbleReturnTouchdown'){
        // 			$score	+=	(0.5 + (0.02 * $length));
        // 		}
        // 		if($scoring_type == 'KickoffReturnTouchdown'){
        // 			$score	+=	(0.5 + (0.02 * $length));
        // 		}
        // 		if($scoring_type == 'PuntReturnTouchdown'){
        // 			$score	+=	(0.5 + (0.02 * $length));
        // 		}
        // 		if($scoring_type == 'BlockedFieldGoalReturnTouchdown'){
        // 			$score	+=	(0.5 + (0.02 * $length));
        // 		}
        // 		if($scoring_type == 'BlockedPuntReturnTouchdown'){
        // 			$score	+=	(0.5 + (0.02 * $length));
        // 		}
        // 		if($scoring_type == 'FieldGoalReturnTouchdown'){
        // 			$score	+=	(0.5 + (0.02 * $length));
        // 		}
        // 	}
        // }
        // return $score;
    }
    //TODO: Not used? Do we need to keep it?
    // public function getLivePlayerDetails2(Request $request)
    // {
    //     $season		= $week = $seasonType = '';
    //     $offenseTeams	=	$kickerTeams	=	$qbTeams	= $diffTeams	=	$specialTeams = array();

    //     if (isset($request->projection) && $request->projection =='1') {
    //         return $this->getProjectionDetails($request);
    //     }
    //     if (isset($request->team_id) && $request->team_id !='') {
    //         $teamId	=	$request->team_id;
    //     }

    //     if (isset($request->team_id2) && $request->team_id2 !='') {
    //         $teamId2	=	$request->team_id2;
    //     }

    //     $userId	=	Auth::user()->id;
    //     $team	=	FantasyTeam::where('user_id', $userId)->first();
    //     if (empty($request->team_id) && empty($request->team_id2)) {
    //         $teamId	= 	$team->id;
    //     }
    //     $league		= 	League::find($team->league_id);
    //     $settings	= 	SystemSetting::find(1);

    //     if (!empty($league)) {
    //         $override_system	=	$league->override_system;
    //         if (isset($request->week)) {
    //             $week	=	$request->week;
    //         } elseif ($override_system) {
    //             $week	=	$league->week;
    //         } else {
    //             $week	=	$settings->week;
    //         }

    //         if (isset($request->season_type)) {
    //             $seasonType			=	$request->season_type;
    //             $seasonTypeArray	=	Helper::$seasonTypes;
    //             $revArray			=	array_flip($seasonTypeArray);
    //             $seasonType			=	$revArray[$seasonType];
    //         } elseif ($override_system) {
    //             $seasonType	=	$league->season_type;
    //         } else {
    //             $seasonType	=	$settings->season_type;
    //         }

    //         if (isset($request->season)) {
    //             // $season			=	$request->season;
    //             $season	=	$settings->season;
    //         } elseif ($override_system) {
    //             $season	=	$league->season;
    //         } else {
    //             $season	=	$settings->season;
    //         }
    //     }
    //     $offenseArray	=	array("TQB", "RB", "WR", "TE");

    //     //Get the whole FantasyTeam object and return it.

    //     $team_one=Helper::getFantasyTeamDataByWeekEloquent($season, $seasonType, $week, $teamId);
    //     $team_two=Helper::getFantasyTeamDataByWeekEloquent($season, $seasonType, $week, $teamId2);

    //     $merge_offenseTeams = array_merge($team_one['offenseTeams'], $team_two['offenseTeams']);
    //     $merge_kickerTeams = array_merge($team_one['kickerTeams'], $team_two['kickerTeams']);
    //     $merge_diffTeams = array_merge($team_one['diffTeams'], $team_two['diffTeams']);
    //     $merge_specialTeams= array_merge($team_one['specialTeams'], $team_two['specialTeams']);

    //     $collection = collect($merge_offenseTeams);
    //     $merged_kickerTeams = $collection->merge($merge_kickerTeams);
    //     $merged_diffTeams = $merged_kickerTeams->merge($merge_diffTeams);
    //     $merged = $merged_diffTeams->merge($merge_specialTeams);

    //     $offenseTeams = $merged->whereIn('position', array('TQB',"RB", "QB", "WR", "TE"));
    //     $kickerTeams = $merged->whereIn('position', array('K'));
    //     $diffTeams = $merged->whereIn('position', array('DEF'));
    //     $specialTeams = $merged->whereIn('position', array('ST'));

    //     $response['offenseTeams']		=	Helper::sortTeamArray(array_values($offenseTeams->toArray()));
    //     $response['kickerTeams']		=	array_values($kickerTeams->toArray());
    //     $response['diffTeams']			=	array_values($diffTeams->toArray());
    //     $response['specialTeams']		=	array_values($specialTeams->toArray());

    //     return response()->json($response);
    // }

    // public function getStatistics(Request $request){
    // 					  $statistics = '';

    //  	$season		= $week = $seasonType = '';
    // 	$offenseTeams	=	$kickerTeams	=	$qbTeams	= $diffTeams	=	$specialTeams = array();

    // 	if(isset($request->projection) && $request->projection =='1'){
    // 		return $this->getProjectionDetails($request);
    // 	}
    // 	if(isset($request->team_id) && $request->team_id !='')
    // 	 $teamId	=	$request->team_id;

    // 	if(isset($request->team_id2) && $request->team_id2 !='')
    // 	 $teamId2	=	$request->team_id2;

    // 	$userId	=	Auth::user()->id;
    // 	$team	=	FantasyTeam::where('user_id',$userId)->first();
    // 	if(empty($request->team_id) && empty($request->team_id2) ){
    // 		$teamId	= 	$team->id;
    // 	}
    // 	$league		= 	League::find($team->league_id);
    // 	$settings	= 	SystemSetting::find(1);

    // 	if(!empty($league)){
    // 		$override_system	=	$league->override_system;
    // 		if(isset($request->week))
    // 			$week	=	$request->week;
    // 		else if($override_system)
    // 			$week	=	$league->week;
    // 		else
    // 			$week	=	$settings->week;

    // 		if(isset($request->season_type)){
    // 			$seasonType			=	$request->season_type;
    // 			$seasonTypeArray	=	Helper::$seasonTypes;
    // 			$revArray			=	array_flip($seasonTypeArray);
    // 			$seasonType			=	$revArray[$seasonType];
    // 		}
    // 		else if($override_system)
    // 			$seasonType	=	$league->season_type;
    // 		else
    // 			$seasonType	=	$settings->season_type;

    //            if(isset($request->season)){
    //               // $season			=	$request->season;
    // 		   $season	=	$settings->season;
    //            }
    //            else if($override_system)
    //                $season	=	$league->season;
    //            else
    //                $season	=	$settings->season;
    // 	}
    // 	$allow_team_qb	=	$league->allow_team_qb;

    // 	if($allow_team_qb)
    // 	$offenseArray	=	array("TQB", "RB", "WR", "TE");
    // 	else
    // 	$offenseArray	=	array("RB", "QB", "WR", "TE");

    // 	$fantasy_roster_data = Helper::getFantasyTeamDataByWeekEloquent($season,$seasonType,$week,$teamId);

    // 	foreach($fantasy_roster_data as $teamlist){

    // 		 if(!empty($teamlist->FantasyTeamRoster)){

    // 		  foreach($teamlist->FantasyTeamRoster as $list ){
    // 			  $statistics = '';

    // 			  if(!empty($fantasy_player->playerGame)&&(isset($fantasy_player->playerGame[0]))){

    // 		$player_game	 = $fantasy_player->playerGame[0];

    // 		$game_key						 = $player_game->game_key;
    // 		$passing_yards					 = $player_game->passing_yards;
    // 		$rushing_yards					 = $player_game->rushing_yards;
    // 		$receiving_yards				 = $player_game->receiving_yards;
    // 		$passing_interceptions			 = $player_game->passing_interceptions;
    // 		$fumbles_lost					 = $player_game->fumbles_lost;
    // 		$two_point_conversion_passes	 = $player_game->two_point_conversion_passes;
    // 		$two_point_conversion_runs		 = $player_game->two_point_conversion_runs;
    // 		$two_point_conversion_receptions = $player_game->two_point_conversion_receptions;
    // 		$passing_touchdowns 							= $player_game->passing_touchdowns;
    // 		$fg1 							= $player_game->field_goals_made0to19;
    // 		$fg2 							= $player_game->field_goals_made20to29;
    // 		$fg3 							= $player_game->field_goals_made30to39;
    // 		$fg4 							= $player_game->field_goals_made40to49;
    // 		$fg5 							= $player_game->field_goals_made50_plus;
    // 		$extra_points_made 				= $player_game->extra_points_made;
    // 		$extra_points_attempted 		= $player_game->extra_points_attempted;
    // 		$offense_points_acme =0;
    // 		 $fantasy_player->id;

    // 			  }

    // 			  $statistics .= $passing_yards.' PaYd, ';

    // 		  }
    // 	   }
    // 	 }
    // 	return response()->json($team_one);

    // }

    public function getLivePlayerDetails(Request $request)
    {
        $season = $week = $seasonType = '';
        $offenseTeams = $kickerTeams = $qbTeams = $diffTeams = $specialTeams = [];
        $isProjection = false;
        if (isset($request->projection) && $request->projection == '1') {
            $isProjection = true;
        }
        if (isset($request->team_id) && $request->team_id != '') {
            $teamId = $request->team_id;
        }

        if (isset($request->team_id2) && $request->team_id2 != '') {
            $teamId2 = $request->team_id2;
        }

        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        if (empty($request->team_id) && empty($request->team_id2)) {
            $teamId = $team->id;
        }
        $league = League::find($team->league_id);
        $settings = SystemSetting::find(1);

        if (! empty($league)) {
            if (isset($request->week)) {
                $week = $request->week;
            } else {
                $week = $settings->week;
            }

            if (isset($request->season_type)) {
                $seasonType = $request->season_type;
                $seasonTypeArray = Helper::$seasonTypes;
                $revArray = array_flip($seasonTypeArray);
                $seasonType = $revArray[$seasonType];
            } else {
                $seasonType = $settings->season_type;
            }

            //TODO: Update logic
            // $request->season is actually the season_type
            // if (isset($request->season)) {
            //     $seasonType	=	$request->season;
            // }
            // The season "year"
            $season = $settings->season;
        }

        $offenseArray = ['TQB', 'RB', 'WR', 'TE'];

        /* echo "=======season=======".$season."</br>";
        echo "========seasonType======".$seasonType."</br>";
        echo "========week======".$week."</br>";die; */
        $team_one = Helper::getFantasyTeamDataByWeekEloquent($season, $seasonType, $week, $teamId, $simple = false);
        $teamOneScore = $this->getFantasyScore($team_one);

        //return $team_one;

        if (isset($request->team_id2) && $request->team_id2 != '') {
            $team_two = Helper::getFantasyTeamDataByWeekEloquent($season, $seasonType, $week, $teamId2, $simple = false);
            $fantasy_roster_data = [$team_one, $team_two];
            $response = $this->getFantasyTeamRosterByPositions($fantasy_roster_data, $is_projection = $isProjection);
        } else {
            //$response = array($team_one);
            $response = $this->getFantasyTeamRosterByPositions([$team_one], $is_projection = $isProjection);
        }

        return response()->json($response);
    }

    private function getFantasyScore($fantasy_roster_data)
    {
        $fantasy_score = 0;
        $fantasyTeams = [];

        if (! empty($fantasy_roster_data->FantasyTeamRoster)) {
            foreach ($fantasy_roster_data->FantasyTeamRoster as $list) {
                $point = [];
                $playerPoints = 0;

                if ($list->fantasyPlayer->playerGame) {
                    $point = $list->fantasyPlayer->playerGame;
                    $playerPoints = isset($point[0]) ? $point[0]->fantasy_points_acme : 0.00;
                    $fantasyTeams['fantasy_point'][] = $playerPoints;
                }

                //Handle Defense
                if ($list->fantasyPlayer->fantasyDefenseGame) {
                    $point = $list->fantasyPlayer->fantasyDefenseGame;
                    $playerPoints = isset($point[0]) ? $point[0]->fantasy_points_acme : 0.00;
                    $fantasyTeams['fantasy_point'][] = $playerPoints;
                }

                //echo $list->fantasyPlayer->name ." | Pts: ".$playerPoints."\r\n";
            }
        }

        if (! empty($fantasyTeams)) {
            $fantasy_score = collect($fantasyTeams['fantasy_point'])->values()->sum();
        }

        return $fantasy_score;
    }

    public function getAverageDetails(Request $request)
    {
        $season = $week = $seasonType = '';
        $isProjection = false;

        if (isset($request->player_id)) {
            $player_id = $request->player_id;
        }
        $projection = false;
        if (isset($request->projection)) {
            if ($request->projection == 'true') {
                $projection = true;
            }
        }
        $userId = Auth::user()->id;
        $fantasy_points_acme = '';
        $fantasy_player = FantasyPlayer::where('id', $player_id)->with(['playerSeason'])->with(['playerSeasonProjection'])->with(['fantasyDefenseSeason'])->first();

        if ($projection) {
            if (! empty($fantasy_player->playerSeasonProjection)) {
                $collection = collect($fantasy_player->playerSeasonProjection);
            } else {
                $collection = collect($fantasy_player->fantasyDefenseGameProjection);
            }
        } else {
            if (! empty($fantasy_player->PlayerSeason)) {
                $collection = collect($fantasy_player->PlayerSeason);
            } else {
                $collection = collect($fantasy_player->fantasyDefenseSeason);
            }
        }

        $total_count = $collection->count();
        if ($total_count > 1) {
            $sum = $collection->sum('fantasy_points_acme');
            $fantasy_points_acme = $sum / $total_count;
        }

        return response()->json($fantasy_points_acme);
    }

    private function getFantasyTeamRosterByPositions($fantasy_roster_data, $isProjection)
    {
        //dd($fantasy_roster_data);

        //return $fantasy_roster_data;
        $fantasyTeams = [];
        $response = [];

        foreach ($fantasy_roster_data as $teamlist) {
            if (! empty($teamlist->FantasyTeamRoster)) {
                foreach ($teamlist->FantasyTeamRoster as $list) {
                    if ($list->fantasyPlayer->position == 'ST') {
                        $fantasy_team_positions = 'specialTeams';
                        $team_poistions = 'ST';
                    } elseif ($list->fantasyPlayer->position == 'DEF') {
                        $fantasy_team_positions = 'diffTeams';
                        $team_poistions = 'DEF';
                    } elseif ($list->fantasyPlayer->position == 'TQB') {
                        //dd('position is '. $list->fantasyPlayer->position);
                        $fantasy_team_positions = 'offenseTeams';
                        $team_poistions = 'TQB';
                    } elseif ($list->fantasyPlayer->position == 'K') {
                        $fantasy_team_positions = 'kickerTeams';
                        $team_poistions = 'K';
                    } else {
                        $fantasy_team_positions = 'offenseTeams';
                        $team_poistions = $list->fantasyPlayer->position;
                    }
                    $news = $list->fantasyPlayer->fantasyPlayerNews;
                    $statistics = $this->getFantasyStatistics($list->fantasyPlayer, $team_poistions, $isProjection);
                    $fantasyTeams[$fantasy_team_positions][$list->id] = $list;
                    $fantasyTeams[$fantasy_team_positions][$list->id]['position'] = $team_poistions;
                    $fantasyTeams[$fantasy_team_positions][$list->id]['statistics'] = $statistics;
                }
            }
        }

        if (! empty($fantasyTeams)) {
            $response['offenseTeams'] = (! empty($fantasyTeams['offenseTeams'])) ?
                                         Helper::sortTeamArray($fantasyTeams['offenseTeams']) : [];
            $response['kickerTeams'] = (! empty($fantasyTeams['kickerTeams'])) ? array_values($fantasyTeams['kickerTeams'])
                                         : [];
            $response['diffTeams'] = (! empty($fantasyTeams['diffTeams'])) ? array_values($fantasyTeams['diffTeams'])
                                         : [];
            $response['specialTeams'] = (! empty($fantasyTeams['specialTeams'])) ? array_values($fantasyTeams['specialTeams'])
                                         : [];
        } else {
            $response['offenseTeams'] = [];
            $response['kickerTeams'] = [];
            $response['diffTeams'] = [];
            $response['specialTeams'] = [];
        }

        return $response;
    }

    private function getFantasyStatistics($fantasy_player, $team_poistions, $isProjection)
    {
        //dd($fantasy_player);
        $statistics = '';
        //dd($team_poistions);
        $player_game = false;
        if (! empty($fantasy_player->teamGame) && (isset($fantasy_player->teamGame[0]))) {
            $player_game = $fantasy_player->teamGame[0];
        }

        if (! empty($fantasy_player->playerGame) && (isset($fantasy_player->playerGame[0]))) {
            $player_game = $fantasy_player->playerGame[0];
        }

        // if($isProjection){

        // 	if(!empty($fantasy_player->fantasyPlayerGameProjection)&&(isset($fantasy_player->fantasyPlayerGameProjection[0]))){

        // 		$player_game	 = $fantasy_player->fantasyPlayerGameProjection[0];
        // 	}

        // }
        if ($fantasy_player->position == 'TQB') {
            $statistics = '';
            $passing_yards = (! empty($player_game)) ? $player_game->passing_yards : '';
            $rushing_touchdowns = (! empty($player_game)) ? $player_game->rushing_touchdowns : '';

            if ($passing_yards) {
                $statistics .= $passing_yards.' PaYd, ';
            }

            $passing_touchdowns = (! empty($player_game)) ? $player_game->passing_touchdowns : '';

            if ($passing_touchdowns || $rushing_touchdowns) {
                $teamQbData = FantasyPointsHelper::getTqbPlayergame($fantasy_player->team, $player_game->season, $player_game->season_type, $player_game->week, $yearly = false, $isProjection = false);
            }

            if ($passing_touchdowns) {
                // $statistics.=$passing_touchdowns.' PaTD, ';

                if (isset($teamQbData['tdPass']) && $teamQbData['tdPass'] > 0) {
                    $statistics .= $passing_touchdowns.' PaTD('.implode(', ', array_column($teamQbData['tdPass'], 'length')).'), ';
                }
            }

            $passing_interceptions = (! empty($player_game)) ? $player_game->passing_interceptions : '';
            if ($passing_interceptions) {
                $statistics .= $passing_interceptions.' Int, ';
            }

            $rushing_yards = (! empty($player_game)) ? $player_game->rushing_yards : '';
            if ($rushing_yards) {
                $statistics .= $rushing_yards.' RuYd, ';
            }

            if ($rushing_touchdowns) {
                //$statistics .= $rushing_touchdowns.' RuTD, ';
                if (isset($teamQbData['tdRush']) && $teamQbData['tdRush'] > 0) {
                    $statistics .= $rushing_touchdowns.' RuTD('.implode(', ', array_column($teamQbData['tdRush'], 'length')).'), ';
                }
            }
        } elseif ($fantasy_player->position == 'DEF') {
            //dd($fantasy_player->toArray());
            $statistics = '';

            if (! empty($fantasy_player->fantasyDefenseGame) && (isset($fantasy_player->fantasyDefenseGame[0]))) {
                $fantasy_defense_game = $fantasy_player->fantasyDefenseGame[0];
                //dd($fantasy_defense_game);
            }

            // if($isProjection){
            // 		if(!empty($fantasy_player->fantasyDefenseGameProjection)&&(isset($fantasy_player->fantasyDefenseGameProjection))){

            // 		$fantasy_defense_game	 = $fantasy_player->fantasyDefenseGameProjection;
            // 	}
            // }

            if (! empty($fantasy_defense_game->points_allowed)) {
                $statistics .= $fantasy_defense_game->points_allowed.' Pts, ';
            }

            if (! empty($fantasy_defense_game->offensive_yards_allowed)) {
                $statistics .= $fantasy_defense_game->offensive_yards_allowed.' Yds, ';
            }

            if (! empty($fantasy_defense_game->sacks)) {
                $statistics .= $fantasy_defense_game->sacks.' Sck, ';
            }

            if (! empty($fantasy_defense_game->interceptions)) {
                $statistics .= $fantasy_defense_game->interceptions.' Int, ';
            }

            if (! empty($fantasy_defense_game->fumbles_recovered)) {
                $statistics .= $fantasy_defense_game->fumbles_recovered.' Fum, ';
            }

            if (! empty($fantasy_defense_game->fumble_return_touchdowns)) {
                $statistics .= $fantasy_defense_game->fumble_return_touchdowns.' FumRet TD, ';
            }

            if (! empty($fantasy_defense_game->interception_return_touchdowns)) {
                $statistics .= $fantasy_defense_game->interception_return_touchdowns.' IntRet TD, ';
            }

            if (! empty($fantasy_defense_game->safeties)) {
                $statistics .= $fantasy_defense_game->safeties.' Sft, ';
            }
        } elseif ($fantasy_player->position == 'K') {
            $statistics = '';

            // $kScores = Helper::getScores($player_game->game_key,$fantasy_player->player_id,'FieldGoal', false);

            if ($player_game) {
                $fieldGoal = FantasyPointsHelper::getScores($player_game->game_key, $fantasy_player->player_id, 'FieldGoalMade');
                $fieldGoalMissed = FantasyPointsHelper::getScores($player_game->game_key, $fantasy_player->player_id, 'FieldGoalMissed');

                //dd($fieldGoalMissed);

                $fieldGoalScores = $fieldGoal['score'];

                if ($fieldGoal['score'] > 0) {
                    $statistics .= ' FG('.implode(', ', array_column($fieldGoal['plays'], 'length')).'), ';
                }

                if (count($fieldGoalMissed['plays']) > 0) {
                    $statistics .= ' Miss('.implode(', ', array_column($fieldGoalMissed['plays'], 'length')).'), ';
                }

                if (! empty($player_game->extra_points_made)) {
                    $statistics .= $player_game->extra_points_made.' XP, ';
                }

                if (! empty($player_game->extra_points_had_blocked)) {
                    $statistics .= $player_game->extra_points_had_blocked.' MiXP, ';
                }
            }
        } elseif ($fantasy_player->position == 'ST') {
            $statistics = '';
            // if(!empty($fantasy_player->fantasy_defense_game)&&(isset($fantasy_player->fantasy_defense_game))){
            // 	$fantasy_defense_game	 = $fantasy_player->fantasy_defense_game;
            // }
            if ($isProjection) {
                if (! empty($fantasy_player->fantasyDefenseGameProjection) && (isset($fantasy_player->fantasyDefenseGameProjection))) {
                    $fantasy_defense_game = $fantasy_player->fantasyDefenseGameProjection;
                }
            }
            if (! empty($player_game->kick_return_yards)) {
                $statistics .= $player_game->kick_return_yards.' KRYd, ';
            }

            if (! empty($player_game->punt_return_yards)) {
                $statistics .= $player_game->punt_return_yards.' PRYd, ';
            }

            if (! empty($player_game->punt_return_touchdowns)) {
                $statistics .= $player_game->punt_return_touchdowns.' PRTd, ';
            }

            if (! empty($player_game->kick_return_touchdowns)) {
                $statistics .= $player_game->kick_return_touchdowns.' KRTd, ';
            }
        }
        if (in_array($fantasy_player->position, ['RB', 'WR', 'TE'])) {
            $statistics = '';
            $rushing_yards = (! empty($player_game)) ? $player_game->rushing_yards : '';
            $rushing_touchdowns = (! empty($player_game)) ? $player_game->rushing_touchdowns : '';
            $receiving_yards = (! empty($player_game)) ? $player_game->receiving_yards : '';
            $receiving_touchdowns = (! empty($player_game)) ? $player_game->receiving_touchdowns : '';
            $fumbles_lost = (! empty($player_game)) ? $player_game->fumbles_lost : '';

            if ($rushing_yards) {
                $statistics .= $rushing_yards.' RuYd, ';
            }

            if ($rushing_touchdowns) {
                //$statistics	.= $rushing_touchdowns.' RuTD, ';
                $rushTd = FantasyPointsHelper::getScores($player_game->game_key, $fantasy_player->player_id, 'RushingTouchdown');
                if ($rushTd['score'] > 0) {
                    $statistics .= $rushing_touchdowns.' RuTd('.implode(', ', array_column($rushTd['plays'], 'length')).'), ';
                }
            }

            if ($receiving_yards > 0) {
                $statistics .= $receiving_yards.' ReYd, ';
            }

            if ($receiving_touchdowns) {
                //$statistics	.= $receiving_touchdowns.' ReTD, ';
                $playerScore = FantasyPointsHelper::getScores($player_game->game_key, $fantasy_player->player_id, 'ReceivingTouchdown');
                if ($playerScore['score'] > 0) {
                    $statistics .= $receiving_touchdowns.' ReTd('.implode(', ', array_column($playerScore['plays'], 'length')).'), ';
                }
            }

            if ($fumbles_lost) {
                $statistics .= $fumbles_lost.' Fum, ';
            }
        }
        //dd('made it here '. $fantasy_player);
        $statistics = rtrim($statistics, ', ');

        return $statistics;
    }

    private function merge_two_teams_data($team_one, $team_two)
    {
        $merge_offenseTeams = array_merge($team_one['offenseTeams'], $team_two['offenseTeams']);
        $merge_kickerTeams = array_merge($team_one['kickerTeams'], $team_two['kickerTeams']);
        $merge_diffTeams = array_merge($team_one['diffTeams'], $team_two['diffTeams']);
        $merge_specialTeams = array_merge($team_one['specialTeams'], $team_two['specialTeams']);
        $collection = collect($merge_offenseTeams);
        $merged_kickerTeams = $collection->merge($merge_kickerTeams);
        $merged_diffTeams = $merged_kickerTeams->merge($merge_diffTeams);
        $merged = $merged_diffTeams->merge($merge_specialTeams);
        $offenseTeams = $merged->whereIn('position', ['TQB', 'RB', 'QB', 'WR', 'TE']);
        $kickerTeams = $merged->whereIn('position', ['K']);
        $diffTeams = $merged->whereIn('position', ['DEF']);
        $specialTeams = $merged->whereIn('position', ['ST']);

        $response['offenseTeams'] = Helper::sortTeamArray(array_values($offenseTeams->toArray()));
        $response['kickerTeams'] = array_values($kickerTeams->toArray());
        $response['diffTeams'] = array_values($diffTeams->toArray());
        $response['specialTeams'] = array_values($specialTeams->toArray());

        return $response;
    }

    public function getProjectionDetails(Request $request)
    {
        $season = $week = $seasonType = '';
        $offenseTeams = $kickerTeams = $diffTeams = $qbTeams = $specialTeams = [];
        $offenseTeamsProj = $kickerTeamsProj = $diffTeamsProj = $specialTeamsProj = [];

        if (isset($request->team_id) && $request->team_id != '') {
            $teamId[] = $request->team_id;
        }

        if (isset($request->team_id2) && $request->team_id2 != '') {
            $teamId[] = $request->team_id2;
        }

        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        if (empty($request->team_id) && empty($request->team_id2)) {
            $teamId[] = $team->id;
        }

        $league = League::find($team->league_id);
        $settings = SystemSetting::find(1);
        if (! empty($league)) {
            $override_system = $league->override_system;
            if (isset($request->week)) {
                $week = $request->week;
            } elseif ($override_system) {
                $week = $league->week;
            } else {
                $week = $settings->week;
            }

            if (isset($request->season)) {
                $season_type = $request->season_type;
                $seasonTypeArray = Helper::$seasonTypes;
                $revArray = array_flip($seasonTypeArray);
                $seasonType = $revArray[$season_type];
            } elseif ($override_system) {
                $seasonType = $league->season_type;
            } else {
                $seasonType = $settings->season_type;
            }

            if (isset($request->season)) {
                $season = $request->season;
            } elseif ($override_system) {
                $season = $league->season;
            } else {
                $season = $settings->season;
            }
        }
        $allow_team_qb = $league->allow_team_qb;
        if ($allow_team_qb) {
            $offenseArray = ['RB', 'WR', 'TE'];
        } else {
            $offenseArray = ['RB', 'QB', 'WR', 'TE'];
        }

        $result = Helper::getFantasyProjectionTeamDataByWeek($season, $seasonType, $week, $teamId);

        return $result;

        /*
                $rosterTeams	= 	FantasyTeamsRoster::selectRaw("p.position,p.name,p.team,pg.opponent,is_st,team_qb,is_def,pg.home_or_away,pg.passing_yards,
                                        pg.passing_touchdowns,pg.passing_interceptions,pg.rushing_yards,pg.rushing_touchdowns,pg.receiving_yards,pg.receiving_touchdowns,pg.punt_return_touchdowns ,pg.kick_return_touchdowns,pg.two_point_conversion_passes ,pg.two_point_conversion_runs ,pg.two_point_conversion_receptions,pg.fumbles_lost,pg.fantasy_points,
                                        pg.extra_points_made,pg.field_goals_made0to19 as fg1,pg.field_goals_made20to29 as fg2,pg.field_goals_made30to39 as fg3,pg.field_goals_made40to49 as fg4,
                                        pg.field_goals_made50_plus as fg5,pg.sacks,pg.interceptions,pg.fumbles_recovered,pg.safeties,pg.defensive_touchdowns,pg.special_teams_touchdowns,pg.kick_return_yards,
                                        pg.kick_return_fair_catches,pg.punt_return_yards,pg.punt_touchbacks,pg.fumbles_recovered,s.away_team,s.home_team,s.away_score,s.home_score,
                                        fantasy_teams_roster.fantasy_team_id as fantasy_team_id,pg.fantasy_points as predicted_score,fantasy_teams_roster.player_id as player_id,pg.id as projection_id,fantasy_teams_roster.active as active_player,fantasy_teams_roster.bench as bench_player,p.id as fplayer_id")
                                    ->leftJoin('fantasy_player as p','p.id','=','fantasy_teams_roster.player_id')
                                    ->leftJoin('player_game_projection as pg', function ($join) use($season,$seasonType,$week){
                                        $join->on('pg.player_id','=','p.player_id');
                                        $join->where('pg.season',$season);
                                        $join->where('pg.season_type',$seasonType);
                                        $join->where('pg.week',$week);
                                    })
                                    ->leftJoin('score as s','s.game_key','=','pg.game_key')
                                    ->whereIn('fantasy_teams_roster.fantasy_team_id',$teamId)
                                    ->where('fantasy_teams_roster.week',$week)
                                    //->where('fantasy_teams_roster.season',$season)
                                    ->where('fantasy_teams_roster.season_type',$seasonType)
                                    ->where('fantasy_teams_roster.is_def','<>',1)
                                    ->where('fantasy_teams_roster.player_transaction_type_id',1)
                                    ->where('fantasy_teams_roster.active',1)
                                    ->orWhere(function($query) {
                                            $query->where('fantasy_teams_roster.bench', 1);
                                        })
                                    ->get()->toArray();


                if(!empty($rosterTeams)){
                    foreach($rosterTeams as $key=>$val){

                         $isTeamQbItem = $val['position'] == "DEF" && $val['team_qb'] == 1;


                        //Update some data for formatting purposes on frontend
                        if($isTeamQbItem){
                            $val['position']			=	'TQB'; //Show that it is "Team QB"
                        }


                        if($val['home_or_away']=='AWAY'){
                            $val['opponent']	= '@'.$val['opponent'];
                        }
                        if(empty($val['projection_id'])){
                            $val['opponent']	= 'Bye Week';
                        }
                        if($val['away_team'] != '' || $val['home_team'] != '')
                        $val['status']			= $val['away_team'].' '.$val['away_score'].' @ '.$val['home_team'].' '.$val['home_score'];
                        $val['ret_td'] 			= $val['punt_return_touchdowns']+$val['kick_return_touchdowns'];
                        $val['two_pt'] 			= $val['two_point_conversion_passes']+$val['two_point_conversion_runs']+$val['two_point_conversion_receptions'];

                        if($val['position'] == 'QB')
                            $val['statistics']	=	$val['passing_yards'].' Yrds '.$val['passing_touchdowns'].' TD '.$val['passing_interceptions'].' INT';
                        else if($val['position'] == 'RB')
                            $val['statistics']	=	$val['rushing_yards'].' Yrds '.$val['rushing_touchdowns'].' TD ';
                        else if($val['position'] == 'WR')
                            $val['statistics']	=	$val['receiving_yards'].' Yrds '.$val['receiving_touchdowns'].' TD ';
                        else if($val['position'] == 'TE')
                            $val['statistics']	=	$val['receiving_yards'].' Yrds '.$val['receiving_touchdowns'].' TD ';


                        if(in_array($val['position'],$offenseArray)){
                                $offenseTeams[]	=	$val;
                        }

                        if($isTeamQbItem){
                            array_unshift($offenseTeams,$val);

                        }

                        else if($val['position'] == 'K'){
                            $sumValue			=	$val['fg1']+$val['fg2']+$val['fg3']+$val['fg4']+$val['fg5'];
                            $val['statistics']	=	$sumValue.' FG';
                            $kickerTeams[]		=	$val;
                        }
                    }
                }



                $defTeams	= 	FantasyTeamsRoster::selectRaw("p.position,p.name,p.team,fd.opponent,is_st,team_qb,is_def,fd.home_or_away,fd.sacks,fd.interceptions,fd.fumbles_recovered,fd.safeties,fd.defensive_touchdowns,fd.special_teams_touchdowns,fd.fantasy_points,s.away_team,s.home_team,s.away_score,s.home_score,fd.points_allowed,fantasy_teams_roster.fantasy_team_id as fantasy_team_id,fd.fantasy_points as predicted_score,fantasy_teams_roster.player_id as player_id,fd.id as projection_id,fantasy_teams_roster.active as active_player,fantasy_teams_roster.bench as bench_player,p.id as fplayer_id")
                                    ->leftJoin('fantasy_player as p','p.id','=','fantasy_teams_roster.player_id')
                                    ->leftJoin('fantasy_defense_game_projection as fd', function ($join) use($season,$seasonType,$week){
                                        $join->on('fd.player_id','=','p.player_id');
                                        $join->where('fd.season',$season);
                                        $join->where('fd.season_type',$seasonType);
                                        $join->where('fd.week',$week);
                                    })
                                    ->leftJoin('score as s','s.game_key','=','fd.game_key')
                                    ->whereIn('fantasy_teams_roster.fantasy_team_id',$teamId)
                                    ->where('fantasy_teams_roster.week',$week)
                                    ->where('fantasy_teams_roster.season_type',$seasonType)
                                    ->where('fantasy_teams_roster.player_transaction_type_id',1)
                                    ->where('fantasy_teams_roster.is_def',1)
                                    ->orWhere(function($query) {
                                            $query->where('fantasy_teams_roster.active', 1)
                                                  ->where('fantasy_teams_roster.bench', 1);
                                        })
                                    ->get()->toArray();
                if(!empty($defTeams)){
                    foreach($defTeams as $dkey=>$dval){
                        if($dval['home_or_away']=='AWAY'){
                            $dval['opponent']		= '@'.$dval['opponent'];
                        }
                        if(empty($dval['projection_id'])){
                            $dval['opponent']		= 'Bye Week';
                        }
                        if($dval['away_team'] != '' || $dval['home_team'] != '')
                        $dval['status']				= 	$dval['away_team'].' '.$dval['away_score'].' @ '.$dval['home_team'].' '.$dval['home_score'];
                        $dval['statistics']			=	$dval['points_allowed'].' Pts '.$dval['sacks'].' Sck '.$dval['interceptions'].' Int '.$dval['fumbles_recovered'].' Fum';
                        $diffTeams[]				=	$dval;
                    }
                }

                $specTeams	= 	FantasyTeamsRoster::selectRaw("p.position,p.name,p.team,fd.opponent,is_st,team_qb,is_def,fd.home_or_away,fd.sacks,fd.interceptions,fd.fumbles_recovered,fd.safeties,fd.defensive_touchdowns,fd.special_teams_touchdowns,fd.fantasy_points,s.away_team,s.home_team,s.away_score,s.home_score,fd.points_allowed,fantasy_teams_roster.fantasy_team_id as fantasy_team_id,fd.fantasy_points as predicted_score,fantasy_teams_roster.player_id as player_id,fd.id as projection_id,fantasy_teams_roster.active as active_player,fantasy_teams_roster.bench as bench_player,p.id as fplayer_id")
                                    ->leftJoin('fantasy_player as p','p.id','=','fantasy_teams_roster.player_id')
                                    ->leftJoin('fantasy_defense_game_projection as fd', function ($join) use($season,$seasonType,$week){
                                        $join->on('fd.player_id','=','p.player_id');
                                        $join->where('fd.season',$season);
                                        $join->where('fd.season_type',$seasonType);
                                        $join->where('fd.week',$week);
                                    })
                                    ->leftJoin('score as s','s.game_key','=','fd.game_key')
                                    ->whereIn('fantasy_teams_roster.fantasy_team_id',$teamId)
                                    ->where('fantasy_teams_roster.week',$week)
                                    //->where('fantasy_teams_roster.season',$season)
                                    ->where('fantasy_teams_roster.season_type',$seasonType)
                                    ->where('fantasy_teams_roster.player_transaction_type_id',1)
                                    ->where('fantasy_teams_roster.is_st',1)
                                    ->orWhere(function($query) {
                                            $query->where('fantasy_teams_roster.active', 1)
                                                  ->where('fantasy_teams_roster.bench', 1);
                                        })
                                    ->get()->toArray();
                if(!empty($specTeams)){
                    foreach($specTeams as $skey=>$sval){
                        $sval['position']			= 'ST';

                        if($sval['home_or_away']=='AWAY'){
                            $sval['opponent']		= '@'.$sval['opponent'];
                        }
                        if(empty($sval['projection_id'])){
                            $sval['opponent']		= 'Bye Week';
                        }
                        if($sval['away_team'] != '' || $sval['home_team'] != '')
                        $sval['status']				= 	$sval['away_team'].' '.$sval['away_score'].' @ '.$sval['home_team'].' '.$sval['home_score'];
                        $sval['statistics']			=	$sval['points_allowed'].' Pts '.$sval['sacks'].' Sck '.$sval['interceptions'].' Int '.$sval['fumbles_recovered'].' Fum';
                        $specialTeams[]				=	$sval;
                    }
                }



                $response['offenseTeams']	=	Helper::sortTeamArray($offenseTeams);
                $response['kickerTeams']	=	$kickerTeams;
                $response['diffTeams']		=	$diffTeams;
                $response['specialTeams']	=	$specialTeams;

                $response['offenseTeamsProj']	=	Helper::sortTeamArray($offenseTeamsProj);
                $response['kickerTeamsProj']	=	$kickerTeamsProj;
                $response['diffTeamsProj']		=	$diffTeamsProj;
                $response['specialTeamsProj']	=	$specialTeamsProj;
                return $response;
                */
    }

    /**
     * Show the live game scoreboard.
     *
     * @return Response
     */
    public function getLeagueGame(Request $request)
    {
        if ($request->week) {
            $week = $request->week;
        } else {
            $week = 1;
        }
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();
        $response = [];
        $leagueTeams = LeagueGame::selectRaw('week,league_schedule_id,round(league_games.team_score,2) as score,0 as PMR,league_games.win as isWon,t.name as teamName')
                            ->leftJoin('fantasy_teams as t', 't.id', '=', 'league_games.team_id')
                            ->where('week', $week)
                            ->where('t.league_id', $league->id)
                            ->get()->groupBy('league_schedule_id')->toArray();

        if (! empty($leagueTeams)) {
            foreach ($leagueTeams as $keys=>$lists) {
                foreach ($lists as $key=>$list) {
                    $response[$list['week']]['week'] = (string) $list['week'];
                    $response[$list['week']]['teamData'][$list['league_schedule_id']] = $lists;
                }
            }
        }

        /* $i		=	-1;
        $week	=	'';
        if(!empty($leagueTeams)){
            foreach($leagueTeams as $key=>$list){
                if($week != $list[0]['week']){
                    $i++;
                    $week =	$list[0]['week'];
                }
                $response[$i]['week']		=	(string)$list[0]['week'];
                $response[$i]['teamData'][]	=	$list;
            }
        } */
        return response()->json($response);
    }

    /**
     * Show the live game scoreboard.
     *
     * @return Response
     */
    public function getAllLeagueGame()
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();
        $response = [];

        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->week) {
            $week = $systemSettings->week;
        }
        if ($systemSettings->season) {
            $season = $systemSettings->season;
        }
        if ($systemSettings->season_type) {
            $season_type = $systemSettings->season_type;
        }

        $leagueTeams = LeagueGame::selectRaw('week,league_schedule_id,round(league_games.team_score,2) as score,t.name as teamName')
                            ->leftJoin('fantasy_teams as t', 't.id', '=', 'league_games.team_id')
                            ->where('t.league_id', $league->id)
                            ->get()->groupBy('league_schedule_id')->toArray();

        $week_range = range(1, 18);
        foreach ($week_range as $key=>$value) {
            $leagueGames = LeagueGame::selectRaw('week,league_schedule_id,round(league_games.team_score,2) as score,t.name as teamName')
                            ->leftJoin('fantasy_teams as t', 't.id', '=', 'league_games.team_id')
                            ->where('t.league_id', $league->id)
                            ->where('week', $value)
                             ->where('year', $season)
                             ->where('game_type_id', 1)
                            ->get()->groupBy('league_schedule_id')->toArray();

            $timeFrame = Timeframe::select('first_game_start')
                                                    ->where('week', $value)
                                                    ->where('season_type', $season_type)
                                                    ->where('season', $season)
                                                    ->first();

            $response[$value]['time_frame'] = (! empty($timeFrame)) ? date('l, F j, Y', strtotime($timeFrame->first_game_start)) : '';

            if (! empty($leagueGames)) {
                foreach ($leagueGames as $keys=>$lists) {
                    foreach ($lists as $key=>$list) {
                        if (! empty($lists[0]['teamName']) && ! empty($lists[1]['teamName'])) {
                            $response[$list['week']]['teamData'][$list['league_schedule_id']]['home_team'] = $lists[0]['teamName'];
                            $response[$list['week']]['teamData'][$list['league_schedule_id']]['visitor_team'] = $lists[1]['teamName'];
                            $response[$list['week']]['teamData'][$list['league_schedule_id']]['result'] = $lists[0]['score'].' - '.$lists[1]['score'];
                        }
                    }
                }
            } else {
                $leagueTeams = LeagueSchedule::where('league_schedule.league_id', $league->id)
                                                    ->where('week', $value)
                                                    ->where('year', $season)
                                                    ->where('game_type_id', 1)
                                                    ->get();

                foreach ($leagueTeams as $key=>$list) {
                    $response[$list['week']]['teamData'][$list['id']]['home_team'] = $list->leagueHomeTeam->name;
                    $response[$list['week']]['teamData'][$list['id']]['visitor_team'] = $list->leagueAwayTeam->name;
                    $response[$list['week']]['teamData'][$list['id']]['result'] = '';
                }
            }
        }

        /*

        $leagueTeams	= 	LeagueGame::selectRaw("week,league_schedule_id,round(league_games.team_score,2) as score,t.name as teamName")
                        ->leftJoin('fantasy_teams as t','t.id','=','league_games.team_id')
                        ->where('t.league_id',$league->id)
                        ->get()->groupBy('league_schedule_id')->toArray();


        if(!empty($leagueTeams)){

        foreach($leagueTeams as $keys=>$lists){
            foreach($lists as $key=>$list){
             if(!empty($lists[0]['teamName']) && !empty($lists[1]['teamName'])){
                $response[$list['week']]['teamData'][$list['league_schedule_id']]['home_team']	=	$lists[0]['teamName'];
                $response[$list['week']]['teamData'][$list['league_schedule_id']]['visitor_team']=	$lists[1]['teamName'];
                $response[$list['week']]['teamData'][$list['league_schedule_id']]['result']	=	$lists[0]['score'].'-'.$lists[1]['score'];
             }
            }
        }
        }

        */

        return response()->json($response);
    }

    // private function getFantasyScore($fantasyTeamRoster)
    // {
    //     $rosterScore	= 0;
    //     //dd($fantasyTeamRoster->FantasyTeamRoster->toArray());
    //     foreach ($fantasyTeamRoster->FantasyTeamRoster as $player) {
    //         //dd($player->fantasyPlayer->player_current_week_fantasy_points_acme);
    //         if (isset($player->fantasyPlayer->player_current_week_fantasy_points_acme)) {
    //             $rosterScore += $player->fantasyPlayer->player_current_week_fantasy_points_acme;
    //         }
    //     }

    //     return $rosterScore;
    // }

    public function getSeasonPostScoreDetails(Request $request)
    {
        $systemSettings = Helper::getSystemSettingsDetails();
        $week = $request->week;
        $season = $systemSettings['season'];
        $seasonType = $systemSettings['season_type'];
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();
        $fantasy_teams = FantasyTeam::where('league_id', $league->id)->get();
        //dd($fantasy_teams);
        $newArray = [];
        if (! empty($fantasy_teams)) {
            foreach ($fantasy_teams as $key=>$val) {
                $fantasyTeamRoster = Helper::getFantasyTeamDataByWeekEloquent($season, $seasonType, $week, $val->id, $simple = false);
                $response = $this->getFantasyTeamRosterByPositions([$fantasyTeamRoster], $is_projection = false);
                //dd($score_result);
                $score = $this->getFantasyScore($fantasyTeamRoster);
                //$result[$val->id]		=	$score;

                $result[$val->id] = ['fantasy_team_details' => $fantasyTeamRoster, 'total_home_acme_points'=>$score, 'by_position'=>$response];

                if ($week > 1) {
                    $prevResult[$val->id] = Helper::getPostSeasonScoreDetails($season, $seasonType, $week - 1, $val->id);
                    //dd($prevResult[$val->id]);
                }
                //$prevResult[$val->id]	=	Helper::getFantasyTeamDataByWeekEloquent($season, $seasonType, $week-1, array($val->id), $simple=false);
            }
        }

        if ($result) {
            foreach ($result as $tkey=>$tval) {
                $newArray[$tkey] = $tval;
                $total_home_acme_points = $tval['total_home_acme_points'];
                if (isset($prevResult[$tkey])) {
                    $newArray[$tkey]['prev_total'] = $prevResult[$tkey]['total_home_acme_points'];
                    $newArray[$tkey]['prev_tds'] = $prevResult[$tkey]['tds'];
                    $prev_total = $prevResult[$tkey]['total_home_acme_points'];
                //dd($prevResult);
                } else {
                    $newArray[$tkey]['prev_total'] = 0;
                    $newArray[$tkey]['prev_tds'] = 0;
                    $prev_total = 0;
                }

                $newArray[$tkey]['grandTotal'] = $total_home_acme_points + $prev_total;
            }
        }
        $returnArray = (array_values($newArray));
        $PCT = array_column($returnArray, 'grandTotal');

        array_multisort($PCT, SORT_DESC, $returnArray);

        return response()->json($returnArray);
    }

    public function getPostSeasonTeams(Request $request)
    {
        $systemSettings = Helper::getSystemSettingsDetails();
        $week = $request->week;
        $season = $systemSettings['season'];
        $seasonType = $systemSettings['season_type'];
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();

        //all active player_ids from fantasy_teams_roster for fantasy_league

        $fantasy_teams = FantasyTeam::where('league_id', $league->id)->get();

        $fantasy_teams_players = FantasyTeamsRoster::where('league_id', $league->id)
                                                    ->where('season', $season)
                                                    ->where('season_type', $seasonType)
                                                    ->where('week', $week)
                                                    ->where('active', 1)
                                                    ->get()->toArray();

        $collection = collect($fantasy_teams_players);
        $unique_fantasy_players = $collection->unique('player_id');
        $unique_players = $unique_fantasy_players->values()->all();

        $keyed = $unique_fantasy_players->mapWithKeys(function ($item) {
            return [$item['player_id'] => $item['player_id']];
        });
        $unique_players_id = $keyed->values()->all();
        $fantay_data = Helper::getFantasyPlayerDataByWeekEloquent($season, $seasonType, $week, $unique_players_id);
        $result = [];

        if (! empty($fantasy_teams)) {
            //dd($fantasy_teams);
            foreach ($fantasy_teams as $key=>$val) {
                $fantay_data_offenseTeams_collection = collect($fantay_data['offenseTeams']);
                $offenseTeams_filtered = $fantay_data_offenseTeams_collection->where('fantasy_team_id', $val->id);

                $fantay_data_kickerTeams_collection = collect($fantay_data['kickerTeams']);
                $kickerTeams_filtered = $fantay_data_kickerTeams_collection->where('fantasy_team_id', $val->id);

                $fantay_data_diffTeams_collection = collect($fantay_data['diffTeams']);
                $diffTeams_filtered = $fantay_data_diffTeams_collection->where('fantasy_team_id', $val->id);

                $fantay_data_specialTeams_collection = collect($fantay_data['specialTeams']);
                $specialTeams_filtered = $fantay_data_specialTeams_collection->where('fantasy_team_id', $val->id);

                $offenseTeams_points = $offenseTeams_filtered->sum(function ($item) {
                    return $item['fantasy_points_acme'];
                });

                $kickerTeams_points = $kickerTeams_filtered->sum(function ($item) {
                    return $item['fantasy_points_acme'];
                });
                $diffTeams_points = $diffTeams_filtered->sum(function ($item) {
                    return $item['fantasy_points_acme'];
                });
                $specialTeams_points = $specialTeams_filtered->sum(function ($item) {
                    return $item['fantasy_points_acme'];
                });

                $result[$val->id]['offenseTeams'] = $offenseTeams_filtered->values()->all();
                $result[$val->id]['kickerTeams'] = $kickerTeams_filtered->values()->all();
                $result[$val->id]['diffTeams'] = $diffTeams_filtered->values()->all();
                $result[$val->id]['specialTeams'] = $specialTeams_filtered->values()->all();
                $result[$val->id]['team_name'] = $val->name;
                $result[$val->id]['total_home_acme_points'] = $offenseTeams_points + $kickerTeams_points + $diffTeams_points + $specialTeams_points;
                if ($week > 1) {
                    $prevResult[$val->id] = Helper::getPostSeasonScoreDetails($season, $seasonType, $week - 1, $val->id);
                }
            }
        }

        if ($result) {
            foreach ($result as $tkey=>$tval) {
                $newArray[$tkey] = $tval;
                $total_home_acme_points = $tval['total_home_acme_points'];
                if (isset($prevResult[$tkey])) {
                    $newArray[$tkey]['prev_total'] = $prevResult[$tkey]['total_home_acme_points'];
                    $prev_total = $prevResult[$tkey]['total_home_acme_points'];
                } else {
                    $newArray[$tkey]['prev_total'] = '0.00';
                    $prev_total = 0;
                }

                $newArray[$tkey]['grandTotal'] = $total_home_acme_points + $prev_total;
            }
        }

        $returnArray = (array_values($newArray));
        $PCT = array_column($returnArray, 'grandTotal');

        array_multisort($PCT, SORT_DESC, $returnArray);

        return response()->json($returnArray);
    }

    public function getNFLSchedules(Request $request)
    {
        $nflTeams = [];
        $systemSettings = Helper::getSystemSettingsDetails();
        $week = $request->week ?? $systemSettings['week'];
        $season = $systemSettings['season'];
        $seasonType = $systemSettings['season_type'];
        $schedules = Schedule::select('t.key', 'schedule.away_team', 'schedule.home_team', 't.full_name', 't.primary_color', 't.secondary_color', 'game_key')
                                ->leftJoin('team as t', function ($join) {
                                    $join->on('t.team_id', '=', 'schedule.global_away_team_id');
                                    $join->orOn('t.team_id', '=', 'schedule.global_home_team_id');
                                })
                                ->where('week', $week)
                                ->where('season', $season)
                                ->where('season_type', $seasonType)
                                ->get()->toArray();
        $awayTeams = $homeTeams = $response = [];
        if (! empty($schedules)) {
            foreach ($schedules as $val) {
                if ($val['home_team'] == $val['key']) {
                    $nflTeams[$val['game_key']]['home_team'] = $val;
                }
                if ($val['away_team'] == $val['key']) {
                    $nflTeams[$val['game_key']]['away_team'] = $val;
                }
            }
        }
        $response['nflTeams'] = array_values($nflTeams);

        return response()->json($response);
    }

    private function getPlayerGame($game_key, $week, $season, $seasonType)
    {
        $player_game = PlayerGame::where('game_key', $game_key)
                                ->where('week', $week)
                                ->where('season', $season)
                                ->where('season_type', $seasonType)
                                ->get();
        $players_array = $players_details = [];
        if (! empty($player_game) && count($player_game) > 0) {
            $collection = collect($player_game);
            $qb = $collection->where('position', 'QB');
            $rb = $collection->where('position', 'RB');
            $rec = $collection->whereIn('position', ['RB', 'WR', 'TE']);

            $players_array['home_team']['pass'] = $qb->where('home_or_away', 'HOME')->sortByDesc('passing_yards')->first() ?? new \StdClass;
            $players_array['away_team']['pass'] = $qb->where('home_or_away', 'AWAY')->sortByDesc('passing_yards')->first() ?? new \StdClass;
            $players_array['home_team']['rush'] = $rb->where('home_or_away', 'HOME')->sortByDesc('rushing_yards')->first() ?? new \StdClass;
            $players_array['away_team']['rush'] = $rb->where('home_or_away', 'AWAY')->sortByDesc('rushing_yards')->first() ?? new \StdClass;

            $players_array['home_team']['rec'] = $rec->where('home_or_away', 'HOME')->sortByDesc('receiving_yards')->first() ?? new \StdClass;
            $players_array['away_team']['rec'] = $rec->where('home_or_away', 'AWAY')->sortByDesc('receiving_yards')->first() ?? new \StdClass;
        }

        return 	$players_array;
    }

    private function getScheduleVideo2($game_key, $substinrg_date, $week, $season, $seasonType)
    {
        //$date='2018-09-09T13:00:00';
        $date = date('Y-m-d', strtotime($substinrg_date));
        $schedules = Schedule::where(\DB::raw('substr(date, 1, 10)'), '=', $date)
                                ->where('week', $week)
                                ->where('season', $season)
                                ->where('season_type', $seasonType)
                                ->get();

        $shedule_collection = collect($schedules);
        $filtered = $shedule_collection->where('game_key', $game_key);
        $position = $filtered->keys();
        $game_position = $position->first();
        $game_position = ($game_position < 10) ? '0'.$game_position : $game_position;
        $game_date = date('Ymd', strtotime($date));
        $end_point = $game_date.$game_position.'.json';

        dd($end_point);

        $client = new \GuzzleHttp\Client();
        try {
            $url = 'http://www.nfl.com/feeds-rs/videos/gameHighlights/byGame/'.$end_point;
            $request = $client->request('GET', $url);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // This will catch all 400 level errors.
            return $e->getResponse()->getStatusCode();
        }

        $status = $request->getStatusCode();
        $video_array = [];
        if ($status == 200) {
            $contents = $request->getBody()->getContents();
            $videos = json_decode($contents);
            $collection = collect($videos->videos);
            $filtered_video = $collection->first();
            if ($filtered_video) {
                $video_array['video_url'] = $filtered_video->videoFileUrl;
                $video_array['video_headline'] = $filtered_video->briefHeadline;
            }
        }

        return $video_array;
    }

    private function getScheduleVideo($week, $season, $seasonType)
    {
        $schedules = Schedule::where('week', $week)
                                ->where('season', $season)
                                ->where('season_type', $seasonType)
                                ->get()->toArray();

        $video_array = [];
        foreach ($schedules as $list) {
            $date = date('Y-m-d', strtotime($list['date']));
            $date_schedules = Schedule::where(\DB::raw('substr(date, 1, 10)'), '=', $date)
                                ->where('week', $week)
                                ->where('season', $season)
                                ->where('season_type', $seasonType)
                                ->get();

            $shedule_collection = collect($date_schedules);
            $filtered = $shedule_collection->where('game_key', $list['game_key']);
            $position = $filtered->keys();
            $game_position = $position->first();
            $game_position = ($game_position < 10) ? '0'.$game_position : $game_position;
            $game_date = date('Ymd', strtotime($date));
            $end_point = $game_date.$game_position.'.json';

            $client = new \GuzzleHttp\Client();
            try {
                $url = 'http://www.nfl.com/feeds-rs/videos/gameHighlights/byGame/'.$end_point;
                $request = $client->request('GET', $url);
            } catch (\GuzzleHttp\Exception\ConnectException $e) {
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                // This will catch all 400 level errors.
                return $e->getResponse()->getStatusCode();
            }

            $status = $request->getStatusCode();

            if ($status == 200) {
                $contents = $request->getBody()->getContents();
                $videos = json_decode($contents);
                $collection = collect($videos->videos);
                $filtered_video = $collection->first();
                if ($filtered_video) {
                    $video_array[$list['game_key']]['video_url'] = $filtered_video->videoFileUrl;
                    $video_array[$list['game_key']]['video_headline'] = $filtered_video->briefHeadline;
                    $video_array[$list['game_key']]['video_img'] = $filtered_video->largeImageUrl;
                    $video_array[$list['game_key']]['video_type'] = 'video/mp4';
                } else {
                    $video_array[$list['game_key']]['video_url'] = '';
                    $video_array[$list['game_key']]['video_headline'] = '';
                    $video_array[$list['game_key']]['video_img'] = '';
                    $video_array[$list['game_key']]['video_type'] = 'video/mp4';
                }
            }
        }

        return $video_array;
    }

    public function getNFLGameScores(Request $request)
    {
        $nflTeams = [];
        $game_key = '';
        $systemSettings = Helper::getSystemSettingsDetails();
        $week = $systemSettings['week'];
        $season = $systemSettings['season'];
        $seasonType = $systemSettings['season_type'];
        if (isset($request->week)) {
            $week = $request->week;
        }
        if (isset($request->season)) {
            $season = $request->season;
        }
        if (isset($request->season_type)) {
            $seasonType = $request->season_type;
        }
        if (isset($request->game_key)) {
            $game_key = $request->game_key;
        }

        $video_details = $this->getScheduleVideo($week, $season, $seasonType);
        //dd($video_details);

        $awayTeams = $homeTeams = $response = [];

        $schedules_qry = Schedule::leftJoin('team as t', function ($join) {
            $join->on('t.team_id', '=', 'schedule.global_away_team_id');
            $join->orOn('t.team_id', '=', 'schedule.global_home_team_id');
        })
                            ->where('week', $week)
                            ->where('season', $season)
                            ->where('season_type', $seasonType);
        if ($game_key != '') {
            $schedules_qry->where('game_key', $game_key);
        }
        $schedules = $schedules_qry->get();

        if (! empty($schedules)) {
            foreach ($schedules as $val) {
                $players_details = $this->getPlayerGame($val->game_key, $week, $season, $seasonType);
                if (! empty($players_details)) {
                    $nflTeams[$val->game_key]['game_key'] = $val->game_key;
                    $nflTeams[$val->game_key]['home_away_team_score']['score_data'] = $val->scheduleScore;
//                    $nflTeams[$val->game_key]['video_details'] = $video_details[$val->game_key];

                    $emptyObject = new \stdClass();
                    $emptyObject->wins = 0;
                    $emptyObject->losses = 0;
                    if ($val->home_team == $val->key) {
                        $nflTeams[$val->game_key]['home_team']['team_data'] = $val;
                        $nflTeams[$val->game_key]['home_team']['score_data'] = $val->scheduleScore;
                        $nflTeams[$val->game_key]['home_team']['team_record'] = $val->scheduleHomeTeamRecord ?? $emptyObject;
                        $nflTeams[$val->game_key]['home_team']['players'] = $players_details['home_team'];
                    }
                    if ($val->away_team == $val->key) {
                        $nflTeams[$val->game_key]['away_team']['team_data'] = $val;
                        $nflTeams[$val->game_key]['away_team']['score_data'] = $val->scheduleScore;
                        $nflTeams[$val->game_key]['away_team']['team_record'] = $val->scheduleAwayTeamRecord ?? $emptyObject;
                        $nflTeams[$val->game_key]['away_team']['players'] = $players_details['away_team'];
                    }
                }
            }
        }

        $response['nflTeams'] = array_values($nflTeams);

        return response()->json(array_values($nflTeams));
    }

    public function showBoxScoreNflGames(Request $request)
    {
        $game_key = $request->game_key;
        $week = $request->week;
        $season = $request->season;

        return view('scores.box-score', compact('game_key', 'week', 'season'));
    }

    public function getKeyPlayerGame(Request $request)
    {
        $game_key = $request->game_key;
        $week = $request->week;
        $season = $request->season;

        $player_game = PlayerGame::where('game_key', $game_key)
                                                ->where('week', $week)
                                                ->where('season', $season)
                                                ->with(['player'])
                                                ->get();
        $players_array = $players_details = [];
        if (! empty($player_game) && count($player_game) > 0) {
            $collection = collect($player_game);
            $qb = $collection->where('position', 'TQB');
            $rb = $collection->where('position', 'RB');
            $rec = $collection->whereIn('position', ['WR', 'TE']);

            $players_array['qb'] = $qb->sortByDesc('fantasy_points_acme')->first();
            $players_array['rb'] = $rb->sortByDesc('fantasy_points_acme')->first();
            $players_array['rec'] = $rec->sortByDesc('fantasy_points_acme')->first();

            //$players_array  		= $collection->sortByDesc('fantasy_points_acme')->take(3);
            //$players_array  		= $players_array->values()->all();
        }

        return response()->json($players_array);
    }

    public function getScoringDetails(Request $request)
    {
        $game_key = $request->game_key;
        $score_details = Score::leftJoin('team as t', function ($join) {
            $join->on('t.key', '=', 'score.away_team');
            $join->orOn('t.key', '=', 'score.home_team');
        })
                            ->where('game_key', $game_key)->with(['scorePlay'])->get();
        $gameArray = [];
        if (! empty($score_details)) {
            foreach ($score_details as $skey=>$sval) {
                $scorePlays = $sval->scorePlay;
                $scorePlays = collect($scorePlays);
                $sorted = $scorePlays->sortByDesc('quarter');
                if ($sval->home_team == $sval->key) {
                    $gameArray['home_logo_url'] = $sval->wikipedia_logo_url;
                }
                if ($sval->away_team == $sval->key) {
                    $gameArray['away_logo_url'] = $sval->wikipedia_logo_url;
                }
                $scoreArray = [];
                for ($i = 1; $i <= 5; $i++) {
                    $scoreArray[$i] = [];
                }
                if (! empty($sorted)) {
                    foreach ($sorted as $key=>$value) {
                        $player_desc = strtolower($value->play_description);
                        if (strstr($player_desc, 'touchdown')) {
                            $value->play_title = 'TOUCHDOWN';
                        } elseif (strstr($player_desc, 'goal')) {
                            $value->play_title = 'FIELD GOAL';
                        } else {
                            $value->play_title = 'Point After TD';
                        }
                        if ($value->team == $sval->key) {
                            $value->team_logo = $sval->wikipedia_logo_url;
                        }
                        $scoreArray[$value->quarter][] = $value;
                        /* if($score_details->away_team ==  $value->team)
                            $returnArray[$value->quarter]['awayTeam'][]	= $value;
                        if($score_details->home_team ==  $value->team)
                            $returnArray[$value->quarter]['homeTeam'][]	= $value; */
                    }
                }
            }
        }
        $return['gameArray'] = $gameArray;
        $return['scoreArray'] = $scoreArray;

        return response()->json($return);
    }

    public function getTeamPlayerStat(Request $request)
    {
        $game_key = $request->game_key;
        $player_game = PlayerGame::select('position', 'home_or_away', 'game_key', 'passing_yards', 'passing_touchdowns', 'passing_interceptions', 'rushing_attempts', 'rushing_yards', 'rushing_touchdowns', 'receptions', 'receiving_yards', 'receiving_touchdowns', 'short_name', 'passing_completions', 'passing_attempts', 'rushing_long', 'receiving_targets', 'receptions', 'receiving_long', 'player_game.team', 't.city', 't.key', 't.wikipedia_logo_url')
                            ->leftJoin('team as t', function ($join) {
                                $join->on('t.key', '=', 'player_game.team');
                            })
                            ->where('game_key', $game_key)
                            ->get();
        //dd($player_game);
        $players_array = $players_details = [];
        if (! empty($player_game) && count($player_game) > 0) {
            $collection = collect($player_game);
            $qb = $collection->where('position', 'QB');
            $rb = $collection->where('position', 'RB');
            $rec = $collection->whereIn('position', ['RB', 'WR', 'TE']);

            $players_array['team_details']['home'] = $collection->where('home_or_away', 'HOME')->first();
            $players_array['team_details']['away'] = $collection->where('home_or_away', 'AWAY')->first();
            $players_array['home_team']['pass'] = $qb->where('home_or_away', 'HOME')->where('passing_attempts', '>', 0)->sortByDesc('passing_yards')->values()->all();
            $players_array['away_team']['pass'] = $qb->where('home_or_away', 'AWAY')->where('passing_attempts', '>', 0)->sortByDesc('passing_yards')->values()->all();
            $players_array['home_team']['rush'] = $rb->where('home_or_away', 'HOME')->where('rushing_attempts', '>', 0)->sortByDesc('rushing_yards')->values()->all();
            $players_array['away_team']['rush'] = $rb->where('home_or_away', 'AWAY')->where('rushing_attempts', '>', 0)->sortByDesc('rushing_yards')->values()->all();
            $players_array['home_team']['rec'] = $rec->where('home_or_away', 'HOME')->where('receiving_targets', '>', 0)->sortByDesc('receiving_yards')->values()->all();
            $players_array['away_team']['rec'] = $rec->where('home_or_away', 'AWAY')->where('receiving_targets', '>', 0)->sortByDesc('receiving_yards')->values()->all();
        }

        return response()->json($players_array);
    }
}
