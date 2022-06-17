<?php

namespace App\Models;

use App\Events\DraftOrderChanged;
use Illuminate\Database\Eloquent\Model;

class DraftOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'fantasy_team_id',
        'fantasy_player_id',
        'round',
        'league_overall_pick',
        'round_overall_pick',
        'deadline',
    ];

    protected $table = 'draft_order';

    protected $dispatchesEvents = [
        'saved' => DraftOrderChanged::class,
        // 'created' => DraftOrderChanged::class,
    ];

    public function fantasyPlayer()
    {
        return $this->belongsTo(\App\Models\FantasyData\FantasyPlayer::class, 'fantasy_player_id')->withDefault();
    }

    public function fantasyTeam()
    {
        return $this->belongsTo(\App\Models\FantasyTeam::class, 'fantasy_team_id', 'id');
    }
}
