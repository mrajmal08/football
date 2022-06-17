<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerPunting extends Model
{
    use SoftDeletes;

    protected $table = 'player_punting';

    protected $fillable = [
        'player_game_id',
        'player_id',
        'short_name',
        'name',
        'team',
        'number',
        'position',
        'position_category',
        'fantasy_position',
        'fantasy_points',
        'updated',
        'punts',
        'punt_average',
        'punt_inside20',
        'punt_touchbacks',
        'punt_yards',
    ];

    protected $casts = [
        'player_game_id' => 'integer',
        'player_id' => 'integer',
        'short_name' => 'string',
        'name' => 'string',
        'team' => 'string',
        'number' => 'integer',
        'position' => 'string',
        'position_category' => 'string',
        'fantasy_position' => 'string',
        'fantasy_points' => 'integer',
        'updated' => 'string',
        'punts' => 'integer',
        'punt_average' => 'integer',
        'punt_inside20' => 'integer',
        'punt_touchbacks' => 'integer',
        'punt_yards' => 'integer',
    ];
}
