<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\LeagueGame;
use App\Models\LeagueGamesSim;
use App\Models\SystemSetting;
use Auth;
use Helper;
use Illuminate\Http\Request;

class StandingController extends Controller
{
    /**
     * Show the Standings.
     *
     * @return Response
     */
    public function showStandings()
    {
        return view('standings.index');
    }

    /**
     * Show the Standings Head to Head.
     *
     * @return Response
     */
    public function showStandingsHeadToHead()
    {
        return view('standings.head-tohead');
    }

    /**
     * Show the Standings Overall.
     *
     * @return Response
     */
    public function showStandingsOverall($id = '', $id2 = '')
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();

        $settings = SystemSetting::find(1);
        $seasonTypeArray = Helper::$seasonTypes;
        $override_system = $league->override_system;
        if (isset($id) && ! empty($id2)) {
            $week = $id2;
        } elseif ($override_system) {
            $week = $league->week;
        } else {
            $week = $settings->week - 1;
        }

        if (isset($id2) && ! empty($id)) {
            $season = $id;
        } else {
            $season = $league->season;
        }

        return view('standings.overall', compact('week', 'season'));
    }

    /**
     * Show the Standings Tournament.
     *
     * @return Response
     */
    public function showStandingsTournament()
    {
        return view('standings.tournament');
    }

    /**
     * Show the Standings coach ratings.
     *
     * @return Response
     */
    public function showStandingsCoachRating($id = '', $id2 = '')
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();

        $settings = SystemSetting::find(1);
        $seasonTypeArray = Helper::$seasonTypes;
        $override_system = $league->override_system;
        if (isset($id) && ! empty($id2)) {
            $week = $id2;
        } elseif ($override_system) {
            $week = $league->week;
        } else {
            $week = $settings->week - 1;
        }

        if (isset($id2) && ! empty($id)) {
            $season = $id;
        } else {
            $season = $league->season;
        }
        $system_week = $settings->week;

        if ($settings->season_type == 3) {
            $system_week = 17;
        }

        return view('standings.coachrating', compact('week', 'season', 'system_week'));
    }

    private function getWeekLeagueGameSim($year, $week, $home_team_id)
    {
        $total_weeks = range(1, $week);

        $response = [];
        $league_statics = [];
        $win = 0;
        $loss = 0;
        $tie = 0;
        $sim_win = 0;
        $sim_loss = 0;
        $sim_tie = 0;

        $leagueTeams = LeagueGamesSim::selectRaw('league_games_sims.home_team_id,league_games_sims.away_team_id ,t.name as teamName')
                            ->leftJoin('fantasy_teams as t', 't.id', '=', 'league_games_sims.away_team_id')
                            ->where('year', $year)
                            ->where('week', $week)
                            ->where('home_team_id', $home_team_id)
                            ->get();

        foreach ($leagueTeams as $key=>$list) {

            /*$played_status	=	LeagueGame::where('home_team_id',$home_team_id)->where('away_team_id',$list['away_team_id'])->where('year',$year)->whereIn('week',$total_weeks)->first();
            */
            $allWinCount = LeagueGamesSim::where('home_team_id', $home_team_id)->where('away_team_id', $list['away_team_id'])
                                                ->where('year', $year)->whereIn('week', $total_weeks)->where('win', 1)->count();

            $alllossCount = LeagueGamesSim::where('home_team_id', $home_team_id)->where('away_team_id', $list['away_team_id'])
                                                ->where('year', $year)->whereIn('week', $total_weeks)->where('loss', 1)->count();

            $allTieCount = LeagueGamesSim::where('home_team_id', $home_team_id)->where('away_team_id', $list['away_team_id'])
                                                ->where('year', $year)->whereIn('week', $total_weeks)->where('tie', 1)->count();

            $played_winCount = LeagueGame::where('team_id', $home_team_id)->where('opponent_id', $list['away_team_id'])
                                                ->where('year', $year)->whereIn('week', $total_weeks)->where('win', 1)->count();

            $played_lossCount = LeagueGame::where('team_id', $home_team_id)->where('opponent_id', $list['away_team_id'])
                                                ->where('year', $year)->whereIn('week', $total_weeks)->where('loss', 1)->count();

            $played_tieCount = LeagueGame::where('team_id', $home_team_id)->where('opponent_id', $list['away_team_id'])
                                                ->where('year', $year)->whereIn('week', $total_weeks)->where('tie', 1)->count();

            $win += $played_winCount;
            $loss += $played_lossCount;
            $tie += $played_tieCount;

            $sim_win += $allWinCount;
            $sim_loss += $alllossCount;
            $sim_tie += $allTieCount;

            $league_statics[$key] = $list;
            $league_statics[$key]['played_win'] = $played_winCount;
            $league_statics[$key]['played_loss'] = $played_lossCount;
            $league_statics[$key]['played_tie'] = $played_tieCount;
            $league_statics[$key]['sim_win'] = $allWinCount;
            $league_statics[$key]['sim_loss'] = $alllossCount;
            $league_statics[$key]['sim_tie'] = $allTieCount;
        }

        $league_result['total_result_win'] = $win;
        $league_result['total_result_loss'] = $loss;
        $league_result['total_result_tie'] = $tie;
        $league_result['all_win'] = $sim_win;
        $league_result['all_loss'] = $sim_loss;
        $league_result['all_tie'] = $sim_tie;

        $response['league_result'] = $league_result;
        $response['league_statics'] = $league_statics;

        return 	$response;
    }

    /**
     * Show the Standings coach ratings.
     *
     * @return Response
     */
    public function getMatchupResult(Request $request)
    {
        $systemSettings = Helper::getSystemSettingsDetails();
        if (isset($request->week)) {
            $week = $request->week;
        } else {
            $week = $systemSettings['week'];
        }

        if (isset($request->season)) {
            $year = $request->season;
        } else {
            $year = $systemSettings['season'];
        }

        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();

        $teams = FantasyTeam::where('league_id', $team->league_id)->pluck('id')->toArray();

        $response = [];

        $leagueTeams = LeagueGame::selectRaw('league_games.home_team_id,league_games.team_id,t.name as teamName,win,loss,tie')
                            ->leftJoin('fantasy_teams as t', 't.id', '=', 'league_games.team_id')
                            ->where('league_games.year', $year)
                            ->where('league_games.week', $week)
                            ->whereIn('league_games.team_id', $teams)
                            ->get()
                            ->groupBy('team_id')
                            ->toArray();

        $i = 0;
        foreach ($leagueTeams as $key=>$list) {
            $response['teamData'][$key]['teamName'] = $list[0]['teamName'];
            $response['teamData'][$key]['team_id'] = $list[0]['team_id'];
            $result = $this->getWeekLeagueGameSim($year, $week, $list[0]['team_id']);

            $response['teamData'][$key]['league_statics'] = $result['league_statics'];
            $response['teamData'][$key]['league_result'] = $result['league_result'];
        }

        return response()->json($response);
    }
}
