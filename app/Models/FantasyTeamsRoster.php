<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FantasyTeamsRoster extends Model
{
    protected $casts = [
        'projected_fantasy_points_acme' => 'decimal:3',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'fantasy_player_id',
        'fantasy_team_id',
        'player_transaction_type_id',
        'active',
        'week',
        'season',
        'season_type',
        'bench',
        'game_started',
    ];

    protected $dispatchesEvents = [
        'saved' => \App\Events\FantasyTeamsRosterSaved::class,
    ];

    protected $table = 'fantasy_teams_roster';

    protected $appends = ['owner_name', 'position', 'fantasy_points_acme', 'projected_fantasy_points_acme'];

    protected $with = ['fantasyPlayer'];

    public function fantasyTeam()
    {
        return $this->belongsTo(\App\Models\FantasyTeam::class, 'fantasy_team_id', 'id');
    }

    public function fantasyPlayer()
    {
        return $this->belongsTo(\App\Models\FantasyData\FantasyPlayer::class, 'fantasy_player_id', 'id')->withDefault();
    }

    public function getOwnerNameAttribute()
    {
        if ($this->fantasyTeam) {
            return $this->fantasyTeam->name;
        }
    }

    public function getPositionAttribute()
    {
        return $this->fantasyPlayer->position;
    }

    public function getProjectedFantasyPointsAcmeAttribute()
    {
        // if (count($this->fantasyPlayer->playerGameProjection) > 0) {
        //     return floatval($this->fantasyPlayer->playerGameProjection->first()->fantasy_points_acme);
        // }
        // if ($this->position == "DEF" && count($this->fantasyPlayer->fantasyDefenseGameProjection) > 0) {
        //     return floatval($this->fantasyPlayer->fantasyDefenseGameProjection->first()->fantasy_points_acme);
        // }
        return 0;
    }

    public function getFantasyPointsAcmeAttribute()
    {
        // if (count($this->fantasyPlayer->playerGame) > 0) {
        //     return floatval($this->fantasyPlayer->playerGame->first()->fantasy_points_acme);
        // }
        // if ($this->position == "DEF" && count($this->fantasyPlayer->fantasyDefenseGame) > 0) {
        //     return floatval($this->fantasyPlayer->fantasyDefenseGame->first()->fantasy_points_acme);
        // }
        return 0;
    }
}
