<?php

namespace Laravel\Spark\Http\Middleware;

use Closure;
class VerifyUserIsSubscribed
{
    /**
     * Verify the incoming request's user has a subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $subscription
     * @param  string  $plan
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next, $subscription = 'default', $plan = null)
    {
		
		$league_owner=$request->user()->leagues;	

		if(empty($league_owner)){
			 return $next($request);
		}
        if ($request->user()) {
            return $next($request);
        }

        return $request->ajax() || $request->wantsJson()
                                ? response('Subscription Required.', 402)
                                : redirect('/register/final');
    }

    /**
     * Determine if the given user is subscribed to the given plan.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $subscription
     * @param  string  $plan
     * @param  bool  $defaultSubscription
     * @return bool
     */
    protected function subscribed($user, $subscription, $plan, $defaultSubscription)
    {
        if (! $user) {
            return false;
        }

        return ($defaultSubscription && $user->onGenericTrial()) ||
                $user->subscribed($subscription, $plan);
    }
}
