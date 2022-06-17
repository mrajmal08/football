<?php

namespace App\Console\Commands;

use App\Clients\FdClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Helper;
use Illuminate\Console\Command;

class UpdatePlayerSeasonStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdatePlayerSeasonStats {--year=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To update player season stats';

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
                $this->info('UpdatePlayerSeasonStats Working on '.$season);
                $result = $apiInstance->playerSeasonStats('json', $season);
                if (! empty($result)) {
                    foreach ($result as $key=>$val) {
                        $player_season_stat = [
                            'player_id' 						=> $val->getPlayerId(),
                            'season_type' 						=> $val->getSeasonType(),
                            'season' 							=> $val->getSeason(),
                            'team'								=> $val->getTeam(),
                            'number' 							=> $val->getNumber(),
                            'name' 								=> $val->getName(),
                            'position' 							=> $val->getPosition(),
                            'position_category' 				=> $val->getPositionCategory(),
                            'activated' 						=> $val->getActivated(),
                            'played' 							=> $val->getPlayed(),
                            'started' 							=> $val->getStarted(),
                            'passing_attempts' 					=> $val->getPassingAttempts(),
                            'passing_completions' 				=> $val->getPassingCompletions(),
                            'passing_yards' 					=> $val->getPassingYards(),
                            'passing_completion_percentage' 	=> $val->getPassingCompletionPercentage(),
                            'passing_yards_per_attempt' 		=> $val->getPassingYardsPerAttempt(),
                            'passing_yards_per_completion' 		=> $val->getPassingYardsPerCompletion(),
                            'passing_touchdowns' 				=> $val->getPassingTouchdowns(),
                            'passing_interceptions' 			=> $val->getPassingInterceptions(),
                            'passing_rating' 					=> $val->getPassingRating(),
                            'passing_long' 						=> $val->getPassingLong(),
                            'passing_sacks' 					=> $val->getPassingSacks(),
                            'passing_sack_yards' 				=> $val->getPassingSackYards(),
                            'rushing_attempts' 					=> $val->getRushingAttempts(),
                            'rushing_yards' 					=> $val->getRushingYards(),
                            'rushing_yards_per_attempt' 		=> $val->getRushingYardsPerAttempt(),
                            'rushing_touchdowns' 				=> $val->getRushingTouchdowns(),
                            'rushing_long' 						=> $val->getRushingLong(),
                            'receiving_targets' 				=> $val->getReceivingTargets(),
                            'receptions' 						=> $val->getReceptions(),
                            'receiving_yards' 					=> $val->getReceivingYards(),
                            'receiving_yards_per_reception' 	=> $val->getReceivingYardsPerReception(),
                            'receiving_touchdowns' 				=> $val->getReceivingTouchdowns(),
                            'receiving_long' 					=> $val->getReceivingLong(),
                            'fumbles' 							=> $val->getFumbles(),
                            'fumbles_lost' 						=> $val->getFumblesLost(),
                            'punt_returns' 						=> $val->getPuntReturns(),
                            'punt_return_yards'					=> $val->getPuntReturnYards(),
                            'punt_return_yards_per_attempt' 	=> $val->getPuntReturnYardsPerAttempt(),
                            'punt_return_touchdowns' 			=> $val->getPuntReturnTouchdowns(),
                            'punt_return_long' 					=> $val->getPuntReturnLong(),
                            'kick_returns' 						=> $val->getKickReturns(),
                            'kick_return_yards' 				=> $val->getKickReturnYards(),
                            'kick_return_yards_per_attempt' 	=> $val->getKickReturnYardsPerAttempt(),
                            'kick_return_touchdowns' 			=> $val->getKickReturnTouchdowns(),
                            'kick_return_long' 					=> $val->getKickReturnLong(),
                            'solo_tackles' 						=> $val->getSoloTackles(),
                            'assisted_tackles' 					=> $val->getAssistedTackles(),
                            'tackles_for_loss' 					=> $val->getTacklesForLoss(),
                            'sacks' 							=> $val->getSacks(),
                            'sack_yards' 						=> $val->getSackYards(),
                            'quarterback_hits' 					=> $val->getQuarterbackHits(),
                            'passes_defended' 					=> $val->getPassesDefended(),
                            'fumbles_forced' 					=> $val->getFumblesForced(),
                            'fumbles_recovered' 				=> $val->getFumblesRecovered(),
                            'fumble_return_yards' 				=> $val->getFumbleReturnYards(),
                            'fumble_return_touchdowns' 			=> $val->getFumbleReturnTouchdowns(),
                            'interceptions' 					=> $val->getInterceptions(),
                            'interception_return_yards' 		=> $val->getInterceptionReturnYards(),
                            'interception_return_touchdowns' 	=> $val->getInterceptionReturnTouchdowns(),
                            'blocked_kicks' 					=> $val->getBlockedKicks(),
                            'special_teams_solo_tackles' 		=> $val->getSpecialTeamsSoloTackles(),
                            'special_teams_assisted_tackles' 	=> $val->getSpecialTeamsAssistedTackles(),
                            'misc_solo_tackles' 				=> $val->getMiscSoloTackles(),
                            'misc_assisted_tackles' 			=> $val->getMiscAssistedTackles(),
                            'punts' 							=> $val->getPunts(),
                            'punt_yards' 						=> $val->getPuntYards(),
                            'punt_average' 						=> $val->getPuntAverage(),
                            'field_goals_attempted' 			=> $val->getFieldGoalsAttempted(),
                            'field_goals_made' 					=> $val->getFieldGoalsMade(),
                            'field_goals_longest_made' 			=> $val->getFieldGoalsLongestMade(),
                            'extra_points_made' 				=> $val->getExtraPointsMade(),
                            'two_point_conversion_passes' 		=> $val->getTwoPointConversionPasses(),
                            'two_point_conversion_runs' 		=> $val->getTwoPointConversionRuns(),
                            'two_point_conversion_receptions' 	=> $val->getTwoPointConversionReceptions(),
                            'fantasy_points' 					=> $val->getFantasyPoints(),
                            'fantasy_points_p_p_r' 				=> $val->getFantasyPointsPpr(),
                            'reception_percentage' 				=> $val->getReceptionPercentage(),
                            'receiving_yards_per_target' 		=> $val->getReceivingYardsPerTarget(),
                            'tackles' 							=> $val->getTackles(),
                            'offensive_touchdowns' 				=> $val->getOffensiveTouchdowns(),
                            'defensive_touchdowns' 				=> $val->getDefensiveTouchdowns(),
                            'special_teams_touchdowns' 			=> $val->getSpecialTeamsTouchdowns(),
                            'touchdowns' 						=> $val->getTouchdowns(),
                            'fantasy_position' 					=> $val->getFantasyPosition(),
                            'field_goal_percentage' 			=> $val->getFieldGoalPercentage(),
                            'player_season_id' 					=> $val->getPlayerSeasonId(),
                            'fumbles_own_recoveries' 			=> $val->getFumblesOwnRecoveries(),
                            'fumbles_out_of_bounds' 			=> $val->getFumblesOutOfBounds(),
                            'kick_return_fair_catches'			=> $val->getKickReturnFairCatches(),
                            'punt_return_fair_catches' 			=> $val->getPuntReturnFairCatches(),
                            'punt_touchbacks' 					=> $val->getPuntTouchbacks(),
                            'punt_inside20' 					=> $val->getPuntInside20(),
                            'punt_net_average' 					=> $val->getPuntNetAverage(),
                            'extra_points_attempted' 			=> $val->getExtraPointsAttempted(),
                            'blocked_kick_return_touchdowns' 	=> $val->getBlockedKickReturnTouchdowns(),
                            'field_goal_return_touchdowns' 		=> $val->getFieldGoalReturnTouchdowns(),
                            'safeties' 							=> $val->getSafeties(),
                            'field_goals_had_blocked' 			=> $val->getFieldGoalsHadBlocked(),
                            'punts_had_blocked' 				=> $val->getPuntsHadBlocked(),
                            'extra_points_had_blocked' 			=> $val->getExtraPointsHadBlocked(),
                            'punt_long' 						=> $val->getPuntLong(),
                            'blocked_kick_return_yards' 		=> $val->getBlockedKickReturnYards(),
                            'field_goal_return_yards' 			=> $val->getFieldGoalReturnYards(),
                            'punt_net_yards' 					=> $val->getPuntNetYards(),
                            'special_teams_fumbles_forced' 		=> $val->getSpecialTeamsFumblesForced(),
                            'special_teams_fumbles_recovered' 	=> $val->getSpecialTeamsFumblesRecovered(),
                            'misc_fumbles_forced' 				=> $val->getMiscFumblesForced(),
                            'misc_fumbles_recovered' 			=> $val->getMiscFumblesRecovered(),
                            'short_name' 						=> $val->getShortName(),
                            'safeties_allowed' 					=> $val->getSafetiesAllowed(),
                            'temperature' 						=> $val->getTemperature(),
                            'humidity' 							=> $val->getHumidity(),
                            'wind_speed' 						=> $val->getWindSpeed(),
                            'offensive_snaps_played' 			=> $val->getOffensiveSnapsPlayed(),
                            'defensive_snaps_played' 			=> $val->getDefensiveSnapsPlayed(),
                            'special_teams_snaps_played' 		=> $val->getSpecialTeamsSnapsPlayed(),
                            'offensive_team_snaps' 				=> $val->getOffensiveTeamSnaps(),
                            'defensive_team_snaps' 				=> $val->getDefensiveTeamSnaps(),
                            'special_teams_team_snaps' 			=> $val->getSpecialTeamsTeamSnaps(),
                            'auction_value' 					=> $val->getAuctionValue(),
                            'auction_value_p_p_r' 				=> $val->getAuctionValuePpr(),
                            'two_point_conversion_returns' 		=> $val->getTwoPointConversionReturns(),
                            'fantasy_points_fan_duel' 			=> $val->getFantasyPointsFanDuel(),
                            'field_goals_made0to19' 			=> $val->getFieldGoalsMade0to19(),
                            'field_goals_made20to29' 			=> $val->getFieldGoalsMade20to29(),
                            'field_goals_made30to39' 			=> $val->getFieldGoalsMade30to39(),
                            'field_goals_made40to49' 			=> $val->getFieldGoalsMade40to49(),
                            'field_goals_made50_plus' 			=> $val->getFieldGoalsMade50Plus(),
                            'fantasy_points_draft_kings' 		=> $val->getFantasyPointsDraftKings(),
                            'fantasy_points_yahoo' 				=> $val->getFantasyPointsYahoo(),
                            'average_draft_position' 			=> $val->getAverageDraftPosition(),
                            'average_draft_position_p_p_r' 		=> $val->getAverageDraftPositionPpr(),
                            'team_id' 							=> $val->getTeamId(),
                            'global_team_id'					=> $val->getGlobalTeamId(),
                            'fantasy_points_fantasy_draft' 		=> $val->getFantasyPointsFantasyDraft(), /* ,
                            'scoring_details' 					=> $fantasy_scoring_details_data */
                        ];
                        \App\Models\FantasyData\PlayerSeason::updateOrCreate(
                            ['player_id' => $val['player_id'], 'season_type' => $val['season_type'], 'season' => $val['season'], 'team' => $val['team']],
                            $player_season_stat
                        );
                    }
                    $this->info('Player season stat details has been added/updated successfully');
                }
            } catch (Exception $e) {
                echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
            }
        }
    }
}
