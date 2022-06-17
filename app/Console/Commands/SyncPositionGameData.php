<?php

namespace App\Console\Commands;

use App\Helpers\FantasyPointsHelper;
use App\Models\FantasyData\FantasyDefenseGameProjection;
use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyData\TeamGame;
use Helper;
use Illuminate\Console\Command;

class SyncPositionGameData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SyncPositionGameData {--team} {--position=} {--all} {--week=} {--season=} {--seasonTypeInt=} {--isProjection}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To sync data for a teamed/group player. This command is called automatically in UpdateBoxScores. This command does not need to be ran manually.';

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
        $isProjection = $this->option('isProjection');
        $season = $this->option('season');
        $seasonTypeInt = $this->option('seasonTypeInt');
        $teamPrompt = $this->option('team');
        $position = $this->option('position');

        //$this->info('Syncing: '. $teamPrompt . ' '. $position);
        try {
            // the 'year'
            $season = (! empty($season)) ? $season : $systemSettings['season'];
            // 1 = reg; 2 = pre; 3 = post
            $seasonTypeInt = (! empty($seasonTypeInt)) ? $seasonTypeInt : $systemSettings['seasonTypeInt'];
            $seasonVal = $systemSettings['seasonVal'];

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
              $weekLimit = 18;    //Go all the way to week 17
            }

            for ($week = $weekStart; $week <= $weekLimit; $week++) {
                if ($teamPrompt) {
                    $fantasy_player = FantasyPlayer::where('position', $position)->where('team', $teamPrompt)->get();
                } else {
                    $fantasy_player = FantasyPlayer::where('position', $position)->get();
                }

                if (! empty($fantasy_player)) {
                    $alertType = ($isProjection) ? ' Projections' : ' Real';
                    $alertLine = class_basename(get_class($this)).' '.$position.' '.$alertType.' |  Season: '.$season.' | seasonTypeInt: '.$seasonTypeInt.'  | Week: '.$week;
                    //$this->info($alertLine);

                    foreach ($fantasy_player as $list) {
                        if ($position == 'TQB') {
                            $player_games = FantasyPointsHelper::getTqbPlayergame($list->team, $season, $seasonTypeInt, $week, $yearly = false, $isProjection);
                            //dd($player_games);
                            if (! empty($player_games['game_key'])) {
                                $player_games_data = [];
                                $player_games_data =
                                  [
                                      'game_key' => $player_games['game_key'],
                                      'player_id' => $list->player_id,
                                      'season_type' => $seasonTypeInt,
                                      'season'=> $season,
                                      'game_date'=> $player_games['game_date'],
                                      'week'=> $week,
                                      'team'=> $player_games['team'],
                                      'fantasy_points_acme' => $player_games['fantasy_points_acme'],
                                      'opponent'=> $player_games['opponent'],
                                      'home_or_away'=> $player_games['home_or_away'],
                                      'number'=> $player_games['number'],
                                      'name'=> $list->name,
                                      'position'=> 'TQB',
                                      'position_category'=> $player_games['position_category'],
                                      'activated'=> $player_games['activated'],
                                      'played'=> $player_games['played'],
                                      'started'=> $player_games['started'],
                                      'passing_attempts'=> $player_games['passing_attempts'],
                                      'passing_completions'=> $player_games['passing_completions'],
                                      'passing_yards'=> $player_games['passing_yards'],
                                      'passing_completion_percentage'=> $player_games['passing_completion_percentage'],
                                      'passing_yards_per_attempt'=> $player_games['passing_yards_per_attempt'],
                                      'passing_yards_per_completion'=> $player_games['passing_yards_per_completion'],
                                      'passing_touchdowns'=> $player_games['passing_touchdowns'],
                                      'passing_interceptions'=> $player_games['passing_interceptions'],
                                      'passing_rating'=> $player_games['passing_rating'],
                                      'passing_long'=> $player_games['passing_long'],
                                      'passing_sacks'=> $player_games['passing_sacks'],
                                      'passing_sack_yards'=> $player_games['passing_sack_yards'],
                                      'rushing_attempts'=> $player_games['rushing_attempts'],
                                      'rushing_yards'=> $player_games['rushing_yards'],
                                      'rushing_yards_per_attempt'=> $player_games['rushing_yards_per_attempt'],
                                      'rushing_touchdowns'=> $player_games['rushing_touchdowns'],
                                      'rushing_long'=> $player_games['rushing_long'],
                                      'receiving_targets'=> $player_games['receiving_targets'],
                                      'receptions'=> $player_games['receptions'],
                                      'receiving_yards'=> $player_games['receiving_yards'],
                                      'receiving_yards_per_reception'=> $player_games['receiving_yards_per_reception'],
                                      'receiving_touchdowns'=> $player_games['receiving_touchdowns'],
                                      'receiving_long'=> $player_games['receiving_long'],
                                      'fumbles'=> $player_games['fumbles'],
                                      'fumbles_lost'=> $player_games['fumbles_lost'],
                                      'punt_returns'=> $player_games['punt_returns'],
                                      'punt_return_yards'=> $player_games['punt_return_yards'],
                                      'punt_return_yards_per_attempt'=> $player_games['punt_return_yards_per_attempt'],
                                      'punt_return_touchdowns'=> $player_games['punt_return_touchdowns'],
                                      'punt_return_long'=> $player_games['punt_return_long'],
                                      'kick_returns'=> $player_games['kick_returns'],
                                      'kick_return_yards'=> $player_games['kick_return_yards'],
                                      'kick_return_yards_per_attempt'=> $player_games['kick_return_yards_per_attempt'],
                                      'kick_return_touchdowns'=> $player_games['kick_return_touchdowns'],
                                      'kick_return_long'=> $player_games['kick_return_long'],
                                      'solo_tackles'=> $player_games['solo_tackles'],
                                      'assisted_tackles'=> $player_games['assisted_tackles'],
                                      'tackles_for_loss'=> $player_games['tackles_for_loss'],
                                      'sacks'=> $player_games['sacks'],
                                      'sack_yards'=> $player_games['sack_yards'],
                                      'quarterback_hits'=> $player_games['quarterback_hits'],
                                      'passes_defended'=> $player_games['passes_defended'],
                                      'fumbles_forced'=> $player_games['fumbles_forced'],
                                      'fumbles_recovered'=> $player_games['fumbles_recovered'],
                                      'fumble_return_yards'=> $player_games['fumble_return_yards'],
                                      'fumble_return_touchdowns'=> $player_games['fumble_return_touchdowns'],
                                      'interceptions'             => $player_games['interceptions'],
                                      'interception_return_yards'       => $player_games['interception_return_yards'],
                                      'interception_return_touchdowns'    => $player_games['interception_return_touchdowns'],
                                      'blocked_kicks'             => $player_games['blocked_kicks'],
                                      'special_teams_solo_tackles'      => $player_games['special_teams_solo_tackles'],
                                      'special_teams_assisted_tackles'    => $player_games['special_teams_assisted_tackles'],
                                      'misc_solo_tackles'           => $player_games['misc_solo_tackles'],
                                      'misc_assisted_tackles'         => $player_games['misc_assisted_tackles'],
                                      'punts'                 => $player_games['punts'],
                                      'punt_yards'              => $player_games['punt_yards'],
                                      'punt_average'              => $player_games['punt_average'],
                                      'field_goals_attempted'         => $player_games['field_goals_attempted'],
                                      'field_goals_made'            => $player_games['field_goals_made'],
                                      'field_goals_longest_made'        => $player_games['field_goals_longest_made'],
                                      'extra_points_made'           => $player_games['extra_points_made'],
                                      'two_point_conversion_passes'     => $player_games['two_point_conversion_passes'],
                                      'two_point_conversion_runs'       => $player_games['two_point_conversion_runs'],
                                      'two_point_conversion_receptions'   => $player_games['two_point_conversion_receptions'],
                                      'fantasy_points'            => $player_games['fantasy_points'],
                                      'fantasy_points_ppr'          => 0,
                                      'reception_percentage'          => $player_games['reception_percentage'],
                                      'receiving_yards_per_target'      => $player_games['receiving_yards_per_target'],
                                      'tackles'               => $player_games['tackles'],
                                      'offensive_touchdowns'          => $player_games['offensive_touchdowns'],
                                      'defensive_touchdowns'          => $player_games['defensive_touchdowns'],
                                      'special_teams_touchdowns'        => $player_games['special_teams_touchdowns'],
                                      'touchdowns'              => $player_games['touchdowns'],
                                      'fantasy_position'            => $player_games['fantasy_position'],
                                      'field_goal_percentage'         => $player_games['field_goal_percentage'],
                                      'player_game_id'            => $player_games['player_game_id'],
                                      'fumbles_own_recoveries'        => $player_games['fumbles_own_recoveries'],
                                      'fumbles_out_of_bounds'         => $player_games['fumbles_out_of_bounds'],
                                      'kick_return_fair_catches'        => $player_games['kick_return_fair_catches'],
                                      'punt_return_fair_catches'        => $player_games['punt_return_fair_catches'],
                                      'punt_touchbacks'           => $player_games['punt_touchbacks'],
                                      'punt_inside20'             => $player_games['punt_inside20'],
                                      'extra_points_attempted'        => $player_games['extra_points_attempted'],
                                      'blocked_kick_return_touchdowns'    => $player_games['blocked_kick_return_touchdowns'],
                                      'field_goal_return_touchdowns'      => $player_games['field_goal_return_touchdowns'],
                                      'safeties'                => $player_games['safeties'],
                                      'field_goals_had_blocked'       => $player_games['field_goals_had_blocked'],
                                      'extra_points_had_blocked'        => $player_games['extra_points_had_blocked'],
                                      'punt_long'               => $player_games['punt_long'],
                                      'blocked_kick_return_yards'       => $player_games['blocked_kick_return_yards'],
                                      'field_goal_return_yards'       => $player_games['field_goal_return_yards'],
                                      'punt_net_yards'            => $player_games['punt_net_yards'],
                                      'special_teams_fumbles_forced'      => $player_games['special_teams_fumbles_forced'],
                                      'special_teams_fumbles_recovered'   => $player_games['special_teams_fumbles_recovered'],
                                      'misc_fumbles_forced'         => $player_games['misc_fumbles_forced'],
                                      'misc_fumbles_recovered'        => $player_games['misc_fumbles_recovered'],
                                      'short_name'              => $player_games['short_name'],
                                      'playing_surface'           => $player_games['playing_surface'],
                                      'is_game_over'              => $player_games['is_game_over'],
                                      'safeties_allowed'            => $player_games['safeties_allowed'],
                                      'stadium'               => $player_games['stadium'],
                                      'temperature'             => $player_games['temperature'],
                                      'humidity'                => $player_games['humidity'],
                                      'wind_speed'              => $player_games['wind_speed'],
                                      'fan_duel_salary'           => $player_games['fan_duel_salary'],
                                      'draft_kings_salary'          => $player_games['draft_kings_salary'],
                                      'fantasy_data_salary'         => $player_games['fantasy_data_salary'],
                                      'offensive_snaps_played'        => $player_games['offensive_snaps_played'],
                                      'defensive_snaps_played'        => $player_games['defensive_snaps_played'],
                                      'special_teams_snaps_played'      => $player_games['special_teams_snaps_played'],
                                      'offensive_team_snaps'          => $player_games['offensive_team_snaps'],
                                      'defensive_team_snaps'          => $player_games['defensive_team_snaps'],
                                      'special_teams_team_snaps'        => $player_games['special_teams_team_snaps'],
                                      'victiv_salary'               => $player_games['victiv_salary'],
                                      'two_point_conversion_returns'      => $player_games['two_point_conversion_returns'],
                                      'fantasy_points_fan_duel'       => $player_games['fantasy_points_fan_duel'],
                                      'field_goals_made0to19'         => $player_games['field_goals_made0to19'],
                                      'field_goals_made20to29'        => $player_games['field_goals_made20to29'],
                                      'field_goals_made30to39'        => $player_games['field_goals_made30to39'],
                                      'field_goals_made40to49'        => $player_games['field_goals_made40to49'],
                                      'field_goals_made50_plus'       => $player_games['field_goals_made50_plus'],
                                      'fantasy_points_draft_kings'      => $player_games['fantasy_points_draft_kings'],
                                      'yahoo_salary'              => $player_games['yahoo_salary'],
                                      'fantasy_points_yahoo'          => $player_games['fantasy_points_yahoo'],
                                      'injury_status'             => $player_games['injury_status'],
                                      'injury_body_part'           => $player_games['injury_body_part'],
                                      'injury_start_date'           => $player_games['injury_start_date'],
                                      'injury_notes'              => $player_games['injury_notes'],
                                      'fan_duel_position'           => $player_games['fan_duel_position'],
                                      'draft_kings_position'          => $player_games['draft_kings_position'],
                                      'yahoo_position'            => $player_games['yahoo_position'],
                                      'opponent_rank'             => $player_games['opponent_rank'],
                                      'opponent_position_rank'        => $player_games['opponent_position_rank'],
                                      'injury_practice'           => $player_games['injury_practice'],
                                      'injury_practice_description'     => $player_games['injury_practice_description'],
                                      'declared_inactive'           => $player_games['declared_inactive'],
                                      'fantasy_draft_salary'          => $player_games['fantasy_draft_salary'],
                                      'fantasy_draft_position'        => $player_games['fantasy_draft_position'],
                                      'team_id'               => $player_games['team_id'],
                                      'opponent_id'             => $player_games['opponent_id'],
                                      'day'                 => $player_games['day'],
                                      'date_time'               => $player_games['date_time'],
                                      'global_game_id'            => $player_games['global_game_id'],
                                      'global_team_id'            => $player_games['global_team_id'],
                                      'global_opponent_id'          => $player_games['global_opponent_id'],
                                      'score_id'                => $player_games['score_id'],
                                      'fantasy_points_fantasy_draft'      => $player_games['fantasy_points_fantasy_draft'],
                                      'scoring_details'           => $player_games['scoring_details'],
                                  ];
                                if ($isProjection) {
                                    // dd($player_games_data);
                                    \App\Models\FantasyData\PlayerGameProjection::updateOrCreate(
                                        [
                                            'game_key' => $player_games['game_key'],
                                            'player_id'   => $list->player_id,
                                            'position'   => 'TQB',
                                            'week'   => $week,
                                            'season'   => $season,
                                            'season_type'   => $seasonTypeInt,
                                        ],
                                        $player_games_data
                                    );
                                } else {
                                    \App\Models\FantasyData\PlayerGame::updateOrCreate(
                                        [
                                            'game_key' => $player_games['game_key'],
                                            'player_id'   => $list->player_id,
                                            'position'   => 'TQB',
                                            'week'   => $week,
                                            'season'   => $season,
                                            'season_type'   => $seasonTypeInt,
                                        ],
                                        $player_games_data
                                    );
                                    FantasyPointsHelper::calculateFantasyPlayerGameFantasyPoints($week, $season, $seasonTypeInt, $list->player_id, $isProjection = false);
                                    unset($player_games_data);
                                    unset($player_games);
                                }
                                unset($player_games);
                            }
                        }
                        if ($position == 'ST') {
                            if ($isProjection) {
                                $team_games = FantasyDefenseGameProjection::where('season_type', $seasonTypeInt)
                              ->where('season', $season)
                              ->where('week', $week)
                              ->where('team', $list->team)
                              ->first();
                                if (! empty($team_games['game_key'])) {
                                    $player_games_data = [];
                                    $player_games_data =
                                  [
                                      'game_key'                  => $team_games['game_key'],
                                      'player_id'                 => $list->player_id,
                                      'season_type'             => $seasonTypeInt,
                                      'season'                  => $season,
                                      'game_date'                 => $team_games['date'],
                                      'week'                      => $week,
                                      'team'                      => $team_games['team'],
                                      'opponent'                  => $team_games['opponent'],
                                      'home_or_away'              => $team_games['home_or_away'],
                                      'player_game_id'            => 0,
                                      'name'                  => $list->name,
                                      'position'                => 'ST',
                                      'position_category'           => 'ST',
                                      'activated'               => 1,
                                      'played'                => 1,
                                      'started'               => 1,
                                      'punt_returns'              => $team_games['punt_returns'],
                                      'punt_return_yards'           => $team_games['punt_return_yards'],
                                      'punt_return_yards_per_attempt'     => 0,                                       //Calculate below
                                      'punt_return_touchdowns'        => $team_games['punt_return_touchdowns'],
                                      'punt_return_long'            => $team_games['punt_return_long'],
                                      'kick_returns'              => $team_games['kick_returns'],
                                      'kick_return_yards'           => $team_games['kick_return_yards'],
                                      'kick_return_yards_per_attempt'     => 0,                                       //Calculate below
                                      'kick_return_touchdowns'        => $team_games['kick_return_touchdowns'],
                                      'kick_return_long'            => $team_games['kick_return_long'],
                                      'blocked_kicks'              => $team_games['blocked_kicks'],
                                      'special_teams_touchdowns'        => $team_games['special_teams_touchdowns'],
                                      'fantasy_position'            => 'ST',
                                      'team_id'               => $team_games['team_id'],
                                      'opponent_id'             => $team_games['opponent_id'],
                                      'day'                 => $team_games['day'],
                                      'date_time'               => $team_games['date_time'],
                                      'global_game_id'            => $team_games['global_game_id'],
                                      'global_team_id'            => $team_games['global_team_id'],
                                      'global_opponent_id'          => $team_games['global_opponent_id'],
                                      'score_id'                => $team_games['score_id'],
                                      'fantasy_points_fantasy_draft'      => $team_games['fantasy_points_fantasy_draft'],
                                      'scoring_details'           => $team_games['scoring_details'],
                                  ];

                                    if ($team_games['punt_returns'] > 0) {
                                        $player_games_data['punt_return_yards_per_attempt'] = ($team_games['punt_return_yards'] / $team_games['punt_returns']);
                                    }

                                    if ($team_games['kick_returns'] > 0) {
                                        $player_games_data['kick_return_yards_per_attempt'] = ($team_games['kick_return_yards'] / $team_games['kick_returns']);
                                    }
                                }
                            } else {
                                $team_games = TeamGame::where('season_type', $seasonTypeInt)
                              ->where('season', $season)
                              ->where('week', $week)
                              ->where('team', $list->team)
                              ->first();

                                if (! empty($team_games['game_key'])) {
                                    $player_games_data = [];
                                    $player_games_data =
                                  [
                                      'game_key'                  => $team_games['game_key'],
                                      'player_id'                 => $list->player_id,
                                      'season_type'             => $seasonTypeInt,
                                      'season'                  => $season,
                                      'game_date'                 => $team_games['date'],
                                      'week'                      => $week,
                                      'team'                      => $team_games['team'],
                                      'opponent'                  => $team_games['opponent'],
                                      'home_or_away'              => $team_games['home_or_away'],
                                      'number'                => $team_games['number'],
                                      'name'                  => $list->name,
                                      'position'                => 'ST',
                                      'position_category'           => 'ST',
                                      'activated'               => 1,
                                      'played'                => 1,
                                      'started'               => 1,
                                      // 'passing_attempts'           => $team_games['passing_attempts'],
                                      // 'passing_completions'          => $team_games['passing_completions'],
                                      // 'passing_yards'              => $team_games['passing_yards'],
                                      // 'passing_completion_percentage'      => $team_games['passing_completion_percentage'],
                                      // 'passing_yards_per_attempt'        => $team_games['passing_yards_per_attempt'],
                                      // 'passing_yards_per_completion'     => $team_games['passing_yards_per_completion'],
                                      // 'passing_touchdowns'         => $team_games['passing_touchdowns'],
                                      // 'passing_interceptions'          => $team_games['passing_interceptions'],
                                      // 'passing_rating'           => $team_games['passing_rating'],
                                      // 'passing_long'             => $team_games['passing_long'],
                                      // 'passing_sacks'                => $team_games['passing_sacks'],
                                      // 'passing_sack_yards'         => $team_games['passing_sack_yards'],
                                      // 'rushing_attempts'           => $team_games['rushing_attempts'],
                                      // 'rushing_yards'              => $team_games['rushing_yards'],
                                      // 'rushing_yards_per_attempt'          => $team_games['rushing_yards_per_attempt'],
                                      // 'rushing_touchdowns'         => $team_games['rushing_touchdowns'],
                                      // 'rushing_long'             => $team_games['rushing_long'],
                                      // 'receiving_targets'            => $team_games['receiving_targets'],
                                      // 'receptions'             => $team_games['receptions'],
                                      // 'receiving_yards'            => $team_games['receiving_yards'],
                                      // 'receiving_yards_per_reception'      => $team_games['receiving_yards_per_reception'],
                                      // 'receiving_touchdowns'         => $team_games['receiving_touchdowns'],
                                      // 'receiving_long'           => $team_games['receiving_long'],
                                      // 'fumbles'                => $team_games['fumbles'],
                                      // 'fumbles_lost'             => $team_games['fumbles_lost'],
                                      'punt_returns'              => $team_games['punt_returns'],
                                      'punt_return_yards'           => $team_games['punt_return_yards'],
                                      'punt_return_yards_per_attempt'     => 0,                                       //Calculate below
                                      'punt_return_touchdowns'        => $team_games['punt_return_touchdowns'],
                                      'punt_return_long'            => $team_games['punt_return_long'],
                                      'kick_returns'              => $team_games['kick_returns'],
                                      'kick_return_yards'           => $team_games['kick_return_yards'],
                                      'kick_return_yards_per_attempt'     => 0,                                       //Calculate below
                                      'kick_return_touchdowns'        => $team_games['kick_return_touchdowns'],
                                      'kick_return_long'            => $team_games['kick_return_long'],
                                      // 'solo_tackles'             => $team_games['solo_tackles'],
                                      // 'assisted_tackles'           => $team_games['assisted_tackles'],
                                      // 'tackles_for_loss'           => $team_games['tackles_for_loss'],
                                      // 'sacks'                  => $team_games['sacks'],
                                      // 'sack_yards'             => $team_games['sack_yards'],
                                      // 'quarterback_hits'           => $team_games['quarterback_hits'],
                                      // 'passes_defended'            => $team_games['passes_defended'],
                                      // 'fumbles_forced'           => $team_games['fumbles_forced'],
                                      // 'fumbles_recovered'            => $team_games['fumbles_recovered'],
                                      // 'fumble_return_yards'          => $team_games['fumble_return_yards'],
                                      // 'fumble_return_touchdowns'       => $team_games['fumble_return_touchdowns'],
                                      // 'interceptions'              => $team_games['interceptions'],
                                      // 'interception_return_yards'        => $team_games['interception_return_yards'],
                                      // 'interception_return_touchdowns'   => $team_games['interception_return_touchdowns'],
                                      // 'blocked_kicks'              => $team_games['blocked_kicks'],
                                      'special_teams_solo_tackles'      => $team_games['special_teams_solo_tackles'],
                                      'special_teams_assisted_tackles'    => $team_games['special_teams_assisted_tackles'],
                                      // 'misc_solo_tackles'            => $team_games['misc_solo_tackles'],
                                      // 'misc_assisted_tackles'          => $team_games['misc_assisted_tackles'],
                                      'punts'                 => $team_games['punts'],
                                      'punt_yards'              => $team_games['punt_yards'],
                                      'punt_average'              => $team_games['punt_average'],
                                      'field_goals_attempted'         => $team_games['field_goals_attempted'],
                                      'field_goals_made'            => $team_games['field_goals_made'],
                                      'field_goals_longest_made'        => $team_games['field_goals_longest_made'],
                                      'extra_points_made'           => $team_games['extra_points_made'],
                                      // 'two_point_conversion_passes'      => $team_games['two_point_conversion_passes'],
                                      // 'two_point_conversion_runs'        => $team_games['two_point_conversion_runs'],
                                      // 'two_point_conversion_receptions'    => $team_games['two_point_conversion_receptions'],
                                      // 'fantasy_points'           => $team_games['fantasy_points'],
                                      // 'fantasy_points_ppr'         => 0,
                                      // 'reception_percentage'         => $team_games['reception_percentage'],
                                      // 'receiving_yards_per_target'     => $team_games['receiving_yards_per_target'],
                                      // 'tackles'                => $team_games['tackles'],
                                      // 'offensive_touchdowns'         => $team_games['offensive_touchdowns'],
                                      // 'defensive_touchdowns'         => $team_games['defensive_touchdowns'],
                                      'special_teams_touchdowns'        => $team_games['special_teams_touchdowns'],
                                      // 'touchdowns'             => $team_games['touchdowns'],
                                      'fantasy_position'            => $team_games['fantasy_position'],
                                      'field_goal_percentage'         => $team_games['field_goal_percentage'],
                                      'player_game_id'            => 0,
                                      // 'fumbles_own_recoveries'       => $team_games['fumbles_own_recoveries'],
                                      // 'fumbles_out_of_bounds'          => $team_games['fumbles_out_of_bounds'],
                                      'kick_return_fair_catches'        => $team_games['kick_return_fair_catches'],
                                      'punt_return_fair_catches'        => $team_games['punt_return_fair_catches'],
                                      'punt_touchbacks'           => $team_games['punt_touchbacks'],
                                      'punt_inside20'             => $team_games['punt_inside20'],
                                      'extra_points_attempted'        => $team_games['extra_points_attempted'],
                                      'blocked_kick_return_touchdowns'    => $team_games['blocked_kick_return_touchdowns'],
                                      'field_goal_return_touchdowns'      => $team_games['field_goal_return_touchdowns'],
                                      // 'safeties'               => $team_games['safeties'],
                                      'field_goals_had_blocked'       => $team_games['field_goals_had_blocked'],
                                      'extra_points_had_blocked'        => $team_games['extra_points_had_blocked'],
                                      'punt_long'               => $team_games['punt_long'],
                                      'blocked_kick_return_yards'       => $team_games['blocked_kick_return_yards'],
                                      'field_goal_return_yards'       => $team_games['field_goal_return_yards'],
                                      'punt_net_yards'            => $team_games['punt_net_yards'],
                                      'special_teams_fumbles_forced'      => $team_games['special_teams_fumbles_forced'],
                                      'special_teams_fumbles_recovered'   => $team_games['special_teams_fumbles_recovered'],
                                      // 'misc_fumbles_forced'          => $team_games['misc_fumbles_forced'],
                                      // 'misc_fumbles_recovered'       => $team_games['misc_fumbles_recovered'],
                                      'short_name'              => $team_games['short_name'],
                                      'playing_surface'           => $team_games['playing_surface'],
                                      'is_game_over'              => $team_games['is_game_over'],
                                      'safeties_allowed'            => $team_games['safeties_allowed'],
                                      'stadium'               => $team_games['stadium'],
                                      'temperature'             => $team_games['temperature'],
                                      'humidity'                => $team_games['humidity'],
                                      'wind_speed'              => $team_games['wind_speed'],
                                      'fan_duel_salary'           => $team_games['fan_duel_salary'],
                                      'draft_kings_salary'          => $team_games['draft_kings_salary'],
                                      'fantasy_data_salary'         => $team_games['fantasy_data_salary'],
                                      // 'offensive_snaps_played'       => $team_games['offensive_snaps_played'],
                                      // 'defensive_snaps_played'       => $team_games['defensive_snaps_played'],
                                      'special_teams_snaps_played'      => $team_games['special_teams_snaps_played'],
                                      // 'offensive_team_snaps'         => $team_games['offensive_team_snaps'],
                                      // 'defensive_team_snaps'         => $team_games['defensive_team_snaps'],
                                      'special_teams_team_snaps'        => $team_games['special_teams_team_snaps'],
                                      'victiv_salary'               => $team_games['victiv_salary'],
                                      // 'two_point_conversion_returns'     => $team_games['two_point_conversion_returns'],
                                      'fantasy_points_fan_duel'       => $team_games['fantasy_points_fan_duel'],
                                      'field_goals_made0to19'         => $team_games['field_goals_made0to19'],
                                      'field_goals_made20to29'        => $team_games['field_goals_made20to29'],
                                      'field_goals_made30to39'        => $team_games['field_goals_made30to39'],
                                      'field_goals_made40to49'        => $team_games['field_goals_made40to49'],
                                      'field_goals_made50_plus'       => $team_games['field_goals_made50_plus'],
                                      'fantasy_points_draft_kings'      => $team_games['fantasy_points_draft_kings'],
                                      'yahoo_salary'              => $team_games['yahoo_salary'],
                                      'fantasy_points_yahoo'          => $team_games['fantasy_points_yahoo'],
                                      'injury_status'             => $team_games['injury_status'],
                                      'injury_body_part'           => $team_games['injury_body_part'],
                                      'injury_start_date'           => $team_games['injury_start_date'],
                                      'injury_notes'              => $team_games['injury_notes'],
                                      'fan_duel_position'           => $team_games['fan_duel_position'],
                                      'draft_kings_position'          => $team_games['draft_kings_position'],
                                      'yahoo_position'            => $team_games['yahoo_position'],
                                      'opponent_rank'             => $team_games['opponent_rank'],
                                      'opponent_position_rank'        => $team_games['opponent_position_rank'],
                                      'injury_practice'           => $team_games['injury_practice'],
                                      'injury_practice_description'     => $team_games['injury_practice_description'],
                                      'declared_inactive'           => $team_games['declared_inactive'],
                                      'fantasy_draft_salary'          => $team_games['fantasy_draft_salary'],
                                      'fantasy_draft_position'        => $team_games['fantasy_draft_position'],
                                      'team_id'               => $team_games['team_id'],
                                      'opponent_id'             => $team_games['opponent_id'],
                                      'day'                 => $team_games['day'],
                                      'date_time'               => $team_games['date_time'],
                                      'global_game_id'            => $team_games['global_game_id'],
                                      'global_team_id'            => $team_games['global_team_id'],
                                      'global_opponent_id'          => $team_games['global_opponent_id'],
                                      'score_id'                => $team_games['score_id'],
                                      'fantasy_points_fantasy_draft'      => $team_games['fantasy_points_fantasy_draft'],
                                      'scoring_details'           => $team_games['scoring_details'],
                                  ];

                                    if ($team_games['punt_returns'] > 0) {
                                        $player_games_data['punt_return_yards_per_attempt'] = ($team_games['punt_return_yards'] / $team_games['punt_returns']);
                                    }

                                    if ($team_games['kick_returns'] > 0) {
                                        $player_games_data['kick_return_yards_per_attempt'] = ($team_games['kick_return_yards'] / $team_games['kick_returns']);
                                    }
                                }
                            }

                            if (! empty($player_games_data['game_key'])) {
                                if ($isProjection) {
                                    \App\Models\FantasyData\PlayerGameProjection::updateOrCreate(
                                        [
                                            'game_key' => $player_games_data['game_key'],
                                            'player_id' => $list->player_id,
                                            'position'   => 'ST',
                                            'week'   => $week,
                                            'season'   => $season,
                                            'season_type'   => $seasonTypeInt,
                                        ],
                                        $player_games_data
                                    );
                                // $this->info("ST Player Game Projection added successfully");
                                } else {
                                    \App\Models\FantasyData\PlayerGame::updateOrCreate(
                                        [
                                            'game_key' => $player_games_data['game_key'],
                                            'player_id'   => $list->player_id,
                                            'position'   => 'ST',
                                            'week'   => $week,
                                            'season'   => $season,
                                            'season_type'   => $seasonTypeInt,
                                        ],
                                        $player_games_data
                                    );
                                    // $this->info("ST Player Game added successfully");
                                }
                                unset($player_games_data);
                                unset($team_games);
                                FantasyPointsHelper::calculateFantasyPlayerGameFantasyPoints($week, $season, $seasonTypeInt, $list->player_id, $isProjection);
                            }
                        }
                    }
                    //$this->info("Finished ". $alertLine);
                }
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
