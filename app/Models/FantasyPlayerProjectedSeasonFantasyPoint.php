<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FantasyPlayerProjectedSeasonFantasyPoint extends Model
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
        'fantasy_points',
    ];
}
