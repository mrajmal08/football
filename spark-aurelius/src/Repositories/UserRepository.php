<?php

namespace Laravel\Spark\Repositories;

use Carbon\Carbon;
use Laravel\Spark\Spark;
use Illuminate\Support\Facades\Auth;
use Laravel\Spark\Events\PaymentMethod\VatIdUpdated;
use Laravel\Spark\Events\PaymentMethod\BillingAddressUpdated;
use Laravel\Spark\Contracts\Repositories\UserRepository as UserRepositoryContract;
use App\Models\League;
use App\Models\User;
use App\Models\LeagueCommissioner;
use App\Models\FantasyTeam;
use App\Models\ScoringReview;
use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyTeamsPlayerTransaction;
use URL;
use Exception;
use App\Models\SystemSetting;
use Helper;
use App\Models\LeagueInvitation;

class UserRepository implements UserRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function current()
    {
        if (Auth::check()) {
            return $this->find(Auth::id())->shouldHaveSelfVisibility();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $showLeague     = 0;
        $user 		= Spark::user()->where('id', $id)->first();
        $manager 	= app('impersonate');
        $is_manager = $manager->isImpersonating();
        $fantasyTeam = $user->teams->first();
        $league = $fantasyTeam->league;

        //Set commissioner Details
        $commissioner = $league->leagueCommissioner->first();
        $user->league_owner = $commissioner->user_id;
        if ($commissioner->user_id == $user->id) {
            $user->is_commissioner    = 1;
        }

        //Set CoCommissioner Details
        // $coCommissioner = $league->leagueCommissioner->get(1); //Gets 2nd if it exists
        // $user->co_commissioner = $coCommissioner->user_id;

        //TODO: Not sure what this does?
        $leagueTeam = FantasyTeam::where('league_id', $league->id)->get();

        $systemSettings	= SystemSetting::first();
        
        if (!empty($league)) {
            $user->league_name		=	$league->name;
            $user->season			=	$league->season;
            $user->season_type		=	$league->season_type;
            $user->week				=	$league->week;
            if ($league->draft_date != null) {
                $user->draft_date	=	date("Y-m-d\TH:i:s.000\Z", strtotime($league->draft_date));
            } else {
                $user->draft_date	= 	'';
            }
            $user->invite_code		=	url("/register/{$league->invite_code}");
            $user->number_of_teams	=	$league->number_of_teams;
            $user->allow_team_qb	=	$league->allow_team_qb;
            $user->teams_count		=	count($leagueTeam);
            $user->league_teams		=	$leagueTeam->toArray();
            $user->override_system 	=	$league->override_system;
            $user->online_draft 	=	$league->online_draft;
            $user->draft_pick_max_time 	=	$league->draft_pick_max_time;
        }
        
        if (!empty($systemSettings)) {
            $user->sys_season						=	$systemSettings->season;
            $user->sys_season_type					=	$systemSettings->season_type;
            $user->sys_week							=	$systemSettings->week;
            $user->sys_waiver_period_enabled		=	$systemSettings->waiver_period_enabled;
            $user->sys_display_ads					=	$systemSettings->display_ads;
        }
        $user->is_manager				=	$is_manager;
        $fantasy_player_transaction_count=0;
        
        $fantasy_team_has_fantasy_player=0;
        $players_array = [];



        // if(!empty($league)){
        // 	$fantasy_player_transaction	= FantasyTeamsPlayerTransaction::select('id','fantasy_player_id','fantasy_team_id')->with(['fantacyPlayer'])
        // 																	->where('league_id',$league->id)
        // 																	->where('active',1)->orderBy('week','desc')->get();
        // 	$collection = collect($fantasy_player_transaction);
        // 	$grouped = $collection->groupBy('fantasy_team_id');
        // 	$groupCount = $grouped->map(function ($item, $key) {
        // 			return collect($item)->count();
        // 		});
        // 	$fantasy_team_has_fantasy_player=count($groupCount);
            
        // 		$teamcollection = collect($fantasy_player_transaction);
        // 	    $team_grouped 	= $teamcollection->groupBy('fantasy_team_id');
        
        // 	$fantasy_player_transaction	= FantasyTeamsPlayerTransaction::select('id','fantasy_player_id','fantasy_team_id')->with(['fantacyPlayer'])
        // 																		->where('league_id',$league->id)
        // 																		->where('week',    $systemSettings->week)
        // 																		->where('season',  $systemSettings->season)
        // 																		->where('season_type',  $systemSettings->season_type)
        // 																		->where('active',1)->orderBy('week','desc')->get();
                
        // 			foreach($fantasy_player_transaction as $list){
                        
        // 				$players_array[$list->fantasy_team_id][$list->fantacyPlayer->position][]=array('fantasy_player_id'=>$list->fantacyPlayer->id,
        // 																'position'=>$list->fantacyPlayer->position,
        // 																'name'=>$list->fantacyPlayer->name
        // 																);
                        
        // 			}
        // }


        // $scoring_review		= ScoringReview::with(['fantacyPlayer'])->where('week',    $systemSettings->week)
        // 															->where('season',  $systemSettings->season)
        // 															->where('season_type',  $systemSettings->season_type)
        // 															->get();
                                                                                                
        
        // 		$fantasy_player		= FantasyPlayer::select('id','team','position','name','average_draft_position')->orderBy('average_draft_position')->get();
        // 		$collection = collect($fantasy_player);
        // 		$grouped = $collection->groupBy('position');
        // 		$user->fantasy_player				=	$grouped;
        // 		$user->fantasy_team_has_fantasy_player	=	$fantasy_team_has_fantasy_player;
        // 		$user->fantasy_player_all				=	$fantasy_player;
        // 		$years = range(Carbon::now()->year, 2016);
        // 		$user->settings_years				=	$years;
        // 		$user->settings_years				=	$years;
        // 		$user->team_grouped					=	$players_array;
        // 		//dd($user);
        return $user ? $this->loadUserRelationships($user) : null;
    }
  

    /**
     * Load the relationships for the given user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function loadUserRelationships($user)
    {
        $user->load('subscriptions');

        if (Spark::usesTeams()) {
            $user->load(['ownedTeams.subscriptions', 'teams.subscriptions']);

            $user->currentTeam();
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function search($query, $excludeUser = null)
    {
        $search = Spark::user()->with('subscriptions');

        // If a user to exclude was passed to the repository, we will exclude their User
        // ID from the list. Typically we don't want to show the current user in the
        // search results and only want to display the other users from the query.
        if ($excludeUser) {
            $search->where('id', '<>', $excludeUser->id);
        }

        return $search->where(function ($search) use ($query) {
            $search->where('email', 'like', $query)
                   ->orWhere('name', 'like', $query);
        })->get();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $systemSettings	= Helper::getSystemSettingsDetails();
        $week			= $systemSettings['week'];
        $season			= $systemSettings['season'];
        $seasonType		= $systemSettings['season_type'];
        
        $user 			= Spark::user();
        $uri 			= URL::previous();
        $uri_parts 		= explode('/', $uri);
        $uri_tail 		= end($uri_parts);
        $invite_code 	= $invite_token = '';
        if ($uri_tail != 'register') {
            $uri_sub_parts = explode('?invite_token=', $uri_tail);
            if (!empty($uri_sub_parts)) {
                $invite_code 	=	$uri_sub_parts[0];
                if (isset($uri_sub_parts[1])) {
                    $invite_token 	=	$uri_sub_parts[1];
                }
            } else {
                $invite_code 	=	$uri_tail;
                $invite_token 	=	'';
            }
        }
        
        
        
        
        $user->forceFill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'last_read_announcements_at' => Carbon::now(),
            'trial_ends_at' => Carbon::now()->addDays(Spark::trialDays()),
        ])->save();
        
        if (isset($data['league_name']) && $data['league_name'] != '') {
            $league = League::create([
                'name' => $data['league_name'],
                'number_of_teams' => 12,
                'invite_code' => str_random(16),
                'season' => $season,
                'season_type' => 1,
                'week' => 1
            ]);
            LeagueCommissioner::create([
                'user_id' => $user->id,
                'league_id' => $league->id
            ]);
        } elseif ($invite_code != '') {
            $league = League::where('invite_code', $invite_code)->first();
        }
        
        if (!empty($league)) {
            $fantasy_team = FantasyTeam::create([
                'name' => $data['team_name'],
                'short_name' => $data['short_name'],
                'user_id' => $user->id,
                'league_id' => $league->id
            ]);
        }
        
        if ($invite_token != '') {
            $invitation_details = LeagueInvitation::where('token', $invite_token)->first();
            $invitation_details->fantasy_team_id = $fantasy_team->id;
            $invitation_details->save();
        }
        
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function updateBillingAddress($user, array $data)
    {
        $user->forceFill([
            'card_country' => array_get($data, 'card_country'),
            'billing_address' => array_get($data, 'address'),
            'billing_address_line_2' => array_get($data, 'address_line_2'),
            'billing_city' => array_get($data, 'city'),
            'billing_state' => array_get($data, 'state'),
            'billing_zip' => array_get($data, 'zip'),
            'billing_country' => array_get($data, 'country'),
        ])->save();

        event(new BillingAddressUpdated($user));
    }

    /**
     * {@inheritdoc}
     */
    public function updateVatId($user, $vatId)
    {
        $user->forceFill(['vat_id' => $vatId])->save();

        event(new VatIdUpdated($user));
    }
}
