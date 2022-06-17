<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Session;
use Stripe;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        // dd(env('amount'));
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([
            'amount' => 15000.00,
            'currency' => 'usd',
            'customer' => 'cus_HECLfYVUWQJ3IO',
            'source' => $request->stripeToken,
            'description' => 'League start payment',
        ]);

        $user = auth()->user();
        $user = User::find($user->id);
        $user->uses_two_factor_auth = 1;
        $user->save();

        Session::flash('success', 'Payment successful!');

        return back();
    }
}
