<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Injury extends Model
{
    use SoftDeletes;

    protected $table = 'injury';

    protected $fillable = [
        'injury_id',
        'season_type',
        'season',
        'week',
        'player_id',
        'name',
        'position',
        'number',
        'team',
        'opponent',
        'body_part',
        'status',
        'practice',
        'practice_description',
        'updated',
        'declared_inactive',
        'team_id',
        'opponent_id',
    ];

    protected $casts = [
        'injury_id' => 'integer',
        'season_type' => 'integer',
        'season' => 'integer',
        'week' => 'integer',
        'player_id' => 'integer',
        'name' => 'string',
        'position' => 'string',
        'number' => 'integer',
        'team' => 'string',
        'opponent' => 'string',
        'body_part' => 'string',
        'status' => 'string',
        'practice' => 'string',
        'practice_description' => 'string',
        'updated' => 'string',
        'declared_inactive' => 'boolean',
        'team_id' => 'integer',
        'opponent_id' => 'integer',
    ];
}
