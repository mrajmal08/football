<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoxScoreV3 extends Model
{
    use SoftDeletes;

    protected $table = 'box_score_v3';

    protected $fillable = [
        'quarters',
        'team_games',
        'player_games',
        'fantasy_defense_games',
        'scoring_plays',
        'scoring_details',
    ];

    protected $casts = [
        'quarters' => 'array',
        'team_games' => 'array',
        'player_games' => 'array',
        'fantasy_defense_games' => 'array',
        'scoring_plays' => 'array',
        'scoring_details' => 'array',
    ];
}
