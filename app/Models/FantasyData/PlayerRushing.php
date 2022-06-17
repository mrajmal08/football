<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerRushing extends Model
{
    use SoftDeletes;

    protected $table = 'player_rushing';

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
        'rushing_attempts',
        'rushing_yards',
        'rushing_touchdowns',
        'rushing_long',
        'rushing_yards_per_attempt',
        'fumbles_lost',
        'two_point_conversion_runs',
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
        'rushing_attempts' => 'integer',
        'rushing_yards' => 'integer',
        'rushing_touchdowns' => 'integer',
        'rushing_long' => 'integer',
        'rushing_yards_per_attempt' => 'integer',
        'fumbles_lost' => 'integer',
        'two_point_conversion_runs' => 'integer',
    ];
}
