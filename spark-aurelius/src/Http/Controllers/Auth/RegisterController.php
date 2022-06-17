<?php

namespace Laravel\Spark\Http\Controllers\Auth;

use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Spark\Events\Auth\UserRegistered;
use Laravel\Spark\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Laravel\Spark\Contracts\Interactions\Auth\Register;
use Laravel\Spark\Contracts\Http\Requests\Auth\RegisterRequest;
use App\Models\League;
use App\Models\FantasyTeam;
use App\Notifications\WelcomeToFantasyLeague;
use App\Models\SystemSetting;
class RegisterController extends Controller
{
    use RedirectsUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

        $this->redirectTo = Spark::afterLoginRedirect();
    }

    /**
     * Show the application registration form.
     *
     * @param  Request  $request
     * @return Response
     */
    public function showRegistrationForm(Request $request, $inviteCode = '')
    {
		
        if (Spark::promotion() && ! $request->filled('coupon')) {
            // If the application is running a site-wide promotion, we will redirect the user
            // to a register URL that contains the promotional coupon ID, which will force
            // all new registrations to use this coupon when creating the subscriptions.
            return redirect($request->fullUrlWithQuery([
                'coupon' => Spark::promotion()
            ]));
        }
			$systemSettings	= SystemSetting::first();	
			
		$league='';
		if($inviteCode != ''){
			$league		=	League::where('invite_code',$inviteCode)->first();
			if(empty($league)){
				return redirect('register')->with('error', "Your invite code is not valid. Please try again.");
			}else{
				$teamCount	=	FantasyTeam::where('league_id',$league->id)->count();
				if($league->number_of_teams == $teamCount){
					$league_full	=	"This league is already full. Please click this button to create your own league.";
					return view('spark::auth.register', compact('league_full','inviteCode','systemSettings'));
				}
			}
		}	
			
        return view('spark::auth.register', compact('inviteCode','league','systemSettings'));
	}
	
    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest  $request
     * @return Response
     */
    public function register(RegisterRequest $request)
    {
        Auth::login($user = Spark::interact(
            Register::class, [$request]
        ));	
	  $user->notify(new WelcomeToFantasyLeague($user));

        event(new UserRegistered($user));
		
		$league_owner=$user->leagues;	
	
		if(!empty($league_owner)){		
			$this->redirectTo = Spark::afterRegisterRedirect();
		
		}
		
        return response()->json([
            'redirect' => $this->redirectPath()
        ]);
    }
}
