<?php

namespace App\Models;

use Helper;
use Illuminate\Database\Eloquent\Model;

class FantasyTeam extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'league_id',
        'short_name',
    ];

    protected $appends = ['sys_short_name'];

    /**
     * Get the leagues that belongs to the team.
     */
    public function league()
    {
        return $this->belongsTo(\App\Models\League::class);
    }

    /**
     * Get the users that belongs to the team.
     */
    public function users()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Get the team owner  that belongs to the team.
     */
    public function teamOwner()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Get the fantasy team player transactions for teams.
     */
    public function playerTransactions()
    {
        return $this->hasMany('App\Models\FantasyTeamPlayerTransaction');
    }

    /**
     * Get the fantasy team roster.
     */
    public function FantasyTeamRoster()
    {
        return $this->hasMany(\App\Models\FantasyTeamsRoster::class, 'fantasy_team_id', 'id');
    }

    /**
     * Get the fantasy team roster.
     */
    public function leagueTeamRanking()
    {
        $systemSettings = Helper::getSystemSettingsDetails();
        $week = $systemSettings['week'];
        $season = $systemSettings['season'];
        $seasonType = $systemSettings['season_type'];

        return $this->hasOne(\App\Models\LeagueTeamRanking::class, 'fatasy_team_id', 'id')
            ->where('week', $week - 1)
            ->where('season', $season)
            ->where('season_type', $seasonType);
    }

    public function getSysShortNameAttribute()
    {
        if ($this->short_name) {
            return $this->short_name;
        } else {
            $temp = explode(' ', $this->name);
            $result = '';
            foreach ($temp as $t) {
                if (is_array($t)) {
                    $result .= $t[0];
                } else {
                    $result .= '';
                }
            }

            return $result;
        }
    }

    // TODO: Update this to do what the PlayerController::checkFantasyTeamRoster() does
    public function getPositionCountAttribute()
    {
        return 0;

        // return Helper::getUserFantasyTeamRoster($this);
        //$fantasyTeam = $this->FantasyTeamRoster->toArray();
        return $this->FantasyTeamRoster;
        //$counts = array_count_values(array_column($fantasyTeam, 'position','fantasy_team_roster'));
        // //$fantasyTeam['position_counts'] = $counts;
        //return $counts;
    }
}
