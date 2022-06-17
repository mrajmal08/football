<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerPassing extends Model
{
    use SoftDeletes;

    protected $table = 'player_passing';

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
        'passing_attempts',
        'passing_completions',
        'passing_yards',
        'passing_touchdowns',
        'passing_interceptions',
        'passing_long',
        'passing_sacks',
        'passing_sack_yards',
        'passing_completion_percentage',
        'passing_yards_per_attempt',
        'passing_yards_per_completion',
        'passing_rating',
        'two_point_conversion_passes',
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
        'passing_attempts' => 'integer',
        'passing_completions' => 'integer',
        'passing_yards' => 'integer',
        'passing_touchdowns' => 'integer',
        'passing_interceptions' => 'integer',
        'passing_long' => 'integer',
        'passing_sacks' => 'integer',
        'passing_sack_yards' => 'integer',
        'passing_completion_percentage' => 'integer',
        'passing_yards_per_attempt' => 'integer',
        'passing_yards_per_completion' => 'integer',
        'passing_rating' => 'integer',
        'two_point_conversion_passes' => 'integer',
        'fumbles_lost' => 'integer',
    ];
}
