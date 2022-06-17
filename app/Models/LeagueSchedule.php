<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueSchedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'league_id',
        'week',
        'year',
        'game_type_id',
        'week_game',
        'reg_season_tourn_type',
    ];

    protected $table = 'league_schedule';

    /**
     * Get the league game that owns the league.
     */
    public function leagueHomeTeam()
    {
        return $this->belongsTo(\App\Models\FantasyTeam::class, 'home_team_id', 'id');
    }

    public function leagueAwayTeam()
    {
        return $this->belongsTo(\App\Models\FantasyTeam::class, 'away_team_id', 'id');
    }
}
