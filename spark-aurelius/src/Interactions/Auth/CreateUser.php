<?php

namespace Laravel\Spark\Interactions\Auth;

use Laravel\Spark\Spark;
use Illuminate\Support\Facades\Validator;
use Laravel\Spark\Contracts\Repositories\UserRepository;
use Laravel\Spark\Contracts\Interactions\Auth\CreateUser as Contract;
use URL;

class CreateUser implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function validator($request)
    {
        $validator = $this->baseValidator($request);

        $validator->sometimes('team', 'required|max:255', function ($input) {
            return Spark::usesTeams() &&
                   Spark::onlyTeamPlans() &&
                   ! isset($input['invitation']);
        });

        $validator->sometimes('team_slug', 'required|alpha_dash|unique:teams,slug', function ($input) {
            return Spark::usesTeams() &&
                   Spark::onlyTeamPlans() &&
                   Spark::teamsIdentifiedByPath() &&
                   ! isset($input['invitation']);
        });
		
		
		
		$validator->sometimes('league_name', 'required', function ($input) {
			$uri 			= URL::previous();
			$uri_parts 		= explode('/', $uri);
			$uri_tail 		= end($uri_parts);
			$invite_code 	= '';
			if($uri_tail != 'register')
				$invite_code =	$uri_tail;
			return isset($input['league_name']) && $invite_code =='';
        });
		
		
        return $validator;
    }

    /**
     * Create a base validator instance for creating a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Validation\Validator
     */
    protected function baseValidator($request)
    {
        return Validator::make(
            $request->all(), Spark::call(static::class.'@rules', [$request]),
            [], ['address_line_2' => __('second address line')]
        );
    }

    /**
     * Get the basic validation rules for creating a new user.
     *
     * @param  \Laravel\Spark\Http\Requests\Auth\RegisterRequest  $request
     * @return array
     */
    public function rules($request)
    {
		$rules = [];
		$rules['name'] = 'required|max:255';
		$rules['team_name'] = 'required|max:255';
		$rules['short_name'] = 'required|max:5';
		$rules['email'] = 'required|email|max:255|unique:users';
		$rules['password'] = 'required|confirmed|min:'.Spark::minimumPasswordLength();
		$rules['vat_id'] = 'nullable|max:50|vat_id';
		$rules['terms'] = 'required|accepted';

        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function handle($request)
    {
        return Spark::interact(UserRepository::class.'@create', [$request->all()]);
    }
}
