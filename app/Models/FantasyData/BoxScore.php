<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoxScore extends Model
{
    use SoftDeletes;

    protected $table = 'box_score';

    protected $fillable = [
        'scoring_plays',
        'scoring_details',
        'away_passing',
        'away_rushing',
        'away_receiving',
        'away_kicking',
        'away_punting',
        'away_kick_punt_returns',
        'away_defense',
        'home_passing',
        'home_rushing',
        'home_receiving',
        'home_kicking',
        'home_punting',
        'home_kick_punt_returns',
        'home_defense',
    ];

    protected $casts = [
        'scoring_plays' => 'array',
        'scoring_details' => 'array',
        'away_passing' => 'array',
        'away_rushing' => 'array',
        'away_receiving' => 'array',
        'away_kicking' => 'array',
        'away_punting' => 'array',
        'away_kick_punt_returns' => 'array',
        'away_defense' => 'array',
        'home_passing' => 'array',
        'home_rushing' => 'array',
        'home_receiving' => 'array',
        'home_kicking' => 'array',
        'home_punting' => 'array',
        'home_kick_punt_returns' => 'array',
        'home_defense' => 'array',
    ];
}
