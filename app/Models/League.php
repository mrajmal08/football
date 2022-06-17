<?php

namespace App\Models;

use App\Events\LeagueOrDraftDataChanged;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'number_of_teams',
        'league_commissioner_id',
        'invite_code',
        'season',
        'season_type',
        'week',
        'allow_team_qb',
        'online_draft',
        'draft_order_generated',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    // protected $casts = [
    //     'draft_date' => 'timestamp',
    // ];

    protected $dispatchesEvents = [
        'saved' => LeagueOrDraftDataChanged::class,
        // 'created' => DraftOrderChanged::class,
    ];

    /**
     * Get the league commisoner that owns the league.
     */
    public function leagueCommissioner()
    {
        return $this->hasMany(\App\Models\LeagueCommissioner::class);
    }

    /**
     * Get the teams that owned by league.
     */
    public function teams()
    {
        return $this->hasMany(\App\Models\FantasyTeam::class);
    }

    /**
     * Get the teams that owned by league.
     */
    public function invitations()
    {
        return $this->hasMany(\App\Models\LeagueInvitation::class);
    }
}
