<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScoringDetail extends Model
{
    use SoftDeletes;

    protected $table = 'scoring_detail';

    protected $fillable = [
        'game_key',
        'season_type',
        'player_id',
        'team',
        'season',
        'week',
        'scoring_type',
        'length',
        'scoring_detail_id',
        'player_game_id',
        'score_id',
    ];

    protected $casts = [
        'game_key' => 'string',
        'season_type' => 'integer',
        'player_id' => 'integer',
        'team' => 'string',
        'season' => 'integer',
        'week' => 'integer',
        'scoring_type' => 'string',
        'length' => 'integer',
        'scoring_detail_id' => 'integer',
        'player_game_id' => 'integer',
        'score_id' => 'integer',
    ];
}
