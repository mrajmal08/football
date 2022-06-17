<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DraftOrder;
use App\Models\FantasyTeam;
use App\Models\FantasyTeamsPlayerTransaction;
use App\Models\League;
use App\Models\LeagueCommissioner;
use App\Models\SystemSetting;
use Auth;
use Carbon\Carbon;
use Helper;
use Illuminate\Http\Request;

class DraftController extends Controller
{
    /**
     * Show the Draft.
     *
     * @return Response
     */
    public function showDraft()
    {
        return view('draft.index');
    }

    /**
     * Show the Draft Room.
     *
     * @return Response
     */
    public function showDraftRoom()
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
        $userLeague = FantasyTeam::where('user_id', $userId)->first();
        $leagueDetails = League::find($userLeague->league_id);
        $commissioner = LeagueCommissioner::where('league_id', $userLeague->league_id)->get();
        $ids = array_column($commissioner->toArray(), 'user_id');
        //dd($ids);
        $isCommissioner = $show_draft_user = false;
        /* if(!empty($commissioner)){
        } */
        if (in_array($userId, $ids)) {
            $isCommissioner = true;
        }

        $draft_date = $leagueDetails->draft_date;

        return view('draft.room', compact('leagueDetails', 'isCommissioner', 'draft_date', 'userId', 'week'));
    }

    /**
     * Show the Draft Prep.
     *
     * @return Response
     */
    public function showDraftPrep()
    {
        return view('draft.prep');
    }

    /**
     * Show the Draft Results.
     *
     * @return Response
     */
    public function showDraftResults()
    {
        return view('draft.results');
    }

    /**
     * Show the Draft Results.
     *
     * @return Response
     */
    public function showLeagueDraftResults()
    {
        $userId = Auth::user()->id;
        $userLeague = FantasyTeam::where('user_id', $userId)->first();
        $draftOrder = DraftOrder::where('league_id', $userLeague->league_id)
            ->with(['fantasyPlayer'])
            ->with(['fantasyTeam'])
            ->orderBy('league_overall_pick')
            ->get();

        return response()->json($draftOrder);
    }

    /**
     * assign the draft order.
     *
     * @return Response
     */
    public function assignDraftOrder()
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $teams = FantasyTeam::where('league_id', $team->league_id)->orderBy('id', 'asc')->get();
        $leagueDetails = League::where('id', $team->league_id)->first();
        $random = $teams->shuffle();
        $random->all();
        $random = $random->toArray();
        $i = 0;
        $deadline = null;
        if (! empty($random)) {
            $j = 1;
            for ($i = 1; $i <= 9; $i++) {
                if ($i % 2 == 0) {
                    $random = array_reverse($random);
                } else {
                    $random = array_reverse($random);
                }
                $m = 1;
                foreach ($random as $key => $val) {
                    if ($i == 1) {
                        $team = FantasyTeam::where('id', $val['id'])->first();
                        $team->league_team_number = $m;
                        $team->save();
                    }
                    if ($j == 1) {
                        $dateTime = new \DateTime($leagueDetails->draft_date);
                        $dateTime->modify('+1 minutes');
                        $deadline = $dateTime;
                    } else {
                        $deadline = null;
                    }

                    $draftOrder = DraftOrder::create([
                        'league_id' => $team->league_id,
                        'fantasy_team_id' => $val['id'],
                        'fantasy_player_id' => null,
                        'round' => $i,
                        'league_overall_pick' => $j,
                        'round_overall_pick' => $m,
                        'deadline' => $deadline,
                    ]);
                    $j++;
                    $m++;
                }
            }
        }

        $success = 'Draft order has been assigned';

        return response()->json($success);
    }

    public function leagueDraftData()
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
        $fantasyTeam = FantasyTeam::where('user_id', $userId)
            ->first();
        $leagueDetails = League::find($fantasyTeam->league_id);

        $draftOrderList = DraftOrder::where('league_id', $leagueDetails->id)
            ->with(['fantasyPlayer', 'fantasyTeam'])
            ->orderBy('league_overall_pick')
            ->get()->toArray();

        $teams = $current_draft = [];
        $userId = Auth::user()->id;

        $team = FantasyTeam::where('user_id', $userId)->first();
        $leagueDetails = League::find($team->league_id);
        $next_draft = '';
        $message = '';
        $onClockAudio = false;
        $draftStartAudio = false;

        $draft_started = false;
        $show_draft_order = false;
        //dd($leagueDetails->draft_date);
        $draft_date = null;
        if ($leagueDetails->draft_date) {
            $draft_date = Carbon::parse($leagueDetails->draft_date);
            //dd($draft_date);
        }
        $show_timer = false;

        $currentTime = Carbon::parse('now');
        $currentTime = $currentTime->format('Y-m-d H:i:s');

        //if current time greater/equal to draft date/time then that means it's past the draft time. Show Timers
        if ($currentTime >= $draft_date && ! $leagueDetails->draft_completed) {
            //See if the generate console command has ran yet.
            $draft_started = true;
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
                    $draft_started = true;
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
                        if ($collection->league_overall_pick == 1) {
                            $draftStartAudio = url('/audio/crowd.mp3');
                        }
                    } else {
                        $draft_started = true;
                        //$message="You are done drafting!";
                        $message = '';
                    }

                    //Load the teams to show in the draft card row.
                    $teams = DraftOrder::where('draft_order.league_id', $team->league_id)
                        ->leftJoin('fantasy_teams as f', 'f.id', '=', 'draft_order.fantasy_team_id')
                        ->where('fantasy_player_id', null)
                        ->take(12)->get();
                }
            }
        }

        // 	$draft_round_order_details=array();

        // 	foreach($draftOrderList as $key=>$list){

        // 		$position=$list->position;

        // 	if($list->player_transaction_type_id == 1)
        // 		$status='Added';
        // 	else
        // 		$status='Drafted';

        // 	$draft_round_order_details[$list->id]['round']						=  $list->round;
        // 	$draft_round_order_details[$list->id]['round_overall_pick']			=  $list->round_overall_pick;
        // 	$draft_round_order_details[$list->id]['fantasy_player_id']			=  $list->fantasy_player_id;
        // 	$draft_round_order_details[$list->id]['league_overall_pick']		=  $list->league_overall_pick;
        // 	$draft_round_order_details[$list->id]['name']						=  $list->name;
        // 	$draft_round_order_details[$list->id]['position']					=  $position;
        // 	$draft_round_order_details[$list->id]['week']						=  $list->week;
        // 	$draft_round_order_details[$list->id]['team']						=  $list->team;
        // 	$draft_round_order_details[$list->id]['fantasy_team']				=  $list->fantasyTeam->name;
        // 	$draft_round_order_details[$list->id]['status']		  				=  (!empty($list->playerTransactionType))?$list->playerTransactionType->name:'';

        // 	$draft_round_order_details[$list->id]['fantasy_team_id']			=  $list->fantasy_team_id;
        // }

        // $draft_order_details=array();
        // $draftOrder = FantasyTeamsPlayerTransaction::where('fantasy_teams_player_transactions.league_id',$team->league_id)
        // 					->leftJoin('fantasy_player as p','p.id','=','fantasy_teams_player_transactions.fantasy_player_id')

        // 					->where('season',$season)
        // 					->where('season_type',$season_type)
        // 					->get();

        // foreach($draftOrder as $key=>$list){
        // 		$position=$list->position;

        // 	if($list->player_transaction_type_id == 1)
        // 		$status='Added';
        // 	else
        // 		$status='Drafted';

        // 	$draft_order_details[$key]['fantasy_name']	=  (!empty($list->fantasyTeam))?$list->fantasyTeam->name:'';
        // 	$draft_order_details[$key]['created_at']	=  date('F d',strtotime($list->created_at));
        // 	$draft_order_details[$key]['name']			=  $list->name;
        // 	$draft_order_details[$key]['fantasy_player_id']=  $list->id;
        // 	$draft_order_details[$key]['position']		=  $position;
        // 	$draft_order_details[$key]['week']			=  $list->week;
        // 	$draft_order_details[$key]['team']			=  $list->team;
        // 	$draft_order_details[$key]['status']		=  (!empty($list->playerTransactionType))?$list->playerTransactionType->name:'';
        // 	$draft_order_details[$key]['fantasy_team_id']= $list->fantasy_team_id;
        // 	$draft_order_details[$key]['fantasy_team']	=  $list->fantasyTeam->name;
        // }
        $response['draftRoundData'] = array_values($draftOrderList);

        if (! empty($current_draft)) {
            // Add in position counts to the records.
            $positionCounts = Helper::getUserFantasyTeamRoster($current_draft->id);
            $current_draft->setAttribute('position_counts', $positionCounts);
        }
        $response['currentDraft'] = ! empty($current_draft) ? $current_draft->load(['fantasyTeam']) : [];

        $response['league'] = $leagueDetails;
        $response['message'] = $message;
        // $response['draftCompleted']	=	($leagueDetails->draft_completed ? true : false);
        // $response['draft_pick_max_time']	=	($leagueDetails->draft_pick_max_time ? $leagueDetails->draft_pick_max_time : 60);
        $response['draftStarted'] = ($draft_started ? true : false);
        // $response['draft_date']	=	$draft_date;
        // $response['show_timer']	=	$show_timer;
        $response['user_team_id'] = $team->id;
        // $response['show_draft_order'] = $show_draft_order;
        // $response['league_draft_date'] = $leagueDetails->draft_date;
        $response['on_clock_audio'] = url('/audio/ticktock.mp3');
        $response['draft_start_audio'] = url('/audio/crowd.mp3');

        return response()->json($response);
    }

    public function leagueRoundDraftPick()
    {
        $userId = Auth::user()->id;
        $team = FantasyTeam::where('user_id', $userId)->first();
        $leagueDetails = League::find($team->league_id);

        /*$draftOrder		=	DraftOrder::where('draft_order.league_id',$team->league_id)
                            ->leftJoin('fantasy_player as f','f.id','=','draft_order.player_id')

                            ->where('draft_order.player_id','<>',NULL)
                            ->orderBy('draft_order.id','desc')
                            ->get()->toArray();
        */
        $draftOrder = FantasyTeamsPlayerTransaction::where('fantasy_teams_player_transactions.league_id', $team->league_id)
            ->leftJoin('fantasy_player as p', 'p.id', '=', 'fantasy_teams_player_transactions.fantasy_player_id')
            ->get();
        $draft_order_details = [];

        foreach ($draftOrder as $key => $list) {
            $position = $list->position;

            if ($list->player_transaction_type_id == 1) {
                $status = 'Added';
            } else {
                $status = 'Drafted';
            }

            $draft_order_details[$key]['fantasy_name'] = (! empty($list->fantasyTeam)) ? $list->fantasyTeam->name : '';
            $draft_order_details[$key]['created_at'] = date('F d', strtotime($list->created_at));
            $draft_order_details[$key]['name'] = $list->name;
            $draft_order_details[$key]['position'] = $position;
            $draft_order_details[$key]['week'] = $list->week;
            $draft_order_details[$key]['team'] = $list->team;
            $draft_order_details[$key]['status'] = $status;
            $draft_order_details[$key]['fantasy_team_id'] = $list->fantasy_team_id;
        }

        $response['draftData'] = $draft_order_details;
        $response['draftCompleted'] = ($leagueDetails->draft_completed ? 1 : 0);

        return response()->json($response);
    }
}
