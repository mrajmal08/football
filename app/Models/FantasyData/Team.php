<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    protected $table = 'team';

    protected $fillable = [
        'key',
        'team_id',
        'player_id',
        'city',
        'name',
        'conference',
        'division',
        'full_name',
        'stadium_id',
        'bye_week',
        'average_draft_position',
        'average_draft_position_p_p_r',
        'head_coach',
        'offensive_coordinator',
        'defensive_coordinator',
        'special_teams_coach',
        'offensive_scheme',
        'defensive_scheme',
        'upcoming_salary',
        'upcoming_opponent',
        'upcoming_opponent_rank',
        'upcoming_opponent_position_rank',
        'upcoming_fan_duel_salary',
        'upcoming_draft_kings_salary',
        'upcoming_yahoo_salary',
        'primary_color',
        'secondary_color',
        'tertiary_color',
        'quaternary_color',
        'wikipedia_logo_url',
        'wikipedia_word_mark_url',
        'global_team_id',
        'draft_kings_name',
        'draft_kings_player_id',
        'fan_duel_name',
        'fan_duel_player_id',
        'fantasy_draft_name',
        'fantasy_draft_player_id',
        'yahoo_name',
        'yahoo_player_id',
    ];

    protected $casts = [
        'key' => 'string',
        'team_id' => 'integer',
        'player_id' => 'integer',
        'city' => 'string',
        'name' => 'string',
        'conference' => 'string',
        'division' => 'string',
        'full_name' => 'string',
        'stadium_id' => 'integer',
        'bye_week' => 'integer',
        'average_draft_position' => 'integer',
        'average_draft_position_p_p_r' => 'integer',
        'head_coach' => 'string',
        'offensive_coordinator' => 'string',
        'defensive_coordinator' => 'string',
        'special_teams_coach' => 'string',
        'offensive_scheme' => 'string',
        'defensive_scheme' => 'string',
        'upcoming_salary' => 'integer',
        'upcoming_opponent' => 'string',
        'upcoming_opponent_rank' => 'integer',
        'upcoming_opponent_position_rank' => 'integer',
        'upcoming_fan_duel_salary' => 'integer',
        'upcoming_draft_kings_salary' => 'integer',
        'upcoming_yahoo_salary' => 'integer',
        'primary_color' => 'string',
        'secondary_color' => 'string',
        'tertiary_color' => 'string',
        'quaternary_color' => 'string',
        'wikipedia_logo_url' => 'string',
        'wikipedia_word_mark_url' => 'string',
        'global_team_id' => 'integer',
        'draft_kings_name' => 'string',
        'draft_kings_player_id' => 'integer',
        'fan_duel_name' => 'string',
        'fan_duel_player_id' => 'integer',
        'fantasy_draft_name' => 'string',
        'fantasy_draft_player_id' => 'integer',
        'yahoo_name' => 'string',
        'yahoo_player_id' => 'integer',
    ];

    protected $appends = [];

    public function TeamAwaySchedule()
    {
        return $this->hasMany(\App\Models\FantasyData\Schedule::class, 'away_team', 'key')->where('canceled', 0);
    }

    public function TeamHomeSchedule()
    {
        return $this->hasMany(\App\Models\FantasyData\Schedule::class, 'home_team', 'key')->where('canceled', 0);
    }

    public function getTeamFullScheduleAttribute($value)
    {
        return $this->TeamHomeSchedule->merge($this->TeamAwaySchedule);
    }
}
