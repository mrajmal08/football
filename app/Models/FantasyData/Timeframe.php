<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timeframe extends Model
{
    use SoftDeletes;

    protected $table = 'timeframe';

    protected $fillable = [
        'season_type',
        'season',
        'week',
        'name',
        'short_name',
        'start_date',
        'end_date',
        'first_game_start',
        'first_game_end',
        'last_game_end',
        'has_games',
        'has_started',
        'has_ended',
        'has_first_game_started',
        'has_first_game_ended',
        'has_last_game_ended',
        'api_season',
        'api_week',
    ];

    protected $casts = [
        'season_type' => 'integer',
        'season' => 'integer',
        'week' => 'integer',
        'name' => 'string',
        'short_name' => 'string',
        'start_date' => 'string',
        'end_date' => 'string',
        'first_game_start' => 'string',
        'first_game_end' => 'string',
        'last_game_end' => 'string',
        'has_games' => 'boolean',
        'has_started' => 'boolean',
        'has_ended' => 'boolean',
        'has_first_game_started' => 'boolean',
        'has_first_game_ended' => 'boolean',
        'has_last_game_ended' => 'boolean',
        'api_season' => 'string',
        'api_week' => 'string',
    ];
}
