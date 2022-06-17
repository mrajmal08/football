<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quarter extends Model
{
    use SoftDeletes;

    protected $table = 'quarter';

    protected $fillable = [
        'quarter_id',
        'score_id',
        'number',
        'name',
        'description',
        'away_team_score',
        'home_team_score',
        'updated',
        'created',
    ];

    protected $casts = [
        'quarter_id' => 'integer',
        'score_id' => 'integer',
        'number' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'away_team_score' => 'integer',
        'home_team_score' => 'integer',
        'updated' => 'string',
        'created' => 'string',
    ];
}
