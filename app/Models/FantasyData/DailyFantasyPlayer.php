<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyFantasyPlayer extends Model
{
    use SoftDeletes;

    protected $table = 'daily_fantasy_player';

    protected $fillable = [
        'player_id',
        'date',
        'short_name',
        'name',
        'team',
        'opponent',
        'home_or_away',
        'position',
        'salary',
        'last_game_fantasy_points',
        'projected_fantasy_points',
        'opponent_rank',
        'opponent_position_rank',
        'status',
        'status_code',
        'status_color',
        'fan_duel_salary',
        'draft_kings_salary',
        'yahoo_salary',
        'fantasy_data_salary',
        'fantasy_draft_salary',
    ];

    protected $casts = [
        'player_id' => 'integer',
        'date' => 'string',
        'short_name' => 'string',
        'name' => 'string',
        'team' => 'string',
        'opponent' => 'string',
        'home_or_away' => 'string',
        'position' => 'string',
        'salary' => 'integer',
        'last_game_fantasy_points' => 'integer',
        'projected_fantasy_points' => 'integer',
        'opponent_rank' => 'integer',
        'opponent_position_rank' => 'integer',
        'status' => 'string',
        'status_code' => 'string',
        'status_color' => 'string',
        'fan_duel_salary' => 'integer',
        'draft_kings_salary' => 'integer',
        'yahoo_salary' => 'integer',
        'fantasy_data_salary' => 'integer',
        'fantasy_draft_salary' => 'integer',
    ];
}
