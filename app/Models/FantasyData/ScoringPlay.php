<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScoringPlay extends Model
{
    use SoftDeletes;

    protected $table = 'scoring_play';

    protected $fillable = [
        'game_key',
        'season_type',
        'scoring_play_id',
        'season',
        'week',
        'away_team',
        'home_team',
        'date',
        'sequence',
        'team',
        'quarter',
        'time_remaining',
        'play_description',
        'away_score',
        'home_score',
        'score_id',
    ];

    protected $casts = [
        'game_key' => 'string',
        'season_type' => 'integer',
        'scoring_play_id' => 'integer',
        'season' => 'integer',
        'week' => 'integer',
        'away_team' => 'string',
        'home_team' => 'string',
        'date' => 'string',
        'sequence' => 'integer',
        'team' => 'string',
        'quarter' => 'string',
        'time_remaining' => 'string',
        'play_description' => 'string',
        'away_score' => 'integer',
        'home_score' => 'integer',
        'score_id' => 'integer',
    ];
}
