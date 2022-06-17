<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueScheduleSim extends Model
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
    ];
}
