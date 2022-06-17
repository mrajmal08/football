<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueTeamRanking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'fatasy_team_id',
        'season',
        'season_type',
        'week',
        'is_finished',
        'win',
        'loss',
        'tie',
        'head_to_head_pts',
        'points_against',
        'points_for',
        'points_for_pts',
        'sim_overall_win',
        'sim_overall_loss',
        'sim_overall_tie',
        'sim_overall_rank',
        'sim_overall_pts',
        'tournament_rank',
        'tournament_pts',
        'coach_score',
        'overall_coach_rank',

    ];

    public function fantasyTeam()
    {
        return $this->belongsTo(\App\Models\FantasyTeam::class, 'id', 'fatasy_team_id');
    }
}
