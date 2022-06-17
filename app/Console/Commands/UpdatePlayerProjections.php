<?php

namespace App\Console\Commands;

use App\Clients\FdProjClient;
use App\Helpers\FantasyPointsHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Helper;
use Illuminate\Console\Command;

class UpdatePlayerProjections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdatePlayerProjections {--all} {--week=0} {--season} {--seasonTypeInt=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update player projections';

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

        $weekPrompt = $this->option('week');
        $allPrompt = $this->option('all');
        $season = $systemSettings['season']; // the 'year'
        $seasonTypeInt = $this->option('seasonTypeInt') ?? $systemSettings['seasonTypeInt']; // 1 = reg; 2 = pre; 3 = post

        $seasonVal = $systemSettings['seasonVal'];

        $apiInstance = new \Acme\FantasyDataProjections\Api\DefaultApi(new FdProjClient());

        //Set default to be current system settings week
        $weekStart = $systemSettings['week'];
        $weekLimit = $weekStart;

        //Now check for specific params that might be passed
        if ($weekPrompt > 0) {
            $weekStart = $weekPrompt;
            $weekLimit = $weekStart;
        }

        //Finally check for all
        if ($allPrompt) {
            $weekStart = 1;     //Start with week 1
            $weekLimit = 17;    //Go all the way to week 17
        }

        try {
            for ($week = $weekStart; $week <= $weekLimit; $week++) {
                //dd($systemSettings);
                $alertLine = class_basename(get_class($this)).' | Seasonval: '.$seasonVal.' | Week: '.$week.' | SeasonTypeInt: '.$seasonTypeInt;
                $this->info($alertLine);
                $result = $apiInstance->projectedPlayerGameStatsByWeekWInjuriesLineupsDfsSalaries('json', $seasonVal, $week);
                //dd($result);
                if (! empty($result)) {
                    foreach ($result as $key=>$val) {
                        $game_stat_data = [];
                        $game_stat_data = [
                            'game_key'							=> $val['game_key'],
                            'player_id'     					=> $val['player_id'],
                            'season_type'     					=> $val['season_type'],
                            'season'     						=> $val['season'],
                            'game_date'     					=> $val['game_date'],
                            'week'     							=> $val['week'],
                            'team'     							=> $val['team'],
                            'opponent'     						=> $val['opponent'],
                            'home_or_away'     					=> $val['home_or_away'],
                            'number'     						=> $val['number'],
                            'name'     							=> $val['name'],
                            'position'     						=> $val['position'],
                            'position_category'     	   		=> $val['position_category'],
                            'activated'    						=> $val['activated'],
                            'played'    						=> $val['played'],
                            'started'    						=> $val['started'],
                            'passing_attempts'     				=> $val['passing_attempts'],
                            'passing_completions'     			=> $val['passing_completions'],
                            'passing_yards'  	   				=> $val['passing_yards'],
                            'passing_completion_percentage'	   	=> $val['passing_completion_percentage'],
                            'passing_yards_per_attempt'	   		=> $val['passing_yards_per_attempt'],
                            'passing_yards_per_completion'	   	=> $val['passing_yards_per_completion'],
                            'passing_touchdowns'	   			=> $val['passing_touchdowns'],
                            'passing_interceptions'	   			=> $val['passing_interceptions'],
                            'passing_rating'	   				=> $val['passing_rating'],
                            'passing_long'	   					=> $val['passing_long'],
                            'passing_sacks'	   					=> $val['passing_sacks'],
                            'passing_sack_yards'	   			=> $val['passing_sack_yards'],
                            'rushing_attempts'	   				=> $val['rushing_attempts'],
                            'rushing_yards'	   					=> $val['rushing_yards'],
                            'rushing_yards_per_attempt'	   		=> $val['rushing_yards_per_attempt'],
                            'rushing_touchdowns'	   			=> $val['rushing_touchdowns'],
                            'rushing_long'     					=> $val['rushing_long'],
                            'receiving_targets'     			=> $val['receiving_targets'],
                            'receptions'     					=> $val['receptions'],
                            'receiving_yards'     				=> $val['receiving_yards'],
                            'receiving_yards_per_reception'    	=> $val['receiving_yards_per_reception'],
                            'receiving_touchdowns'     			=> $val['receiving_touchdowns'],
                            'receiving_long'     				=> $val['receiving_long'],
                            'fumbles'     						=> $val['fumbles'],
                            'fumbles_lost'     					=> $val['fumbles_lost'],
                            'punt_returns'     					=> $val['punt_returns'],
                            'punt_return_yards'     			=> $val['punt_return_yards'],
                            'punt_return_yards_per_attempt'     => $val['punt_return_yards_per_attempt'],
                            'punt_return_touchdowns'     		=> $val['punt_return_touchdowns'],
                            'punt_return_long'     				=> $val['punt_return_long'],
                            'kick_returns'     					=> $val['kick_returns'],
                            'kick_return_yards'     			=> $val['kick_return_yards'],
                            'kick_return_yards_per_attempt'     => $val['kick_return_yards_per_attempt'],
                            'kick_return_touchdowns'     		=> $val['kick_return_touchdowns'],
                            'kick_return_long'     				=> $val['kick_return_long'],
                            'solo_tackles'     					=> $val['solo_tackles'],
                            'assisted_tackles'     				=> $val['assisted_tackles'],
                            'tackles_for_loss'     				=> $val['tackles_for_loss'],
                            'sacks'     						=> $val['sacks'],
                            'sack_yards'     					=> $val['sack_yards'],
                            'quarterback_hits'     				=> $val['quarterback_hits'],
                            'passes_defended'     				=> $val['passes_defended'],
                            'fumbles_forced'     				=> $val['fumbles_forced'],
                            'fumbles_recovered'     			=> $val['fumbles_recovered'],
                            'fumble_return_yards'     			=> $val['fumble_return_yards'],
                            'fumble_return_touchdowns'     		=> $val['fumble_return_touchdowns'],
                            'interceptions'     				=> $val['interceptions'],
                            'interception_return_yards'     	=> $val['interception_return_yards'],
                            'interception_return_touchdowns'    => $val['interception_return_touchdowns'],
                            'blocked_kicks'     				=> $val['blocked_kicks'],
                            'special_teams_solo_tackles'     	=> $val['special_teams_solo_tackles'],
                            'special_teams_assisted_tackles'    => $val['special_teams_assisted_tackles'],
                            'misc_solo_tackles'     			=> $val['misc_solo_tackles'],
                            'misc_assisted_tackles'     		=> $val['misc_assisted_tackles'],
                            'punts'     						=> $val['punts'],
                            'punt_yards'     					=> $val['punt_yards'],
                            'punt_average'     					=> $val['punt_average'],
                            'field_goals_attempted'     		=> $val['field_goals_attempted'],
                            'field_goals_made'     				=> $val['field_goals_made'],
                            'field_goals_longest_made'     		=> $val['field_goals_longest_made'],
                            'extra_points_made'     			=> $val['extra_points_made'],
                            'two_point_conversion_passes'     	=> $val['two_point_conversion_passes'],
                            'two_point_conversion_runs'     	=> $val['two_point_conversion_runs'],
                            'two_point_conversion_receptions'   => $val['two_point_conversion_receptions'],
                            'fantasy_points'     				=> $val['fantasy_points'],
                            'fantasy_points_p_p_r'     			=> $val['fantasy_points_ppr'],
                            'reception_percentage'				=> $val['reception_percentage'],
                            'receiving_yards_per_target' 		=> $val['receiving_yards_per_target'],
                            'tackles' 							=> $val['tackles'],
                            'offensive_touchdowns' 				=> $val['offensive_touchdowns'],
                            'defensive_touchdowns' 				=> $val['defensive_touchdowns'],
                            'special_teams_touchdowns' 			=> $val['defensive_touchdowns'],
                            'touchdowns' 						=> $val['touchdowns'],
                            'fantasy_position' 					=> $val['fantasy_position'],
                            'field_goal_percentage' 			=> $val['field_goal_percentage'],
                            'player_game_id' 					=> $val['player_game_id'],
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
                            'punts_had_blocked'					=> $val['punts_had_blocked'],
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
                            'playing_surface' 					=> $val['playing_surface'],
                            'is_game_over' 						=> $val['is_game_over'],
                            'safeties_allowed' 					=> $val['safeties_allowed'],
                            'stadium' 							=> $val['stadium'],
                            'temperature' 						=> $val['temperature'],
                            'humidity' 							=> $val['humidity'],
                            'wind_speed' 						=> $val['wind_speed'],
                            'fan_duel_salary' 					=> $val['fan_duel_salary'],
                            'draft_kings_salary' 				=> $val['draft_kings_salary'],
                            'fantasy_data_salary' 				=> $val['fantasy_data_salary'],
                            'offensive_snaps_played' 			=> $val['offensive_snaps_played'],
                            'defensive_snaps_played' 			=> $val['defensive_snaps_played'],
                            'special_teams_snaps_played' 		=> $val['special_teams_snaps_played'],
                            'offensive_team_snaps' 				=> $val['offensive_team_snaps'],
                            'defensive_team_snaps' 				=> $val['defensive_team_snaps'],
                            'special_teams_team_snaps' 			=> $val['special_teams_team_snaps'],
                            'victiv_salary'						=> $val['victiv_salary'],
                            'two_point_conversion_returns' 		=> $val['two_point_conversion_returns'],
                            'fantasy_points_fan_duel' 			=> $val['fantasy_points_fan_duel'],
                            'field_goals_made0to19' 			=> $val['field_goals_made0to19'],
                            'field_goals_made20to29' 			=> $val['field_goals_made20to29'],
                            'field_goals_made30to39' 			=> $val['field_goals_made30to39'],
                            'field_goals_made40to49' 			=> $val['field_goals_made40to49'],
                            'field_goals_made50_plus' 			=> $val['field_goals_made50_plus'],
                            'fantasy_points_draft_kings' 		=> $val['fantasy_points_draft_kings'],
                            'yahoo_salary' 						=> $val['yahoo_salary'],
                            'fantasy_points_yahoo' 				=> $val['fantasy_points_yahoo'],
                            'injury_status' 					=> $val['injury_status'],
                            'injury_body_part' 					=> $val['injury_body_part'],
                            'injury_start_date' 				=> $val['injury_start_date'],
                            'injury_notes' 						=> $val['injury_notes'],
                            'fan_duel_position' 				=> $val['fan_duel_position'],
                            'draft_kings_position'				=> $val['draft_kings_position'],
                            'yahoo_position' 					=> $val['yahoo_position'],
                            'opponent_rank' 					=> $val['opponent_rank'],
                            'opponent_position_rank' 			=> $val['opponent_position_rank'],
                            'injury_practice' 					=> $val['injury_practice'],
                            'injury_practice_description' 		=> $val['injury_practice_description'],
                            'declared_inactive' 				=> $val['declared_inactive'],
                            'fantasy_draft_salary' 				=> $val['fantasy_draft_salary'],
                            'fantasy_draft_position' 			=> $val['fantasy_draft_position'],
                            'team_id' 							=> $val['team_id'],
                            'opponent_id' 						=> $val['opponent_id'],
                            'day' 								=> $val['day'],
                            'date_time' 						=> $val['date_time'],
                            'global_game_id' 					=> $val['global_game_id'],
                            'global_team_id' 					=> $val['global_team_id'],
                            'global_opponent_id' 				=> $val['global_opponent_id'],
                            'score_id' 							=> $val['score_id'],
                            'fantasy_points_fantasy_draft' 		=> $val['fantasy_points_fantasy_draft'],
                            'scoring_details' 					=> $val['scoring_details'],
                        ];
                        //dd('here');
                        \App\Models\FantasyData\PlayerGameProjection::updateOrCreate(
                            ['global_game_id'   => $val['global_game_id'], 'player_id'	=> $val['player_id']],
                            $game_stat_data
                        );
                        FantasyPointsHelper::calculateFantasyPlayerGameFantasyPoints($week, $season, $seasonTypeInt, $val['player_id'], $isProjection = true);
                        unset($game_stat_data);
                    }
                }
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
        $this->info('Finished '.$alertLine);
    }
}
