<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueGame extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_schedule_id',
        'team_id',
        'opponent_id',
        'away_team_id',
        'home_team_id',
        'team_score',
        'opponent_score',
        'win',
        'loss',
        'tie',
        'year',
        'week',
        'game_type_id',
        'is_finished',
    ];
}
