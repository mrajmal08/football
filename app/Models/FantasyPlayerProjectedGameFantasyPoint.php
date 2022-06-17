<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FantasyPlayerProjectedGameFantasyPoint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fantasy_player_id',
        'season',
        'season_type',
        'week',
        'game_key',
        'fantasy_points',
    ];
}
