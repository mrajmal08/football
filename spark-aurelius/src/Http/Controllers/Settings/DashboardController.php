<?php

namespace Laravel\Spark\Http\Controllers\Settings;

use Laravel\Spark\Http\Controllers\Controller;
use Auth;
use App\Models\LeagueCommissioner;
use App\Models\League;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the settings dashboard.
     *
     * @return Response
     */
    public function show()
    {
		$user 				= Auth::user();
    $fantasyTeam = $user->teams->first();
    $league = $fantasyTeam->league;
    $commissioner = $league->leagueCommissioner->first();

    //If we have a commissioner we need to show League specific settings the user can adjust
		$showLeague			= 0;
		if($commissioner->user_id == $user->id){
			$showLeague		=	1;
		}
      return view('spark::settings',compact('showLeague'));
    }
	
	public function final_show()
    {		
		$user = Auth::user();		
		if (Auth::user()->subscribed()){
			
			return \Redirect::to('league/home');
		}
		
    $fantasyTeam = $user->teams->first();
    $league = $fantasyTeam->league;
    $commissioner = $league->leagueCommissioner->first();

    $showLeague     = 0;
    if($commissioner->user_id == $user->id){
			$showLeague		=	1;
		}
    return view('spark::register',compact('showLeague'));
    }
}
