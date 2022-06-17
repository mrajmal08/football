<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerOwnership extends Model
{
    use SoftDeletes;

    protected $table = 'player_ownership';

    protected $fillable = [
        'player_id',
        'season',
        'season_type',
        'week',
        'name',
        'position',
        'team',
        'team_id',
        'ownership_percentage',
        'delta_ownership_percentage',
        'start_percentage',
        'delta_start_percentage',
    ];

    protected $casts = [
        'player_id' => 'integer',
        'season' => 'integer',
        'season_type' => 'integer',
        'week' => 'integer',
        'name' => 'string',
        'position' => 'string',
        'team' => 'string',
        'team_id' => 'integer',
        'ownership_percentage' => 'integer',
        'delta_ownership_percentage' => 'integer',
        'start_percentage' => 'integer',
        'delta_start_percentage' => 'integer',
    ];
}
