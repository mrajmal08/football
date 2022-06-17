<?php

namespace App\Console\Commands;

use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyData\PlayerSeasonProjection;
use Helper;
use Illuminate\Console\Command;

class SyncPositionSeasonData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SyncPositionSeasonData {--position=} {--season=} {--seasonTypeInt=} {--isProjection}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To sync data for a teamed/group player.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $systemSettings = Helper::getSystemSettingsDetails();

        $isProjection = $this->option('isProjection');
        $season = $this->option('season') ?? $systemSettings['season'];
        $seasonTypeInt = $this->option('seasonTypeInt') ?? $systemSettings['seasonTypeInt'];
        $position = $this->option('position');

        $alertType = ($isProjection == 'true') ? ' Projections' : ' Real';

        $alertLine = class_basename(get_class($this)).$alertType.' |  Season: '.$season.' |  seasonTypeInt: '.$seasonTypeInt.', Position: '.$position;
        $this->info($alertLine);

        $filter = function ($query) use ($season, $seasonTypeInt) {
            $query->where('season', $season);
            $query->where('season_type', $seasonTypeInt);
        };

        if ($isProjection) {
            $fantasy_player = FantasyPlayer::where('position', $position)
          ->with(['fantasyPlayerGameProjection' => $filter])
          ->get();
        } else {
            $fantasy_player = FantasyPlayer::where('position', $position)
          ->with(['playerGame' => $filter])
          ->get();
        }

        if (! empty($fantasy_player)) {
            if ($position == 'TQB') {
                foreach ($fantasy_player as $list) {
                    if ($isProjection) {
                        $player_game = $list->fantasyPlayerGameProjection->toArray();
                    } else {
                        $player_game = $list->playerGame->toArray();
                    }

                    if (! $player_game) {
                        continue;
                    }
                    // dd($player_game);
                    $playerSeason = Helper::calculateTqbSeasonData($player_game);
                    if (! empty($playerSeason)) {
                        if (! isset($playerSeason['team'])) {
                            //dd($player_game);
                        }
                        $player_season_stat =
                        [
                            'player_id'                         => $list->player_id,
                            'season_type'                       => $seasonTypeInt,
                            'season'                            => $season,
                            'team'                              => $playerSeason['team'],
                            'number'                            => $playerSeason['number'],
                            'name'                              => $playerSeason['name'],
                            'position'                          => 'TQB',
                            'position_category'                 => $playerSeason['position_category'],
                            'activated'                         => $playerSeason['activated'],
                            'played'                            => $playerSeason['played'],
                            'started'                           => $playerSeason['started'],
                            'passing_attempts'                  => $playerSeason['passing_attempts'],
                            'passing_completions'               => $playerSeason['passing_completions'],
                            'passing_yards'                     => $playerSeason['passing_yards'],
                            'passing_completion_percentage'     => $playerSeason['passing_completion_percentage'],
                            'passing_yards_per_attempt'         => $playerSeason['passing_yards_per_attempt'],
                            'passing_yards_per_completion'      => $playerSeason['passing_yards_per_completion'],
                            'passing_touchdowns'                => $playerSeason['passing_touchdowns'],
                            'passing_interceptions'             => $playerSeason['passing_interceptions'],
                            'passing_rating'                    => $playerSeason['passing_rating'],
                            'passing_long'                      => $playerSeason['passing_long'],
                            'passing_sacks'                     => $playerSeason['passing_sacks'],
                            'passing_sack_yards'                => $playerSeason['passing_sack_yards'],
                            'rushing_attempts'                  => $playerSeason['rushing_attempts'],
                            'rushing_yards'                     => $playerSeason['rushing_yards'],
                            'rushing_yards_per_attempt'         => $playerSeason['rushing_yards_per_attempt'],
                            'rushing_touchdowns'                => $playerSeason['rushing_touchdowns'],
                            'rushing_long'                      => $playerSeason['rushing_long'],
                            'receiving_targets'                 => $playerSeason['receiving_targets'],
                            'receptions'                        => $playerSeason['receptions'],
                            'receiving_yards'                   => $playerSeason['receiving_yards'],
                            'receiving_yards_per_reception'     => $playerSeason['receiving_yards_per_reception'],
                            'receiving_touchdowns'              => $playerSeason['receiving_touchdowns'],
                            'receiving_long'                    => $playerSeason['receiving_long'],
                            'fumbles'                           => $playerSeason['fumbles'],
                            'fumbles_lost'                      => $playerSeason['fumbles_lost'],
                            'punt_returns'                      => $playerSeason['punt_returns'],
                            'punt_return_yards'                 => $playerSeason['punt_return_yards'],
                            'punt_return_yards_per_attempt'     => $playerSeason['punt_return_yards_per_attempt'],
                            'punt_return_touchdowns'            => $playerSeason['punt_return_touchdowns'],
                            'punt_return_long'                  => $playerSeason['punt_return_long'],
                            'kick_returns'                      => $playerSeason['kick_returns'],
                            'kick_return_yards'                 => $playerSeason['kick_return_yards'],
                            'kick_return_yards_per_attempt'     => $playerSeason['kick_return_yards_per_attempt'],
                            'kick_return_touchdowns'            => $playerSeason['kick_return_touchdowns'],
                            'kick_return_long'                  => $playerSeason['kick_return_long'],
                            'solo_tackles'                      => $playerSeason['solo_tackles'],
                            'assisted_tackles'                  => $playerSeason['assisted_tackles'],
                            'tackles_for_loss'                  => $playerSeason['tackles_for_loss'],
                            'sacks'                             => $playerSeason['sacks'],
                            'sack_yards'                        => $playerSeason['sack_yards'],
                            'quarterback_hits'                  => $playerSeason['quarterback_hits'],
                            'passes_defended'                   => $playerSeason['passes_defended'],
                            'fumbles_forced'                    => $playerSeason['fumbles_forced'],
                            'fumbles_recovered'                 => $playerSeason['fumbles_recovered'],
                            'fumble_return_yards'               => $playerSeason['fumble_return_yards'],
                            'fumble_return_touchdowns'          => $playerSeason['fumble_return_touchdowns'],
                            'interceptions'                     => $playerSeason['interceptions'],
                            'interception_return_yards'         => $playerSeason['interception_return_yards'],
                            'interception_return_touchdowns'    => $playerSeason['interception_return_touchdowns'],
                            'blocked_kicks'                     => $playerSeason['blocked_kicks'],
                            'special_teams_solo_tackles'        => $playerSeason['special_teams_solo_tackles'],
                            'special_teams_assisted_tackles'    => $playerSeason['special_teams_assisted_tackles'],
                            'misc_solo_tackles'                 => $playerSeason['misc_solo_tackles'],
                            'misc_assisted_tackles'             => $playerSeason['misc_assisted_tackles'],
                            'punts'                             => $playerSeason['punts'],
                            'punt_yards'                        => $playerSeason['punt_yards'],
                            'punt_average'                      => $playerSeason['punt_average'],
                            'field_goals_attempted'             => $playerSeason['field_goals_attempted'],
                            'field_goals_made'                  => $playerSeason['field_goals_made'],
                            'field_goals_longest_made'          => $playerSeason['field_goals_longest_made'],
                            'extra_points_made'                 => $playerSeason['extra_points_made'],
                            'two_point_conversion_passes'       => $playerSeason['two_point_conversion_passes'],
                            'two_point_conversion_runs'         => $playerSeason['two_point_conversion_runs'],
                            'two_point_conversion_receptions'   => $playerSeason['two_point_conversion_receptions'],
                            'fantasy_points'                    => $playerSeason['fantasy_points'],
                            'fantasy_points_p_p_r'              => $playerSeason['fantasy_points_p_p_r'],
                            'reception_percentage'              => $playerSeason['reception_percentage'],
                            'receiving_yards_per_target'        => $playerSeason['receiving_yards_per_target'],
                            'tackles'                           => $playerSeason['tackles'],
                            'offensive_touchdowns'              => $playerSeason['offensive_touchdowns'],
                            'defensive_touchdowns'              => $playerSeason['defensive_touchdowns'],
                            'special_teams_touchdowns'          => $playerSeason['special_teams_touchdowns'],
                            'touchdowns'                        => $playerSeason['touchdowns'],
                            'fantasy_position'                  => $playerSeason['fantasy_position'],
                            'field_goal_percentage'             => $playerSeason['field_goal_percentage'],
                            'player_season_id'                  => '0',
                            'fumbles_own_recoveries'            => $playerSeason['fumbles_own_recoveries'],
                            'fumbles_out_of_bounds'             => $playerSeason['fumbles_out_of_bounds'],
                            'kick_return_fair_catches'          => $playerSeason['kick_return_fair_catches'],
                            'punt_return_fair_catches'          => $playerSeason['punt_return_fair_catches'],
                            'punt_touchbacks'                   => $playerSeason['punt_touchbacks'],
                            'punt_inside20'                     => $playerSeason['punt_inside20'],
                            'punt_net_average'                  => $playerSeason['punt_net_average'],
                            'extra_points_attempted'            => $playerSeason['extra_points_attempted'],
                            'blocked_kick_return_touchdowns'    => $playerSeason['blocked_kick_return_touchdowns'],
                            'field_goal_return_touchdowns'      => $playerSeason['field_goal_return_touchdowns'],
                            'safeties'                          => $playerSeason['safeties'],
                            'field_goals_had_blocked'           => $playerSeason['field_goals_had_blocked'],
                            'punts_had_blocked'                 => $playerSeason['punts_had_blocked'],
                            'extra_points_had_blocked'          => $playerSeason['extra_points_had_blocked'],
                            'punt_long'                         => $playerSeason['punt_long'],
                            'blocked_kick_return_yards'         => $playerSeason['blocked_kick_return_yards'],
                            'field_goal_return_yards'           => $playerSeason['field_goal_return_yards'],
                            'punt_net_yards'                    => $playerSeason['punt_net_yards'],
                            'special_teams_fumbles_forced'      => $playerSeason['special_teams_fumbles_forced'],
                            'special_teams_fumbles_recovered'   => $playerSeason['special_teams_fumbles_recovered'],
                            'misc_fumbles_forced'               => $playerSeason['misc_fumbles_forced'],
                            'misc_fumbles_recovered'            => $playerSeason['misc_fumbles_recovered'],
                            'short_name'                        => $playerSeason['short_name'],
                            'safeties_allowed'                  => $playerSeason['safeties_allowed'],
                            'temperature'                       => $playerSeason['temperature'],
                            'humidity'                          => $playerSeason['humidity'],
                            'wind_speed'                        => $playerSeason['wind_speed'],
                            'offensive_snaps_played'            => $playerSeason['offensive_snaps_played'],
                            'defensive_snaps_played'            => $playerSeason['defensive_snaps_played'],
                            'special_teams_snaps_played'        => $playerSeason['special_teams_snaps_played'],
                            'offensive_team_snaps'              => $playerSeason['offensive_team_snaps'],
                            'defensive_team_snaps'              => $playerSeason['defensive_team_snaps'],
                            'special_teams_team_snaps'          => $playerSeason['special_teams_team_snaps'],
                            'auction_value'                     => '0',
                            'auction_value_p_p_r'               => '0',
                            'two_point_conversion_returns'      => $playerSeason['two_point_conversion_returns'],
                            'fantasy_points_fan_duel'           => $playerSeason['fantasy_points_fan_duel'],
                            'field_goals_made0to19'             => $playerSeason['field_goals_made0to19'],
                            'field_goals_made20to29'            => $playerSeason['field_goals_made20to29'],
                            'field_goals_made30to39'            => $playerSeason['field_goals_made30to39'],
                            'field_goals_made40to49'            => $playerSeason['field_goals_made40to49'],
                            'field_goals_made50_plus'           => $playerSeason['field_goals_made50_plus'],
                            'fantasy_points_draft_kings'        => $playerSeason['fantasy_points_draft_kings'],
                            'fantasy_points_yahoo'              => $playerSeason['fantasy_points_yahoo'],
                            'average_draft_position'            => $playerSeason['fantasy_points_yahoo'],
                            // 'average_draft_position_p_p_r'      => $playerSeason['average_draft_position_p_p_r'],
                            'team_id'                           => $playerSeason['team_id'],
                            'global_team_id'                    => $playerSeason['global_team_id'],
                            'fantasy_points_fantasy_draft'      => $playerSeason['fantasy_points_fantasy_draft'], /* ,
                            'scoring_details'                   => $fantasy_scoring_details_data */
                        ];

                        if ($isProjection) {
                            PlayerSeasonProjection::updateOrCreate(
                                ['player_id' => $playerSeason['player_id'], 'season_type' => $playerSeason['season_type'], 'season' => $playerSeason['season'], 'team' => $playerSeason['team']],
                                $player_season_stat
                            );
                        } else {
                            \App\Models\FantasyData\PlayerSeason::updateOrCreate(
                                ['player_id' => $playerSeason['player_id'], 'season_type' => $playerSeason['season_type'], 'season' => $playerSeason['season'], 'team' => $playerSeason['team']],
                                $player_season_stat
                            );
                        }
                        $this->info('Synced '.$playerSeason['team']);
                    }
                }
            }
            if ($position == 'ST') {
                foreach ($fantasy_player as $list) {
                    if ($isProjection) {
                        $player_game = $list->fantasyPlayerGameProjection->toArray();
                    } else {
                        $player_game = $list->playerGame->toArray();
                    }

                    $playerSeason = Helper::calculateStSeasonData($player_game);
                    if (! empty($playerSeason)) {
                        $player_season_stat =
                        [
                            'player_id'                         => $list->player_id,
                            'season_type'                       => $playerSeason['season_type'],
                            'season'                            => $season,
                            'team'                              => $playerSeason['team'],
                            'number'                            => $playerSeason['number'],
                            'name'                              => $playerSeason['name'],
                            'position'                          => 'ST',
                            'position_category'                 => $playerSeason['position_category'],
                            'activated'                         => $playerSeason['activated'],
                            'played'                            => $playerSeason['played'],
                            'started'                           => $playerSeason['started'],
                            'passing_attempts'                  => $playerSeason['passing_attempts'],
                            'passing_completions'               => $playerSeason['passing_completions'],
                            'passing_yards'                     => $playerSeason['passing_yards'],
                            'passing_completion_percentage'     => $playerSeason['passing_completion_percentage'],
                            'passing_yards_per_attempt'         => $playerSeason['passing_yards_per_attempt'],
                            'passing_yards_per_completion'      => $playerSeason['passing_yards_per_completion'],
                            'passing_touchdowns'                => $playerSeason['passing_touchdowns'],
                            'passing_interceptions'             => $playerSeason['passing_interceptions'],
                            'passing_rating'                    => $playerSeason['passing_rating'],
                            'passing_long'                      => $playerSeason['passing_long'],
                            'passing_sacks'                     => $playerSeason['passing_sacks'],
                            'passing_sack_yards'                => $playerSeason['passing_sack_yards'],
                            'rushing_attempts'                  => $playerSeason['rushing_attempts'],
                            'rushing_yards'                     => $playerSeason['rushing_yards'],
                            'rushing_yards_per_attempt'         => $playerSeason['rushing_yards_per_attempt'],
                            'rushing_touchdowns'                => $playerSeason['rushing_touchdowns'],
                            'rushing_long'                      => $playerSeason['rushing_long'],
                            'receiving_targets'                 => $playerSeason['receiving_targets'],
                            'receptions'                        => $playerSeason['receptions'],
                            'receiving_yards'                   => $playerSeason['receiving_yards'],
                            'receiving_yards_per_reception'     => $playerSeason['receiving_yards_per_reception'],
                            'receiving_touchdowns'              => $playerSeason['receiving_touchdowns'],
                            'receiving_long'                    => $playerSeason['receiving_long'],
                            'fumbles'                           => $playerSeason['fumbles'],
                            'fumbles_lost'                      => $playerSeason['fumbles_lost'],
                            'punt_returns'                      => $playerSeason['punt_returns'],
                            'punt_return_yards'                 => $playerSeason['punt_return_yards'],
                            'punt_return_yards_per_attempt'     => $playerSeason['punt_returns'] > 0 ? ($playerSeason['punt_return_yards'] / $playerSeason['punt_returns']) : 0,
                            'punt_return_touchdowns'            => $playerSeason['punt_return_touchdowns'],
                            'punt_return_long'                  => $playerSeason['punt_return_long'],
                            'kick_returns'                      => $playerSeason['kick_returns'],
                            'kick_return_yards'                 => $playerSeason['kick_return_yards'],
                            'kick_return_yards_per_attempt'     => $playerSeason['kick_returns'] > 0 ? ($playerSeason['kick_return_yards'] / $playerSeason['kick_returns']) : 0,
                            'kick_return_touchdowns'            => $playerSeason['kick_return_touchdowns'],
                            'kick_return_long'                  => $playerSeason['kick_return_long'],
                            'solo_tackles'                      => $playerSeason['solo_tackles'],
                            'assisted_tackles'                  => $playerSeason['assisted_tackles'],
                            'tackles_for_loss'                  => $playerSeason['tackles_for_loss'],
                            'sacks'                             => $playerSeason['sacks'],
                            'sack_yards'                        => $playerSeason['sack_yards'],
                            'quarterback_hits'                  => $playerSeason['quarterback_hits'],
                            'passes_defended'                   => $playerSeason['passes_defended'],
                            'fumbles_forced'                    => $playerSeason['fumbles_forced'],
                            'fumbles_recovered'                 => $playerSeason['fumbles_recovered'],
                            'fumble_return_yards'               => $playerSeason['fumble_return_yards'],
                            'fumble_return_touchdowns'          => $playerSeason['fumble_return_touchdowns'],
                            'interceptions'                     => $playerSeason['interceptions'],
                            'interception_return_yards'         => $playerSeason['interception_return_yards'],
                            'interception_return_touchdowns'    => $playerSeason['interception_return_touchdowns'],
                            'blocked_kicks'                     => $playerSeason['blocked_kicks'],
                            'special_teams_solo_tackles'        => $playerSeason['special_teams_solo_tackles'],
                            'special_teams_assisted_tackles'    => $playerSeason['special_teams_assisted_tackles'],
                            'misc_solo_tackles'                 => $playerSeason['misc_solo_tackles'],
                            'misc_assisted_tackles'             => $playerSeason['misc_assisted_tackles'],
                            'punts'                             => $playerSeason['punts'],
                            'punt_yards'                        => $playerSeason['punt_yards'],
                            'punt_average'                      => $playerSeason['punt_average'],
                            'field_goals_attempted'             => $playerSeason['field_goals_attempted'],
                            'field_goals_made'                  => $playerSeason['field_goals_made'],
                            'field_goals_longest_made'          => $playerSeason['field_goals_longest_made'],
                            'extra_points_made'                 => $playerSeason['extra_points_made'],
                            'two_point_conversion_passes'       => $playerSeason['two_point_conversion_passes'],
                            'two_point_conversion_runs'         => $playerSeason['two_point_conversion_runs'],
                            'two_point_conversion_receptions'   => $playerSeason['two_point_conversion_receptions'],
                            'fantasy_points'                    => $playerSeason['fantasy_points'],
                            'fantasy_points_p_p_r'              => $playerSeason['fantasy_points_p_p_r'],
                            'reception_percentage'              => $playerSeason['reception_percentage'],
                            'receiving_yards_per_target'        => $playerSeason['receiving_yards_per_target'],
                            'tackles'                           => $playerSeason['tackles'],
                            'offensive_touchdowns'              => $playerSeason['offensive_touchdowns'],
                            'defensive_touchdowns'              => $playerSeason['defensive_touchdowns'],
                            'special_teams_touchdowns'          => $playerSeason['special_teams_touchdowns'],
                            'touchdowns'                        => $playerSeason['touchdowns'],
                            'fantasy_position'                  => $playerSeason['fantasy_position'],
                            'field_goal_percentage'             => $playerSeason['field_goal_percentage'],
                            'player_season_id'                  => '0',
                            'fumbles_own_recoveries'            => $playerSeason['fumbles_own_recoveries'],
                            'fumbles_out_of_bounds'             => $playerSeason['fumbles_out_of_bounds'],
                            'kick_return_fair_catches'          => $playerSeason['kick_return_fair_catches'],
                            'punt_return_fair_catches'          => $playerSeason['punt_return_fair_catches'],
                            'punt_touchbacks'                   => $playerSeason['punt_touchbacks'],
                            'punt_inside20'                     => $playerSeason['punt_inside20'],
                            'punt_net_average'                  => $playerSeason['punt_net_average'],
                            'extra_points_attempted'            => $playerSeason['extra_points_attempted'],
                            'blocked_kick_return_touchdowns'    => $playerSeason['blocked_kick_return_touchdowns'],
                            'field_goal_return_touchdowns'      => $playerSeason['field_goal_return_touchdowns'],
                            'safeties'                          => $playerSeason['safeties'],
                            'field_goals_had_blocked'           => $playerSeason['field_goals_had_blocked'],
                            'punts_had_blocked'                 => $playerSeason['punts_had_blocked'],
                            'extra_points_had_blocked'          => $playerSeason['extra_points_had_blocked'],
                            'punt_long'                         => $playerSeason['punt_long'],
                            'blocked_kick_return_yards'         => $playerSeason['blocked_kick_return_yards'],
                            'field_goal_return_yards'           => $playerSeason['field_goal_return_yards'],
                            'punt_net_yards'                    => $playerSeason['punt_net_yards'],
                            'special_teams_fumbles_forced'      => $playerSeason['special_teams_fumbles_forced'],
                            'special_teams_fumbles_recovered'   => $playerSeason['special_teams_fumbles_recovered'],
                            'misc_fumbles_forced'               => $playerSeason['misc_fumbles_forced'],
                            'misc_fumbles_recovered'            => $playerSeason['misc_fumbles_recovered'],
                            'short_name'                        => $playerSeason['short_name'],
                            'safeties_allowed'                  => $playerSeason['safeties_allowed'],
                            'temperature'                       => $playerSeason['temperature'],
                            'humidity'                          => $playerSeason['humidity'],
                            'wind_speed'                        => $playerSeason['wind_speed'],
                            'offensive_snaps_played'            => $playerSeason['offensive_snaps_played'],
                            'defensive_snaps_played'            => $playerSeason['defensive_snaps_played'],
                            'special_teams_snaps_played'        => $playerSeason['special_teams_snaps_played'],
                            'offensive_team_snaps'              => $playerSeason['offensive_team_snaps'],
                            'defensive_team_snaps'              => $playerSeason['defensive_team_snaps'],
                            'special_teams_team_snaps'          => $playerSeason['special_teams_team_snaps'],
                            'auction_value'                     => '0',
                            'auction_value_p_p_r'               => '0',
                            'two_point_conversion_returns'      => $playerSeason['two_point_conversion_returns'],
                            'fantasy_points_fan_duel'           => $playerSeason['fantasy_points_fan_duel'],
                            'field_goals_made0to19'             => $playerSeason['field_goals_made0to19'],
                            'field_goals_made20to29'            => $playerSeason['field_goals_made20to29'],
                            'field_goals_made30to39'            => $playerSeason['field_goals_made30to39'],
                            'field_goals_made40to49'            => $playerSeason['field_goals_made40to49'],
                            'field_goals_made50_plus'           => $playerSeason['field_goals_made50_plus'],
                            'fantasy_points_draft_kings'        => $playerSeason['fantasy_points_draft_kings'],
                            'fantasy_points_yahoo'              => $playerSeason['fantasy_points_yahoo'],
                            'average_draft_position'            => '0',
                            'average_draft_position_p_p_r'      => '0',
                            'team_id'                           => $playerSeason['team_id'],
                            'global_team_id'                    => $playerSeason['global_team_id'],
                            'fantasy_points_fantasy_draft'      => $playerSeason['fantasy_points_fantasy_draft'], /* ,
                            'scoring_details'                   => $fantasy_scoring_details_data */
                        ];

                        if ($isProjection) {
                            \App\Models\FantasyData\PlayerSeasonProjection::updateOrCreate(
                                ['player_id' => $playerSeason['player_id'], 'season_type' => $playerSeason['season_type'], 'season' => $playerSeason['season'], 'team' => $playerSeason['team']],
                                $player_season_stat
                            );
                        } else {
                            \App\Models\FantasyData\PlayerSeason::updateOrCreate(
                                [
                                    'player_id' => $playerSeason['player_id'],
                                    'season_type' => $playerSeason['season_type'],
                                    'season' => $playerSeason['season'],
                                    'team' => $playerSeason['team'],
                                ],
                                $player_season_stat
                            );
                        }
                        $this->info('Synced '.$playerSeason['team']);
                    }
                }
            }
            unset($player_season_stat);
            unset($fantasy_player);
        }
        $this->info('Finished '.$alertLine);
    }
}
