<?php

namespace App\Console\Commands;

use App\Clients\FdProjClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Helper;
use Illuminate\Console\Command;

class UpdatePlayerSeasonProjections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdatePlayerSeasonProjections';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update player season projections';

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
        $season = $systemSettings['season'];
        $seasonType = strtolower($systemSettings['seasonType']);
        $season = $season.$seasonType;
        $apiInstance = new \Acme\FantasyDataProjections\Api\DefaultApi(new FdProjClient());
        try {
            $alertLine = class_basename(get_class($this)).' |  Season: '.$season." \r\n";
            echo $alertLine;
            $result = $apiInstance->projectedPlayerSeasonStatsWByeWeekAdp('json', $season);

            if (! empty($result)) {
                foreach ($result as $key=>$val) {
                    $player_season_data = false;
                    $player_season_data = [
                        'player_id' 						=> $val['player_id'],
                        'season_type'						=> $val['season_type'],
                        'season' 							=> $val['season'],
                        'team' 								=> $val['team'],
                        'number' 							=> $val['number'],
                        'name' 								=> $val['name'],
                        'position' 							=> $val['position'],
                        'position_category' 				=> $val['position_category'],
                        'activated' 						=> $val['activated'],
                        'played' 							=> $val['played'],
                        'started' 							=> $val['started'],
                        'passing_attempts' 					=> $val['passing_attempts'],
                        'passing_completions' 				=> $val['passing_completions'],
                        'passing_yards' 					=> $val['passing_yards'],
                        'passing_completion_percentage' 	=> $val['passing_completion_percentage'],
                        'passing_yards_per_attempt' 		=> $val['passing_yards_per_attempt'],
                        'passing_yards_per_completion' 		=> $val['passing_yards_per_completion'],
                        'passing_touchdowns' 				=> $val['passing_touchdowns'],
                        'passing_interceptions' 			=> $val['passing_interceptions'],
                        'passing_rating' 					=> $val['passing_rating'],
                        'passing_long' 						=> $val['passing_long'],
                        'passing_sacks' 					=> $val['passing_sacks'],
                        'passing_sack_yards' 				=> $val['passing_sack_yards'],
                        'rushing_attempts' 					=> $val['rushing_attempts'],
                        'rushing_yards' 					=> $val['rushing_yards'],
                        'rushing_yards_per_attempt' 		=> $val['rushing_yards_per_attempt'],
                        'rushing_touchdowns' 				=> $val['rushing_touchdowns'],
                        'rushing_long' 						=> $val['rushing_long'],
                        'receiving_targets' 				=> $val['receiving_targets'],
                        'receptions' 						=> $val['receptions'],
                        'receiving_yards' 					=> $val['receiving_yards'],
                        'receiving_yards_per_reception' 	=> $val['receiving_yards_per_reception'],
                        'receiving_touchdowns' 				=> $val['receiving_touchdowns'],
                        'receiving_long' 					=> $val['receiving_long'],
                        'fumbles' 							=> $val['fumbles'],
                        'fumbles_lost' 						=> $val['fumbles_lost'],
                        'punt_returns' 						=> $val['punt_returns'],
                        'punt_return_yards' 				=> $val['punt_return_yards'],
                        'punt_return_yards_per_attempt' 	=> $val['punt_return_yards_per_attempt'],
                        'punt_return_touchdowns' 			=> $val['punt_return_touchdowns'],
                        'punt_return_long' 					=> $val['punt_return_long'],
                        'kick_returns' 						=> $val['kick_returns'],
                        'kick_return_yards' 				=> $val['kick_return_yards'],
                        'kick_return_yards_per_attempt' 	=> $val['kick_return_yards_per_attempt'],
                        'kick_return_touchdowns' 			=> $val['kick_return_touchdowns'],
                        'kick_return_long' 					=> $val['kick_return_long'],
                        'solo_tackles' 						=> $val['solo_tackles'],
                        'assisted_tackles' 					=> $val['assisted_tackles'],
                        'tackles_for_loss' 					=> $val['tackles_for_loss'],
                        'sacks' 							=> $val['sacks'],
                        'sack_yards' 						=> $val['sack_yards'],
                        'quarterback_hits' 					=> $val['quarterback_hits'],
                        'passes_defended' 					=> $val['passes_defended'],
                        'fumbles_forced' 					=> $val['fumbles_forced'],
                        'fumbles_recovered' 				=> $val['fumbles_recovered'],
                        'fumble_return_yards' 				=> $val['fumble_return_yards'],
                        'fumble_return_touchdowns' 			=> $val['fumble_return_touchdowns'],
                        'interceptions' 					=> $val['interceptions'],
                        'interception_return_yards' 		=> $val['interception_return_yards'],
                        'interception_return_touchdowns' 	=> $val['interception_return_touchdowns'],
                        'blocked_kicks' 					=> $val['blocked_kicks'],
                        'special_teams_solo_tackles' 		=> $val['special_teams_solo_tackles'],
                        'special_teams_assisted_tackles' 	=> $val['special_teams_assisted_tackles'],
                        'misc_solo_tackles' 				=> $val['misc_solo_tackles'],
                        'misc_assisted_tackles' 			=> $val['misc_assisted_tackles'],
                        'punts' 							=> $val['punts'],
                        'punt_yards' 						=> $val['punt_yards'],
                        'punt_average' 						=> $val['punt_average'],
                        'field_goals_attempted' 			=> $val['field_goals_attempted'],
                        'field_goals_made' 					=> $val['field_goals_made'],
                        'field_goals_longest_made'			=> $val['field_goals_longest_made'],
                        'extra_points_made' 				=> $val['extra_points_made'],
                        'two_point_conversion_passes' 		=> $val['two_point_conversion_passes'],
                        'two_point_conversion_runs' 		=> $val['two_point_conversion_runs'],
                        'two_point_conversion_receptions' 	=> $val['two_point_conversion_receptions'],
                        'fantasy_points' 					=> $val['fantasy_points'],
                        'fantasy_points_p_p_r' 				=> $val['fantasy_points_ppr'],
                        'reception_percentage' 				=> $val['reception_percentage'],
                        'receiving_yards_per_target' 		=> $val['receiving_yards_per_target'],
                        'tackles' 							=> $val['tackles'],
                        'offensive_touchdowns' 				=> $val['offensive_touchdowns'],
                        'defensive_touchdowns' 				=> $val['defensive_touchdowns'],
                        'special_teams_touchdowns' 			=> $val['special_teams_touchdowns'],
                        'touchdowns' 						=> $val['touchdowns'],
                        'fantasy_position' 					=> $val['fantasy_position'],
                        'field_goal_percentage' 			=> $val['field_goal_percentage'],
                        'player_season_id' 					=> $val['player_season_id'],
                        'fumbles_own_recoveries' 			=> $val['fumbles_own_recoveries'],
                        'fumbles_out_of_bounds' 			=> $val['fumbles_out_of_bounds'],
                        'kick_return_fair_catches' 			=> $val['kick_return_fair_catches'],
                        'punt_return_fair_catches' 			=> $val['punt_return_fair_catches'],
                        'punt_touchbacks' 					=> $val['punt_touchbacks'],
                        'punt_inside20' 					=> $val['punt_inside20'],
                        'punt_net_average' 					=> $val['punt_net_average'],
                        'extra_points_attempted' 			=> $val['extra_points_attempted'],
                        'blocked_kick_return_touchdowns' 	=> $val['blocked_kick_return_touchdowns'],
                        'field_goal_return_touchdowns' 		=> $val['field_goal_return_touchdowns'],
                        'safeties' 							=> $val['safeties'],
                        'field_goals_had_blocked' 			=> $val['field_goals_had_blocked'],
                        'punts_had_blocked' 				=> $val['punts_had_blocked'],
                        'extra_points_had_blocked' 			=> $val['extra_points_had_blocked'],
                        'punt_long' 						=> $val['punt_long'],
                        'blocked_kick_return_yards' 		=> $val['blocked_kick_return_yards'],
                        'field_goal_return_yards' 			=> $val['field_goal_return_yards'],
                        'punt_net_yards' 					=> $val['punt_net_yards'],
                        'special_teams_fumbles_forced' 		=> $val['special_teams_fumbles_forced'],
                        'special_teams_fumbles_recovered' 	=> $val['special_teams_fumbles_recovered'],
                        'misc_fumbles_forced' 				=> $val['misc_fumbles_forced'],
                        'misc_fumbles_recovered' 			=> $val['misc_fumbles_recovered'],
                        'short_name' 						=> $val['short_name'],
                        'safeties_allowed' 					=> $val['safeties_allowed'],
                        'temperature' 						=> $val['temperature'],
                        'humidity' 							=> $val['humidity'],
                        'wind_speed'						=> $val['wind_speed'],
                        'offensive_snaps_played' 			=> $val['offensive_snaps_played'],
                        'defensive_snaps_played' 			=> $val['defensive_snaps_played'],
                        'special_teams_snaps_played' 		=> $val['special_teams_snaps_played'],
                        'offensive_team_snaps' 				=> $val['offensive_team_snaps'],
                        'defensive_team_snaps' 				=> $val['defensive_team_snaps'],
                        'special_teams_team_snaps' 			=> $val['special_teams_team_snaps'],
                        'auction_value' 					=> $val['auction_value'],
                        'auction_value_p_p_r' 				=> $val['auction_value_ppr'],
                        'two_point_conversion_returns' 		=> $val['two_point_conversion_returns'],
                        'fantasy_points_fan_duel' 			=> $val['fantasy_points_fan_duel'],
                        'field_goals_made0to19' 			=> $val['field_goals_made0to19'],
                        'field_goals_made20to29' 			=> $val['field_goals_made20to29'],
                        'field_goals_made30to39' 			=> $val['field_goals_made30to39'],
                        'field_goals_made40to49' 			=> $val['field_goals_made40to49'],
                        'field_goals_made50_plus' 			=> $val['field_goals_made50_plus'],
                        'fantasy_points_draft_kings' 		=> $val['fantasy_points_draft_kings'],
                        'fantasy_points_yahoo' 				=> $val['fantasy_points_yahoo'],
                        'average_draft_position' 			=> $val['average_draft_position'],
                        'average_draft_position_ppr' 		=> $val['average_draft_position_ppr'],
                        'team_id' 							=> $val['team_id'],
                        'global_team_id' 					=> $val['global_team_id'],
                        'fantasy_points_fantasy_draft' 		=> $val['fantasy_points_fantasy_draft'],
                        'scoring_details' 					=> $val['scoring_details'],
                    ];
                    $model = \App\Models\FantasyData\PlayerSeasonProjection::updateOrCreate(
                        ['player_id' => $val['player_id'], 'season_type' => $val['season_type'], 'season' => $val['season']],
                        $player_season_data
                    );
                }
                echo 'Finished: '.$alertLine;
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
