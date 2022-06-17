<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FantasyDefenseGameProjection extends Model
{
    use SoftDeletes;

    protected $table = 'fantasy_defense_game_projection';

    protected $fillable = [
        'game_key',
        'season_type',
        'season',
        'week',
        'date',
        'team',
        'fantasy_points_acme',
        'opponent',
        'points_allowed',
        'touchdowns_scored',
        'solo_tackles',
        'assisted_tackles',
        'sacks',
        'sack_yards',
        'passes_defended',
        'fumbles_forced',
        'fumbles_recovered',
        'fumble_return_yards',
        'fumble_return_touchdowns',
        'interceptions',
        'interception_return_yards',
        'interception_return_touchdowns',
        'blocked_kicks',
        'safeties',
        'punt_returns',
        'punt_return_yards',
        'punt_return_touchdowns',
        'punt_return_long',
        'kick_returns',
        'kick_return_yards',
        'kick_return_touchdowns',
        'kick_return_long',
        'blocked_kick_return_touchdowns',
        'field_goal_return_touchdowns',
        'fantasy_points_allowed',
        'quarterback_fantasy_points_allowed',
        'runningback_fantasy_points_allowed',
        'wide_receiver_fantasy_points_allowed',
        'tight_end_fantasy_points_allowed',
        'kicker_fantasy_points_allowed',
        'blocked_kick_return_yards',
        'field_goal_return_yards',
        'quarterback_hits',
        'tackles_for_loss',
        'defensive_touchdowns',
        'special_teams_touchdowns',
        'is_game_over',
        'fantasy_points',
        'stadium',
        'temperature',
        'humidity',
        'wind_speed',
        'third_down_attempts',
        'third_down_conversions',
        'fourth_down_attempts',
        'fourth_down_conversions',
        'points_allowed_by_defense_special_teams',
        'fan_duel_salary',
        'draft_kings_salary',
        'fantasy_data_salary',
        'victiv_salary',
        'two_point_conversion_returns',
        'fantasy_points_fan_duel',
        'fantasy_points_draft_kings',
        'offensive_yards_allowed',
        'yahoo_salary',
        'player_id',
        'fantasy_points_yahoo',
        'home_or_away',
        'opponent_rank',
        'opponent_position_rank',
        'fantasy_draft_salary',
        'team_id',
        'opponent_id',
        'day',
        'date_time',
        'global_game_id',
        'global_team_id',
        'global_opponent_id',
        'draft_kings_position',
        'fan_duel_position',
        'fantasy_draft_position',
        'yahoo_position',
        'fantasy_defense_id',
        'score_id',
        'fan_duel_fantasy_points_allowed',
        'fan_duel_quarterback_fantasy_points_allowed',
        'fan_duel_runningback_fantasy_points_allowed',
        'fan_duel_wide_receiver_fantasy_points_allowed',
        'fan_duel_tight_end_fantasy_points_allowed',
        'fan_duel_kicker_fantasy_points_allowed',
        'draft_kings_fantasy_points_allowed',
        'draft_kings_quarterback_fantasy_points_allowed',
        'draft_kings_runningback_fantasy_points_allowed',
        'draft_kings_wide_receiver_fantasy_points_allowed',
        'draft_kings_tight_end_fantasy_points_allowed',
        'draft_kings_kicker_fantasy_points_allowed',
        'yahoo_fantasy_points_allowed',
        'yahoo_quarterback_fantasy_points_allowed',
        'yahoo_runningback_fantasy_points_allowed',
        'yahoo_wide_receiver_fantasy_points_allowed',
        'yahoo_tight_end_fantasy_points_allowed',
        'yahoo_kicker_fantasy_points_allowed',
        'fantasy_points_fantasy_draft',
        'fantasy_draft_fantasy_points_allowed',
        'fantasy_draft_quarterback_fantasy_points_allowed',
        'fantasy_draft_runningback_fantasy_points_allowed',
        'fantasy_draft_wide_receiver_fantasy_points_allowed',
        'fantasy_draft_tight_end_fantasy_points_allowed',
        'fantasy_draft_kicker_fantasy_points_allowed',
        'scoring_details',
    ];

    protected $casts = [
        'game_key' => 'string',
        'season_type' => 'integer',
        'season' => 'integer',
        'week' => 'integer',
        'date' => 'string',
        'team' => 'string',
        'opponent' => 'string',
        'points_allowed' => 'integer',
        'touchdowns_scored' => 'integer',
        'solo_tackles' => 'integer',
        'assisted_tackles' => 'integer',
        'sacks' => 'integer',
        'sack_yards' => 'integer',
        'passes_defended' => 'integer',
        'fumbles_forced' => 'integer',
        'fumbles_recovered' => 'integer',
        'fumble_return_yards' => 'integer',
        'fumble_return_touchdowns' => 'integer',
        'interceptions' => 'integer',
        'interception_return_yards' => 'integer',
        'interception_return_touchdowns' => 'integer',
        'blocked_kicks' => 'integer',
        'safeties' => 'integer',
        'punt_returns' => 'integer',
        'punt_return_yards' => 'integer',
        'punt_return_touchdowns' => 'integer',
        'punt_return_long' => 'integer',
        'kick_returns' => 'integer',
        'kick_return_yards' => 'integer',
        'kick_return_touchdowns' => 'integer',
        'kick_return_long' => 'integer',
        'blocked_kick_return_touchdowns' => 'integer',
        'field_goal_return_touchdowns' => 'integer',
        'fantasy_points_allowed' => 'integer',
        'quarterback_fantasy_points_allowed' => 'integer',
        'runningback_fantasy_points_allowed' => 'integer',
        'wide_receiver_fantasy_points_allowed' => 'integer',
        'tight_end_fantasy_points_allowed' => 'integer',
        'kicker_fantasy_points_allowed' => 'integer',
        'blocked_kick_return_yards' => 'integer',
        'field_goal_return_yards' => 'integer',
        'quarterback_hits' => 'integer',
        'tackles_for_loss' => 'integer',
        'defensive_touchdowns' => 'integer',
        'special_teams_touchdowns' => 'integer',
        'is_game_over' => 'boolean',
        'fantasy_points' => 'integer',
        'stadium' => 'string',
        'temperature' => 'integer',
        'humidity' => 'integer',
        'wind_speed' => 'integer',
        'third_down_attempts' => 'integer',
        'third_down_conversions' => 'integer',
        'fourth_down_attempts' => 'integer',
        'fourth_down_conversions' => 'integer',
        'points_allowed_by_defense_special_teams' => 'integer',
        'fan_duel_salary' => 'integer',
        'draft_kings_salary' => 'integer',
        'fantasy_data_salary' => 'integer',
        'victiv_salary' => 'integer',
        'two_point_conversion_returns' => 'integer',
        'fantasy_points_fan_duel' => 'integer',
        'fantasy_points_draft_kings' => 'integer',
        'offensive_yards_allowed' => 'integer',
        'yahoo_salary' => 'integer',
        'player_id' => 'integer',
        'fantasy_points_yahoo' => 'integer',
        'home_or_away' => 'string',
        'opponent_rank' => 'integer',
        'opponent_position_rank' => 'integer',
        'fantasy_draft_salary' => 'integer',
        'team_id' => 'integer',
        'opponent_id' => 'integer',
        'day' => 'string',
        'date_time' => 'string',
        'global_game_id' => 'integer',
        'global_team_id' => 'integer',
        'global_opponent_id' => 'integer',
        'draft_kings_position' => 'string',
        'fan_duel_position' => 'string',
        'fantasy_draft_position' => 'string',
        'yahoo_position' => 'string',
        'fantasy_defense_id' => 'integer',
        'score_id' => 'integer',
        'fan_duel_fantasy_points_allowed' => 'integer',
        'fan_duel_quarterback_fantasy_points_allowed' => 'integer',
        'fan_duel_runningback_fantasy_points_allowed' => 'integer',
        'fan_duel_wide_receiver_fantasy_points_allowed' => 'integer',
        'fan_duel_tight_end_fantasy_points_allowed' => 'integer',
        'fan_duel_kicker_fantasy_points_allowed' => 'integer',
        'draft_kings_fantasy_points_allowed' => 'integer',
        'draft_kings_quarterback_fantasy_points_allowed' => 'integer',
        'draft_kings_runningback_fantasy_points_allowed' => 'integer',
        'draft_kings_wide_receiver_fantasy_points_allowed' => 'integer',
        'draft_kings_tight_end_fantasy_points_allowed' => 'integer',
        'draft_kings_kicker_fantasy_points_allowed' => 'integer',
        'yahoo_fantasy_points_allowed' => 'integer',
        'yahoo_quarterback_fantasy_points_allowed' => 'integer',
        'yahoo_runningback_fantasy_points_allowed' => 'integer',
        'yahoo_wide_receiver_fantasy_points_allowed' => 'integer',
        'yahoo_tight_end_fantasy_points_allowed' => 'integer',
        'yahoo_kicker_fantasy_points_allowed' => 'integer',
        'fantasy_points_fantasy_draft' => 'integer',
        'fantasy_draft_fantasy_points_allowed' => 'integer',
        'fantasy_draft_quarterback_fantasy_points_allowed' => 'integer',
        'fantasy_draft_runningback_fantasy_points_allowed' => 'integer',
        'fantasy_draft_wide_receiver_fantasy_points_allowed' => 'integer',
        'fantasy_draft_tight_end_fantasy_points_allowed' => 'integer',
        'fantasy_draft_kicker_fantasy_points_allowed' => 'integer',
        'scoring_details' => 'array',
        'fantasy_points_acme' => 'decimal:3',
    ];

    // protected $appends = [
    //     'fantasy_points_acme',

    // ];

    //protected $with = ['FantasyPlayerGameProjectionFantasyPoint'];

    // public function FantasyPlayerGameProjectionFantasyPoint()
    // {
    //     return $this->hasManyThrough('App\Models\FantasyPlayerProjectedGameFantasyPoint', 'App\Models\FantasyData\FantasyPlayer', 'fantasy_player_key', 'fantasy_player_id', 'team', 'id');

    //     //return $this->hasOne('App\Models\FantasyData\FantasyPlayer','fantasy_player_key','team');
    // }

    // public function getFantasyPointsAcmeAttribute($value)
    // {
    //     $fantasy_points_acme=($this->FantasyPlayerGameProjectionFantasyPoint)?$this->FantasyPlayerGameProjectionFantasyPoint
    //                                             ->where('season', $this->season)
    //                                             ->where('season_type', $this->season_type)
    //                                             ->where('week', $this->week)
    //                                             ->first():'';

    //     return (!empty($fantasy_points_acme))?$fantasy_points_acme->fantasy_points:'0';
    // }
}
