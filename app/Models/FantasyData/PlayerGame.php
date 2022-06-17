<?php

namespace App\Models\FantasyData;

use App\Jobs\CalculateAcmeFantasyPointsByGame;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Bus\DispatchesJobs;

class PlayerGame extends Model
{
    use SoftDeletes;
    use DispatchesJobs;
    use \Awobaz\Compoships\Compoships;

    // public static function boot()
    // {
    //     parent::boot();

    //     // If fantasy points acme did not change then we need to recalculate points
    //     static::saved(function ($playerGame) {
    //         if (!$playerGame->isDirty('fantasy_points_acme')) {
    //             echo "is dirty";
    //             dd($playerGame);

    //             dispatch(new CalculateAcmeFantasyPointsByGame($playerGame, false));
    //         //CalculateAcmeFantasyPointsByGame::dispatch($playerGame, false);
    //         } else {
    //             echo "Not dirty";
    //             dd($playerGame);
    //         }
    //     });
    // }

    // protected $dispatchesEvents = [
    //     'saved' => PlayerGameChanged::class,
    //     // 'created' => DraftOrderChanged::class,
    // ];

    protected $table = 'player_game';

    protected $fillable = [
        'game_key',
        'player_id',
        'season_type',
        'season',
        'game_date',
        'week',
        'team',
        'opponent',
        'home_or_away',
        'number',
        'name',
        'fantasy_points_acme',
        'position',
        'position_category',
        'activated',
        'played',
        'started',
        'passing_attempts',
        'passing_completions',
        'passing_yards',
        'passing_completion_percentage',
        'passing_yards_per_attempt',
        'passing_yards_per_completion',
        'passing_touchdowns',
        'passing_interceptions',
        'passing_rating',
        'passing_long',
        'passing_sacks',
        'passing_sack_yards',
        'rushing_attempts',
        'rushing_yards',
        'rushing_yards_per_attempt',
        'rushing_touchdowns',
        'rushing_long',
        'receiving_targets',
        'receptions',
        'receiving_yards',
        'receiving_yards_per_reception',
        'receiving_touchdowns',
        'receiving_long',
        'fumbles',
        'fumbles_lost',
        'punt_returns',
        'punt_return_yards',
        'punt_return_yards_per_attempt',
        'punt_return_touchdowns',
        'punt_return_long',
        'kick_returns',
        'kick_return_yards',
        'kick_return_yards_per_attempt',
        'kick_return_touchdowns',
        'kick_return_long',
        'solo_tackles',
        'assisted_tackles',
        'tackles_for_loss',
        'sacks',
        'sack_yards',
        'quarterback_hits',
        'passes_defended',
        'fumbles_forced',
        'fumbles_recovered',
        'fumble_return_yards',
        'fumble_return_touchdowns',
        'interceptions',
        'interception_return_yards',
        'interception_return_touchdowns',
        'blocked_kicks',
        'special_teams_solo_tackles',
        'special_teams_assisted_tackles',
        'misc_solo_tackles',
        'misc_assisted_tackles',
        'punts',
        'punt_yards',
        'punt_average',
        'field_goals_attempted',
        'field_goals_made',
        'field_goals_longest_made',
        'extra_points_made',
        'two_point_conversion_passes',
        'two_point_conversion_runs',
        'two_point_conversion_receptions',
        'fantasy_points',
        'fantasy_points_p_p_r',
        'reception_percentage',
        'receiving_yards_per_target',
        'tackles',
        'offensive_touchdowns',
        'defensive_touchdowns',
        'special_teams_touchdowns',
        'touchdowns',
        'fantasy_position',
        'field_goal_percentage',
        'player_game_id',
        'fumbles_own_recoveries',
        'fumbles_out_of_bounds',
        'kick_return_fair_catches',
        'punt_return_fair_catches',
        'punt_touchbacks',
        'punt_inside20',
        'punt_net_average',
        'extra_points_attempted',
        'blocked_kick_return_touchdowns',
        'field_goal_return_touchdowns',
        'safeties',
        'field_goals_had_blocked',
        'punts_had_blocked',
        'extra_points_had_blocked',
        'punt_long',
        'blocked_kick_return_yards',
        'field_goal_return_yards',
        'punt_net_yards',
        'special_teams_fumbles_forced',
        'special_teams_fumbles_recovered',
        'misc_fumbles_forced',
        'misc_fumbles_recovered',
        'short_name',
        'playing_surface',
        'is_game_over',
        'safeties_allowed',
        'stadium',
        'temperature',
        'humidity',
        'wind_speed',
        'fan_duel_salary',
        'draft_kings_salary',
        'fantasy_data_salary',
        'offensive_snaps_played',
        'defensive_snaps_played',
        'special_teams_snaps_played',
        'offensive_team_snaps',
        'defensive_team_snaps',
        'special_teams_team_snaps',
        'victiv_salary',
        'two_point_conversion_returns',
        'fantasy_points_fan_duel',
        'field_goals_made0to19',
        'field_goals_made20to29',
        'field_goals_made30to39',
        'field_goals_made40to49',
        'field_goals_made50_plus',
        'fantasy_points_draft_kings',
        'yahoo_salary',
        'fantasy_points_yahoo',
        'injury_status',
        'injury_body_part',
        'injury_start_date',
        'injury_notes',
        'fan_duel_position',
        'draft_kings_position',
        'yahoo_position',
        'opponent_rank',
        'opponent_position_rank',
        'injury_practice',
        'injury_practice_description',
        'declared_inactive',
        'fantasy_draft_salary',
        'fantasy_draft_position',
        'team_id',
        'opponent_id',
        'day',
        'date_time',
        'global_game_id',
        'global_team_id',
        'global_opponent_id',
        'score_id',
        'fantasy_points_fantasy_draft',
        'scoring_details',
    ];

    protected $casts = [
        'game_key' => 'string',
        'player_id' => 'integer',
        'season_type' => 'integer',
        'season' => 'integer',
        'game_date' => 'string',
        'week' => 'integer',
        'team' => 'string',
        'opponent' => 'string',
        'home_or_away' => 'string',
        'number' => 'integer',
        'name' => 'string',
        'position' => 'string',
        'position_category' => 'string',
        'activated' => 'integer',
        'played' => 'integer',
        'started' => 'integer',
        'passing_attempts' => 'integer',
        'passing_completions' => 'integer',
        'passing_yards' => 'integer',
        'passing_completion_percentage' => 'integer',
        'passing_yards_per_attempt' => 'integer',
        'passing_yards_per_completion' => 'integer',
        'passing_touchdowns' => 'integer',
        'passing_interceptions' => 'integer',
        'passing_rating' => 'integer',
        'passing_long' => 'integer',
        'passing_sacks' => 'integer',
        'passing_sack_yards' => 'integer',
        'rushing_attempts' => 'integer',
        'rushing_yards' => 'integer',
        'rushing_yards_per_attempt' => 'integer',
        'rushing_touchdowns' => 'integer',
        'rushing_long' => 'integer',
        'receiving_targets' => 'integer',
        'receptions' => 'integer',
        'receiving_yards' => 'integer',
        'receiving_yards_per_reception' => 'integer',
        'receiving_touchdowns' => 'integer',
        'receiving_long' => 'integer',
        'fumbles' => 'integer',
        'fumbles_lost' => 'integer',
        'punt_returns' => 'integer',
        'punt_return_yards' => 'integer',
        'punt_return_yards_per_attempt' => 'integer',
        'punt_return_touchdowns' => 'integer',
        'punt_return_long' => 'integer',
        'kick_returns' => 'integer',
        'kick_return_yards' => 'integer',
        'kick_return_yards_per_attempt' => 'integer',
        'kick_return_touchdowns' => 'integer',
        'kick_return_long' => 'integer',
        'solo_tackles' => 'integer',
        'assisted_tackles' => 'integer',
        'tackles_for_loss' => 'integer',
        'sacks' => 'integer',
        'sack_yards' => 'integer',
        'quarterback_hits' => 'integer',
        'passes_defended' => 'integer',
        'fumbles_forced' => 'integer',
        'fumbles_recovered' => 'integer',
        'fumble_return_yards' => 'integer',
        'fumble_return_touchdowns' => 'integer',
        'interceptions' => 'integer',
        'interception_return_yards' => 'integer',
        'interception_return_touchdowns' => 'integer',
        'blocked_kicks' => 'integer',
        'special_teams_solo_tackles' => 'integer',
        'special_teams_assisted_tackles' => 'integer',
        'misc_solo_tackles' => 'integer',
        'misc_assisted_tackles' => 'integer',
        'punts' => 'integer',
        'punt_yards' => 'integer',
        'punt_average' => 'integer',
        'field_goals_attempted' => 'integer',
        'field_goals_made' => 'integer',
        'field_goals_longest_made' => 'integer',
        'extra_points_made' => 'integer',
        'two_point_conversion_passes' => 'integer',
        'two_point_conversion_runs' => 'integer',
        'two_point_conversion_receptions' => 'integer',
        'fantasy_points' => 'integer',
        'fantasy_points_p_p_r' => 'integer',
        'reception_percentage' => 'integer',
        'receiving_yards_per_target' => 'integer',
        'tackles' => 'integer',
        'offensive_touchdowns' => 'integer',
        'defensive_touchdowns' => 'integer',
        'special_teams_touchdowns' => 'integer',
        'touchdowns' => 'integer',
        'fantasy_position' => 'string',
        'field_goal_percentage' => 'integer',
        'player_game_id' => 'integer',
        'fumbles_own_recoveries' => 'integer',
        'fumbles_out_of_bounds' => 'integer',
        'kick_return_fair_catches' => 'integer',
        'punt_return_fair_catches' => 'integer',
        'punt_touchbacks' => 'integer',
        'punt_inside20' => 'integer',
        'punt_net_average' => 'integer',
        'extra_points_attempted' => 'integer',
        'blocked_kick_return_touchdowns' => 'integer',
        'field_goal_return_touchdowns' => 'integer',
        'safeties' => 'integer',
        'field_goals_had_blocked' => 'integer',
        'punts_had_blocked' => 'integer',
        'extra_points_had_blocked' => 'integer',
        'punt_long' => 'integer',
        'blocked_kick_return_yards' => 'integer',
        'field_goal_return_yards' => 'integer',
        'punt_net_yards' => 'integer',
        'special_teams_fumbles_forced' => 'integer',
        'special_teams_fumbles_recovered' => 'integer',
        'misc_fumbles_forced' => 'integer',
        'misc_fumbles_recovered' => 'integer',
        'short_name' => 'string',
        'playing_surface' => 'string',
        'is_game_over' => 'boolean',
        'safeties_allowed' => 'integer',
        'stadium' => 'string',
        'temperature' => 'integer',
        'humidity' => 'integer',
        'wind_speed' => 'integer',
        'fan_duel_salary' => 'integer',
        'draft_kings_salary' => 'integer',
        'fantasy_data_salary' => 'integer',
        'offensive_snaps_played' => 'integer',
        'defensive_snaps_played' => 'integer',
        'special_teams_snaps_played' => 'integer',
        'offensive_team_snaps' => 'integer',
        'defensive_team_snaps' => 'integer',
        'special_teams_team_snaps' => 'integer',
        'victiv_salary' => 'integer',
        'two_point_conversion_returns' => 'integer',
        'fantasy_points_fan_duel' => 'integer',
        'field_goals_made0to19' => 'integer',
        'field_goals_made20to29' => 'integer',
        'field_goals_made30to39' => 'integer',
        'field_goals_made40to49' => 'integer',
        'field_goals_made50_plus' => 'integer',
        'fantasy_points_draft_kings' => 'integer',
        'yahoo_salary' => 'integer',
        'fantasy_points_yahoo' => 'integer',
        'injury_status' => 'string',
        'injury_body_part' => 'string',
        'injury_start_date' => 'string',
        'injury_notes' => 'string',
        'fan_duel_position' => 'string',
        'draft_kings_position' => 'string',
        'yahoo_position' => 'string',
        'opponent_rank' => 'integer',
        'opponent_position_rank' => 'integer',
        'injury_practice' => 'string',
        'injury_practice_description' => 'string',
        'declared_inactive' => 'boolean',
        'fantasy_draft_salary' => 'integer',
        'fantasy_draft_position' => 'string',
        'team_id' => 'integer',
        'opponent_id' => 'integer',
        'day' => 'string',
        'date_time' => 'string',
        'global_game_id' => 'integer',
        'global_team_id' => 'integer',
        'global_opponent_id' => 'integer',
        'score_id' => 'integer',
        'fantasy_points_fantasy_draft' => 'integer',
        'scoring_details' => 'array',
        'fantasy_points_acme' => 'decimal:3',
    ];
    // protected $appends = [
    //     'fantasy_points_acme',

    // ];

    // protected $with = ['FantasyPlayerGameFantasyPoint'];

    public function Score()
    {
        return $this->hasOne(\App\Models\FantasyData\Score::class, 'score_id', 'score_id');
    }

    public function Player()
    {
        return $this->hasOne(\App\Models\FantasyData\Player::class, 'player_id', 'player_id');
    }

    // public function FantasyPlayerGameFantasyPoint()
    // {
    //     return $this->hasOneThrough('App\Models\FantasyPlayerGameFantasyPoint', 'App\Models\FantasyData\FantasyPlayer', 'player_id', 'fantasy_player_id', 'player_id', 'id');
    //     // return $this->hasOne('App\Models\FantasyPlayerGameFantasyPoint', ['game_key','player_id'], 'player_id', 'fantasy_player_id', 'player_id', 'id');
    //     //TODO: This should work... it's basically being implemented in the get attribute below though.
    //     // return $this->hasOneThrough(
    //     //             'App\Models\FantasyPlayerGameFantasyPoint', // Final Model we wish to access
    //     //   'App\Models\FantasyData\FantasyPlayer', // Name of the intermidiary model
    //     //   'player_id', // Foreign key on FantasyPlayer table...
    //     //   'fantasy_player_id', //Foreign key on FantasyPlayerGameFantasyPoint table...
    //     //   'player_id', // Local Key on PlayerGame
    //     //   'player_id' // Local key on FantasyPlayer table...
    //     //         )
    //     // ->where('game_key', $this->game_key);
    // }

    public function fantasyPlayer()
    {
        return $this->belongsTo('App\Models\FantasyPlayer');
    }

    // public function getFantasyPointsAcmeAttribute()
    // {
    //     //return isset($this->FantasyPlayerGameFantasyPoint['fantasy_points']) ? $this->FantasyPlayerGameFantasyPoint['fantasy_points'] : 0.00;
    //     //return isset($this->FantasyPlayerGameFantasyPoint->fantasy_points) ? $this->FantasyPlayerGameFantasyPoint->fantasy_points : 0.00;
    //     $fantasy_points_acme=($this->FantasyPlayerGameFantasyPoint)?$this->FantasyPlayerGameFantasyPoint
    //                                             ->where('season', $this->season)
    //                                             ->where('season_type', $this->season_type)
    //                                             ->where('week', $this->week)
    //                                             ->where('week', $this->week)
    //                                             ->first():'';

    //     return (!empty($fantasy_points_acme))?$fantasy_points_acme->fantasy_points:'0';
    // }
}
