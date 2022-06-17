<?php

namespace App\Console\Commands;

use Acme\FantasyDataStats\BoxScoreV3;
use Acme\FantasyDataStats\Schedule;
use App\Clients\FdClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class UpdateBoxScoresLiveDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateBoxScoresLiveDemo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update box scores UpdateBoxScoresLiveDemo';

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
        $object = new Schedule();
        $apiInstance = new \Acme\FantasyDataStats\Api\DefaultApi(
            new FdClient()
        );

        $body = new BoxScoreV3();

        \App\Models\FantasyData\PlayerGame::truncate();
        \App\Models\FantasyData\FantasyDefenseGame::truncate();

        try {
            $format = 'json';

            for ($i = 1; $i <= 200; $i++) {
                $result = $apiInstance->boxScoresVSimulation($format, $i);

                if (! empty($result)) {
                    foreach ($result as $key=>$val) {
                        $scores = $val['score'];
                        $quarters = $val['quarters'];
                        $team_games = $val['team_games'];
                        $player_games = $val['player_games'];
                        $fantasy_defense_games = $val['fantasy_defense_games'];
                        $scoring_plays = $val['scoring_plays'];
                        $scoring_details = $val['scoring_details'];
                        $scores_data = [];

                        if (! empty($scores)) {
                            $scores_data = [
                                'game_key' 					=> $scores->getGameKey(),
                                'season_type' 				=> $scores->getSeasonType(),
                                'season' 					=> $scores->getSeason(),
                                'week' 						=> $scores->getWeek(),
                                'date' 						=> $scores->getDate(),
                                'away_team' 				=> $scores->getAwayTeam(),
                                'home_team' 				=> $scores->getHomeTeam(),
                                'away_score' 				=> $scores->getAwayScore(),
                                'home_score' 				=> $scores->getHomeScore(),
                                'channel' 					=> $scores->getChannel(),
                                'point_spread' 				=> $scores->getPointSpread(),
                                'over_under' 				=> $scores->getOverUnder(),
                                'quarter' 					=> $scores->getQuarter(),
                                'time_remaining' 			=> $scores->getTimeRemaining(),
                                'possession' 				=> $scores->getPossession(),
                                'down' 						=> $scores->getDown(),
                                'distance' 					=> $scores->getDistance(),
                                'yard_line' 				=> $scores->getYardLine(),
                                'yard_line_territory' 		=> $scores->getYardLineTerritory(),
                                'red_zone' 					=> $scores->getRedZone(),
                                'away_score_quarter1' 		=> $scores->getAwayScoreQuarter1(),
                                'away_score_quarter2' 		=> $scores->getAwayScoreQuarter2(),
                                'away_score_quarter3' 		=> $scores->getAwayScoreQuarter3(),
                                'away_score_quarter4' 		=> $scores->getAwayScoreQuarter4(),
                                'away_score_overtime' 		=> $scores->getAwayScoreOvertime(),
                                'home_score_quarter1' 		=> $scores->getHomeScoreQuarter1(),
                                'home_score_quarter2' 		=> $scores->getHomeScoreQuarter2(),
                                'home_score_quarter3' 		=> $scores->getHomeScoreQuarter3(),
                                'home_score_quarter4' 		=> $scores->getHomeScoreQuarter4(),
                                'home_score_overtime' 		=> $scores->getHomeScoreOvertime(),
                                'has_started' 				=> $scores->getHasStarted(),
                                'is_in_progress' 			=> $scores->getIsInProgress(),
                                'is_over' 					=> $scores->getIsOver(),
                                'has1st_quarter_started' 	=> $scores->getHas1stQuarterStarted(),
                                'has2nd_quarter_started' 	=> $scores->getHas2ndQuarterStarted(),
                                'has3rd_quarter_started' 	=> $scores->getHas3rdQuarterStarted(),
                                'has4th_quarter_started' 	=> $scores->getHas4thQuarterStarted(),
                                'is_overtime' 				=> $scores->getIsOvertime(),
                                'down_and_distance' 		=> $scores->getDownAndDistance(),
                                'quarter_description' 		=> $scores->getQuarterDescription(),
                                'stadium_id' 				=> $scores->getStadiumId(),
                                'last_updated' 				=> $scores->getLastUpdated(),
                                'geo_lat'					=> $scores->getGeoLat(),
                                'geo_long' 					=> $scores->getGeoLong(),
                                'forecast_temp_low' 		=> $scores->getForecastTempLow(),
                                'forecast_temp_high' 		=> $scores->getForecastTempHigh(),
                                'forecast_description' 		=> $scores->getForecastDescription(),
                                'forecast_wind_chill' 		=> $scores->getForecastWindChill(),
                                'forecast_wind_speed' 		=> $scores->getForecastWindSpeed(),
                                'away_team_money_line' 		=> $scores->getAwayTeamMoneyLine(),
                                'home_team_money_line' 		=> $scores->getHomeTeamMoneyLine(),
                                'canceled' 					=> $scores->getCanceled(),
                                'closed' 					=> $scores->getClosed(),
                                'last_play' 				=> $scores->getLastPlay(),
                                'day' 						=> $scores->getDay(),
                                'date_time' 				=> $scores->getDateTime(),
                                'away_team_id' 				=> $scores->getAwayTeamId(),
                                'home_team_id' 				=> $scores->getHomeTeamId(),
                                'global_game_id' 			=> $scores->getGlobalGameId(),
                                'global_away_team_id' 		=> $scores->getGlobalAwayTeamId(),
                                'global_home_team_id' 		=> $scores->getGlobalHomeTeamId(),
                                'point_spread_away_team_money_line' => $scores->getPointSpreadAwayTeamMoneyLine(),
                                'point_spread_home_team_money_line' => $scores->getPointSpreadHomeTeamMoneyLine(),
                                'score_id' 					=> $scores->getScoreId(),
                            ];
                            $model = \App\Models\FantasyData\Score::updateOrCreate(
                            ['game_key'   => $scores->getGameKey()],
                            $scores_data
                        );
                        }
                        if (isset($quarters) && count($quarters) > 0) {
                            foreach ($quarters as $qkey=>$qval) {
                                $quarters_data = [];
                                $quarters_data = [
                                    'quarter_id' 		=> $qval->getQuarterId(),
                                    'score_id' 			=> $qval->getScoreId(),
                                    'number' 			=> $qval->getNumber(),
                                    'name' 				=> $qval->getName(),
                                    'description' 		=> $qval->getDescription(),
                                    'away_team_score' 	=> $qval->getAwayTeamScore(),
                                    'home_team_score' 	=> $qval->getHomeTeamScore(),
                                    'updated' 			=> $qval->getUpdated(),
                                    'created' 			=> $qval->getCreated(),
                                ];
                                $model = \App\Models\FantasyData\Quarter::updateOrCreate(
                                ['quarter_id'   => $qval->getQuarterId(), 'score_id'	=> $qval->getScoreId()],
                                $quarters_data
                            );
                            }
                        }

                        if (isset($team_games) && count($team_games) > 0) {
                            foreach ($team_games as $tkey=>$tval) {
                                $team_games_data = [];
                                $team_games_data = [
                                    'game_key'						=> $tval->getGameKey(),
                                    'date'							=> $tval->getDate(),
                                    'season_type'					=> $tval->getSeasonType(),
                                    'season'						=> $tval->getSeason(),
                                    'week'							=> $tval->getWeek(),
                                    'team'							=> $tval->getTeam(),
                                    'opponent'						=> $tval->getOpponent(),
                                    'home_or_away'					=> $tval->getHomeOrAway(),
                                    'score'							=> $tval->getScore(),
                                    'opponent_score'				=> $tval->getOpponentScore(),
                                    'total_score'					=> $tval->getTotalScore(),
                                    'stadium'						=> $tval->getStadium(),
                                    'playing_surface'				=> $tval->getPlayingSurface(),
                                    'temperature'					=> $tval->getTemperature(),
                                    'humidity'						=> $tval->getHumidity(),
                                    'wind_speed'					=> $tval->getWindSpeed(),
                                    'over_under'					=> $tval->getOverUnder(),
                                    'point_spread'					=> $tval->getPointSpread(),
                                    'score_quarter1'				=> $tval->getScoreQuarter1(),
                                    'score_quarter2'				=> $tval->getScoreQuarter2(),
                                    'score_quarter3'				=> $tval->getScoreQuarter3(),
                                    'score_quarter4'				=> $tval->getScoreQuarter4(),
                                    'score_overtime'				=> $tval->getScoreOvertime(),
                                    'time_of_possession_minutes'	=> $tval->getTimeOfPossessionMinutes(),
                                    'time_of_possession_seconds'	=> $tval->getTimeOfPossessionSeconds(),
                                    'time_of_possession'			=> $tval->getTimeOfPossession(),
                                    'first_downs'					=> $tval->getFirstDowns(),
                                    'first_downs_by_rushing'		=> $tval->getFirstDownsByRushing(),
                                    'first_downs_by_passing'		=> $tval->getFirstDownsByPassing(),
                                    'first_downs_by_penalty'		=> $tval->getFirstDownsByPenalty(),
                                    'offensive_plays'				=> $tval->getOffensivePlays(),
                                    'offensive_yards'				=> $tval->getOffensiveYards(),
                                    'offensive_yards_per_play'		=> $tval->getOffensiveYardsPerPlay(),
                                    'touchdowns'					=> $tval->getTouchdowns(),
                                    'rushing_attempts'				=> $tval->getRushingAttempts(),
                                    'rushing_yards'					=> $tval->getRushingYards(),
                                    'rushing_yards_per_attempt'		=> $tval->getRushingYardsPerAttempt(),
                                    'rushing_touchdowns'			=> $tval->getRushingTouchdowns(),
                                    'passing_attempts'				=> $tval->getPassingAttempts(),
                                    'passing_completions'			=> $tval->getPassingCompletions(),
                                    'passing_yards'					=> $tval->getPassingYards(),
                                    'passing_touchdowns'			=> $tval->getPassingTouchdowns(),
                                    'passing_interceptions'			=> $tval->getPassingInterceptions(),
                                    'passing_yards_per_attempt'		=> $tval->getPassingYardsPerAttempt(),
                                    'passing_yards_per_completion'	=> $tval->getPassingYardsPerCompletion(),
                                    'completion_percentage'			=> $tval->getCompletionPercentage(),
                                    'passer_rating'					=> $tval->getPasserRating(),
                                    'third_down_attempts'			=> $tval->getThirdDownAttempts(),
                                    'third_down_conversions'		=> $tval->getThirdDownConversions(),
                                    'third_down_percentage'			=> $tval->getThirdDownPercentage(),
                                    'fourth_down_attempts'			=> $tval->getFourthDownAttempts(),
                                    'fourth_down_conversions'		=> $tval->getFourthDownConversions(),
                                    'fourth_down_percentage'		=> $tval->getFourthDownPercentage(),
                                    'red_zone_attempts'				=> $tval->getRedZoneAttempts(),
                                    'red_zone_conversions'			=> $tval->getRedZoneConversions(),
                                    'goal_to_go_attempts'			=> $tval->getGoalToGoAttempts(),
                                    'goal_to_go_conversions'		=> $tval->getGoalToGoConversions(),
                                    'return_yards'					=> $tval->getReturnYards(),
                                    'penalties'						=> $tval->getPenalties(),
                                    'penalty_yards'					=> $tval->getPenaltyYards(),
                                    'fumbles'						=> $tval->getFumbles(),
                                    'fumbles_lost'					=> $tval->getFumblesLost(),
                                    'times_sacked'					=> $tval->getTimesSacked(),
                                    'times_sacked_yards'			=> $tval->getTimesSackedYards(),
                                    'quarterback_hits'				=> $tval->getQuarterbackHits(),
                                    'tackles_for_loss'				=> $tval->getTacklesForLoss(),
                                    'safeties'						=> $tval->getSafeties(),
                                    'punts'							=> $tval->getPunts(),
                                    'punt_yards'					=> $tval->getPuntYards(),
                                    'punt_average'					=> $tval->getPuntAverage(),
                                    'giveaways'						=> $tval->getGiveaways(),
                                    'takeaways'						=> $tval->getTakeaways(),
                                    'turnover_differential'			=> $tval->getTurnoverDifferential(),
                                    'opponent_score_quarter1'		=> $tval->getOpponentScoreQuarter1(),
                                    'opponent_score_quarter2'		=> $tval->getOpponentScoreQuarter2(),
                                    'opponent_score_quarter3'		=> $tval->getOpponentScoreQuarter3(),
                                    'opponent_score_quarter4'		=> $tval->getOpponentScoreQuarter4(),
                                    'opponent_score_overtime'		=> $tval->getOpponentScoreOvertime(),
                                    'opponent_time_of_possession_minutes'=> $tval->getOpponentTimeOfPossessionMinutes(),
                                    'opponent_time_of_possession_seconds'=> $tval->getOpponentTimeOfPossessionSeconds(),
                                    'opponent_time_of_possession'		=> $tval->getOpponentTimeOfPossession(),
                                    'opponent_first_downs'				=> $tval->getOpponentFirstDowns(),
                                    'opponent_first_downs_by_rushing'	=> $tval->getOpponentFirstDownsByRushing(),
                                    'opponent_first_downs_by_passing'	=> $tval->getOpponentFirstDownsByPassing(),
                                    'opponent_first_downs_by_penalty'	=> $tval->getOpponentFirstDownsByPenalty(),
                                    'opponent_offensive_plays'			=> $tval->getOpponentOffensivePlays(),
                                    'opponent_offensive_yards'			=> $tval->getOpponentOffensiveYards(),
                                    'opponent_offensive_yards_per_play'	=> $tval->getOpponentOffensiveYardsPerPlay(),
                                    'opponent_touchdowns'				=> $tval->getOpponentTouchdowns(),
                                    'opponent_rushing_attempts'			=> $tval->getOpponentRushingAttempts(),
                                    'opponent_rushing_yards'			=> $tval->getOpponentRushingYards(),
                                    'opponent_rushing_yards_per_attempt'=> $tval->getOpponentRushingYardsPerAttempt(),
                                    'opponent_rushing_touchdowns'		=> $tval->getOpponentRushingTouchdowns(),
                                    'opponent_passing_attempts'			=> $tval->getOpponentPassingAttempts(),
                                    'opponent_passing_completions'		=> $tval->getOpponentPassingCompletions(),
                                    'opponent_passing_yards'			=> $tval->getOpponentPassingYards(),
                                    'opponent_passing_touchdowns'		=> $tval->getOpponentPassingTouchdowns(),
                                    'opponent_passing_interceptions'	=> $tval->getOpponentPassingInterceptions(),
                                    'opponent_passing_yards_per_attempt'=> $tval->getOpponentPassingYardsPerAttempt(),
                                    'opponent_passing_yards_per_completion'=> $tval->getOpponentPassingYardsPerCompletion(),
                                    'opponent_completion_percentage'	=> $tval->getOpponentCompletionPercentage(),
                                    'opponent_passer_rating'			=> $tval->getOpponentPasserRating(),
                                    'opponent_third_down_attempts'		=> $tval->getOpponentThirdDownAttempts(),
                                    'opponent_third_down_conversions'	=> $tval->getOpponentThirdDownConversions(),
                                    'opponent_third_down_percentage'	=> $tval->getOpponentThirdDownPercentage(),
                                    'opponent_fourth_down_attempts'		=> $tval->getOpponentFourthDownAttempts(),
                                    'opponent_fourth_down_conversions'	=> $tval->getOpponentFourthDownConversions(),
                                    'opponent_fourth_down_percentage'	=> $tval->getOpponentFourthDownPercentage(),
                                    'opponent_red_zone_attempts'		=> $tval->getOpponentRedZoneAttempts(),
                                    'opponent_red_zone_conversions'		=> $tval->getOpponentRedZoneConversions(),
                                    'opponent_goal_to_go_attempts'		=> $tval->getOpponentGoalToGoAttempts(),
                                    'opponent_goal_to_go_conversions'	=> $tval->getOpponentGoalToGoConversions(),
                                    'opponent_return_yards'				=> $tval->getOpponentReturnYards(),
                                    'opponent_penalties'				=> $tval->getOpponentPenalties(),
                                    'opponent_penalty_yards'			=> $tval->getOpponentPenaltyYards(),
                                    'opponent_fumbles'					=> $tval->getOpponentFumbles(),
                                    'opponent_fumbles_lost'				=> $tval->getOpponentFumblesLost(),
                                    'opponent_times_sacked'				=> $tval->getOpponentTimesSacked(),
                                    'opponent_times_sacked_yards'		=> $tval->getOpponentTimesSackedYards(),
                                    'opponent_quarterback_hits'			=> $tval->getOpponentQuarterbackHits(),
                                    'opponent_tackles_for_loss'			=> $tval->getOpponentTacklesForLoss(),
                                    'opponent_safeties'					=> $tval->getOpponentSafeties(),
                                    'opponent_punts'					=> $tval->getOpponentPunts(),
                                    'opponent_punt_yards'				=> $tval->getOpponentPuntYards(),
                                    'opponent_punt_average'				=> $tval->getOpponentPuntAverage(),
                                    'opponent_giveaways'				=> $tval->getOpponentGiveaways(),
                                    'opponent_takeaways'				=> $tval->getOpponentTakeaways(),
                                    'opponent_turnover_differential'	=> $tval->getOpponentTurnoverDifferential(),
                                    'red_zone_percentage'				=> $tval->getRedZonePercentage(),
                                    'goal_to_go_percentage'				=> $tval->getGoalToGoPercentage(),
                                    'quarterback_hits_differential'		=> $tval->getQuarterbackHitsDifferential(),
                                    'tackles_for_loss_differential'		=> $tval->getTacklesForLossDifferential(),
                                    'quarterback_sacks_differential'	=> $tval->getQuarterbackSacksDifferential(),
                                    'tackles_for_loss_percentage'		=> $tval->getTacklesForLossPercentage(),
                                    'quarterback_hits_percentage'		=> $tval->getQuarterbackHitsPercentage(),
                                    'times_sacked_percentage'			=> $tval->getTimesSackedPercentage(),
                                    'opponent_red_zone_percentage'		=> $tval->getOpponentRedZonePercentage(),
                                    'opponent_goal_to_go_percentage'	=> $tval->getOpponentGoalToGoPercentage(),
                                    'opponent_quarterback_hits_differential'	=> $tval->getOpponentQuarterbackHitsDifferential(),
                                    'opponent_tackles_for_loss_differential'	=> $tval->getOpponentTacklesForLossDifferential(),
                                    'opponent_quarterback_sacks_differential'	=> $tval->getOpponentQuarterbackSacksDifferential(),
                                    'opponent_tackles_for_loss_percentage'		=> $tval->getOpponentTacklesForLossPercentage(),
                                    'opponent_quarterback_hits_percentage'		=> $tval->getOpponentQuarterbackHitsPercentage(),
                                    'opponent_times_sacked_percentage'			=> $tval->getOpponentTimesSackedPercentage(),
                                    'kickoffs'							=> $tval->getKickoffs(),
                                    'kickoffs_in_end_zone'				=> $tval->getKickoffsInEndZone(),
                                    'kickoff_touchbacks'				=> $tval->getKickoffTouchbacks(),
                                    'punts_had_blocked'					=> $tval->getPuntsHadBlocked(),
                                    'punt_net_average'					=> $tval->getPuntNetAverage(),
                                    'extra_point_kicking_attempts'		=> $tval->getExtraPointKickingAttempts(),
                                    'extra_point_kicking_conversions'	=> $tval->getExtraPointKickingConversions(),
                                    'extra_points_had_blocked'			=> $tval->getExtraPointsHadBlocked(),
                                    'extra_point_passing_attempts'		=> $tval->getExtraPointPassingAttempts(),
                                    'extra_point_passing_conversions'	=> $tval->getExtraPointPassingConversions(),
                                    'extra_point_rushing_attempts'		=> $tval->getExtraPointRushingAttempts(),
                                    'extra_point_rushing_conversions'	=> $tval->getExtraPointRushingConversions(),
                                    'field_goal_attempts'				=> $tval->getFieldGoalAttempts(),
                                    'field_goals_made'					=> $tval->getFieldGoalsMade(),
                                    'field_goals_had_blocked'			=> $tval->getFieldGoalsHadBlocked(),
                                    'punt_returns'						=> $tval->getPuntReturns(),
                                    'punt_return_yards'					=> $tval->getPuntReturnYards(),
                                    'kick_returns'						=> $tval->getKickReturns(),
                                    'kick_return_yards'					=> $tval->getKickReturnYards(),
                                    'interception_returns'				=> $tval->getInterceptionReturns(),
                                    'interception_return_yards'			=> $tval->getInterceptionReturnYards(),
                                    'opponent_kickoffs'					=> $tval->getOpponentKickoffs(),
                                    'opponent_kickoffs_in_end_zone'		=> $tval->getOpponentKickoffsInEndZone(),
                                    'opponent_kickoff_touchbacks'		=> $tval->getOpponentKickoffTouchbacks(),
                                    'opponent_punts_had_blocked'		=> $tval->getOpponentPuntsHadBlocked(),
                                    'opponent_punt_net_average'			=> $tval->getOpponentPuntNetAverage(),
                                    'opponent_extra_point_kicking_attempts'		=> $tval->getOpponentExtraPointKickingAttempts(),
                                    'opponent_extra_point_kicking_conversions'	=> $tval->getOpponentExtraPointKickingConversions(),
                                    'opponent_extra_points_had_blocked'			=> $tval->getOpponentExtraPointsHadBlocked(),
                                    'opponent_extra_point_passing_attempts'		=> $tval->getOpponentExtraPointPassingAttempts(),
                                    'opponent_extra_point_passing_conversions'	=> $tval->getOpponentExtraPointPassingConversions(),
                                    'opponent_extra_point_rushing_attempts'		=> $tval->getOpponentExtraPointRushingAttempts(),
                                    'opponent_extra_point_rushing_conversions'	=> $tval->getOpponentExtraPointRushingConversions(),
                                    'opponent_field_goal_attempts'				=> $tval->getOpponentFieldGoalAttempts(),
                                    'opponent_field_goals_made'			=> $tval->getOpponentFieldGoalsMade(),
                                    'opponent_field_goals_had_blocked'	=> $tval->getOpponentFieldGoalsHadBlocked(),
                                    'opponent_punt_returns'				=> $tval->getOpponentPuntReturns(),
                                    'opponent_punt_return_yards'		=> $tval->getOpponentPuntReturnYards(),
                                    'opponent_kick_returns'				=> $tval->getOpponentKickReturns(),
                                    'opponent_kick_return_yards'		=> $tval->getOpponentKickReturnYards(),
                                    'opponent_interception_returns'		=> $tval->getOpponentInterceptionReturns(),
                                    'opponent_interception_return_yards'=> $tval->getOpponentInterceptionReturnYards(),
                                    'solo_tackles'						=> $tval->getSoloTackles(),
                                    'assisted_tackles'					=> $tval->getAssistedTackles(),
                                    'sacks'								=> $tval->getSacks(),
                                    'sack_yards'						=> $tval->getSackYards(),
                                    'passes_defended'					=> $tval->getPassesDefended(),
                                    'fumbles_forced'					=> $tval->getFumblesForced(),
                                    'fumbles_recovered'					=> $tval->getFumblesRecovered(),
                                    'fumble_return_yards'				=> $tval->getFumbleReturnYards(),
                                    'fumble_return_touchdowns'			=> $tval->getFumbleReturnTouchdowns(),
                                    'interception_return_touchdowns'	=> $tval->getInterceptionReturnTouchdowns(),
                                    'blocked_kicks'						=> $tval->getBlockedKicks(),
                                    'punt_return_touchdowns'			=> $tval->getPuntReturnTouchdowns(),
                                    'punt_return_long'					=> $tval->getPuntReturnLong(),
                                    'kick_return_touchdowns'			=> $tval->getKickReturnTouchdowns(),
                                    'kick_return_long'					=> $tval->getKickReturnLong(),
                                    'blocked_kick_return_yards'			=> $tval->getBlockedKickReturnYards(),
                                    'blocked_kick_return_touchdowns'	=> $tval->getBlockedKickReturnTouchdowns(),
                                    'field_goal_return_yards'			=> $tval->getFieldGoalReturnYards(),
                                    'field_goal_return_touchdowns'		=> $tval->getFieldGoalReturnTouchdowns(),
                                    'punt_net_yards'					=> $tval->getPuntNetYards(),
                                    'opponent_solo_tackles'				=> $tval->getOpponentSoloTackles(),
                                    'opponent_assisted_tackles'			=> $tval->getOpponentAssistedTackles(),
                                    'opponent_sacks'					=> $tval->getOpponentSacks(),
                                    'opponent_sack_yards'				=> $tval->getOpponentSackYards(),
                                    'opponent_passes_defended'			=> $tval->getOpponentPassesDefended(),
                                    'opponent_fumbles_forced'			=> $tval->getOpponentFumblesForced(),
                                    'opponent_fumbles_recovered'		=> $tval->getOpponentFumblesRecovered(),
                                    'opponent_fumble_return_yards'		=> $tval->getOpponentFumbleReturnYards(),
                                    'opponent_fumble_return_touchdowns'	=> $tval->getOpponentFumbleReturnTouchdowns(),
                                    'opponent_interception_return_touchdowns'=> $tval->getOpponentInterceptionReturnTouchdowns(),
                                    'opponent_blocked_kicks'			=> $tval->getOpponentBlockedKicks(),
                                    'opponent_punt_return_touchdowns'	=> $tval->getOpponentPuntReturnTouchdowns(),
                                    'opponent_punt_return_long'			=> $tval->getOpponentPuntReturnLong(),
                                    'opponent_kick_return_touchdowns'	=> $tval->getOpponentKickReturnTouchdowns(),
                                    'opponent_kick_return_long'			=> $tval->getOpponentKickReturnLong(),
                                    'opponent_blocked_kick_return_yards'=> $tval->getOpponentBlockedKickReturnYards(),
                                    'opponent_blocked_kick_return_touchdowns'=> $tval->getOpponentBlockedKickReturnTouchdowns(),
                                    'opponent_field_goal_return_yards'	=> $tval->getOpponentFieldGoalReturnYards(),
                                    'opponent_field_goal_return_touchdowns'=> $tval->getOpponentFieldGoalReturnTouchdowns(),
                                    'opponent_punt_net_yards'			=> $tval->getOpponentPuntNetYards(),
                                    'is_game_over'						=> $tval->getIsGameOver(),
                                    'team_name'							=> $tval->getTeamName(),
                                    'day_of_week'						=> $tval->getDayOfWeek(),
                                    'passing_dropbacks'					=> $tval->getPassingDropbacks(),
                                    'opponent_passing_dropbacks'		=> $tval->getOpponentPassingDropbacks(),
                                    'team_game_id'						=> $tval->getTeamGameId(),
                                    'point_differential'				=> $tval->getPointDifferential(),
                                    'passing_interception_percentage'	=> $tval->getPassingInterceptionPercentage(),
                                    'punt_return_average'				=> $tval->getPuntReturnAverage(),
                                    'kick_return_average'				=> $tval->getKickReturnAverage(),
                                    'extra_point_percentage'			=> $tval->getExtraPointPercentage(),
                                    'field_goal_percentage'				=> $tval->getFieldGoalPercentage(),
                                    'opponent_passing_interception_percentage'=> $tval->getOpponentPassingInterceptionPercentage(),
                                    'opponent_punt_return_average'		=> $tval->getOpponentPuntReturnAverage(),
                                    'opponent_kick_return_average'		=> $tval->getOpponentKickReturnAverage(),
                                    'opponent_extra_point_percentage'	=> $tval->getOpponentExtraPointPercentage(),
                                    'opponent_field_goal_percentage'	=> $tval->getOpponentFieldGoalPercentage(),
                                    'penalty_yard_differential'			=> $tval->getPenaltyYardDifferential(),
                                    'punt_return_yard_differential'		=> $tval->getPuntReturnYardDifferential(),
                                    'kick_return_yard_differential'		=> $tval->getKickReturnYardDifferential(),
                                    'two_point_conversion_returns'		=> $tval->getTwoPointConversionReturns(),
                                    'opponent_two_point_conversion_returns'=> $tval->getOpponentTwoPointConversionReturns(),
                                    'team_id'							=> $tval->getTeamId(),
                                    'opponent_id'						=> $tval->getOpponentId(),
                                    'day'								=> $tval->getDay(),
                                    'date_time'							=> $tval->getDateTime(),
                                    'global_game_id'					=> $tval->getGlobalGameId(),
                                    'global_team_id'					=> $tval->getGlobalTeamId(),
                                    'global_opponent_id'				=> $tval->getGlobalOpponentId(),
                                    'score_id'							=> $tval->getScoreId(),

                                ];
                                $model = \App\Models\FantasyData\TeamGame::updateOrCreate(
                                ['game_key'   => $tval->getGameKey(), 'team_game_id'   => $tval->getTeamGameId()],
                                $team_games_data
                            );
                            }
                        }

                        if (isset($player_games) && count($player_games) > 0) {
                            foreach ($player_games as $tkey=>$pval) {
                                $player_games_data = [];
                                $player_games_data = [

                                    'game_key'							    => $pval->getGameKey(),
                                    'player_id'							    => $pval->getPlayerId(),
                                    'season_type'							=> $pval->getSeasonType(),
                                    'season'							    => $pval->getSeason(),
                                    'game_date'							    => $pval->getGameDate(),
                                    'week'							        => $pval->getWeek(),
                                    'team'							        => $pval->getTeam(),
                                    'opponent'							    => $pval->getOpponent(),
                                    'home_or_away'							=> $pval->getHomeOrAway(),
                                    'number'								=> $pval->getNumber(),
                                    'name'									=> $pval->getName(),
                                    'position'								=> $pval->getPosition(),
                                    'position_category'						=> $pval->getPositionCategory(),
                                    'activated'								=> $pval->getActivated(),
                                    'played'								=> $pval->getPlayed(),
                                    'started'								=> $pval->getStarted(),
                                    'passing_attempts'						=> $pval->getPassingAttempts(),
                                    'passing_completions'					=> $pval->getPassingCompletions(),
                                    'passing_yards'							=> $pval->getPassingYards(),
                                    'passing_completion_percentage'			=> $pval->getPassingCompletionPercentage(),
                                    'passing_yards_per_attempt'				=> $pval->getPassingYardsPerAttempt(),
                                    'passing_yards_per_completion'			=> $pval->getPassingYardsPerCompletion(),
                                    'passing_touchdowns'					=> $pval->getPassingTouchdowns(),
                                    'passing_interceptions'					=> $pval->getPassingInterceptions(),
                                    'passing_rating'						=> $pval->getPassingRating(),
                                    'passing_long'							=> $pval->getPassingLong(),
                                    'passing_sacks'						    => $pval->getPassingSacks(),
                                    'passing_sack_yards'					=> $pval->getPassingSackYards(),
                                    'rushing_attempts'						=> $pval->getRushingAttempts(),
                                    'rushing_yards'							=> $pval->getRushingYards(),
                                    'rushing_yards_per_attempt'			    => $pval->getRushingYardsPerAttempt(),
                                    'rushing_touchdowns'					=> $pval->getRushingTouchdowns(),
                                    'rushing_long'							=> $pval->getRushingLong(),
                                    'receiving_targets'						=> $pval->getReceivingTargets(),
                                    'receptions'							=> $pval->getReceptions(),
                                    'receiving_yards'						=> $pval->getReceivingYards(),
                                    'receiving_yards_per_reception'			=> $pval->getReceivingYardsPerReception(),
                                    'receiving_touchdowns'					=> $pval->getReceivingTouchdowns(),
                                    'receiving_long'						=> $pval->getReceivingLong(),
                                    'fumbles'								=> $pval->getFumbles(),
                                    'fumbles_lost'							=> $pval->getFumblesLost(),
                                    'punt_returns'							=> $pval->getPuntReturns(),
                                    'punt_return_yards'						=> $pval->getPuntReturnYards(),
                                    'punt_return_yards_per_attempt'			=> $pval->getPuntReturnYardsPerAttempt(),
                                    'punt_return_touchdowns'				=> $pval->getPuntReturnTouchdowns(),
                                    'punt_return_long'						=> $pval->getPuntReturnLong(),
                                    'kick_returns'							=> $pval->getKickReturns(),
                                    'kick_return_yards'						=> $pval->getKickReturnYards(),
                                    'kick_return_yards_per_attempt'			=> $pval->getKickReturnYardsPerAttempt(),
                                    'kick_return_touchdowns'				=> $pval->getKickReturnTouchdowns(),
                                    'kick_return_long'						=> $pval->getKickReturnLong(),
                                    'solo_tackles'							=> $pval->getSoloTackles(),
                                    'assisted_tackles'						=> $pval->getAssistedTackles(),
                                    'tackles_for_loss'						=> $pval->getTacklesForLoss(),
                                    'sacks'									=> $pval->getSacks(),
                                    'sack_yards'							=> $pval->getSackYards(),
                                    'quarterback_hits'						=> $pval->getQuarterbackHits(),
                                    'passes_defended'						=> $pval->getPassesDefended(),
                                    'fumbles_forced'						=> $pval->getFumblesForced(),
                                    'fumbles_recovered'						=> $pval->getFumblesRecovered(),
                                    'fumble_return_yards'					=> $pval->getFumbleReturnYards(),
                                    'fumble_return_touchdowns'				=> $pval->getFumbleReturnTouchdowns(),
                                    'interceptions'							=> $pval->getInterceptions(),
                                    'interception_return_yards'				=> $pval->getInterceptionReturnYards(),
                                    'interception_return_touchdowns'		=> $pval->getInterceptionReturnTouchdowns(),
                                    'blocked_kicks'							=> $pval->getBlockedKicks(),
                                    'special_teams_solo_tackles'			=> $pval->getSpecialTeamsSoloTackles(),
                                    'special_teams_assisted_tackles'		=> $pval->getSpecialTeamsAssistedTackles(),
                                    'misc_solo_tackles'						=> $pval->getMiscSoloTackles(),
                                    'misc_assisted_tackles'					=> $pval->getMiscAssistedTackles(),
                                    'punts'									=> $pval->getPunts(),
                                    'punt_yards'							=> $pval->getPuntYards(),
                                    'punt_average'							=> $pval->getPuntAverage(),
                                    'field_goals_attempted'					=> $pval->getFieldGoalsAttempted(),
                                    'field_goals_made'						=> $pval->getFieldGoalsMade(),
                                    'field_goals_longest_made'				=> $pval->getFieldGoalsLongestMade(),
                                    'extra_points_made'						=> $pval->getExtraPointsMade(),
                                    'two_point_conversion_passes'			=> $pval->getTwoPointConversionPasses(),
                                    'two_point_conversion_runs'				=> $pval->getTwoPointConversionRuns(),
                                    'two_point_conversion_receptions'		=> $pval->getTwoPointConversionReceptions(),
                                    'fantasy_points'						=> $pval->getFantasyPoints(),
                                    'fantasy_points_ppr'					=> $pval->getFantasyPointsPpr(),
                                    'reception_percentage'					=> $pval->getReceptionPercentage(),
                                    'receiving_yards_per_target'			=> $pval->getReceivingYardsPerTarget(),
                                    'tackles'								=> $pval->getTackles(),
                                    'offensive_touchdowns'					=> $pval->getOffensiveTouchdowns(),
                                    'defensive_touchdowns'					=> $pval->getDefensiveTouchdowns(),
                                    'special_teams_touchdowns'				=> $pval->getSpecialTeamsTouchdowns(),
                                    'touchdowns'							=> $pval->getTouchdowns(),
                                    'fantasy_position'						=> $pval->getFantasyPosition(),
                                    'field_goal_percentage'					=> $pval->getFieldGoalPercentage(),
                                    'player_game_id'						=> $pval->getPlayerGameId(),
                                    'fumbles_own_recoveries'				=> $pval->getFumblesOwnRecoveries(),
                                    'fumbles_out_of_bounds'					=> $pval->getFumblesOutOfBounds(),
                                    'kick_return_fair_catches'				=> $pval->getKickReturnFairCatches(),
                                    'punt_return_fair_catches'				=> $pval->getPuntReturnFairCatches(),
                                    'punt_touchbacks'						=> $pval->getPuntTouchbacks(),
                                    'punt_inside20'							=> $pval->getPuntNetAverage(),
                                    'extra_points_attempted'				=> $pval->getExtraPointsAttempted(),
                                    'blocked_kick_return_touchdowns'		=> $pval->getBlockedKickReturnTouchdowns(),
                                    'field_goal_return_touchdowns'			=> $pval->getFieldGoalReturnTouchdowns(),
                                    'safeties'								=> $pval->getSafeties(),
                                    'field_goals_had_blocked'				=> $pval->getFieldGoalsHadBlocked(),
                                    'extra_points_had_blocked'				=> $pval->getExtraPointsHadBlocked(),
                                    'punt_long'								=> $pval->getPuntLong(),
                                    'blocked_kick_return_yards'				=> $pval->getBlockedKickReturnYards(),
                                    'field_goal_return_yards'				=> $pval->getFieldGoalReturnYards(),
                                    'punt_net_yards'						=> $pval->getPuntNetYards(),
                                    'special_teams_fumbles_forced'			=> $pval->getSpecialTeamsFumblesForced(),
                                    'special_teams_fumbles_recovered'		=> $pval->getSpecialTeamsFumblesRecovered(),
                                    'misc_fumbles_forced'					=> $pval->getMiscFumblesForced(),
                                    'misc_fumbles_recovered'				=> $pval->getMiscFumblesRecovered(),
                                    'short_name'							=> $pval->getShortName(),
                                    'playing_surface'						=> $pval->getPlayingSurface(),
                                    'is_game_over'							=> $pval->getIsGameOver(),
                                    'safeties_allowed'						=> $pval->getSafetiesAllowed(),
                                    'stadium'								=> $pval->getStadium(),
                                    'temperature'							=> $pval->getTemperature(),
                                    'humidity'								=> $pval->getHumidity(),
                                    'wind_speed'							=> $pval->getWindSpeed(),
                                    'fan_duel_salary'						=> $pval->getFanDuelSalary(),
                                    'draft_kings_salary'					=> $pval->getDraftKingsSalary(),
                                    'fantasy_data_salary'					=> $pval->getFantasyDataSalary(),
                                    'offensive_snaps_played'				=> $pval->getOffensiveSnapsPlayed(),
                                    'defensive_snaps_played'				=> $pval->getDefensiveSnapsPlayed(),
                                    'special_teams_snaps_played'			=> $pval->getSpecialTeamsSnapsPlayed(),
                                    'offensive_team_snaps'					=> $pval->getOffensiveTeamSnaps(),
                                    'defensive_team_snaps'					=> $pval->getDefensiveTeamSnaps(),
                                    'special_teams_team_snaps'				=> $pval->getSpecialTeamsTeamSnaps(),
                                    'victiv_salary'						    => $pval->getVictivSalary(),
                                    'two_point_conversion_returns'			=> $pval->getTwoPointConversionReturns(),
                                    'fantasy_points_fan_duel'				=> $pval->getFantasyPointsFanDuel(),
                                    'field_goals_made0to19'					=> $pval->getFieldGoalsMade0to19(),
                                    'field_goals_made20to29'				=> $pval->getFieldGoalsMade20to29(),
                                    'field_goals_made30to39'				=> $pval->getFieldGoalsMade30to39(),
                                    'field_goals_made40to49'				=> $pval->getFieldGoalsMade40to49(),
                                    'field_goals_made50_plus'				=> $pval->getFieldGoalsMade50Plus(),
                                    'fantasy_points_draft_kings'			=> $pval->getFantasyPointsDraftKings(),
                                    'yahoo_salary'							=> $pval->getYahooSalary(),
                                    'fantasy_points_yahoo'					=> $pval->getFantasyPointsYahoo(),
                                    'injury_status'							=> $pval->getInjuryStatus(),
                                    'injury_body_part'						=> $pval->getInjuryBodyPart(),
                                    'injury_start_date'						=> $pval->getInjuryStartDate(),
                                    'injury_notes'							=> $pval->getInjuryNotes(),
                                    'fan_duel_position'						=> $pval->getFanDuelPosition(),
                                    'draft_kings_position'					=> $pval->getDraftKingsPosition(),
                                    'yahoo_position'						=> $pval->getYahooPosition(),
                                    'opponent_rank'							=> $pval->getOpponentRank(),
                                    'opponent_position_rank'				=> $pval->getOpponentPositionRank(),
                                    'injury_practice'						=> $pval->getInjuryPractice(),
                                    'injury_practice_description'			=> $pval->getInjuryPracticeDescription(),
                                    'declared_inactive'						=> $pval->getDeclaredInactive(),
                                    'fantasy_draft_salary'					=> $pval->getFantasyDraftSalary(),
                                    'fantasy_draft_position'				=> $pval->getFantasyDraftPosition(),
                                    'team_id'								=> $pval->getTeamId(),
                                    'opponent_id'							=> $pval->getOpponentId(),
                                    'day'									=> $pval->getDay(),
                                    'date_time'								=> $pval->getDateTime(),
                                    'global_game_id'						=> $pval->getGlobalGameId(),
                                    'global_team_id'						=> $pval->getGlobalTeamId(),
                                    'global_opponent_id'					=> $pval->getGlobalOpponentId(),
                                    'score_id'								=> $pval->getScoreId(),
                                    'fantasy_points_fantasy_draft'			=> $pval->getFantasyPointsFantasyDraft(),
                                    'scoring_details'						=> $pval->getScoringDetails(),
                                ];

                                $model = \App\Models\FantasyData\PlayerGame::updateOrCreate(
                                ['game_key'   => $pval->getGameKey(), 'player_id'   => $pval->getPlayerId()],
                                $player_games_data
                            );
                            }
                        }

                        if (isset($fantasy_defense_games) && count($fantasy_defense_games) > 0) {
                            foreach ($fantasy_defense_games as $fkey=>$fval) {
                                $fantasy_scoring_details_data = [];
                                $fantasy_defense_data = [];
                                $fantasy_scoring_details = $fval['scoring_details'];
                                //print_r($fantasy_scoring_details);
                                if (isset($fantasy_scoring_details) && count($fantasy_scoring_details) > 0) {
                                    foreach ($fantasy_scoring_details as $skey=>$sval) {
                                        $fantasy_scoring_details_data = [
                                            'game_key'				=> $sval['game_key'],
                                            'season_type'			=> $sval['season_type'],
                                            'player_id'				=> $sval['player_id'],
                                            'team'					=> $sval['team'],
                                            'season'				=> $sval['season'],
                                            'week'					=> $sval['week'],
                                            'scoring_type'			=> $sval['scoring_type'],
                                            'length'				=> $sval['length'],
                                            'scoring_detail_id'		=> $sval['scoring_detail_id'],
                                            'player_game_id'		=> $sval['player_game_id'],
                                            'score_id'				=> $sval['score_id'],
                                        ];
                                    }
                                }
                                $fantasy_defense_data = [
                                    'game_key' 												=> $fval->getGameKey(),
                                    'season_type' 											=> $fval->getSeasonType(),
                                    'season' 												=> $fval->getSeason(),
                                    'week' 													=> $fval->getWeek(),
                                    'date' 													=> $fval->getDate(),
                                    'team' 													=> $fval->getTeam(),
                                    'opponent' 												=> $fval->getOpponent(),
                                    'points_allowed' 										=> $fval->getPointsAllowed(),
                                    'touchdowns_scored' 									=> $fval->getTouchdownsScored(),
                                    'solo_tackles' 											=> $fval->getSoloTackles(),
                                    'assisted_tackles' 										=> $fval->getAssistedTackles(),
                                    'sacks' 												=> $fval->getSacks(),
                                    'sack_yards' 											=> $fval->getSackYards(),
                                    'passes_defended' 										=> $fval->getPassesDefended(),
                                    'fumbles_forced' 										=> $fval->getFumblesForced(),
                                    'fumbles_recovered' 									=> $fval->getFumblesRecovered(),
                                    'fumble_return_yards' 									=> $fval->getFumbleReturnYards(),
                                    'fumble_return_touchdowns' 								=> $fval->getFumbleReturnTouchdowns(),
                                    'interceptions' 	 									=> $fval->getInterceptions(),
                                    'interception_return_yards' 							=> $fval->getInterceptionReturnYards(),
                                    'interception_return_touchdowns' 						=> $fval->getInterceptionReturnTouchdowns(),
                                    'blocked_kicks' 										=> $fval->getBlockedKicks(),
                                    'safeties' 												=> $fval->getSafeties(),
                                    'punt_returns' 											=> $fval->getPuntReturns(),
                                    'punt_return_yards' 									=> $fval->getPuntReturnYards(),
                                    'punt_return_touchdowns' 								=> $fval->getPuntReturnTouchdowns(),
                                    'punt_return_long' 										=> $fval->getPuntReturnLong(),
                                    'kick_returns' 											=> $fval->getKickReturns(),
                                    'kick_return_yards' 									=> $fval->getKickReturnYards(),
                                    'kick_return_touchdowns' 								=> $fval->getKickReturnTouchdowns(),
                                    'kick_return_long' 										=> $fval->getKickReturnLong(),
                                    'blocked_kick_return_touchdowns' 						=> $fval->getBlockedKickReturnTouchdowns(),
                                    'field_goal_return_touchdowns' 							=> $fval->getFieldGoalReturnTouchdowns(),
                                    'fantasy_points_allowed' 								=> $fval->getFantasyPointsAllowed(),
                                    'quarterback_fantasy_points_allowed' 					=> $fval->getQuarterbackFantasyPointsAllowed(),
                                    'runningback_fantasy_points_allowed' 					=> $fval->getRunningbackFantasyPointsAllowed(),
                                    'wide_receiver_fantasy_points_allowed' 					=> $fval->getWideReceiverFantasyPointsAllowed(),
                                    'tight_end_fantasy_points_allowed' 						=> $fval->getTightEndFantasyPointsAllowed(),
                                    'kicker_fantasy_points_allowed' 						=> $fval->getKickerFantasyPointsAllowed(),
                                    'blocked_kick_return_yards' 							=> $fval->getBlockedKickReturnYards(),
                                    'field_goal_return_yards' 								=> $fval->getFieldGoalReturnYards(),
                                    'quarterback_hits' 										=> $fval->getQuarterbackHits(),
                                    'tackles_for_loss' 										=> $fval->getTacklesForLoss(),
                                    'defensive_touchdowns' 									=> $fval->getDefensiveTouchdowns(),
                                    'special_teams_touchdowns' 								=> $fval->getSpecialTeamsTouchdowns(),
                                    'is_game_over' 											=> $fval->getIsGameOver(),
                                    'fantasy_points' 										=> $fval->getFantasyPoints(),
                                    'stadium' 												=> $fval->getStadium(),
                                    'temperature' 											=> $fval->getTemperature(),
                                    'humidity' 												=> $fval->getHumidity(),
                                    'wind_speed' 											=> $fval->getWindSpeed(),
                                    'third_down_attempts' 									=> $fval->getThirdDownAttempts(),
                                    'third_down_conversions' 								=> $fval->getThirdDownConversions(),
                                    'fourth_down_attempts' 									=> $fval->getFourthDownAttempts(),
                                    'fourth_down_conversions' 								=> $fval->getFourthDownConversions(),
                                    'points_allowed_by_defense_special_teams' 				=> $fval->getPointsAllowedByDefenseSpecialTeams(),
                                    'fan_duel_salary' 										=> $fval->getFanDuelSalary(),
                                    'draft_kings_salary' 									=> $fval->getDraftKingsSalary(),
                                    'fantasy_data_salary' 									=> $fval->getFantasyDataSalary(),
                                    'victiv_salary' 										=> $fval->getVictivSalary(),
                                    'two_point_conversion_returns' 							=> $fval->getTwoPointConversionReturns(),
                                    'fantasy_points_fan_duel' 								=> $fval->getFantasyPointsFanDuel(),
                                    'fantasy_points_draft_kings' 							=> $fval->getFantasyPointsDraftKings(),
                                    'offensive_yards_allowed' 								=> $fval->getOffensiveYardsAllowed(),
                                    'yahoo_salary' 											=> $fval->getYahooSalary(),
                                    'player_id' 											=> $fval->getPlayerId(),
                                    'fantasy_points_yahoo' 									=> $fval->getFantasyPointsYahoo(),
                                    'home_or_away' 											=> $fval->getHomeOrAway(),
                                    'opponent_rank' 										=> $fval->getOpponentRank(),
                                    'opponent_position_rank' 								=> $fval->getOpponentPositionRank(),
                                    'fantasy_draft_salary' 									=> $fval->getFantasyDraftSalary(),
                                    'team_id' 												=> $fval->getTeamId(),
                                    'opponent_id' 											=> $fval->getOpponentId(),
                                    'day' 													=> $fval->getDay(),
                                    'date_time' 											=> $fval->getDateTime(),
                                    'global_game_id' 										=> $fval->getGlobalGameId(),
                                    'global_team_id' 										=> $fval->getGlobalTeamId(),
                                    'global_opponent_id' 									=> $fval->getGlobalOpponentId(),
                                    'draft_kings_position' 									=> $fval->getDraftKingsPosition(),
                                    'fan_duel_position' 									=> $fval->getFanDuelPosition(),
                                    'fantasy_draft_position' 								=> $fval->getFantasyDraftPosition(),
                                    'yahoo_position' 										=> $fval->getYahooPosition(),
                                    'fantasy_defense_id' 									=> $fval->getFantasyDefenseId(),
                                    'score_id' 												=> $fval->getScoreId(),
                                    'fan_duel_fantasy_points_allowed' 						=> $fval->getFanDuelFantasyPointsAllowed(),
                                    'fan_duel_quarterback_fantasy_points_allowed' 			=> $fval->getFanDuelQuarterbackFantasyPointsAllowed(),
                                    'fan_duel_runningback_fantasy_points_allowed' 			=> $fval->getFanDuelRunningbackFantasyPointsAllowed(),
                                    'fan_duel_wide_receiver_fantasy_points_allowed' 		=> $fval->getFanDuelWideReceiverFantasyPointsAllowed(),
                                    'fan_duel_tight_end_fantasy_points_allowed' 			=> $fval->getFanDuelTightEndFantasyPointsAllowed(),
                                    'fan_duel_kicker_fantasy_points_allowed' 				=> $fval->getFanDuelKickerFantasyPointsAllowed(),
                                    'draft_kings_fantasy_points_allowed' 					=> $fval->getDraftKingsFantasyPointsAllowed(),
                                    'draft_kings_quarterback_fantasy_points_allowed' 		=> $fval->getDraftKingsQuarterbackFantasyPointsAllowed(),
                                    'draft_kings_runningback_fantasy_points_allowed' 		=> $fval->getDraftKingsRunningbackFantasyPointsAllowed(),
                                    'draft_kings_wide_receiver_fantasy_points_allowed' 		=> $fval->getDraftKingsWideReceiverFantasyPointsAllowed(),
                                    'draft_kings_tight_end_fantasy_points_allowed' 			=> $fval->getDraftKingsTightEndFantasyPointsAllowed(),
                                    'draft_kings_kicker_fantasy_points_allowed' 			=> $fval->getDraftKingsKickerFantasyPointsAllowed(),
                                    'yahoo_fantasy_points_allowed' 							=> $fval->getYahooFantasyPointsAllowed(),
                                    'yahoo_quarterback_fantasy_points_allowed' 				=> $fval->getYahooQuarterbackFantasyPointsAllowed(),
                                    'yahoo_runningback_fantasy_points_allowed' 				=> $fval->getYahooRunningbackFantasyPointsAllowed(),
                                    'yahoo_wide_receiver_fantasy_points_allowed' 			=> $fval->getYahooWideReceiverFantasyPointsAllowed(),
                                    'yahoo_tight_end_fantasy_points_allowed' 				=> $fval->getYahooTightEndFantasyPointsAllowed(),
                                    'yahoo_kicker_fantasy_points_allowed' 					=> $fval->getYahooKickerFantasyPointsAllowed(),
                                    'fantasy_points_fantasy_draft' 							=> $fval->getFantasyPointsFantasyDraft(),
                                    'fantasy_draft_fantasy_points_allowed' 					=> $fval->getFantasyDraftFantasyPointsAllowed(),
                                    'fantasy_draft_quarterback_fantasy_points_allowed' 		=> $fval->getFantasyDraftQuarterbackFantasyPointsAllowed(),
                                    'fantasy_draft_runningback_fantasy_points_allowed' 		=> $fval->getFantasyDraftRunningbackFantasyPointsAllowed(),
                                    'fantasy_draft_wide_receiver_fantasy_points_allowed' 	=> $fval->getFantasyDraftWideReceiverFantasyPointsAllowed(),
                                    'fantasy_draft_tight_end_fantasy_points_allowed' 		=> $fval->getFantasyDraftTightEndFantasyPointsAllowed(),
                                    'fantasy_draft_kicker_fantasy_points_allowed' 			=> $fval->getFantasyDraftKickerFantasyPointsAllowed(),
                                    'scoring_details' 										=> $fantasy_scoring_details_data,
                                ];
                                $model = \App\Models\FantasyData\FantasyDefenseGame::updateOrCreate(
                                ['game_key'   => $fval->getGameKey(), 'fantasy_defense_id'   => $fval->getFantasyDefenseId()],
                                $fantasy_defense_data
                            );
                            }
                        }

                        if (isset($scoring_plays) && count($scoring_plays) > 0) {
                            foreach ($scoring_plays as $sckey=>$scval) {
                                $scoring_plays_data = [];
                                $scoring_plays_data = [
                                    'game_key' 			=> $scval['game_key'],
                                    'season_type' 		=> $scval['season_type'],
                                    'scoring_play_id' 	=> $scval['scoring_play_id'],
                                    'season' 			=> $scval['season'],
                                    'week' 				=> $scval['week'],
                                    'away_team' 		=> $scval['away_team'],
                                    'home_team' 		=> $scval['home_team'],
                                    'date' 				=> $scval['date'],
                                    'sequence' 			=> $scval['sequence'],
                                    'team' 				=> $scval['team'],
                                    'quarter' 			=> $scval['quarter'],
                                    'time_remaining' 	=> $scval['time_remaining'],
                                    'play_description' 	=> $scval['play_description'],
                                    'away_score' 		=> $scval['away_score'],
                                    'home_score' 		=> $scval['home_score'],
                                    'score_id' 			=> $scval['score_id'],
                                ];
                                $model = \App\Models\FantasyData\ScoringPlay::updateOrCreate(
                                ['game_key'   => $scval['game_key'], 'scoring_play_id' =>$scval['scoring_play_id']],
                                $scoring_plays_data
                            );
                            }
                        }

                        if (isset($scoring_details) && count($scoring_details) > 0) {
                            foreach ($scoring_details as $sdkey=>$sdval) {
                                $scoring_details_data = [];
                                $scoring_details_data = [
                                    'game_key'				=> $sdval['game_key'],
                                    'season_type'			=> $sdval['season_type'],
                                    'player_id'				=> $sdval['player_id'],
                                    'team'					=> $sdval['team'],
                                    'season'				=> $sdval['season'],
                                    'week'					=> $sdval['week'],
                                    'scoring_type'			=> $sdval['scoring_type'],
                                    'length'				=> $sdval['length'],
                                    'scoring_detail_id'		=> $sdval['scoring_detail_id'],
                                    'player_game_id'		=> $sdval['player_game_id'],
                                    'score_id'				=> $sdval['score_id'],
                                ];
                                $model = \App\Models\FantasyData\ScoringDetail::updateOrCreate(
                                ['game_key'   => $sdval['game_key'], 'scoring_detail_id' =>$sdval['scoring_detail_id']],
                                $scoring_details_data
                            );
                            }
                        }
                        /* $box_score_data=array(
                            'scores' 					=> $scores_data,
                            'quarters' 					=> $quarters_data,
                            'team_games'				=> $team_games_data,
                            'fantasy_defense_games'		=> $fantasy_defense_data,
                            'scoring_plays'				=> $scoring_plays_data,
                            'scoring_details'			=> $scoring_details_data,
                        );
                        $model = \App\Models\FantasyData\BoxScoreV3::create($box_score_data); */
                    }
                    echo 'Box Scores Delta V3 '.$i." details has been added successfully\r\n";
                }
                sleep(5);
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
