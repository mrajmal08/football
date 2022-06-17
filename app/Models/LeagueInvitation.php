<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueInvitation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'league_id',
        'fantasy_team_id',
        'email',
        'role',
        'token',
    ];

    public function generateInvitationToken()
    {
        $this->token = substr(md5(rand(0, 9).$this->email.time()), 0, 32);
    }

    /**
     * Get the teams that owned by league.
     */
    public function users()
    {
        return $this->hasOne(\App\Models\User::class, 'email', 'email');
    }

    /**
     * Get the teams that owned by league.
     */
    public function fantasyTeams()
    {
        return $this->hasOne(\App\Models\FantasyTeam::class, 'id', 'fantasy_team_id');
    }
}
