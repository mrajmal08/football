<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyFantasyScoring extends Model
{
    use SoftDeletes;

    protected $table = 'daily_fantasy_scoring';

    protected $fillable = [
        'player_id',
        'name',
        'team',
        'position',
        'fantasy_points',
        'fantasy_points_p_p_r',
        'fantasy_points_fan_duel',
        'fantasy_points_draft_kings',
        'fantasy_points_yahoo',
        'has_started',
        'is_in_progress',
        'is_over',
        'date',
        'fantasy_points_fantasy_draft',
    ];

    protected $casts = [
        'player_id' => 'integer',
        'name' => 'string',
        'team' => 'string',
        'position' => 'string',
        'fantasy_points' => 'integer',
        'fantasy_points_p_p_r' => 'integer',
        'fantasy_points_fan_duel' => 'integer',
        'fantasy_points_draft_kings' => 'integer',
        'fantasy_points_yahoo' => 'integer',
        'has_started' => 'boolean',
        'is_in_progress' => 'boolean',
        'is_over' => 'boolean',
        'date' => 'string',
        'fantasy_points_fantasy_draft' => 'integer',
    ];
}
