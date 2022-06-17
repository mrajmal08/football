<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Spark\User as SparkUser;

class User extends SparkUser
{
    use Impersonate,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'two_factor_reset_code',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    protected $appends = ['is_commissioner'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'uses_two_factor_auth' => 'boolean',
    ];

    /**
     * Get the teams that owned by users.
     */
    public function teams()
    {
        return $this->hasMany(\App\Models\FantasyTeam::class);
    }

    /**
     * Get the fantasy league that owned by users.
     */
    /**
     * Get the league that owned by users.
     */
    // public function league()
    //    {
    //        return $this->fantasyTeam->leagues;
    //    }
    /**
     * Get the league coownner by users.
     */
    public function leagueCoOwnner()
    {
        return $this->hasOne(\App\Models\LeagueCommissioner::class, 'is_co_commissioner');
    }

    public function leagueCommissioner()
    {
        return $this->hasOneThrough(\App\Models\LeagueCommissioner::class, \App\Models\League::class, 'id', 'league_id');
    }

    public function getIsCommissionerAttribute()
    {
        if ($this->leagueCommissioner) {
            return true;
        }

        return false;
    }
}
