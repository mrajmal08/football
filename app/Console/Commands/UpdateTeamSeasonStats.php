<?php

namespace App\Console\Commands;

use App\Clients\FdClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Helper;
use Illuminate\Console\Command;

class UpdateTeamSeasonStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateTeamSeasonStats {--year=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To update team season stats';

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
                $this->info('UpdateTeamSeasonStats Working on '.$season);

                $result = $apiInstance->teamSeasonStats('json', $season);

                if (! empty($result)) {
                    foreach ($result as $key=>$val) {
                        $team_season_stat = [
                            'season_type' 						=> $val->getSeasonType(),
                            'season' 							=> $val->getSeason(),
                            'team'								=> $val->getTeam(),
                            'score' 							=> $val->getScore(),
                            'opponent_score' 					=> $val->getOpponentScore(),
                            'total_score' 						=> $val->getTotalScore(),
                            'temperature' 						=> $val->getTemperature(),
                            'humidity' 							=> $val->getHumidity(),
                            'wind_speed' 						=> $val->getOverUnder(),
                            'point_spread' 						=> $val->getPointSpread(),
                            'score_quarter1' 					=> $val->getScoreQuarter1(),
                            'score_quarter2' 					=> $val->getScoreQuarter2(),
                            'score_quarter3' 					=> $val->getScoreQuarter3(),
                            'score_quarter4' 					=> $val->getScoreQuarter4(),
                            'score_overtime' 					=> $val->getScoreOvertime(),
                            'time_of_possession' 				=> $val->getTimeOfPossession(),
                            'first_downs' 						=> $val->getFirstDowns(),
                            'first_downs_by_rushing' 			=> $val->getFirstDownsByRushing(),
                            'first_downs_by_passing' 			=> $val->getFirstDownsByPassing(),
                            'first_downs_by_penalty' 			=> $val->getFirstDownsByPenalty(),
                            'offensive_plays' 					=> $val->getOffensivePlays(),
                            'offensive_yards' 					=> $val->getOffensiveYards(),
                            'offensive_yards_per_play' 			=> $val->getOffensiveYardsPerPlay(),
                            'touchdowns' 						=> $val->getTouchdowns(),
                            'rushing_attempts' 					=> $val->getRushingAttempts(),
                            'rushing_yards' 					=> $val->getRushingYards(),
                            'rushing_yards_per_attempt' 		=> $val->getRushingYardsPerAttempt(),
                            'rushing_touchdowns' 				=> $val->getRushingTouchdowns(),
                            'passing_attempts' 					=> $val->getPassingAttempts(),
                            'passing_completions' 				=> $val->getPassingCompletions(),
                            'passing_yards' 					=> $val->getPassingYards(),
                            'passing_touchdowns' 				=> $val->getPassingTouchdowns(),
                            'passing_interceptions' 			=> $val->getPassingInterceptions(),
                            'passing_yards_per_attempt' 		=> $val->getPassingYardsPerAttempt(),
                            'passing_yards_per_completion' 		=> $val->getPassingYardsPerCompletion(),
                            'completion_percentage' 			=> $val->getCompletionPercentage(),
                            'passer_rating' 					=> $val->getPasserRating(),
                            'third_down_attempts' 				=> $val->getThirdDownAttempts(),
                            'third_down_conversions' 			=> $val->getThirdDownConversions(),
                            'third_down_percentage'				=> $val->getThirdDownPercentage(),
                            'fourth_down_attempts' 				=> $val->getFourthDownAttempts(),
                            'fourth_down_conversions' 			=> $val->getFourthDownConversions(),
                            'fourth_down_percentage' 			=> $val->getFourthDownPercentage(),
                            'red_zone_attempts' 				=> $val->getRedZoneAttempts(),
                            'red_zone_conversions' 				=> $val->getRedZoneConversions(),
                            'goal_to_go_attempts' 				=> $val->getGoalToGoAttempts(),
                            'goal_to_go_conversions' 			=> $val->getGoalToGoConversions(),
                            'return_yards' 						=> $val->getReturnYards(),
                            'penalties' 						=> $val->getPenalties(),
                            'penalty_yards' 					=> $val->getPenaltyYards(),
                            'fumbles' 							=> $val->getFumbles(),
                            'fumbles_lost' 						=> $val->getFumblesLost(),
                            'times_sacked' 						=> $val->getTimesSacked(),
                            'times_sacked_yards' 				=> $val->getTimesSackedYards(),
                            'quarterback_hits' 					=> $val->getQuarterbackHits(),
                            'tackles_for_loss' 					=> $val->getTacklesForLoss(),
                            'safeties' 							=> $val->getSafeties(),
                            'punts' 							=> $val->getPunts(),
                            'punt_yards' 						=> $val->getPuntYards(),
                            'punt_average' 						=> $val->getPuntAverage(),
                            'giveaways' 						=> $val->getGiveaways(),
                            'takeaways' 						=> $val->getTakeaways(),
                            'turnover_differential' 			=> $val->getTurnoverDifferential(),
                            'opponent_score_quarter1' 			=> $val->getOpponentScoreQuarter1(),
                            'opponent_score_quarter2' 			=> $val->getOpponentScoreQuarter2(),
                            'opponent_score_quarter3' 			=> $val->getOpponentScoreQuarter3(),
                            'opponent_score_quarter4' 			=> $val->getOpponentScoreQuarter4(),
                            'opponent_score_overtime' 			=> $val->getOpponentScoreOvertime(),
                            'opponent_time_of_possession' 		=> $val->getOpponentTimeOfPossession(),
                            'opponent_first_downs' 				=> $val->getOpponentFirstDowns(),
                            'opponent_first_downs_by_rushing' 	=> $val->getOpponentFirstDownsByRushing(),
                            'opponent_first_downs_by_passing' 	=> $val->getOpponentFirstDownsByPassing(),
                            'opponent_first_downs_by_penalty' 	=> $val->getOpponentFirstDownsByPenalty(),
                            'opponent_offensive_plays' 			=> $val->getOpponentOffensivePlays(),
                            'opponent_offensive_yards' 			=> $val->getOpponentOffensiveYards(),
                            'opponent_offensive_yards_per_play'	=> $val->getOpponentOffensiveYardsPerPlay(),
                            'opponent_touchdowns' 				=> $val->getOpponentTouchdowns(),
                            'opponent_rushing_attempts' 		=> $val->getOpponentRushingAttempts(),
                            'opponent_rushing_yards' 			=> $val->getOpponentRushingYards(),
                            'opponent_rushing_yards_per_attempt'=> $val->getOpponentRushingYardsPerAttempt(),
                            'opponent_rushing_touchdowns' 		=> $val->getOpponentRushingTouchdowns(),
                            'opponent_passing_attempts' 		=> $val->getOpponentPassingAttempts(),
                            'opponent_passing_completions' 		=> $val->getOpponentPassingCompletions(),
                            'opponent_passing_yards' 			=> $val->getOpponentPassingYards(),
                            'opponent_passing_touchdowns' 		=> $val->getOpponentPassingTouchdowns(),
                            'opponent_passing_interceptions' 	=> $val->getOpponentPassingInterceptions(),
                            'opponent_passing_yards_per_attempt' => $val->getOpponentPassingYardsPerAttempt(),
                            'opponent_passing_yards_per_completion' => $val->getOpponentPassingYardsPerCompletion(),
                            'opponent_completion_percentage' 	=> $val->getOpponentCompletionPercentage(),
                            'opponent_passer_rating' 			=> $val->getOpponentPasserRating(),
                            'opponent_third_down_attempts' 		=> $val->getOpponentThirdDownAttempts(),
                            'opponent_third_down_conversions' 	=> $val->getOpponentThirdDownConversions(),
                            'opponent_third_down_percentage' 	=> $val->getOpponentThirdDownPercentage(),
                            'opponent_fourth_down_attempts' 	=> $val->getOpponentFourthDownAttempts(),
                            'opponent_fourth_down_conversions'	=> $val->getOpponentFourthDownConversions(),
                            'opponent_fourth_down_percentage' 	=> $val->getOpponentFourthDownPercentage(),
                            'opponent_red_zone_attempts' 		=> $val->getOpponentRedZoneAttempts(),
                            'opponent_red_zone_conversions' 	=> $val->getOpponentRedZoneConversions(),
                            'opponent_goal_to_go_attempts' 		=> $val->getOpponentGoalToGoAttempts(),
                            'opponent_goal_to_go_conversions' 	=> $val->getOpponentGoalToGoConversions(),
                            'opponent_return_yards' 			=> $val->getOpponentReturnYards(),
                            'opponent_penalties' 				=> $val->getOpponentPenalties(),
                            'opponent_penalty_yards' 			=> $val->getOpponentPenaltyYards(),
                            'opponent_fumbles' 					=> $val->getOpponentFumbles(),
                            'opponent_fumbles_lost' 			=> $val->getOpponentFumblesLost(),
                            'opponent_times_sacked' 			=> $val->getOpponentTimesSacked(),
                            'opponent_times_sacked_yards' 		=> $val->getOpponentTimesSackedYards(),
                            'opponent_quarterback_hits' 		=> $val->getOpponentQuarterbackHits(),
                            'opponent_tackles_for_loss' 		=> $val->getOpponentTacklesForLoss(),
                            'opponent_safeties' 				=> $val->getOpponentSafeties(),
                            'opponent_punts' 					=> $val->getOpponentPunts(),
                            'opponent_punt_yards' 				=> $val->getOpponentPuntYards(),
                            'opponent_punt_average' 			=> $val->getOpponentPuntAverage(),
                            'opponent_giveaways' 				=> $val->getOpponentGiveaways(),
                            'opponent_takeaways' 				=> $val->getOpponentTakeaways(),
                            'opponent_turnover_differential' 	=> $val->getOpponentTurnoverDifferential(),
                            'red_zone_percentage' 				=> $val->getRedZonePercentage(),
                            'goal_to_go_percentage' 			=> $val->getGoalToGoPercentage(),
                            'quarterback_hits_differential' 	=> $val->getQuarterbackHitsDifferential(),
                            'tackles_for_loss_differential' 	=> $val->getTacklesForLossDifferential(),
                            'quarterback_sacks_differential' 	=> $val->getQuarterbackSacksDifferential(),
                            'tackles_for_loss_percentage' 		=> $val->getTacklesForLossPercentage(),
                            'quarterback_hits_percentage' 		=> $val->getQuarterbackHitsPercentage(),
                            'times_sacked_percentage' 			=> $val->getTimesSackedPercentage(),
                            'opponent_red_zone_percentage' 		=> $val->getOpponentRedZonePercentage(),
                            'opponent_goal_to_go_percentage' 	=> $val->getOpponentGoalToGoPercentage(),
                            'opponent_quarterback_hits_differential'=> $val->getOpponentQuarterbackHitsDifferential(),
                            'opponent_tackles_for_loss_differential' => $val->getOpponentTacklesForLossDifferential(),
                            'opponent_quarterback_sacks_differential' 		=> $val->getopponentQuarterbackSacksDifferential(),
                            'opponent_tackles_for_loss_percentage' 	=> $val->getOpponentTacklesForLossPercentage(),
                            'opponent_quarterback_hits_percentage' 	=> $val->getOpponentQuarterbackHitsPercentage(),
                            'opponent_times_sacked_percentage' 		=> $val->getOpponentTimesSackedPercentage(),
                            'kickoffs' 								=> $val->getKickoffs(),
                            'kickoffs_in_end_zone' 					=> $val->getKickoffsInEndZone(),
                            'kickoff_touchbacks' 					=> $val->getKickoffTouchbacks(),
                            'punts_had_blocked' 					=> $val->getPuntsHadBlocked(),
                            'punt_net_average' 					    => $val->getPuntNetAverage(),
                            'extra_point_kicking_attempts' 			=> $val->getExtraPointKickingAttempts(),
                            'extra_point_kicking_conversions' 		=> $val->getExtraPointKickingConversions(),
                            'extra_points_had_blocked'				=> $val->getExtraPointsHadBlocked(),
                            'extra_point_passing_attempts' 			=> $val->getExtraPointPassingAttempts(),
                            'extra_point_passing_conversions' 		=> $val->getExtraPointPassingConversions(),
                            'extra_point_rushing_attempts' 			=> $val->getExtraPointRushingAttempts(),
                            'extra_point_rushing_conversions' 		=> $val->getExtraPointRushingConversions(),
                            'field_goal_attempts' 					=> $val->getFieldGoalAttempts(),
                            'field_goals_made' 						=> $val->getFieldGoalsMade(),
                            'field_goals_had_blocked' 				=> $val->getFieldGoalsHadBlocked(),
                            'punt_returns' 							=> $val->getPuntReturns(),
                            'kick_returns' 							=> $val->getKickReturns(),
                            'kick_return_yards' 					=> $val->getKickReturnYards(),
                            'interception_returns' 					=> $val->getInterceptionReturns(),
                            'interception_return_yards' 			=> $val->getInterceptionReturnYards(),
                            'opponent_kickoffs' 					=> $val->getOpponentKickoffs(),
                            'opponent_kickoffs_in_end_zone' 		=> $val->getOpponentKickoffsInEndZone(),
                            'opponent_kickoff_touchbacks' 			=> $val->getOpponentKickoffTouchbacks(),
                            'opponent_punts_had_blocked' 			=> $val->getOpponentPuntsHadBlocked(),
                            'opponent_punt_net_average' 			=> $val->getOpponentPuntNetAverage(),
                            'opponent_extra_point_kicking_attempts' => $val->getOpponentExtraPointKickingAttempts(),
                            'opponent_extra_point_kicking_conversions' 	=> $val->getOpponentExtraPointKickingConversions(),
                            'opponent_extra_points_had_blocked' 		=> $val->getOpponentExtraPointsHadBlocked(),
                            'opponent_extra_point_passing_attempts' 	=> $val->getOpponentExtraPointPassingAttempts(),
                            'opponent_extra_point_passing_conversions' 	=> $val->getOpponentExtraPointPassingConversions(),
                            'opponent_extra_point_rushing_attempts' 	=> $val->getOpponentExtraPointRushingAttempts(),
                            'opponent_extra_point_rushing_conversions' 	=> $val->getOpponentExtraPointRushingConversions(),

                            'opponent_field_goal_attempts' 				=> $val->getOpponentFieldGoalAttempts(),
                            'opponent_field_goals_made' 				=> $val->getOpponentFieldGoalsMade(),
                            'opponent_field_goals_had_blocked' 			=> $val->getOpponentFieldGoalsHadBlocked(),
                            'opponent_punt_returns' 					=> $val->getOpponentPuntReturns(),
                            'opponent_punt_return_yards' 				=> $val->getOpponentPuntReturnYards(),
                            'opponent_kick_returns' 					=> $val->getOpponentKickReturns(),

                            'opponent_kick_return_yards' 				=> $val->getOpponentKickReturnYards(),
                            'opponent_interception_returns' 			=> $val->getOpponentInterceptionReturns(),
                            'opponent_interception_return_yards' 		=> $val->getOpponentInterceptionReturnYards(),
                            'solo_tackles' 								=> $val->getSoloTackles(),
                            'assisted_tackles' 							=> $val->getAssistedTackles(),
                            'sacks' 									=> $val->getSacks(),
                            'sack_yards'								=> $val->getSackYards(),

                            'passes_defended'							=> $val->getPassesDefended(),
                            'fumbles_forced'							=> $val->getfumblesForced(),
                            'fumbles_recovered' 						=> $val->getFumblesRecovered(),
                            'fumble_return_yards' 						=> $val->getFumbleReturnYards(),
                            'fumble_return_touchdowns' 					=> $val->getFumbleReturnTouchdowns(),
                            'interception_return_touchdowns' 			=> $val->getInterceptionReturnTouchdowns(),
                            'blocked_kicks' 							=> $val->getBlockedKicks(),
                            'punt_return_touchdowns' 					=> $val->getPuntReturnTouchdowns(),
                            'punt_return_long' 							=> $val->getPuntReturnLong(),
                            'kick_return_touchdowns' 					=> $val->getKickReturnTouchdowns(),
                            'kick_return_long' 							=> $val->getKickReturnLong(),
                            'blocked_kick_return_yards' 				=> $val->getBlockedKickReturnYards(),
                            'blocked_kick_return_touchdowns' 			=> $val->getBlockedKickReturnTouchdowns(),
                            'field_goal_return_yards' 					=> $val->getFieldGoalReturnYards(),
                            'field_goal_return_touchdowns' 				=> $val->getFieldGoalReturnTouchdowns(),
                            'punt_net_yards' 							=> $val->getPuntNetYards(),
                            'opponent_solo_tackles' 					=> $val->getOpponentSoloTackles(),
                            'opponent_assisted_tackles' 				=> $val->getOpponentAssistedTackles(),
                            'opponent_sacks' 							=> $val->getOpponentSacks(),
                            'opponent_sacks' 							=> $val->getOpponentSacks(),
                            'opponent_passes_defended' 					=> $val->getOpponentPassesDefended(),
                            'opponent_fumbles_forced' 					=> $val->getOpponentFumblesForced(),
                            'opponent_fumbles_recovered' 				=> $val->getOpponentFumblesRecovered(),
                            'opponent_fumble_return_yards' 				=> $val->getOpponentFumbleReturnYards(),
                            'opponent_interception_return_touchdowns' 		=> $val->getOpponentInterceptionReturnTouchdowns(),
                            'opponent_punt_return_touchdowns' 			=> $val->getOpponentPuntReturnTouchdowns(),
                            'opponent_punt_return_long' 				=> $val->getOpponentPuntReturnLong(),
                            'opponent_kick_return_touchdowns' 			=> $val->getOpponentKickReturnTouchdowns(),
                            'opponent_kick_return_long' 				=> $val->getOpponentKickReturnLong(),
                            'opponent_blocked_kick_return_yards' 		 	=> $val->getOpponentBlockedKickReturnYards(),
                            'opponent_blocked_kick_return_touchdowns' 	=> $val->getOpponentBlockedKickReturnTouchdowns(),
                            'opponent_field_goal_return_yards' 		  	=> $val->getOpponentFieldGoalReturnYards(),
                            'opponent_field_goal_return_touchdowns'   	=> $val->getOpponentFieldGoalReturnTouchdowns(),
                            'opponent_punt_net_yards' 				  	=> $val->getOpponentPuntNetYards(),
                            'team_name' 								=> $val->getTeamName(),
                            'games' 									=> $val->getGames(),
                            'passing_dropbacks' 						=> $val->getPassingDropbacks(),
                            'opponent_passing_dropbacks' 				=> $val->getOpponentPassingDropbacks(),
                            'team_season_id' 							=> $val->getTeamSeasonId(),
                            'point_differential' 						=> $val->getPointDifferential(),
                            'passing_interception_percentage' 			=> $val->getPassingInterceptionPercentage(),
                            'punt_return_average' 						=> $val->getPuntReturnAverage(),
                            'kick_return_average' 						=> $val->getKickReturnAverage(),
                            'extra_point_percentage' 					=> $val->getExtraPointPercentage(),
                            'field_goal_percentage' 					=> $val->getFieldGoalPercentage(),
                            'opponent_passing_interception_percentage' 				=> $val->getOpponentPassingInterceptionPercentage(),
                            'opponent_punt_return_average' 				=> $val->getOpponentPuntReturnAverage(),
                            'opponent_kick_return_average' 				=> $val->getOpponentKickReturnAverage(),
                            'opponent_extra_point_percentage' 			=> $val->getOpponentExtraPointPercentage(),
                            'opponent_field_goal_percentage' 			=> $val->getOpponentFieldGoalPercentage(),
                            'penalty_yard_differential' 				=> $val->getPenaltyYardDifferential(),
                            'punt_return_yard_differential' 			=> $val->getPuntReturnYardDifferential(),
                            'kick_return_yard_differential' 			=> $val->getKickReturnYardDifferential(),
                            'two_point_conversion_returns' 				=> $val->getTwoPointConversionReturns(),
                            'opponent_two_point_conversion_returns' 	=> $val->getOpponentTwoPointConversionReturns(),
                            'team_id' 									=> $val->getTeamId(),
                            'global_team_id' 							=> $val->getGlobalTeamId(),

                        ];
                        $model = \App\Models\FantasyData\TeamSeason::updateOrCreate(
                            ['season_type' => $val['season_type'], 'season' => $val['season'], 'team' => $val['team']],
                            $team_season_stat
                        );
                    }
                    $this->info('Team season stat details has been added/updated successfully');
                }
            } catch (Exception $e) {
                echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
            }
        }
    }
}
