<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerKicking extends Model
{
    use SoftDeletes;

    protected $table = 'player_kicking';

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
        'extra_points_made',
        'extra_points_attempted',
        'field_goals_made',
        'field_goals_attempted',
        'field_goals_longest_made',
        'field_goal_percentage',
        'field_goals_made0to19',
        'field_goals_made20to29',
        'field_goals_made30to39',
        'field_goals_made40to49',
        'field_goals_made50_plus',
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
        'extra_points_made' => 'integer',
        'extra_points_attempted' => 'integer',
        'field_goals_made' => 'integer',
        'field_goals_attempted' => 'integer',
        'field_goals_longest_made' => 'integer',
        'field_goal_percentage' => 'integer',
        'field_goals_made0to19' => 'integer',
        'field_goals_made20to29' => 'integer',
        'field_goals_made30to39' => 'integer',
        'field_goals_made40to49' => 'integer',
        'field_goals_made50_plus' => 'integer',
    ];
}
