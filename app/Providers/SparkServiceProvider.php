<?php

namespace App\Providers;

use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;
use Laravel\Spark\Spark;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Your Company',
        'product' => 'Your Product',
        'street' => 'PO Box 111',
        'location' => 'Your Town, NY 12345',
        'phone' => '555-555-5555',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = null;

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        'tylor@peakcollective.com', 'thindery@gmail.com', 'toddtoddbirk@aol.com', 'dirlas24@gmail.com', 'hvats.hv@gmail.com',
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = true;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function boot()
    {
        Spark::useStripe()->noCardUpFront()->trialDays(10);

        /*  Spark::freePlan()
              ->features([
                  'First', 'Second', 'Third'
              ]);

          Spark::plan('Basic', 'provider-id-1')
              ->price(10)
              ->features([
                  'First', 'Second', 'Third'
              ]);
              */
        Spark::plan('2019 Season', env('STRIPE_PLAN_ID'))
            ->price(150)
            ->yearly()
            ->features([
                'Feature 1',
                'Feature 2',
                'Feature 3',
            ]);
        Spark::canBillCustomers();
    }

    public function register()
    {
        Spark::useUserModel(\App\Models\User::class);

        Spark::useTeamModel(\App\Models\Team::class);
    }
}
