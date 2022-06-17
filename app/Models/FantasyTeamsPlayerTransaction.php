<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FantasyTeamsPlayerTransaction extends Model
{
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
        'conditional_drop',
        'claim_request',
    ];

    /**
     * Get the fantasy team that belongs to the player trans0action.
     */
    public function fantasyTeam()
    {
        return $this->belongsTo(\App\Models\FantasyTeam::class);
    }

    /**
     * Get the player transaction type of fantasy team player transaction.
     */
    public function playerTransactionType()
    {
        return $this->belongsTo(\App\Models\PlayerTransactionType::class);
    }

    /**
     * Get the player transaction type of fantasy team player transaction.
     */
    public function fantacyPlayer()
    {
        return $this->belongsTo(\App\Models\FantasyData\FantasyPlayer::class, 'fantasy_player_id', 'id');
    }

    public function fantasyPlayer()
    {
        return $this->belongsTo(\App\Models\FantasyData\FantasyPlayer::class, 'fantasy_player_id', 'id');
    }

    /**
     * Get the player transaction type of fantasy team player transaction.
     */
    public function dropFantasyPlayer()
    {
        return $this->belongsTo(\App\Models\FantasyData\FantasyPlayer::class, 'conditional_drop', 'id')->withDefault();
    }
}
