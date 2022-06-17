<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DraftOrder;
use App\Models\FantasyTeam;
use App\Models\FantasyTeamsPlayerTransaction;
use App\Models\FantasyTeamsRoster;
use App\Models\League;
use App\Models\SystemSetting;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class TeamController extends Controller
{
    /**
     * The image manager instance.
     *
     * @var ImageManager
     */
    protected $images;

    /**
     * Create a new interaction instance.
     *
     * @param  ImageManager  $images
     * @return void
     */
    public function __construct(ImageManager $images)
    {
        $this->images = $images;
    }

    /**
     * Show the Team.
     *
     * @return Response
     */
    public function showTeam()
    {
        return view('team.index');
    }

    /**
     * Show the team Roster.
     *
     * @return Response
     */
    public function getTeamRoster(Request $request)
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();
        $seasonTypeArray = Helper::$seasonTypes;
        $settings = SystemSetting::find(1);
        $override_system = $league->override_system;

        if (isset($request->week)) {
            $week = $request->week;
        } elseif ($override_system) {
            $week = $league->week;
        } else {
            $week = $settings->week;
        }

        if (isset($request->season)) {
            $season = $request->season;
        } elseif ($override_system) {
            $season = $league->season_type;
        } else {
            $season = $settings->season_type;
        }

        return redirect()->route('team.roster', ['week' => $week, 'season' => $seasonTypeArray[$season]]);
    }

    public function getTeamRoster_new(Request $request)
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();
        $seasonTypeArray = Helper::$seasonTypes;
        $settings = SystemSetting::find(1);
        $override_system = $league->override_system;

        if (isset($request->week)) {
            $week = $request->week;
        } elseif ($override_system) {
            $week = $league->week;
        } else {
            $week = $settings->week;
        }

        if (isset($request->season)) {
            $season = $request->season;
        } elseif ($override_system) {
            $season = $league->season_type;
        } else {
            $season = $settings->season_type;
        }

        return redirect()->route('team.roster_new', ['week' => $week, 'season' => $seasonTypeArray[$season], 'teams' => $team->id]);
    }

    /**
     * Show the team Roster.
     *
     * @return Response
     */
    public function showTeamRoster(Request $request)
    {
        $week = 1;
        $season = 'REG';
        $settings = SystemSetting::find(1);
        $league_setting_week = $settings->week;
        $year = $settings->season;
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $team_id = $team->id;
        if (isset($request->week)) {
            $week = $request->week;
        }
        if (isset($request->season)) {
            $season = $request->season;
        }
        if (isset($request->teams)) {
            $team_id = $request->teams;
        }
        $seasonTypeArray = Helper::getSystemSettingsDetails();
        $seasonType = $seasonTypeArray['seasonType'];

        return view('team.roster_new', compact('week', 'season', 'year', 'league_setting_week', 'team_id'));
    }

    public function showTeamRoster_new(Request $request)
    {
        $week = 1;
        $season = 'REG';
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $team_id = $team->id;
        $settings = SystemSetting::find(1);
        $league_setting_week = $settings->week;
        $year = $settings->season;
        if (isset($request->week)) {
            $week = $request->week;
        }
        if (isset($request->season)) {
            $season = $request->season;
        }
        if (isset($request->teams)) {
            $team_id = $request->teams;
        }
        $seasonTypeArray = Helper::getSystemSettingsDetails();
        $seasonType = $seasonTypeArray['seasonType'];

        return view('team.roster_new', compact('week', 'season', 'year', 'seasonType', 'league_setting_week', 'team_id'));
    }

    /**
     * Show the Team leaque teams.
     *
     * @return Response
     */
    public function showTeamLeagueTeams()
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

        return view('team.league-teams')->with('week', $week);
    }

    public function getTeamRosterGridData(Request $request)
    {
        $systemSettings = Helper::getSystemSettingsDetails();
        $week = $systemSettings['week'];
        $season = $systemSettings['season'];
        $seasonType = $systemSettings['season_type'];
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::where('id', $team->league_id)->first();
        if (isset($request->week)) {
            $week = $request->week;
        }

        //all active player_ids from fantasy_teams_roster for fantasy_league

        $fantasy_teams = FantasyTeam::where('league_id', $league->id)->get();

        $fantasy_teams_players = FantasyTeamsRoster::where('league_id', $league->id)
                                                    ->where('season', $season)
                                                    ->where('season_type', $seasonType)
                                                    ->where('week', $week)
                                                    ->where('active', 1)
                                                    ->get()->toArray();

//        $collection =collect($fantasy_teams_players);
//        $unique_fantasy_players = $collection->unique('fantasy_player_id');
//        $unique_players=$unique_fantasy_players->values()->all();
//
//        $keyed = $unique_fantasy_players->mapWithKeys(function ($item) {
//            return [$item['fantasy_player_id'] => $item['fantasy_player_id']];
//        });
//        $unique_players_id=$keyed->values()->all();
//
//        $fantasy_roster_data=Helper::getFantasyPlayerDataByWeekEloquent($season, $seasonType, $week, $unique_players_id);
//
//        $fantay_data = $this->getFantasyTeamRosterByPositions($fantasy_roster_data);

        $result = [];

        $teamData = [];
        if (! empty($fantasy_teams)) {
            foreach ($fantasy_teams as $key=>$val) {
                $teamRoster = Helper::getFantasyTeamDataByWeekEloquent($season, $seasonType, $week, $val->id, $simple = true);

                $players = $teamRoster->FantasyTeamRoster;

                // TQB

                $tqb_data = $players->where('fantasyPlayer.position', 'TQB')->sortByDesc('active')->flatten()->all();
                $rb_data = $players->where('fantasyPlayer.position', 'RB')->sortByDesc('active')->flatten()->all();
                $wr_data = $players->where('fantasyPlayer.position', 'WR')->sortByDesc('active')->flatten()->all();
                $te_data = $players->where('fantasyPlayer.position', 'TE')->sortByDesc('active')->flatten()->all();
                $k_data = $players->where('fantasyPlayer.position', 'K')->sortByDesc('active')->flatten()->all();
                $st_data = $players->where('fantasyPlayer.position', 'ST')->sortByDesc('active')->flatten()->all();
                $def_data = $players->where('fantasyPlayer.position', 'DEF')->sortByDesc('active')->flatten()->all();

//                $fantay_data_offenseTeams_collection = collect($fantay_data['offenseTeams']);
//                $offenseTeams_filtered 				 = $fantay_data_offenseTeams_collection->where('fantasy_team_id', $val->id);
//
//                $fantay_data_kickerTeams_collection 	= collect($fantay_data['kickerTeams']);
//                $kickerTeams_filtered 					= $fantay_data_kickerTeams_collection->where('fantasy_team_id', $val->id);
//
//                $fantay_data_diffTeams_collection		= collect($fantay_data['diffTeams']);
//                $diffTeams_filtered						= $fantay_data_diffTeams_collection->where('fantasy_team_id', $val->id);
//
//                $fantay_data_specialTeams_collection    = collect($fantay_data['specialTeams']);
//                $specialTeams_filtered					= $fantay_data_specialTeams_collection->where('fantasy_team_id', $val->id);

//                $tqb_filtered 			 = $offenseTeams_filtered->where('position', 'TQB');
//
//
                //$tqb_data				 = $tqb_filtered->implode('fantasyPlayer.name', ', ');
//
//
//                $rb_filtered 			 = $offenseTeams_filtered->where('position', 'RB');
//                $rb_data				 = $rb_filtered->implode('fantasyPlayer.name', '<br/> ');
//
//                $wr_filtered 			 = $offenseTeams_filtered->where('position', 'WR');
//                $wr_data				 = $wr_filtered->implode('fantasyPlayer.name', '<br/> ');
//
//                $te_filtered 			 = $offenseTeams_filtered->where('position', 'TE');
//                $te_data				 = $te_filtered->implode('fantasyPlayer.name', ', ');
//
//                $k_filtered 			 = $kickerTeams_filtered->where('position', 'K');
//                $k_data				     = $k_filtered->implode('fantasyPlayer.name', ', ');
//
//                $def_filtered 			 = $diffTeams_filtered->where('position', 'DEF');
//                $def_data				 = $def_filtered->implode('fantasyPlayer.name', ', ');
//
//                $st_filtered 			 = $specialTeams_filtered->where('position', 'ST');
//                $st_data				 = $st_filtered->implode('fantasyPlayer.name', ', ');

                $teamData[$key]['team'] = $val->name;
                $teamData[$key]['tqb'] = $tqb_data;
                $teamData[$key]['rb'] = $rb_data;
                $teamData[$key]['wr'] = $wr_data;
                $teamData[$key]['te'] = $te_data;
                $teamData[$key]['k'] = $k_data;
                $teamData[$key]['def'] = $def_data;
                $teamData[$key]['st'] = $st_data;
            }
        }

        /*
        $systemSettings	= 	SystemSetting::find(1);
        if($systemSettings->week)
            $week		= 	$systemSettings->week;
        if($systemSettings->season)
            $season		= 	$systemSettings->season;
        if($systemSettings->season_type)
            $season_type= 	$systemSettings->season_type;
        if(isset($request->week))
            $week	=	$request->week;
        $userId			=	Auth::user()->id;
        $team			=	FantasyTeam::where('user_id',$userId)->first();

        $league			=	League::find($team->league_id);
        $teams	 		= 	FantasyTeam::select('fantasy_teams.id','fantasy_teams.name')
                                        ->where('league_id',$league->id)
                                        ->get();
        $teamData	=	array();
        if($teams){
            foreach($teams as $key=>$val){

                $players_list=$this->getRosterPlayersTeam($val->id,$week,$season,$season_type);

                foreach($players_list as $list){

                    $collection = collect($players_list);

                    $tqb_filtered 			 = $collection->where('position', 'TQB');
                    $tqb_data				 = $tqb_filtered->implode('name', ', ');

                    $rb_filtered 			 = $collection->where('position', 'RB');
                    $rb_data				 = $rb_filtered->implode('name', '<br/> ');

                    $wr_filtered 			 = $collection->where('position', 'WR');
                    $wr_data				 = $wr_filtered->implode('name', '<br/> ');

                    $te_filtered 			 = $collection->where('position', 'TE');
                    $te_data				 = $te_filtered->implode('name', ', ');

                    $k_filtered 			 = $collection->where('position', 'K');
                    $k_data				     = $k_filtered->implode('name', ', ');

                    $def_filtered 			 = $collection->where('position', 'DEF');
                    $def_data				 = $def_filtered->implode('name', ', ');

                    $st_filtered 			 = $collection->where('position', 'ST');
                    $st_data				 = $st_filtered->implode('name', ', ');

                    $teamData[$key]['team']  = $val->name;
                    $teamData[$key]['tqb']   = $tqb_data;
                    $teamData[$key]['rb']	 = $rb_data;
                    $teamData[$key]['wr']	 = $wr_data;
                    $teamData[$key]['te']	 = $te_data;
                    $teamData[$key]['k']	 = $k_data;
                    $teamData[$key]['def']	 = $def_data;
                    $teamData[$key]['st']	 = $st_data;
                }
            }
        }
        */
        return response()->json(array_values($teamData));
    }

    private function getFantasyTeamRosterByPositions($fantasy_roster_data)
    {

        //return $fantasy_roster_data;
        $fantasyTeams = [];
        $response = [];

        if (! empty($fantasy_roster_data)) {
            foreach ($fantasy_roster_data as $list) {
                if ($list->fantasyPlayer->position == 'ST') {
                    $fantasy_team_positions = 'specialTeams';
                    $team_poistions = 'ST';
                } elseif ($list->fantasyPlayer->position == 'DEF') {
                    $fantasy_team_positions = 'diffTeams';
                    $team_poistions = 'DEF';
                } elseif ($list->fantasyPlayer->position == 'TQB') {
                    $fantasy_team_positions = 'offenseTeams';
                    $team_poistions = 'TQB';
                } elseif ($list->fantasyPlayer->position == 'K') {
                    $fantasy_team_positions = 'kickerTeams';
                    $team_poistions = 'K';
                } else {
                    $fantasy_team_positions = 'offenseTeams';
                    $team_poistions = $list->fantasyPlayer->position;
                }

                $fantasyTeams[$fantasy_team_positions][$list->id] = $list;
                $fantasyTeams[$fantasy_team_positions][$list->id]['position'] = $team_poistions;
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
        }

        return $response;
    }

    private function getRosterPlayersTeam($teamId, $week, $season, $season_type)
    {
        $teamPlayers = FantasyTeamsPlayerTransaction::selectRaw('season_type,week,position,name,team,bye_week')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_player_transactions.fantasy_player_id')
                            ->where('fantasy_team_id', $teamId)
                            ->where('week', $week)
                            ->where('season', $season)
                            ->where('season_type', $season_type)
                            ->where('fantasy_teams_player_transactions.player_transaction_type_id', 1)
                            ->where('fantasy_teams_player_transactions.active', 1)->get();

        $teamArray = $teamPlayers->toArray();

        return Helper::sortTeamArray($teamArray);
    }

    /**
     * Show the Team Settings.
     *
     * @return Response
     */
    public function showSettings()
    {
        return view('team.setting');
    }

    /**
     * Show the Team draft list.
     *
     * @return Response
     */
    // TODO: 04/20/20 - Delete this. Moved to DraftController
    public function showTeamList()
    {
        $teams = $current_draft = [];
        $userId = Auth::user()->id;

        $team = FantasyTeam::where('user_id', $userId)->first();
        $leagueDetails = League::find($team->league_id);
        $next_draft = '';
        $message = '';
        $onClockAudio = false;

        $draft_started = false;
        $show_draft_order = false;
        $draft_date = Carbon::parse($leagueDetails->draft_date);
        $show_timer = false;

        $currentTime = Carbon::parse('now');
        $currentTime = $currentTime->format('Y-m-d H:i:s');

        //if current time greater/equal to draft date/time then that means it's past the draft time. Show Timers
        if ($currentTime >= $draft_date && ! $leagueDetails->draft_completed) {
            //See if the generate console command has ran yet.
            $draft_started = $leagueDetails->draft_started ?: true;
            $show_timer = true;
        }

        if (! $leagueDetails->draft_completed) {
            //Subtract 15 minutes because we want to show the draft cards and big countdown timer 15 minutes early
            $showDraftOrderDate = Carbon::parse($leagueDetails->draft_date);
            $showDraftOrderDate = $showDraftOrderDate->subMinutes(50)->format('Y-m-d H:i:s');

            //Show the draft order 15 minutes before the draft begins.
            if ($currentTime >= $showDraftOrderDate) {
                $show_draft_order = true;

                //See if we have a draft order yet.
                $current_draft = DraftOrder::where('draft_order.league_id', $team->league_id)
              ->leftJoin('fantasy_teams as f', 'f.id', '=', 'draft_order.fantasy_team_id')
              ->where('fantasy_player_id', null)
              ->where('deadline', '<>', null)
              //->where('deadline','>=',$draft_date)
              ->first();

                //Set the data
                if (! empty($current_draft)) {
                    //$draft_started = true;
                    $show_timer = true;
                    //Get the next 24 picks and see if the user is in there
                    $teams24 = DraftOrder::where('draft_order.league_id', $team->league_id)
                ->leftJoin('fantasy_teams as f', 'f.id', '=', 'draft_order.fantasy_team_id')
                ->where('fantasy_player_id', null)
                ->take(24)->get();

                    $collection = collect($teams24)->firstWhere('fantasy_team_id', $team->id);
                    //$message = "Test for Todd";
                    if ($collection && $current_draft->league_overall_pick) {
                        $next_draft = $collection->league_overall_pick - $current_draft->league_overall_pick;
                        if ($next_draft) {
                            $message = 'You draft next in '.$next_draft.' picks.';
                        }
                        if ($next_draft == 0) {
                            $onClockAudio = url('/audio/ticktock.mp3');
                            $message = 'You are on the clock!';
                        }
                    } else {
                        //$draft_started = true;
                        $message = 'You are done drafting!';
                    }

                    //Load the teams to show in the draft card row.
                    $teams = DraftOrder::where('draft_order.league_id', $team->league_id)
                  ->leftJoin('fantasy_teams as f', 'f.id', '=', 'draft_order.fantasy_team_id')
                  ->where('fantasy_player_id', null)
                  ->take(12)->get();
                }
            }
        }

        $response['draftTeams'] = $teams;
        $response['currentDraft'] = $current_draft;
        $response['message'] = $message;
        $response['draftCompleted'] = ($leagueDetails->draft_completed ? true : false);
        $response['draft_pick_max_time'] = ($leagueDetails->draft_pick_max_time ? $leagueDetails->draft_pick_max_time : 60);
        $response['draftStarted'] = ($draft_started ? true : false);
        $response['draft_date'] = $draft_date;
        $response['show_timer'] = $show_timer;
        $response['user_team_id'] = $team->id;
        $response['show_draft_order'] = $show_draft_order;
        $response['league_draft_date'] = $leagueDetails->draft_date;
        $response['on_clock_audio'] = $onClockAudio;

        return response()->json($response);
    }

    /**
     * Show the team deatils.
     *
     * @return Response
     */
    public function showTeamDetails()
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();

        return response()->json($team);
    }

    /**
     * Save the team deatils.
     *
     * @return Response
     */
    public function updateSettings(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $response['success'] = '';
        if ($request->name != '') {
            $team->name = $request->name;
            $team->save();
            $response['success'] = 'Team details has been updated successfully.';
        }

        return response()->json($response);
    }

    /**
     * Save the logo deatils.
     *
     * @return Response
     */
    public function storeLogo(Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|image|max:4000',
        ]);
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $file = $request['photo'];

        $path = $file->hashName('team-logo');

        // We will store the profile photos on the "public" disk, which is a convention
        // for where to place assets we want to be publicly accessible. Then, we can
        // grab the URL for the image to store with this user in the database row.
        $disk = Storage::disk('public');

        $disk->put($path, $this->formatImage($file));

        $oldLogoUrl = $team->logo_url;

        // Next, we'll update this URL on the local user instance and save it to the DB
        // so we can access it later. Then we will delete the old photo from storage
        // since we'll no longer need to access it for this specific user profile.
        $team->forceFill([
            'logo_url' => $disk->url($path),
        ])->save();

        if (preg_match('/team-logo\/(.*)$/', $oldLogoUrl, $matches)) {
            $disk->delete('team-logo/'.$matches[1]);
        }
    }

    /**
     * Resize an image instance for the given file.
     *
     * @param  \SplFileInfo  $file
     * @return \Intervention\Image\Image
     */
    public function formatImage($file)
    {
        return (string) $this->images->make($file->path())
                            ->fit(300)->encode();
    }

    /**
     * Show the Team table list.
     *
     * @return Response
     */
    public function showTeamTableList()
    {
        $settings = SystemSetting::find(1);
        $week = $settings->week;
        $season = $settings->season;
        $seasonType = $settings->season_type;

        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $league = League::find($team->league_id);
        $teams = FantasyTeam::select('fantasy_teams.id', 'fantasy_teams.name', 'fantasy_teams.logo_url', 'u.name as manager_name')
                            ->leftJoin('users as u', 'u.id', '=', 'fantasy_teams.user_id')
                            ->where('league_id', $league->id)
                            ->take(12)->get();

        $teamData = [];
        if ($teams) {
            foreach ($teams as $key=>$val) {
                //$val->players = $this->getPlayersInTeam($val->id);
                $players_list = $this->getPlayersInTeam($val->id);
                $collection = collect($players_list);

                if (($week == 1 || $week == 2 || $week == 3 || $week == 4) && ($seasonType == 3)) {
                    $filtered = $collection->where('week', $week);
                    $filtered = $filtered->where('season_type', $seasonType);
                    $values = $filtered->values();
                    $val->players = $values;
                } else {
                    $val->players = $players_list;
                }
                $teamData[] = $val;
            }
        }

        $response['draftCompleted'] = ($league->draft_completed ? 1 : 0);
        $response['teamData'] = $teamData;

        return response()->json($response);
    }

    /**
     * Show the my team list.
     *
     * @return Response
     */
    public function showMyTeam()
    {
        $settings = SystemSetting::find(1);
        $week = $settings->week;
        $season = $settings->season;
        $seasonType = $settings->season_type;

        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->get();
        $league = League::find($team[0]->league_id);
        $teamData = [];
        if ($team) {
            foreach ($team as $key=>$val) {
                $val->manager_name = Auth::user()->name;

                $players_list = $this->getPlayersInTeam($val->id);
                $collection = collect($players_list);

                if (($week == 1 || $week == 2 || $week == 3 || $week == 4) && ($seasonType == 3)) {
                    $filtered = $collection->where('week', $week);
                    $filtered = $filtered->where('season_type', $seasonType);
                    $values = $filtered->values();
                    $val->players = $values;
                } else {
                    $collection = collect($players_list);
                    $filtered = $collection->whereNotIn('season_type', [3]);
                    $values = $filtered->values();
                    $val->players = $values;
                }
                $teamData = $val;
            }
        }

        $response['draftCompleted'] = ($league->draft_completed ? 1 : 0);
        $response['teamData'] = $teamData;

        return response()->json($response);
    }

    /**
     * Get roster page details.
     *
     * @return Response
     */
    /* public function getRosterDetails(){
        $userId			=	Auth::user()->id;
        $team			=	FantasyTeam::where('user_id',$userId)->first();
        $scoreControl	= 	new ScoreController;
        $response		= 	$scoreControl->getTeamScoreDetails($team->id);
        return response()->json($response);
    } */

    /**
     * Get player in teams.
     *
     * @return Response
     */
    public function getPlayersInTeam($teamId)
    {
        $teamPlayers = [];
        $teamPlayers = FantasyTeamsPlayerTransaction::selectRaw('season_type,week,position,name,team,bye_week')
                            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_player_transactions.fantasy_player_id')
                            ->where('fantasy_team_id', $teamId)
                            ->where('fantasy_teams_player_transactions.player_transaction_type_id', 1)
                            ->where('fantasy_teams_player_transactions.active', 1)->get()->toArray();

        $collection = collect($teamPlayers);
        $grouped = $collection->groupBy('position');
        $wr_count = $collection->where('position', 'WR')->count();
        $rb_count = $collection->where('position', 'RB')->count();
        $tqb_count = $collection->where('position', 'TQB')->count();
        $te_count = $collection->where('position', 'TE')->count();
        $k_count = $collection->where('position', 'K')->count();
        $def_count = $collection->where('position', 'DEF')->count();
        $st_count = $collection->where('position', 'ST')->count();

        $team_positions = ['TQB'=>1,
            'RB'=>2,
            'WR'=>2,
            'TE'=>1,
            'K'=>1,
            'ST'=>1,
            'DEF'=>1,
        ];

        foreach ($team_positions as $key=>$value) {
            if ($key == 'TQB') {
                $no_of_player = ($tqb_count >= 1) ? 0 : 1;
            } elseif ($key == 'RB') {
                if ($rb_count >= 2) {
                    $no_of_player = 0;
                } else {
                    $no_of_player = ($rb_count == 1) ? 1 : 2;
                }
            } elseif ($key == 'WR') {
                if ($wr_count >= 2) {
                    $no_of_player = 0;
                } else {
                    $no_of_player = ($wr_count == 1) ? 1 : 2;
                }
            } elseif ($key == 'TE') {
                $no_of_player = ($te_count >= 1) ? 0 : 1;
            } elseif ($key == 'K') {
                $no_of_player = ($k_count >= 1) ? 0 : 1;
            } elseif ($key == 'DEF') {
                $no_of_player = ($def_count >= 1) ? 0 : 1;
            } elseif ($key == 'ST') {
                $no_of_player = ($st_count >= 1) ? 0 : 1;
            }
            if ($no_of_player) {
                for ($i = 1; $i <= $no_of_player; $i++) {
                    $teamPlayers[] = [
                        'season_type'=>1,
                        'week'=>1,
                        'position'=>$key,
                        'name'=>'Empty',
                        'team'=>'',
                        'bye_week'=>'',
                    ];
                }
            }
        }

        //$teamArray		=	$teamPlayersArray->toArray();
        return Helper::sortTeamArray($teamPlayers);
    }
}
