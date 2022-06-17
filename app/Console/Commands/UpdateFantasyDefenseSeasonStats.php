<?php

namespace App\Console\Commands;

use App\Clients\FdClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Helper;
use Illuminate\Console\Command;

class UpdateFantasyDefenseSeasonStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateFantasyDefenseSeasonStats {--year=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To update fantasy defense stats';

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
        $yearPrompt = $this->option('year');
        $systemSettings = Helper::getSystemSettingsDetails();
        $season = (! empty($yearPrompt)) ? $yearPrompt : $systemSettings['season'];
        // $yearArray = array($season);

        $yearArray = [$season.'reg'];

        // If it is post season add it on at the end.
        if ($systemSettings['season_type'] == 3) {
            array_push($yearArray, $season.'post');
        }

        $apiInstance = new \Acme\FantasyDataStats\Api\DefaultApi(new FdClient());

        foreach ($yearArray as $season) {
            try {
                $this->info('UpdateFantasyDefenseSeasonStats Working on '.$season);
                $result = $apiInstance->fantasyDefenseSeasonStats('json', $season);
                if (! empty($result)) {
                    foreach ($result as $key=>$val) {
                        $fantasy_scoring_details_data = [];
                        $fantasy_scoring_details = $val['scoring_details'];
                        if (isset($fantasy_scoring_details) && count($fantasy_scoring_details) > 0) {
                            foreach ($fantasy_scoring_details as $skey=>$sval) {
                                $fantasy_scoring_details_data = [
                                    'game_key'				=> $sval->getGameKey(),
                                    'season_type'			=> $sval->getSeasonType(),
                                    'player_id'				=> $sval->getPlayerId(),
                                    'team'					=> $sval->getTeam(),
                                    'season'				=> $sval->getSeason(),
                                    'week'					=> $sval->getWeek(),
                                    'scoring_type'			=> $sval->getScoringType(),
                                    'length'				=> $sval->getLength(),
                                    'scoring_detail_id'		=> $sval->getScoringDetailId(),
                                    'player_game_id'		=> $sval->getPlayerGameId(),
                                    'score_id'				=> $sval->getScoreId(),
                                ];
                            }
                        }
                        $fantasy_season_stat = [
                            'season_type' 										=> $val->getSeasonType(),
                            'season' 											=> $val->getSeason(),
                            'team' 												=> $val->getTeam(),
                            'points_allowed'									=> $val->getPointsAllowed(),
                            'touchdowns_scored' 								=> $val->getTouchdownsScored(),
                            'solo_tackles' 										=> $val->getSoloTackles(),
                            'assisted_tackles' 									=> $val->getAssistedTackles(),
                            'sacks' 											=> $val->getSacks(),
                            'sack_yards' 										=> $val->getSackYards(),
                            'passes_defended' 									=> $val->getPassesDefended(),
                            'fumbles_forced' 									=> $val->getFumblesForced(),
                            'fumbles_recovered' 								=> $val->getFumblesRecovered(),
                            'fumble_return_yards' 								=> $val->getFumbleReturnYards(),
                            'fumble_return_touchdowns' 							=> $val->getFumbleReturnTouchdowns(),
                            'interceptions' 									=> $val->getInterceptions(),
                            'interception_return_yards' 						=> $val->getInterceptionReturnYards(),
                            'interception_return_touchdowns' 					=> $val->getInterceptionReturnTouchdowns(),
                            'blocked_kicks' 									=> $val->getBlockedKicks(),
                            'safeties' 											=> $val->getSafeties(),
                            'punt_returns' 										=> $val->getPuntReturns(),
                            'punt_return_yards' 								=> $val->getPuntReturnYards(),
                            'punt_return_touchdowns' 							=> $val->getPuntReturnTouchdowns(),
                            'punt_return_long' 									=> $val->getPuntReturnLong(),
                            'kick_returns' 										=> $val->getKickReturns(),
                            'kick_return_yards' 								=> $val->getKickReturnYards(),
                            'kick_return_touchdowns' 							=> $val->getKickReturnTouchdowns(),
                            'kick_return_long' 									=> $val->getKickReturnLong(),
                            'blocked_kick_return_touchdowns' 					=> $val->getBlockedKickReturnTouchdowns(),
                            'field_goal_return_touchdowns' 						=> $val->getFieldGoalReturnTouchdowns(),
                            'fantasy_points_allowed' 							=> $val->getFantasyPointsAllowed(),
                            'quarterback_fantasy_points_allowed' 				=> $val->getQuarterbackFantasyPointsAllowed(),
                            'runningback_fantasy_points_allowed' 				=> $val->getRunningbackFantasyPointsAllowed(),
                            'wide_receiver_fantasy_points_allowed' 				=> $val->getWideReceiverFantasyPointsAllowed(),
                            'tight_end_fantasy_points_allowed' 					=> $val->getTightEndFantasyPointsAllowed(),
                            'kicker_fantasy_points_allowed' 					=> $val->getKickerFantasyPointsAllowed(),
                            'games' 											=> $val->getGames(),
                            'blocked_kick_return_yards' 						=> $val->getBlockedKickReturnYards(),
                            'field_goal_return_yards'							=> $val->getFieldGoalReturnYards(),
                            'quarterback_hits' 									=> $val->getQuarterbackHits(),
                            'tackles_for_loss' 									=> $val->getTacklesForLoss(),
                            'defensive_touchdowns' 								=> $val->getDefensiveTouchdowns(),
                            'special_teams_touchdowns' 							=> $val->getSpecialTeamsTouchdowns(),
                            'fantasy_points' 									=> $val->getFantasyPoints(),
                            'temperature' 										=> $val->getTemperature(),
                            'humidity' 											=> $val->getHumidity(),
                            'wind_speed' 										=> $val->getWindSpeed(),
                            'third_down_attempts' 								=> $val->getThirdDownAttempts(),
                            'third_down_conversions' 							=> $val->getThirdDownConversions(),
                            'fourth_down_attempts' 								=> $val->getFourthDownAttempts(),
                            'fourth_down_conversions' 							=> $val->getFourthDownConversions(),
                            'points_allowed_by_defense_special_teams' 			=> $val->getPointsAllowedByDefenseSpecialTeams(),
                            'auction_value' 									=> $val->getAuctionValue(),
                            'auction_value_p_p_r' 								=> $val->getAuctionValuePpr(),
                            'two_point_conversion_returns' 						=> $val->getTwoPointConversionReturns(),
                            'fantasy_points_fan_duel' 							=> $val->getFantasyPointsFanDuel(),
                            'fantasy_points_draft_kings' 						=> $val->getFantasyPointsDraftKings(),
                            'offensive_yards_allowed' 							=> $val->getOffensiveYardsAllowed(),
                            'player_id' 										=> $val->getPlayerId(),
                            'fantasy_points_yahoo' 								=> $val->getFantasyPointsYahoo(),
                            'average_draft_position' 							=> $val->getAverageDraftPosition(),
                            'average_draft_position_p_p_r' 						=> $val->getAverageDraftPositionPpr(),
                            'team_id' 											=> $val->getTeamId(),
                            'global_team_id'									=> $val->getGlobalTeamId(),
                            'fan_duel_fantasy_points_allowed' 					=> $val->getFanDuelFantasyPointsAllowed(),
                            'fan_duel_quarterback_fantasy_points_allowed' 		=> $val->getFanDuelQuarterbackFantasyPointsAllowed(),
                            'fan_duel_runningback_fantasy_points_allowed' 		=> $val->getFanDuelRunningbackFantasyPointsAllowed(),
                            'fan_duel_wide_receiver_fantasy_points_allowed' 	=> $val->getFanDuelWideReceiverFantasyPointsAllowed(),
                            'fan_duel_tight_end_fantasy_points_allowed' 		=> $val->getFanDuelTightEndFantasyPointsAllowed(),
                            'fan_duel_kicker_fantasy_points_allowed' 			=> $val->getFanDuelKickerFantasyPointsAllowed(),
                            'draft_kings_fantasy_points_allowed' 				=> $val->getDraftKingsFantasyPointsAllowed(),
                            'draft_kings_quarterback_fantasy_points_allowed' 	=> $val->getDraftKingsQuarterbackFantasyPointsAllowed(),
                            'draft_kings_runningback_fantasy_points_allowed' 	=> $val->getDraftKingsRunningbackFantasyPointsAllowed(),
                            'draft_kings_wide_receiver_fantasy_points_allowed' 	=> $val->getDraftKingsWideReceiverFantasyPointsAllowed(),
                            'draft_kings_tight_end_fantasy_points_allowed' 		=> $val->getDraftKingsTightEndFantasyPointsAllowed(),
                            'draft_kings_kicker_fantasy_points_allowed' 		=> $val->getDraftKingsKickerFantasyPointsAllowed(),
                            'yahoo_fantasy_points_allowed' 						=> $val->getYahooFantasyPointsAllowed(),
                            'yahoo_quarterback_fantasy_points_allowed' 			=> $val->getYahooQuarterbackFantasyPointsAllowed(),
                            'yahoo_runningback_fantasy_points_allowed' 			=> $val->getYahooRunningbackFantasyPointsAllowed(),
                            'yahoo_wide_receiver_fantasy_points_allowed' 		=> $val->getYahooWideReceiverFantasyPointsAllowed(),
                            'yahoo_tight_end_fantasy_points_allowed' 			=> $val->getYahooTightEndFantasyPointsAllowed(),
                            'yahoo_kicker_fantasy_points_allowed' 				=> $val->getYahooKickerFantasyPointsAllowed(),
                            'fantasy_points_fantasy_draft' 						=> $val->getFantasyPointsFantasyDraft(),
                            'fantasy_draft_fantasy_points_allowed' 				=> $val->getFantasyDraftFantasyPointsAllowed(),
                            'fantasy_draft_quarterback_fantasy_points_allowed' 	=> $val->getFantasyDraftQuarterbackFantasyPointsAllowed(),
                            'fantasy_draft_runningback_fantasy_points_allowed' 	=> $val->getFantasyDraftRunningbackFantasyPointsAllowed(),
                            'fantasy_draft_wide_receiver_fantasy_points_allowed'=> $val->getFantasyDraftWideReceiverFantasyPointsAllowed(),
                            'fantasy_draft_tight_end_fantasy_points_allowed' 	=> $val->getFantasyDraftTightEndFantasyPointsAllowed(),
                            'fantasy_draft_kicker_fantasy_points_allowed' 		=> $val->getFantasyDraftKickerFantasyPointsAllowed(),
                            'scoring_details' 									=> $fantasy_scoring_details_data,
                        ];
                        $model = \App\Models\FantasyData\FantasyDefenseSeason::updateOrCreate(
                            ['season_type' => $val['season_type'], 'season' => $val['season'], 'team' => $val['team']],
                            $fantasy_season_stat
                        );
                    }
                    $this->info('Fantasy defense season stat details has been added/updated successfully');
                }
            } catch (Exception $e) {
                echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
            }
        }
    }
}
