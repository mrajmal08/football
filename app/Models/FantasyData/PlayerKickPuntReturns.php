<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerKickPuntReturns extends Model
{
    use SoftDeletes;

    protected $table = 'player_kick_punt_returns';

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
        'kick_returns',
        'kick_return_yards',
        'kick_return_yards_per_attempt',
        'kick_return_long',
        'kick_return_touchdowns',
        'punt_returns',
        'punt_return_yards',
        'punt_return_yards_per_attempt',
        'punt_return_long',
        'punt_return_touchdowns',
        'fumbles_lost',
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
        'kick_returns' => 'integer',
        'kick_return_yards' => 'integer',
        'kick_return_yards_per_attempt' => 'integer',
        'kick_return_long' => 'integer',
        'kick_return_touchdowns' => 'integer',
        'punt_returns' => 'integer',
        'punt_return_yards' => 'integer',
        'punt_return_yards_per_attempt' => 'integer',
        'punt_return_long' => 'integer',
        'punt_return_touchdowns' => 'integer',
        'fumbles_lost' => 'integer',
    ];
}
