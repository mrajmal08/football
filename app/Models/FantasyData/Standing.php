<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Standing extends Model
{
    use SoftDeletes;

    protected $table = 'standing';

    protected $fillable = [
        'season_type',
        'season',
        'conference',
        'division',
        'team',
        'name',
        'wins',
        'losses',
        'ties',
        'percentage',
        'points_for',
        'points_against',
        'net_points',
        'touchdowns',
        'division_wins',
        'division_losses',
        'conference_wins',
        'conference_losses',
        'team_id',
    ];

    protected $casts = [
        'season_type' => 'integer',
        'season' => 'integer',
        'conference' => 'string',
        'division' => 'string',
        'team' => 'string',
        'name' => 'string',
        'wins' => 'integer',
        'losses' => 'integer',
        'ties' => 'integer',
        'percentage' => 'integer',
        'points_for' => 'integer',
        'points_against' => 'integer',
        'net_points' => 'integer',
        'touchdowns' => 'integer',
        'division_wins' => 'integer',
        'division_losses' => 'integer',
        'conference_wins' => 'integer',
        'conference_losses' => 'integer',
        'team_id' => 'integer',
    ];
}
