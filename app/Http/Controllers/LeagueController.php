<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DraftOrder;
use App\Models\FantasyTeam;
use App\Models\FantasyTeamsPlayerTransaction;
use App\Models\League;
use App\Models\LeagueCommissioner;
use App\Models\LeagueGame;
use App\Models\LeagueInvitation;
use App\Models\LeagueSchedule;
use App\Models\LeagueTeamRanking;
use App\Models\SystemSetting;
use App\Models\User;
use App\Notifications\FantasyLeagueInvitation;
use Auth;
use Carbon\Carbon;
use Helper;
use Illuminate\Http\Request;
use Session;

class LeagueController extends Controller
{
    /**
     * Show the Leaque.
     *
     * @return Response
     */
    public function showLeague()
    {
        return view('league.index');
    }

    /**
     * Show the Leaque.
     *
     * @return Response
     */
    public function systemSetting()
    {
        return view('league.index');
    }

    /**
     * Show the Leaque home.
     *
     * @return Response
     */
    public function showLeagueHome(Request $request)
    {
        if (isset($request->msg)) {
            Session::flash('success', 'Thank you for signing up! Payment completed successfully!');
        }

        return view('league.home');
    }

    /**
     * Show the Leaque home.
     *
     * @return Response
     */
    public function getLeagueTeam()
    {
        $league_team = [];
        $userId = Auth::user()->id;
        $userteam = FantasyTeam::where('user_id', $userId)->first();
        $allteams = FantasyTeam::with(['teamOwner'])->where('league_id', $userteam->league_id)->get();
        $league_team['userteam'] = $userteam;
        $league_team['allteams'] = $allteams;

        return response()->json($league_team);
    }

    /**
     * Show the leaque Schedule.
     *
     * @return Response
     */
    public function showLeagueSchedule()
    {
        return view('league.schedule');
    }

    /**
     * Show the leaque Transactions.
     *
     * @return Response
     */
    public function showLeagueTransactions()
    {
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

        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();
        $fantasy_teams = FantasyTeam::select('id as value', 'name as text')
                                ->where('league_id', $league->id)->get()->toJson();

        $transactions = FantasyTeamsPlayerTransaction::where('league_id', $league->id)
                            ->whereIn('player_transaction_type_id', [1, 2])  // Only show "add" and "drop" trans
                            ->with(['fantasyPlayer'])
                            ->with(['fantasyTeam'])
                            ->orderBy('id')
                            ->get()->toJson();

        //dd($transactions);

        return view('league.transactions')->with('week', $week)->with('teams', $fantasy_teams)->with('transactions', $transactions);
    }

    /**
     * Show the leaque Transactions.
     *
     * @return Response
     */
    public function showTask()
    {
        $is_co_commissioner = 0;
        $commissioner = 0;
        $league_task = [];
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();
        $fantasy_teams = FantasyTeam::where('league_id', $league->id)->get()->count();
        $leagueCom = User::find($userId)->leagues;

        $userId = Auth::user()->id;
        $fantasy_teams = FantasyTeam::where('league_id', $league->id)->get()->count();

        $commissioner = LeagueCommissioner::where('league_id', $league->id)->get();
        $ids = array_column($commissioner->toArray(), 'user_id');
        //dd($ids);
        $isCommissioner = false;
        /* if(!empty($commissioner)){
        } */
        if (in_array($userId, $ids) || $userId == $commissioner->is_co_commissioner) {
            $isCommissioner = true;
        }

        $league_task['commissioner'] = $isCommissioner;
        $league_task['is_co_commissioner'] = $isCommissioner;

        $systemSettings = SystemSetting::find(1);
        $league_task['invite_code'] = url("/register/{$league->invite_code}");
        $league_task['teams_count'] = $fantasy_teams;
        $league_task['draft_completed'] = (! empty($league->draft_completed)) ? $league->draft_completed : '0';
        $league_task['draft_started'] = $league->draft_started;
        $league_task['week'] = $systemSettings->week;
        $seasonTypeArray = Helper::$seasonTypes;
        $league_task['season_type'] = $seasonTypeArray[$systemSettings->season_type];
        $user = User::find(auth()->user()->id);
        $league_task['user'] = $user;

        return response()->json($league_task);
    }

    public function allteam_rank()
    {
        $team_id = 1;
        $week = 2;
        $season = 2018;
        $season_type = 1;

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

        $league = League::all();

        if (! empty($league)) {
            foreach ($league  as $key=>$value) {
                $fantasy_teams = FantasyTeam::where('league_id', $value->id)->get();

                if (! empty($fantasy_teams)) {
                    foreach ($fantasy_teams  as $fkey=>$fvalue) {
                        $result = Helper::getTeamRankUpToWeek($value->id, $fvalue->id, $week);

                        $win = $result['team_win_loss']['total_win'];
                        $loss = $result['team_win_loss']['total_loss'];
                        $tie = $result['team_win_loss']['total_tie'];
                        $sim_win = $result['teamSim_win_loss']['total_win'];
                        $sim_loss = $result['teamSim_win_loss']['total_loss'];
                        $sim_tie = $result['teamSim_win_loss']['total_tie'];
                        $sim_overall_pts = $result['sim_overall_pts'];
                        $coach_score = $result['coach_score'];
                        $head_to_head_pts = $result['team_scores']['head_to_head_pts'];
                        $points_against = $result['team_scores']['points_against'];
                        $points_for = $result['team_scores']['points_for'];
                        $points_for_pts = $result['team_scores']['points_for_pts'];

                        $sim_overall_rank = 0;

                        $data = [
                            'league_id'      	=> $value->id,
                            'fatasy_team_id' 	=> $fvalue->id,
                            'season' 			=> $season,
                            'season_type' 		=> $season_type,
                            'week' 				=> $week,
                            'is_finished' 		=> true,
                            'win' 				=> $win,
                            'loss' 				=> $loss,
                            'tie' 				=> $tie,
                            'head_to_head_pts' 	=> $head_to_head_pts,
                            'points_against' 	=> $points_against,
                            'points_for' 		=> $points_for,
                            'points_for_pts' 	=> $points_for_pts,
                            'sim_overall_win' 	=> $sim_win,
                            'sim_overall_loss' 	=> $sim_loss,
                            'sim_overall_tie' 	=> $sim_tie,
                            'sim_overall_pts' 	=> $sim_overall_pts,
                            'sim_overall_rank' 	=> $sim_overall_rank,
                            'tournament_rank' 	=> 0,
                            'tournament_pts' 	=> 0,
                            'coach_score' 		=> $coach_score,
                            'overall_coach_rank'=> 1,

                        ];

                        $model = LeagueTeamRanking::updateOrCreate(
                            ['season'   => $season, 'season_type'=> $season_type, 'week'=> $week, 'league_id'=>$value->id, 'fatasy_team_id'=>$fvalue->id],
                            $data
                        );
                    }

                    $leage_rank = LeagueTeamRanking::where('season', $season)->where('season_type', $season_type)->where('week', $week)
                                                                ->where('league_id', $value->id)->orderBy('coach_score', 'desc')->get()->toArray();

                    if (! empty($leage_rank)) {
                        $i = 1;
                        foreach ($leage_rank as $key=>$val) {
                            $leage_team_rank = LeagueTeamRanking::find($val['id']);
                            $leage_team_rank->overall_coach_rank = $i;
                            $leage_team_rank->save();
                            $i++;
                        }
                    }
                }
            }
        }
    }

    /**
     * Show the league details.
     *
     * @return Response
     */
    public function showLeagueDetails()
    {
        $userId = Auth::user()->id;
        $commissioner = LeagueCommissioner::where('user_id', $userId)->orWhere('is_co_commissioner', $userId)->first();
        $league = [];
        if (! empty($commissioner)) {
            $league = League::where('id', $commissioner->league_id)->first();
        }

        return response()->json($league);
    }

    /**
     * Show the league waivers.
     *
     * @return Response
     */
    public function showWaivers()
    {
        $userId = Auth::user()->id;
        $commissioner = LeagueCommissioner::where('user_id', $userId)->orWhere('is_co_commissioner', $userId)->first();
        $league = [];
        if (! empty($commissioner)) {
            $league = League::where('id', $commissioner->league_id)->first();
        }

        $systemSettings = SystemSetting::find(1);
        //dd($systemSettings);
        $season = [$systemSettings->season];
        $seasonType = $systemSettings->season_type;
        $week = $systemSettings->week;
        $systemSeason = [$systemSettings->season];

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

        $waivers = \App\Models\FantasyTeamsPlayerTransaction::with(['fantacyPlayer'])
            ->where('league_id', $league->id)
            ->where('week', $week)
            ->whereIn('player_transaction_type_id', [5])
            ->with(['fantacyPlayer.fantasyTeamOwnedBy' => $filterPlayerTeamRoster])
            ->with('dropFantasyPlayer')
            ->with(['fantasyTeam'])
            ->with(['fantasyTeam.leagueTeamRanking' => function ($q) {
                $q->orderBy('overall_coach_rank');
            }])
            ->get();

        return response()->json($waivers);
    }

    public function update(Request $request)
    {
        //return response()->json($request);
        $this->validate($request, [
            'name' => 'required|max:255',
            'season_type' => 'required',
            'season' => 'required',
            'week' => 'required',
            //'allow_team_qb' => 'required',
            //'draft_date' => 'required',
        ]);

        $user = Auth::user();
        $fantasyTeam = $user->teams->first();
        $league = $fantasyTeam->league;
        $commissioner = $league->leagueCommissioner->first();

        if ($commissioner->user_id == $user->id) {
            // $league->number_of_teams	= $request->number_of_teams;
            // $league->season				= $request->season;
            // $league->season_type		= $request->season_type;
            // $league->week               = $request->week;
            $league->name = $request->name;
            $league->draft_pick_max_time = $request->draft_pick_max_time;
            $league->online_draft = $request->online_draft;
            $league->timezone = session('timezone');
            if ($request->online_draft) {
                $date = Carbon::parse($request->draft_date);
                //$f_date                 = $date->format('Y-m-d H:i');
                //dd($date);
                $league->draft_date = $date;
            } else {
                $league->draft_date = null;
            }
            $league->save();
        }

        //Update this to support levels of commissioner
        if (! empty($request->is_co_commissioner)) {
            LeagueCommissioner::updateOrCreate(
                ['is_co_commissioner' => 1, 'league_id' => $league->id],
                ['price' => 99, 'discounted' => 1, 'user_id' => $request->is_co_commissioner]
            );
        }
    }

    public function startleaque(Request $request)
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $leagueDetails = League::find($team->league_id);
        $settings = SystemSetting::find(1);
        if (! empty($leagueDetails)) {
            $override_system = $leagueDetails->override_system;
            if ($override_system) {
                $week = $leagueDetails->week;
            } else {
                $week = $settings->week;
            }
        }

        $fantasy_team_has_fantasy_player = 0;
        if (! empty($team->league_id)) {
            $fantasy_player_transaction = FantasyTeamsPlayerTransaction::select('id', 'fantasy_player_id', 'fantasy_team_id')
                                                                            ->where('league_id', $team->league_id)
                                                                            ->where('active', 1)->get();
            $collection = collect($fantasy_player_transaction);
            $grouped = $collection->groupBy('fantasy_team_id');
            $groupCount = $grouped->map(function ($item, $key) {
                return collect($item)->count();
            });
            $fantasy_team_has_fantasy_player = count($groupCount);
        }

        if ($fantasy_team_has_fantasy_player == 12) {

            //call the GenerateLeagueTeamNumbers console command
            \Artisan::call('GenerateLeagueTeamNumbers', ['--league_id' => $team->league_id]);

            //call the GenerateLeagueSchedules console command
            \Artisan::call('GenerateLeagueSchedules', ['--league_id' => $team->league_id]);
            $leagueDetails->draft_completed = 1;
            $leagueDetails->draft_started = 1;
            $leagueDetails->save();
        }

        return 1;
    }

    public function clearteam(Request $request)
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $leagueDetails = League::find($team->league_id);
        $settings = SystemSetting::find(1);

        if (! empty($leagueDetails)) {
            $override_system = $leagueDetails->override_system;
            if ($override_system) {
                $week = $leagueDetails->week;
            } else {
                $week = $settings->week;
            }
        }

        $transaction_query = FantasyTeamsPlayerTransaction::where('active', 1)->Orwhere('bench', 1);
        $transaction = $transaction_query->where('player_transaction_type_id', 1)->where('league_id', $team->league_id)->where('week', $week)->get();

        if (! empty($transaction)) {
            foreach ($transaction as $list) {
                $list->active = 0;
                $list->save();

                $message = 'Player has been removed successfully';
                $status = 1;
            }

            //call the FillFantasyTeamsRoster console command
            // \Artisan::call('FillFantasyTeamsRoster');
            \Artisan::call('FillFantasyTeamsRoster', ['--league_id'=>$team->league_id]);
        }

        $returnArray['message'] = $message;
        $returnArray['status'] = $status;

        return response()->json($returnArray);
    }

    public function systemUpdate(Request $request)
    {
        $this->validate($request, [

            'season_type' => 'required',
            'season' => 'required',
            'week' => 'required',

        ]);
        $setting_data = [
            'season'					=> $request->season,
            'season_type'     			=> $request->season_type,
            'week'     					=> $request->week,
        ];

        $model = \App\Models\SystemSetting::updateOrCreate(
            ['id'   => 1],
            $setting_data
        );
    }

    /**
     * Show the first division list.
     *
     * @return Response
     */
    public function showFirstDivision()
    {
        $userId = Auth::user()->id;
        $league = FantasyTeam::select('league_id')->where('user_id', $userId)->first();
        $year = date('Y');
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $year = $systemSettings->season;
        }
        $divisions = DraftOrder::selectRaw('f.name as teamName,fantasy_team_id,f.logo_url as logo')
                        ->leftJoin('fantasy_teams as f', 'f.id', '=', 'draft_order.fantasy_team_id')
                        ->where('round', 1)->whereIn('round_overall_pick', [1, 2, 3])
                        ->where('draft_order.league_id', $league->league_id)
                        ->whereIn('round_overall_pick', [1, 2, 3])
                        ->orderBy('round_overall_pick')->get();
        $divisions = $divisions->toArray();
        $returnArray = [];
        if (! empty($divisions)) {
            foreach ($divisions as $key=>$val) {
                $winCount = LeagueGame::where('team_id', $val['fantasy_team_id'])->where('year', $year)->where('win', 1)->count();
                $lossCount = LeagueGame::where('team_id', $val['fantasy_team_id'])->where('year', $year)->where('loss', 1)->count();
                $tieCount = LeagueGame::where('team_id', $val['fantasy_team_id'])->where('year', $year)->where('tie', 1)->count();
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
                $pf = LeagueGame::where('team_id', $val['fantasy_team_id'])->where('year', $year)->sum('team_score');
                $back = 0;
                $pa = LeagueGame::where('team_id', $val['fantasy_team_id'])->where('year', $year)->sum('opponent_score');

                $val['W'] = $winCount;
                $val['L'] = $lossCount;
                $val['T'] = $tieCount;
                $val['PCT'] = $pct;
                $val['GB'] = $gb;
                $val['STREAK'] = $streak;
                $val['DIV'] = $div;
                $val['WKS'] = $wks;
                $val['PF'] = number_format($pf, 2);
                $val['BACK'] = $back;
                $val['PA'] = number_format($pa, 2);
                if ($val['logo'] != null) {
                    $logo = $val['logo'];
                } else {
                    $logo = 'https://cdn.head-fi.org/g/2283245_l.jpg';
                }
                $returnArray[$key] = $val;
                $returnArray[$key]['teamName'] = $val['teamName'];
                $returnArray[$key]['logo'] = $logo;
            }
        }

        $returnArray = (array_values($returnArray));
        $PCT = array_column($returnArray, 'PCT');
        $PF = array_column($returnArray, 'PF');

        array_multisort($PCT, SORT_DESC, $PF, SORT_DESC, $returnArray);

        $response['name'] = 'NORTH DIVISION';
        $response['teams'] = $returnArray;

        return response()->json($response);
    }

    /**
     * Show the division list.
     *
     * @return Response
     */
    public function showDivisions()
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();

        $league = League::where('id', $team->league_id)->first();
        $year = date('Y');
        $systemSettings = SystemSetting::find(1);
        if ($systemSettings->season) {
            $year = $systemSettings->season;
        }

        /*$divisions		=	DraftOrder::selectRaw("round_overall_pick,fantasy_team_id,f.name as teamName,f.logo_url as logo")
                            ->leftJoin('fantasy_teams as f','f.id','=','draft_order.fantasy_team_id')
                            ->where('round',1)
                            ->where('draft_order.league_id',$team->league_id)
                            ->whereIn('round_overall_pick',array(1,2,3,4,5,6,7,8,9,10,11,12))
                            ->orderBy('round_overall_pick')->get();
        */
        $divisions = FantasyTeam::where('league_id', $team->league_id)->get();

        $divisions = $divisions->toArray();
        $user_teaam_division = '';
        $returnArray = $northArray = $southArray = $westArray = $eastArray = [];
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

                $val['W'] = $winCount;
                $val['L'] = $lossCount;
                $val['T'] = $tieCount;
                $val['PCT'] = $pct;
                $val['GB'] = $gb;
                $val['STREAK'] = $streak;
                $val['DIV'] = $div;
                $val['WKS'] = $wks;
                $val['PF'] = number_format($pf, 2);
                $val['BACK'] = $back;
                $val['PA'] = number_format($pa, 2);
                if ($val['logo_url'] != null) {
                    $logo = $val['logo_url'];
                } else {
                    $logo = 'https://cdn.head-fi.org/g/2283245_l.jpg';
                }
                if (in_array($val['league_team_number'], [1, 2, 3])) {
                    $northArray[$key] = $val;
                    $northArray[$key]['teamName'] = $val['name'];
                    $northArray[$key]['logo'] = $logo;
                } elseif (in_array($val['league_team_number'], [4, 5, 6])) {
                    $southArray[$key] = $val;
                    $southArray[$key]['teamName'] = $val['name'];
                    $southArray[$key]['logo'] = $logo;
                } elseif (in_array($val['league_team_number'], [7, 8, 9])) {
                    $westArray[$key] = $val;
                    $westArray[$key]['teamName'] = $val['name'];
                    $westArray[$key]['logo'] = $logo;
                } elseif (in_array($val['league_team_number'], [10, 11, 12])) {
                    $eastArray[$key] = $val;
                    $eastArray[$key]['teamName'] = $val['name'];
                    $eastArray[$key]['logo'] = $logo;
                }
            }

            $user_team_id = $team->id;

            $north_collection = collect($northArray);
            $north_filtered = $north_collection->where('id', $user_team_id);

            $south_collection = collect($southArray);
            $south_filtered = $south_collection->where('id', $user_team_id);

            $west_collection = collect($westArray);
            $west_filtered = $west_collection->where('id', $user_team_id);

            $east_collection = collect($eastArray);
            $east_filtered = $east_collection->where('id', $user_team_id);

            if ($north_filtered->isNotEmpty()) {
                $user_teaam_division = 'north';
            }
            if ($south_filtered->isNotEmpty()) {
                $user_teaam_division = 'south';
            }
            if ($west_filtered->isNotEmpty()) {
                $user_teaam_division = 'west';
            }
            if ($east_filtered->isNotEmpty()) {
                $user_teaam_division = 'east';
            }

            $northArray = (array_values($northArray));
            $PCT = array_column($northArray, 'PCT');
            $PF = array_column($northArray, 'PF');
            array_multisort($PCT, SORT_DESC, $PF, SORT_DESC, $northArray);

            $response['north']['name'] = 'NORTH DIVISION';
            $response['north']['teams'] = array_values($northArray);

            $southArray = (array_values($southArray));
            $PCT = array_column($southArray, 'PCT');
            $PF = array_column($southArray, 'PF');
            array_multisort($PCT, SORT_DESC, $PF, SORT_DESC, $southArray);

            $response['south']['name'] = 'SOUTH DIVISION';
            $response['south']['teams'] = array_values($southArray);
            $response['west']['name'] = 'WEST DIVISION';

            $westArray = (array_values($westArray));
            $wPCT = array_column($westArray, 'PCT');
            $wPF = array_column($westArray, 'PF');
            array_multisort($wPCT, SORT_DESC, $wPF, SORT_DESC, $westArray);

            $response['west']['teams'] = array_values($westArray);
            $response['east']['name'] = 'EAST DIVISION';
            $eastArray = (array_values($eastArray));
            $ePCT = array_column($eastArray, 'PCT');
            $ePF = array_column($eastArray, 'PF');
            array_multisort($ePCT, SORT_DESC, $ePF, SORT_DESC, $eastArray);
            $response['east']['teams'] = array_values($eastArray);

            if ($user_teaam_division) {
                $this->move_to_top($response, $user_teaam_division);
            }

            return response()->json(array_values($response));
        } else {
            $draft_date = $league->draft_date;
            $draft_tz = $league->timezone; //need to ensure carbon knows the $draft_date time is for the timezone. that way it updates it correctly with session timezone.
            $draft_tz = 'America/Chicago';
            $date = Carbon::parse($draft_date)->timezone($draft_tz);

            $f_date = $date->format('m/d/Y h:i a');

            if ($draft_date) {
                $response['error'] = 'Your league has not held a draft yet. Your Draft is scheduled for '.$f_date.' Central Time.';
            } else {
                $response['error'] = 'Your league has not held a draft yet. Your league has not set a draft date yet';
            }
            //$f_date				= date('d/m/Y h:i a',strtotime($draft_date));
            //$response['error'] 	= 'Your league has not held a draft yet. Your Draft is scheduled for '.$f_date.' Central Time.';
            return response()->json($response);
        }
    }

    private function move_to_top(&$array, $key)
    {
        $temp = [$key => $array[$key]];
        unset($array[$key]);
        $array = $temp + $array;
    }

    public function leaqueTeamRank(Request $request)
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();

        $systemSettings = SystemSetting::find(1);

        if (isset($request->week)) {
            $week = $request->week;
        } else {
            $week = $systemSettings->week;
        }

        if (isset($request->season)) {
            $season = $request->season;
        } elseif ($systemSettings->season) {
            $season = $systemSettings->season;
        }

        if ($systemSettings->season_type) {
            $season_type = $systemSettings->season_type;
        }

        $current_week = $systemSettings->week;

        if ($season_type == 3) {
            $current_week = 17;
            $season_type = 1;
        }

        if ($current_week == $week) {
            $check_current_week = LeagueTeamRanking::select('week')
                                ->where('season', $season)
                                ->where('league_id', $team->league_id)
                                ->where('season_type', $season_type)
                                ->where('week', $current_week)
                                ->first();

            if ($check_current_week) {
                $week = $check_current_week->week;
            } else {
                $week = $week - 1;
            }
        }

        $divisions = LeagueTeamRanking::leftJoin('fantasy_teams as f', 'f.id', '=', 'league_team_rankings.fatasy_team_id')
                            ->where('league_team_rankings.league_id', $team->league_id)
                            ->where('season', $season)
                            ->where('season_type', $season_type)
                            ->where('week', $week)
                            ->orderBy('league_team_rankings.overall_coach_rank', 'asc')
                            ->get();
        $divisions = $divisions->toArray();

        //dd($divisions);

        $returnArray = [];
        if (! empty($divisions)) {
            foreach ($divisions as $key=>$val) {
                $previous_rank = 'NA';

                $previous_week = $week - 1;

                if ($previous_week > 0) {
                    $previous_rank = LeagueTeamRanking::select('overall_coach_rank')
                                                        ->where('fatasy_team_id', $val['fatasy_team_id'])
                                                        ->where('season', $season)
                                                        ->where('season_type', $season_type)
                                                        ->where('week', $previous_week)
                                                        ->where('league_id', $team->league_id)
                                                        ->first();

                    if ($previous_rank) {
                        $previous_rank = $previous_rank->overall_coach_rank;
                    }
                }
                $winCount = $val['win'];
                $lossCount = $val['loss'];
                $tieCount = $val['tie'];
                $total = $winCount + $lossCount + $tieCount;

                if ($total > 0) {
                    $pct = $winCount / ($winCount + $lossCount + $tieCount);
                } else {
                    $pct = 0;
                }

                $pct = number_format($pct, 3);

                $sim_winCount = $val['sim_overall_win'];
                $sim_lossCount = $val['sim_overall_loss'];
                $sim_tieCount = $val['sim_overall_tie'];
                $sim_total = $sim_winCount + $sim_lossCount + $sim_tieCount;

                if ($sim_total > 0) {
                    $sim_pct = $sim_winCount / ($sim_winCount + $sim_lossCount + $sim_tieCount);
                } else {
                    $sim_pct = 0;
                }

                $points_for = $val['points_for'];
                $average = $points_for / $week;
                $points_for_pts = $val['points_for_pts'];
                $val['W'] = $winCount;
                $val['L'] = $lossCount;
                $val['T'] = $tieCount;
                $val['PCT'] = number_format($pct, 3);
                $val['average'] = $points_for.'/'.number_format($average, 2);
                $val['Prv'] = $previous_rank;
                $val['over_all_record'] = 1;
                $val['overall_pts'] = $val['sim_overall_pts'];
                $val['head_to_head_pts_val'] = $val['head_to_head_pts'];
                $val['head_to_head_pts'] = $winCount.'-'.$lossCount.'-'.$tieCount.' / '.$pct;
                $val['sim_over_all_recod'] = $sim_winCount.'-'.$sim_lossCount.'-'.$sim_tieCount.' / '.number_format($sim_pct, 3);
                $val['Pts'] = $val['points_for_pts'];
                $val['Tournament_Pts'] = $val['tournament_pts'];
                $val['POWER'] = $val['coach_score'];
                $val['Tournament'] = $val['tournament_rank'];

                if ($val['logo_url'] != null) {
                    $logo = $val['logo_url'];
                } else {
                    $logo = 'https://cdn.head-fi.org/g/2283245_l.jpg';
                }
                $returnArray[$key] = $val;
                $returnArray[$key]['TEAM']['teamName'] = $val['name'];
                $returnArray[$key]['TEAM']['logo'] = $logo;
            }
            // if ($week==17) {
            //     $returnArray	=(array_values($returnArray));
            //     $tournament_rank 			= array_column($returnArray, 'tournament_rank');
            //     array_multisort($tournament_rank, SORT_ASC, $returnArray);
            // }
            $response['teams'] = array_values($returnArray);

            return response()->json($response);
        } else {
            $draft_date = $league->draft_date;
            $draft_tz = $league->timezone; //need to ensure carbon knows the $draft_date time is for the timezone. that way it updates it correctly with session timezone.
            $draft_tz = 'America/Chicago';
            $date = Carbon::parse($draft_date)->timezone($draft_tz);

            $f_date = $date->format('m/d/Y h:i a');

            //$f_date				= date('d/m/Y h:i a',strtotime($draft_date));
            $response['error'] = 'Your league has not held a draft yet. Your Draft is scheduled for '.$f_date.' Central Time.';

            return response()->json($response);
        }
    }

    public function array_multi_sort($array, $on1, $on2, $order = SORT_ASC)
    {
        foreach ($array as $key=>$value) {
            $one_way_fares[$key] = $value[$on2];
            $return_fares[$key] = $value[$on1];
        }

        return array_multisort($return_fares, $order, $one_way_fares, $order, $array);
    }

    public function tournamentGraph(Request $request)
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league_id = $team->league_id;
        $systemSettings = SystemSetting::find(1);
        $week = $systemSettings->week;
        $year = $systemSettings->season;
        $season_type = $systemSettings->season_type;
        $week_sixteen = 16;

        //Show regular season data if we are in the post season.
        if ($season_type == 3) {
            $season_type = 2;
            $week = 17;
        }

        $national_conference_details = $american_conference_details = $championship_details = [];

        $north_division = LeagueSchedule::selectRaw('f.name as teamName,home_team_id as team_id')
                            ->leftJoin('fantasy_teams as f', 'f.id', '=', 'league_schedule.home_team_id')
                            ->where('league_schedule.league_id', $league_id)
                            ->where('league_schedule.year', $year)
                            ->where('league_schedule.week', 15)
                            ->where('league_schedule.reg_season_tourn_type', 'division_playoff_north')
                            ->get()->toArray();

        if ($north_division) {
            foreach ($north_division as $key=>$val) {
                $north_ids[] = $val['team_id'];
            }
        }

        $south_division = LeagueSchedule::selectRaw('f.name as teamName,home_team_id as team_id')
                            ->leftJoin('fantasy_teams as f', 'f.id', '=', 'league_schedule.home_team_id')
                            ->where('league_schedule.league_id', $league_id)
                            ->where('league_schedule.year', $year)
                            ->where('league_schedule.week', 15)
                            ->where('league_schedule.reg_season_tourn_type', 'division_playoff_south')
                            ->get()->toArray();

        if ($south_division) {
            foreach ($south_division as $key=>$val) {
                $south_ids[] = $val['team_id'];
            }
        }

        $east_division = LeagueSchedule::selectRaw('f.name as teamName,home_team_id as team_id')
                            ->leftJoin('fantasy_teams as f', 'f.id', '=', 'league_schedule.home_team_id')
                            ->where('league_schedule.league_id', $league_id)
                            ->where('league_schedule.year', $year)
                            ->where('league_schedule.week', 15)
                            ->where('league_schedule.reg_season_tourn_type', 'division_playoff_east')
                            ->get()->toArray();

        if ($east_division) {
            foreach ($east_division as $key=>$val) {
                $east_ids[] = $val['team_id'];
            }
        }

        $west_division = LeagueSchedule::selectRaw('f.name as teamName,home_team_id as team_id')
                            ->leftJoin('fantasy_teams as f', 'f.id', '=', 'league_schedule.home_team_id')
                            ->where('league_schedule.league_id', $league_id)
                            ->where('league_schedule.year', $year)
                            ->where('league_schedule.week', 15)
                            ->where('league_schedule.reg_season_tourn_type', 'division_playoff_west')
                            ->get()->toArray();

        if ($west_division) {
            foreach ($west_division as $key=>$val) {
                $west_ids[] = $val['team_id'];
            }
        }
        $national_conference = LeagueSchedule::selectRaw('home_team_id,away_team_id')
                                    ->where('league_id', $league_id)
                                    ->where('year', $year)
                                    ->where('week', $week_sixteen)
                                    ->where('reg_season_tourn_type', 'national_conference_championship')
                                    ->first();

        if ($national_conference) {
            $national_home_team = FantasyTeam::where('id', $national_conference->home_team_id)->first();
            $national_away_team = FantasyTeam::where('id', $national_conference->away_team_id)->first();

            $nationalHomeTeamResult = Helper::getConferenceChampionshipRank($national_conference->home_team_id, $year, 16);
            $nationalAwayTeamResult = Helper::getConferenceChampionshipRank($national_conference->away_team_id, $year, 16);

            //dd($nationalHomeTeamResult);

            $national_conference_details['national_home_team'] = array_merge($national_home_team->toArray(), $nationalHomeTeamResult);
            $national_conference_details['national_away_team'] = array_merge($national_away_team->toArray(), $nationalAwayTeamResult);
        }

        //dd($national_conference->home_team_id);
        $american_conference = LeagueSchedule::selectRaw('home_team_id,away_team_id')
                                ->where('league_schedule.league_id', $league_id)
                                ->where('league_schedule.year', $year)
                                ->where('league_schedule.week', $week_sixteen)
                                ->where('league_schedule.reg_season_tourn_type', 'american_conference_championship')
                                ->first();

        if ($american_conference) {
            $american_home_team = FantasyTeam::where('id', $american_conference->home_team_id)->first();
            $american_away_team = FantasyTeam::where('id', $american_conference->away_team_id)->first();

            $americanHomeTeamResult = Helper::getConferenceChampionshipRank($american_conference->home_team_id, $year, 16);
            $americanAwayTeamResult = Helper::getConferenceChampionshipRank($american_conference->away_team_id, $year, 16);

            $american_conference_details['american_home_team'] = array_merge($american_home_team->toArray(), $americanHomeTeamResult);
            $american_conference_details['american_away_team'] = array_merge($american_away_team->toArray(), $americanAwayTeamResult);
        }
        $league_championship = LeagueSchedule::selectRaw('home_team_id,away_team_id')
                                    ->where('league_schedule.league_id', $league_id)
                                    ->where('league_schedule.year', $year)
                                    ->where('league_schedule.week', 17)
                                    ->where('league_schedule.reg_season_tourn_type', 'league_championship')
                                    ->first();

        if ($league_championship) {
            if (in_array($league_championship->home_team_id, $north_ids)) {
                $championship_details['conference_home_team_division'] = 'north';
            } elseif (in_array($league_championship->home_team_id, $south_ids)) {
                $championship_details['conference_home_team_division'] = 'south';
            } elseif (in_array($league_championship->home_team_id, $east_ids)) {
                $championship_details['conference_home_team_division'] = 'east';
            } elseif (in_array($league_championship->home_team_id, $west_ids)) {
                $championship_details['conference_home_team_division'] = 'west';
            }

            if (in_array($league_championship->away_team_id, $north_ids)) {
                $championship_details['conference_away_team_division'] = 'north';
            } elseif (in_array($league_championship->away_team_id, $south_ids)) {
                $championship_details['conference_away_team_division'] = 'south';
            } elseif (in_array($league_championship->away_team_id, $east_ids)) {
                $championship_details['conference_away_team_division'] = 'east';
            } elseif (in_array($league_championship->away_team_id, $west_ids)) {
                $championship_details['conference_away_team_division'] = 'west';
            }

            $championship_home_team = FantasyTeam::where('id', $league_championship->home_team_id)->first();
            $championship_away_team = FantasyTeam::where('id', $league_championship->away_team_id)->first();

            $championship_details['conference_home_team'] = $championship_home_team->name;
            $championship_details['conference_away_team'] = $championship_away_team->name;
        }
        $toilet_bowl_array = $northArray = $southArray = $westArray = $eastArray = [];

        $toilet_bowl = LeagueSchedule::selectRaw('home_team_id ,away_team_id')
                            ->where('league_schedule.league_id', $league_id)
                            ->where('league_schedule.year', $year)
                            ->where('league_schedule.week', 17)
                            ->where('league_schedule.reg_season_tourn_type', 'toilet_bowl')
                            ->get();

        $toilet_teams = [];
        $i = 0;
        foreach ($toilet_bowl as $key=>$val) {
            $toilet_teams[$val['home_team_id']] = $val['home_team_id'];
            $toilet_teams[$val['away_team_id']] = $val['away_team_id'];
            $i++;
        }
        $returnArray = [];
        $i = 0;
        foreach ($toilet_teams as $key=>$val) {
            $fantacy_teams = FantasyTeam::where('id', $val)->first();
            if (in_array($val, $north_ids)) {
                $returnArray[$i]['team_id'] = $val;
                $returnArray[$i]['teamName'] = $fantacy_teams->name;
                $returnArray[$i]['teamDivision'] = 'north';
            } elseif (in_array($val, $south_ids)) {
                $returnArray[$i]['team_id'] = $val;
                $returnArray[$i]['teamName'] = $fantacy_teams->name;
                $returnArray[$i]['teamDivision'] = 'south';
            } elseif (in_array($val, $east_ids)) {
                $returnArray[$i]['team_id'] = $val;
                $returnArray[$i]['teamName'] = $fantacy_teams->name;
                $returnArray[$i]['teamDivision'] = 'east';
            } elseif (in_array($val, $west_ids)) {
                $returnArray[$i]['team_id'] = $val;
                $returnArray[$i]['teamName'] = $fantacy_teams->name;
                $returnArray[$i]['teamDivision'] = 'west';
            }
            $i++;
        }

        $toilet_bowl_array = array_values($returnArray);
        $PCT = array_column($toilet_bowl_array, 'teamDivision');
        array_multisort($PCT, SORT_ASC, $toilet_bowl_array);

        $national_conference = LeagueSchedule::selectRaw('home_team_id ,away_team_id')
                        ->where('league_schedule.league_id', $league_id)
                        ->where('league_schedule.year', $year)
                        ->where('league_schedule.week', 16)
                        ->where('league_schedule.reg_season_tourn_type', 'national_conference_cons_round_1')
                        ->get();

        $national_conference_teams = [];
        $i = 0;
        foreach ($national_conference as $key=>$val) {
            $national_conference_teams[$val['home_team_id']] = $val['home_team_id'];
            $national_conference_teams[$val['away_team_id']] = $val['away_team_id'];
            $i++;
        }

        $i = 0;
        $returnArray = [];
        foreach ($national_conference_teams as $key=>$val) {
            $fantacy_teams = FantasyTeam::where('id', $val)->first();
            if (in_array($val, $north_ids)) {
                $returnArray[$i]['team_id'] = $val;
                $returnArray[$i]['teamName'] = $fantacy_teams->name;
                $returnArray[$i]['teamDivision'] = 'north';
            } elseif (in_array($val, $south_ids)) {
                $returnArray[$i]['team_id'] = $val;
                $returnArray[$i]['teamName'] = $fantacy_teams->name;
                $returnArray[$i]['teamDivision'] = 'south';
            } elseif (in_array($val, $east_ids)) {
                $returnArray[$i]['team_id'] = $val;
                $returnArray[$i]['teamName'] = $fantacy_teams->name;
                $returnArray[$i]['teamDivision'] = 'east';
            } elseif (in_array($val, $west_ids)) {
                $returnArray[$i]['team_id'] = $val;
                $returnArray[$i]['teamName'] = $fantacy_teams->name;
                $returnArray[$i]['teamDivision'] = 'west';
            }
            $i++;
        }

        $national_conference_best_teams = array_values($returnArray);

        $american_conference = LeagueSchedule::selectRaw('home_team_id ,away_team_id')
                        ->where('league_schedule.league_id', $league_id)
                        ->where('league_schedule.year', $year)
                        ->where('league_schedule.week', 16)
                        ->where('league_schedule.reg_season_tourn_type', 'american_conference_cons_round_1')
                        ->get();

        $american_conference_teams = [];
        $i = 0;
        foreach ($american_conference as $key=>$val) {
            $american_conference_teams[$val['home_team_id']] = $val['home_team_id'];
            $american_conference_teams[$val['away_team_id']] = $val['away_team_id'];
            $i++;
        }

        $i = 0;
        $returnArray = [];
        foreach ($american_conference_teams as $key=>$val) {
            $fantacy_teams = FantasyTeam::where('id', $val)->first();
            if (in_array($val, $north_ids)) {
                $returnArray[$i]['team_id'] = $val;
                $returnArray[$i]['teamName'] = $fantacy_teams->name;
                $returnArray[$i]['teamDivision'] = 'north';
            } elseif (in_array($val, $south_ids)) {
                $returnArray[$i]['team_id'] = $val;
                $returnArray[$i]['teamName'] = $fantacy_teams->name;
                $returnArray[$i]['teamDivision'] = 'south';
            } elseif (in_array($val, $east_ids)) {
                $returnArray[$i]['team_id'] = $val;
                $returnArray[$i]['teamName'] = $fantacy_teams->name;
                $returnArray[$i]['teamDivision'] = 'east';
            } elseif (in_array($val, $west_ids)) {
                $returnArray[$i]['team_id'] = $val;
                $returnArray[$i]['teamName'] = $fantacy_teams->name;
                $returnArray[$i]['teamDivision'] = 'west';
            }
            $i++;
        }

        $american_conference_best_teams = array_values($returnArray);

        $cons_finals = LeagueSchedule::selectRaw('home_team_id ,away_team_id')
                        ->where('league_schedule.league_id', $league_id)
                        ->where('league_schedule.year', $year)
                        ->where('league_schedule.week', 17)
                        ->where('league_schedule.reg_season_tourn_type', 'cons_finals')
                        ->get()->toArray();

        $cons_finals_team = [];
        $consTeamArray = [];
        $i = 0;
        foreach ($cons_finals as $key=>$val) {
            $cons_finals_team[$val['home_team_id']] = $val['home_team_id'];
            $cons_finals_team[$val['away_team_id']] = $val['away_team_id'];
            $i++;
        }

        $j = 0;
        foreach ($cons_finals_team as $key=>$val) {
            $fantacy_teams = FantasyTeam::where('id', $val)->first();
            if (in_array($val, $north_ids)) {
                $consTeamArray[$j]['team_id'] = $val;
                $consTeamArray[$j]['teamName'] = $fantacy_teams->name;
                $consTeamArray[$j]['teamDivision'] = 'north';
            } elseif (in_array($val, $south_ids)) {
                $consTeamArray[$j]['team_id'] = $val;
                $consTeamArray[$j]['teamName'] = $fantacy_teams->name;
                $consTeamArray[$j]['teamDivision'] = 'south';
            } elseif (in_array($val, $east_ids)) {
                $consTeamArray[$j]['team_id'] = $val;
                $consTeamArray[$j]['teamName'] = $fantacy_teams->name;
                $consTeamArray[$j]['teamDivision'] = 'east';
            } elseif (in_array($val, $west_ids)) {
                $consTeamArray[$j]['team_id'] = $val;
                $consTeamArray[$j]['teamName'] = $fantacy_teams->name;
                $consTeamArray[$j]['teamDivision'] = 'west';
            }
            $j++;
        }

        $cons_finals_team = array_values($consTeamArray);

        $tournament = LeagueSchedule::selectRaw('home_team_id ,away_team_id')
                        ->where('league_schedule.league_id', $league_id)
                        ->where('league_schedule.year', $year)
                        ->whereIn('league_schedule.week', [15, 16, 17])
                        ->where('league_schedule.reg_season_tourn_type', '<>', null)
                        ->get();

        $tournament_teams = [];
        $tournamentArray = [];
        $i = 0;
        foreach ($tournament as $key=>$val) {
            $tournament_teams[$val['home_team_id']] = $val['home_team_id'];
            $tournament_teams[$val['away_team_id']] = $val['away_team_id'];
            $i++;
        }
        $j = 0;
        foreach ($tournament_teams as $key=>$val) {
            $fantacy_teams = FantasyTeam::where('id', $val)->first();
            if (in_array($val, $north_ids)) {
                $tournamentArray[$j]['team_id'] = $val;
                $tournamentArray[$j]['teamName'] = $fantacy_teams->name;
                $tournamentArray[$j]['teamDivision'] = 'north';
            } elseif (in_array($val, $south_ids)) {
                $tournamentArray[$j]['team_id'] = $val;
                $tournamentArray[$j]['teamName'] = $fantacy_teams->name;
                $tournamentArray[$j]['teamDivision'] = 'south';
            } elseif (in_array($val, $east_ids)) {
                $tournamentArray[$j]['team_id'] = $val;
                $tournamentArray[$j]['teamName'] = $fantacy_teams->name;
                $tournamentArray[$j]['teamDivision'] = 'east';
            } elseif (in_array($val, $west_ids)) {
                $tournamentArray[$j]['team_id'] = $val;
                $tournamentArray[$j]['teamName'] = $fantacy_teams->name;
                $tournamentArray[$j]['teamDivision'] = 'west';
            }
            $j++;
        }
        $tournament_teams = array_values($tournamentArray);

        //Build array of all weekly statistics up to current week of season.
        for ($weekOfStats = 15; $weekOfStats <= $week; $weekOfStats++) {
            $response['north_teams']['week'][$weekOfStats] = Helper::getTeamWinLossTie($north_division, $year, $weekOfStats);
            $response['south_teams']['week'][$weekOfStats] = Helper::getTeamWinLossTie($south_division, $year, $weekOfStats);
            $response['east_teams']['week'][$weekOfStats] = Helper::getTeamWinLossTie($east_division, $year, $weekOfStats);
            $response['west_teams']['week'][$weekOfStats] = Helper::getTeamWinLossTie($west_division, $year, $weekOfStats);
        }

        $response['national_conference_teams'] = ['national_home_team' => '', 'national_away_team' => ''];
        $response['american_conference_teams'] = ['american_home_team' => '', 'american_away_team' => ''];
        $response['national_conference_consolation'] = [];
        $response['american_conference_consolation'] = [];
        $response['championship_teams'] = [];
        $response['consolation_finals'] = [];
        $response['toilet_bowl'] = [];
        $response['tournament_teams'] = [];

        if ($week >= 16) {
            //Week 16 Conference Championship
            $response['national_conference_teams'] = $national_conference_details;
            $response['american_conference_teams'] = $american_conference_details;
            //$response['national_conference_teams']['week'][16] = Helper::getChampionshipFinals($league_id, 16)['national_team'];

            //Week 16 Consolation Rounds
            $response['national_conference_consolation'] = Helper::getTeamWinLossTie($national_conference_best_teams, $year, 16);
            $response['american_conference_consolation'] = Helper::getTeamWinLossTie($american_conference_best_teams, $year, 16);
        }

        if ($week >= 17) {
            //Week 17 League Championship
            $response['championship_teams'] = $championship_details;

            //Week 17 Consolation Finals
            $response['consolation_finals'] = Helper::getTeamWinLossTie($cons_finals_team, $year, 17);

            //Week 17 Toilet Bowl
            $response['toilet_bowl'] = Helper::getTeamWinLossTie($toilet_bowl_array, $year, 17);

            //	$response['tournament_teams']					=	Helper::getTournamentPoints($tournament_teams,$year,array(15,16,17));

            $arraySearch = [17];
            if ($week == 17 && $systemSettings->season_type != 3) {
                $arraySearch = [16];
            }

            $response['tournament_teams'] = $tournament_teams ? Helper::getTournamentRank($league_id, $tournament_teams, $year, $arraySearch) : [];
            //dd($response['tournament_teams']);
        }

        return response()->json($response);
    }

    /**
     * Show the active fantasy teams.
     *
     * @return Response
     */
    public function activeFantasyTeams()
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();
        $fantasy_teams = FantasyTeam::with('teamOwner')->where('league_id', $team->league_id)->orderBy('created_at', 'asc')->get();
        $teamArray = [];
        if (! empty($fantasy_teams)) {
            foreach ($fantasy_teams as $key=>$val) {
                $teamArray[$key]['number'] = $key + 1;
                if ($val->logo_url != null) {
                    $logo = $val['logo_url'];
                } else {
                    $logo = 'https://cdn.head-fi.org/g/2283245_l.jpg';
                }
                $teamArray[$key]['logo'] = $logo;
                $teamArray[$key]['name'] = $val->name;
                $teamArray[$key]['user'] = $val->teamOwner->name;
                $teamArray[$key]['created'] = date('F d, Y', strtotime($val->created_at));
            }
        }
        if (count($fantasy_teams) < 12) {
            for ($i = count($fantasy_teams) + 1; $i <= 12; $i++) {
                $teamArray[$i]['number'] = $i;
                $teamArray[$i]['logo'] = 'https://cdn.head-fi.org/g/2283245_l.jpg';
                $teamArray[$i]['name'] = '';
                $teamArray[$i]['user'] = '';
                $teamArray[$i]['created'] = '';
            }
        }

        return response()->json(array_values($teamArray));
    }

    public function storeInvitations(Request $request)
    {
        $user = Auth::user();
        $team = FantasyTeam::where('user_id', $user->id)->first();
        $league = League::where('id', $team->league_id)->first();
        $returnArray = [];

        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:league_invitations|unique:users',
        ]);
        $token = str_random(16);
        LeagueInvitation::create([
            'email' => $request->email,
            'token' => $token,
            'league_id' => $league->id,
        ]);
        $user->email = $request->email;
        $user->notify(new FantasyLeagueInvitation($user, $token, $request->email));
        $returnArray['message'] = 'Inserted';

        return response()->json(array_values($returnArray));
    }

    public function getInvitationList()
    {
        $user = Auth::user();
        $team = FantasyTeam::where('user_id', $user->id)->first();
        $league = League::where('id', $team->league_id)->first();
        $invitations = LeagueInvitation::select('league_invitations.email', 'league_invitations.created_at as invited_date', 'f.name as fantasy_team', 'u.created_at as registered_date')
                        ->where('league_invitations.league_id', $team->league_id)
                        ->leftJoin('fantasy_teams as f', 'f.id', '=', 'league_invitations.fantasy_team_id')
                        ->leftJoin('users as u', 'u.id', '=', 'f.user_id')
                        ->orderBy('league_invitations.created_at', 'asc')->get();
        $returnArray = [];
        if (! empty($invitations)) {
            foreach ($invitations as $key=>$val) {
                $returnArray[$key]['email'] = $val->email;
                $returnArray[$key]['invited_date'] = date('F d, Y', strtotime($val->invited_date));
                if (isset($val->registered_date)) {
                    $returnArray[$key]['registered_date'] = date('F d, Y', strtotime($val->registered_date));
                } else {
                    $returnArray[$key]['registered_date'] = '';
                }
                if (isset($val->fantasy_team) && ! empty($val->fantasy_team)) {
                    $returnArray[$key]['team_name'] = $val->fantasy_team;
                } else {
                    $returnArray[$key]['team_name'] = '';
                }
            }
        }

        return response()->json(array_values($returnArray));
    }
}
