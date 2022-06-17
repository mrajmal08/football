<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoringReview extends Model
{
    protected $table = 'scoring_review';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fantasy_player_id',
        'game_key',
        'season',
        'season_type',
        'week',
        'adjustment_amount',
        'comment',
    ];

    /**
     * Get the player transaction type of fantasy team player transaction.
     */
    public function fantacyPlayer()
    {
        return $this->belongsTo(\App\Models\FantasyData\FantasyPlayer::class, 'fantasy_player_id', 'id');
    }
}
