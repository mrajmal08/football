<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaguePostseasonScores extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'fatasy_team_id',
        'league_id',
        'season',
        'season_type',
        'week',
        'points_for',
        'tds',
    ];
}
