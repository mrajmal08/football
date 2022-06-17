<?php

namespace App\Console\Commands;

use App\Clients\FdProjClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Helper;
use Illuminate\Console\Command;

class UpdateDefenseSeasonProjections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateDefenseSeasonProjections';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update defense season projections';

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

            $result = $apiInstance->projectedFantasyDefenseSeasonStatsWByeWeekAdp('json', $season);
            if (! empty($result)) {
                foreach ($result as $key=>$val) {
                    $defense_season_data = [
                        'season_type' 											=> $val['season_type'],
                        'season' 												=> $val['season'],
                        'team' 													=> $val['team'],
                        'points_allowed' 										=> $val['points_allowed'],
                        'touchdowns_scored' 									=> $val['touchdowns_scored'],
                        'solo_tackles' 											=> $val['solo_tackles'],
                        'assisted_tackles' 										=> $val['assisted_tackles'],
                        'sacks' 												=> $val['sacks'],
                        'sack_yards' 											=> $val['sack_yards'],
                        'passes_defended' 										=> $val['passes_defended'],
                        'fumbles_forced' 										=> $val['fumbles_forced'],
                        'fumbles_recovered' 									=> $val['fumbles_recovered'],
                        'fumble_return_yards' 									=> $val['fumble_return_yards'],
                        'fumble_return_touchdowns' 								=> $val['fumble_return_touchdowns'],
                        'interceptions' 										=> $val['interceptions'],
                        'interception_return_yards' 							=> $val['interception_return_yards'],
                        'interception_return_touchdowns' 						=> $val['interception_return_touchdowns'],
                        'blocked_kicks' 										=> $val['blocked_kicks'],
                        'safeties' 												=> $val['safeties'],
                        'punt_returns' 											=> $val['punt_returns'],
                        'punt_return_yards' 									=> $val['punt_return_yards'],
                        'punt_return_touchdowns' 								=> $val['punt_return_touchdowns'],
                        'punt_return_long' 										=> $val['punt_return_long'],
                        'kick_returns' 											=> $val['kick_returns'],
                        'kick_return_yards' 									=> $val['kick_return_yards'],
                        'kick_return_touchdowns' 								=> $val['kick_return_touchdowns'],
                        'kick_return_long' 										=> $val['kick_return_long'],
                        'blocked_kick_return_touchdowns' 						=> $val['blocked_kick_return_touchdowns'],
                        'field_goal_return_touchdowns' 							=> $val['field_goal_return_touchdowns'],
                        'fantasy_points_allowed' 								=> $val['fantasy_points_allowed'],
                        'quarterback_fantasy_points_allowed' 					=> $val['quarterback_fantasy_points_allowed'],
                        'runningback_fantasy_points_allowed' 					=> $val['runningback_fantasy_points_allowed'],
                        'wide_receiver_fantasy_points_allowed' 					=> $val['wide_receiver_fantasy_points_allowed'],
                        'tight_end_fantasy_points_allowed' 						=> $val['tight_end_fantasy_points_allowed'],
                        'kicker_fantasy_points_allowed' 						=> $val['kicker_fantasy_points_allowed'],
                        'games' 												=> $val['games'],
                        'blocked_kick_return_yards' 							=> $val['blocked_kick_return_yards'],
                        'field_goal_return_yards' 								=> $val['field_goal_return_yards'],
                        'quarterback_hits' 										=> $val['quarterback_hits'],
                        'tackles_for_loss' 										=> $val['tackles_for_loss'],
                        'defensive_touchdowns' 									=> $val['defensive_touchdowns'],
                        'special_teams_touchdowns' 								=> $val['special_teams_touchdowns'],
                        'fantasy_points' 										=> $val['fantasy_points'],
                        'temperature' 											=> $val['temperature'],
                        'humidity' 												=> $val['humidity'],
                        'wind_speed' 											=> $val['wind_speed'],
                        'third_down_attempts' 									=> $val['third_down_attempts'],
                        'third_down_conversions' 								=> $val['third_down_conversions'],
                        'fourth_down_attempts' 									=> $val['fourth_down_attempts'],
                        'fourth_down_conversions' 								=> $val['fourth_down_conversions'],
                        'points_allowed_by_defense_special_teams' 				=> $val['points_allowed_by_defense_special_teams'],
                        'auction_value' 										=> $val['auction_value'],
                        'auction_value_ppr' 									=> $val['auction_value_ppr'],
                        'two_point_conversion_returns' 							=> $val['two_point_conversion_returns'],
                        'fantasy_points_fan_duel' 								=> $val['fantasy_points_fan_duel'],
                        'fantasy_points_draft_kings' 							=> $val['fantasy_points_draft_kings'],
                        'offensive_yards_allowed' 								=> $val['offensive_yards_allowed'],
                        'player_id' 											=> $val['player_id'],
                        'fantasy_points_yahoo' 									=> $val['fantasy_points_yahoo'],
                        'average_draft_position' 								=> $val['average_draft_position'],
                        'average_draft_position_p_p_r' 							=> $val['average_draft_position_ppr'],
                        'team_id' 												=> $val['team_id'],
                        'global_team_id' 										=> $val['global_team_id'],
                        'fan_duel_fantasy_points_allowed' 						=> $val['fan_duel_fantasy_points_allowed'],
                        'fan_duel_quarterback_fantasy_points_allowed' 			=> $val['fan_duel_quarterback_fantasy_points_allowed'],
                        'fan_duel_runningback_fantasy_points_allowed' 			=> $val['fan_duel_runningback_fantasy_points_allowed'],
                        'fan_duel_wide_receiver_fantasy_points_allowed' 		=> $val['fan_duel_wide_receiver_fantasy_points_allowed'],
                        'fan_duel_tight_end_fantasy_points_allowed' 			=> $val['fan_duel_tight_end_fantasy_points_allowed'],
                        'fan_duel_kicker_fantasy_points_allowed' 				=> $val['fan_duel_kicker_fantasy_points_allowed'],
                        'draft_kings_fantasy_points_allowed' 					=> $val['draft_kings_fantasy_points_allowed'],
                        'draft_kings_quarterback_fantasy_points_allowed' 		=> $val['draft_kings_quarterback_fantasy_points_allowed'],
                        'draft_kings_runningback_fantasy_points_allowed' 		=> $val['draft_kings_runningback_fantasy_points_allowed'],
                        'draft_kings_wide_receiver_fantasy_points_allowed' 		=> $val['draft_kings_wide_receiver_fantasy_points_allowed'],
                        'draft_kings_tight_end_fantasy_points_allowed' 			=> $val['draft_kings_tight_end_fantasy_points_allowed'],
                        'draft_kings_kicker_fantasy_points_allowed' 			=> $val['draft_kings_kicker_fantasy_points_allowed'],
                        'yahoo_fantasy_points_allowed' 							=> $val['yahoo_fantasy_points_allowed'],
                        'yahoo_quarterback_fantasy_points_allowed' 				=> $val['yahoo_quarterback_fantasy_points_allowed'],
                        'yahoo_runningback_fantasy_points_allowed' 				=> $val['yahoo_runningback_fantasy_points_allowed'],
                        'yahoo_wide_receiver_fantasy_points_allowed' 			=> $val['yahoo_wide_receiver_fantasy_points_allowed'],
                        'yahoo_tight_end_fantasy_points_allowed' 				=> $val['yahoo_tight_end_fantasy_points_allowed'],
                        'yahoo_kicker_fantasy_points_allowed' 					=> $val['yahoo_kicker_fantasy_points_allowed'],
                        'fantasy_points_fantasy_draft' 							=> $val['fantasy_points_fantasy_draft'],
                        'fantasy_draft_fantasy_points_allowed' 					=> $val['fantasy_draft_fantasy_points_allowed'],
                        'fantasy_draft_quarterback_fantasy_points_allowed' 		=> $val['fantasy_draft_quarterback_fantasy_points_allowed'],
                        'fantasy_draft_runningback_fantasy_points_allowed' 		=> $val['fantasy_draft_runningback_fantasy_points_allowed'],
                        'fantasy_draft_wide_receiver_fantasy_points_allowed' 	=> $val['fantasy_draft_wide_receiver_fantasy_points_allowed'],
                        'fantasy_draft_tight_end_fantasy_points_allowed' 		=> $val['fantasy_draft_tight_end_fantasy_points_allowed'],
                        'fantasy_draft_kicker_fantasy_points_allowed' 			=> $val['fantasy_draft_kicker_fantasy_points_allowed'],
                        'scoring_details' 										=> $val['scoring_details'],
                    ];
                    $model = \App\Models\FantasyData\FantasyDefenseSeasonProjection::updateOrCreate(
                        ['global_team_id' => $val['global_team_id'], 'season_type' => $val['season_type'], 'season' => $val['season']],
                        $defense_season_data
                    );
                }
                echo 'Finished: '.$alertLine;
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
