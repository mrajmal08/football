<?php

use App\Models\FantasyData\TeamSeason;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamSeasonTable extends Migration
{
    public function up()
    {
        $tablename = (new TeamSeason)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_type')->nullable();
            $table->integer('season')->nullable();
            $table->string('team')->nullable();
            $table->integer('score')->nullable();
            $table->integer('opponent_score')->nullable();
            $table->integer('total_score')->nullable();
            $table->integer('temperature')->nullable();
            $table->integer('humidity')->nullable();
            $table->integer('wind_speed')->nullable();
            $table->integer('over_under')->nullable();
            $table->integer('point_spread')->nullable();
            $table->integer('score_quarter1')->nullable();
            $table->integer('score_quarter2')->nullable();
            $table->integer('score_quarter3')->nullable();
            $table->integer('score_quarter4')->nullable();
            $table->integer('score_overtime')->nullable();
            $table->string('time_of_possession')->nullable();
            $table->integer('first_downs')->nullable();
            $table->integer('first_downs_by_rushing')->nullable();
            $table->integer('first_downs_by_passing')->nullable();
            $table->integer('first_downs_by_penalty')->nullable();
            $table->integer('offensive_plays')->nullable();
            $table->integer('offensive_yards')->nullable();
            $table->integer('offensive_yards_per_play')->nullable();
            $table->integer('touchdowns')->nullable();
            $table->integer('rushing_attempts')->nullable();
            $table->integer('rushing_yards')->nullable();
            $table->integer('rushing_yards_per_attempt')->nullable();
            $table->integer('rushing_touchdowns')->nullable();
            $table->integer('passing_attempts')->nullable();
            $table->integer('passing_completions')->nullable();
            $table->integer('passing_yards')->nullable();
            $table->integer('passing_touchdowns')->nullable();
            $table->integer('passing_interceptions')->nullable();
            $table->integer('passing_yards_per_attempt')->nullable();
            $table->integer('passing_yards_per_completion')->nullable();
            $table->integer('completion_percentage')->nullable();
            $table->integer('passer_rating')->nullable();
            $table->integer('third_down_attempts')->nullable();
            $table->integer('third_down_conversions')->nullable();
            $table->integer('third_down_percentage')->nullable();
            $table->integer('fourth_down_attempts')->nullable();
            $table->integer('fourth_down_conversions')->nullable();
            $table->integer('fourth_down_percentage')->nullable();
            $table->integer('red_zone_attempts')->nullable();
            $table->integer('red_zone_conversions')->nullable();
            $table->integer('goal_to_go_attempts')->nullable();
            $table->integer('goal_to_go_conversions')->nullable();
            $table->integer('return_yards')->nullable();
            $table->integer('penalties')->nullable();
            $table->integer('penalty_yards')->nullable();
            $table->integer('fumbles')->nullable();
            $table->integer('fumbles_lost')->nullable();
            $table->integer('times_sacked')->nullable();
            $table->integer('times_sacked_yards')->nullable();
            $table->integer('quarterback_hits')->nullable();
            $table->integer('tackles_for_loss')->nullable();
            $table->integer('safeties')->nullable();
            $table->integer('punts')->nullable();
            $table->integer('punt_yards')->nullable();
            $table->integer('punt_average')->nullable();
            $table->integer('giveaways')->nullable();
            $table->integer('takeaways')->nullable();
            $table->integer('turnover_differential')->nullable();
            $table->integer('opponent_score_quarter1')->nullable();
            $table->integer('opponent_score_quarter2')->nullable();
            $table->integer('opponent_score_quarter3')->nullable();
            $table->integer('opponent_score_quarter4')->nullable();
            $table->integer('opponent_score_overtime')->nullable();
            $table->string('opponent_time_of_possession')->nullable();
            $table->integer('opponent_first_downs')->nullable();
            $table->integer('opponent_first_downs_by_rushing')->nullable();
            $table->integer('opponent_first_downs_by_passing')->nullable();
            $table->integer('opponent_first_downs_by_penalty')->nullable();
            $table->integer('opponent_offensive_plays')->nullable();
            $table->integer('opponent_offensive_yards')->nullable();
            $table->integer('opponent_offensive_yards_per_play')->nullable();
            $table->integer('opponent_touchdowns')->nullable();
            $table->integer('opponent_rushing_attempts')->nullable();
            $table->integer('opponent_rushing_yards')->nullable();
            $table->integer('opponent_rushing_yards_per_attempt')->nullable();
            $table->integer('opponent_rushing_touchdowns')->nullable();
            $table->integer('opponent_passing_attempts')->nullable();
            $table->integer('opponent_passing_completions')->nullable();
            $table->integer('opponent_passing_yards')->nullable();
            $table->integer('opponent_passing_touchdowns')->nullable();
            $table->integer('opponent_passing_interceptions')->nullable();
            $table->integer('opponent_passing_yards_per_attempt')->nullable();
            $table->integer('opponent_passing_yards_per_completion')->nullable();
            $table->integer('opponent_completion_percentage')->nullable();
            $table->integer('opponent_passer_rating')->nullable();
            $table->integer('opponent_third_down_attempts')->nullable();
            $table->integer('opponent_third_down_conversions')->nullable();
            $table->integer('opponent_third_down_percentage')->nullable();
            $table->integer('opponent_fourth_down_attempts')->nullable();
            $table->integer('opponent_fourth_down_conversions')->nullable();
            $table->integer('opponent_fourth_down_percentage')->nullable();
            $table->integer('opponent_red_zone_attempts')->nullable();
            $table->integer('opponent_red_zone_conversions')->nullable();
            $table->integer('opponent_goal_to_go_attempts')->nullable();
            $table->integer('opponent_goal_to_go_conversions')->nullable();
            $table->integer('opponent_return_yards')->nullable();
            $table->integer('opponent_penalties')->nullable();
            $table->integer('opponent_penalty_yards')->nullable();
            $table->integer('opponent_fumbles')->nullable();
            $table->integer('opponent_fumbles_lost')->nullable();
            $table->integer('opponent_times_sacked')->nullable();
            $table->integer('opponent_times_sacked_yards')->nullable();
            $table->integer('opponent_quarterback_hits')->nullable();
            $table->integer('opponent_tackles_for_loss')->nullable();
            $table->integer('opponent_safeties')->nullable();
            $table->integer('opponent_punts')->nullable();
            $table->integer('opponent_punt_yards')->nullable();
            $table->integer('opponent_punt_average')->nullable();
            $table->integer('opponent_giveaways')->nullable();
            $table->integer('opponent_takeaways')->nullable();
            $table->integer('opponent_turnover_differential')->nullable();
            $table->integer('red_zone_percentage')->nullable();
            $table->integer('goal_to_go_percentage')->nullable();
            $table->integer('quarterback_hits_differential')->nullable();
            $table->integer('tackles_for_loss_differential')->nullable();
            $table->integer('quarterback_sacks_differential')->nullable();
            $table->integer('tackles_for_loss_percentage')->nullable();
            $table->integer('quarterback_hits_percentage')->nullable();
            $table->integer('times_sacked_percentage')->nullable();
            $table->integer('opponent_red_zone_percentage')->nullable();
            $table->integer('opponent_goal_to_go_percentage')->nullable();
            $table->integer('opponent_quarterback_hits_differential')->nullable();
            $table->integer('opponent_tackles_for_loss_differential')->nullable();
            $table->integer('opponent_quarterback_sacks_differential')->nullable();
            $table->integer('opponent_tackles_for_loss_percentage')->nullable();
            $table->integer('opponent_quarterback_hits_percentage')->nullable();
            $table->integer('opponent_times_sacked_percentage')->nullable();
            $table->integer('kickoffs')->nullable();
            $table->integer('kickoffs_in_end_zone')->nullable();
            $table->integer('kickoff_touchbacks')->nullable();
            $table->integer('punts_had_blocked')->nullable();
            $table->integer('punt_net_average')->nullable();
            $table->integer('extra_point_kicking_attempts')->nullable();
            $table->integer('extra_point_kicking_conversions')->nullable();
            $table->integer('extra_points_had_blocked')->nullable();
            $table->integer('extra_point_passing_attempts')->nullable();
            $table->integer('extra_point_passing_conversions')->nullable();
            $table->integer('extra_point_rushing_attempts')->nullable();
            $table->integer('extra_point_rushing_conversions')->nullable();
            $table->integer('field_goal_attempts')->nullable();
            $table->integer('field_goals_made')->nullable();
            $table->integer('field_goals_had_blocked')->nullable();
            $table->integer('punt_returns')->nullable();
            $table->integer('punt_return_yards')->nullable();
            $table->integer('kick_returns')->nullable();
            $table->integer('kick_return_yards')->nullable();
            $table->integer('interception_returns')->nullable();
            $table->integer('interception_return_yards')->nullable();
            $table->integer('opponent_kickoffs')->nullable();
            $table->integer('opponent_kickoffs_in_end_zone')->nullable();
            $table->integer('opponent_kickoff_touchbacks')->nullable();
            $table->integer('opponent_punts_had_blocked')->nullable();
            $table->integer('opponent_punt_net_average')->nullable();
            $table->integer('opponent_extra_point_kicking_attempts')->nullable();
            $table->integer('opponent_extra_point_kicking_conversions')->nullable();
            $table->integer('opponent_extra_points_had_blocked')->nullable();
            $table->integer('opponent_extra_point_passing_attempts')->nullable();
            $table->integer('opponent_extra_point_passing_conversions')->nullable();
            $table->integer('opponent_extra_point_rushing_attempts')->nullable();
            $table->integer('opponent_extra_point_rushing_conversions')->nullable();
            $table->integer('opponent_field_goal_attempts')->nullable();
            $table->integer('opponent_field_goals_made')->nullable();
            $table->integer('opponent_field_goals_had_blocked')->nullable();
            $table->integer('opponent_punt_returns')->nullable();
            $table->integer('opponent_punt_return_yards')->nullable();
            $table->integer('opponent_kick_returns')->nullable();
            $table->integer('opponent_kick_return_yards')->nullable();
            $table->integer('opponent_interception_returns')->nullable();
            $table->integer('opponent_interception_return_yards')->nullable();
            $table->integer('solo_tackles')->nullable();
            $table->integer('assisted_tackles')->nullable();
            $table->integer('sacks')->nullable();
            $table->integer('sack_yards')->nullable();
            $table->integer('passes_defended')->nullable();
            $table->integer('fumbles_forced')->nullable();
            $table->integer('fumbles_recovered')->nullable();
            $table->integer('fumble_return_yards')->nullable();
            $table->integer('fumble_return_touchdowns')->nullable();
            $table->integer('interception_return_touchdowns')->nullable();
            $table->integer('blocked_kicks')->nullable();
            $table->integer('punt_return_touchdowns')->nullable();
            $table->integer('punt_return_long')->nullable();
            $table->integer('kick_return_touchdowns')->nullable();
            $table->integer('kick_return_long')->nullable();
            $table->integer('blocked_kick_return_yards')->nullable();
            $table->integer('blocked_kick_return_touchdowns')->nullable();
            $table->integer('field_goal_return_yards')->nullable();
            $table->integer('field_goal_return_touchdowns')->nullable();
            $table->integer('punt_net_yards')->nullable();
            $table->integer('opponent_solo_tackles')->nullable();
            $table->integer('opponent_assisted_tackles')->nullable();
            $table->integer('opponent_sacks')->nullable();
            $table->integer('opponent_sack_yards')->nullable();
            $table->integer('opponent_passes_defended')->nullable();
            $table->integer('opponent_fumbles_forced')->nullable();
            $table->integer('opponent_fumbles_recovered')->nullable();
            $table->integer('opponent_fumble_return_yards')->nullable();
            $table->integer('opponent_fumble_return_touchdowns')->nullable();
            $table->integer('opponent_interception_return_touchdowns')->nullable();
            $table->integer('opponent_blocked_kicks')->nullable();
            $table->integer('opponent_punt_return_touchdowns')->nullable();
            $table->integer('opponent_punt_return_long')->nullable();
            $table->integer('opponent_kick_return_touchdowns')->nullable();
            $table->integer('opponent_kick_return_long')->nullable();
            $table->integer('opponent_blocked_kick_return_yards')->nullable();
            $table->integer('opponent_blocked_kick_return_touchdowns')->nullable();
            $table->integer('opponent_field_goal_return_yards')->nullable();
            $table->integer('opponent_field_goal_return_touchdowns')->nullable();
            $table->integer('opponent_punt_net_yards')->nullable();
            $table->string('team_name')->nullable();
            $table->integer('games')->nullable();
            $table->integer('passing_dropbacks')->nullable();
            $table->integer('opponent_passing_dropbacks')->nullable();
            $table->unsignedInteger('team_season_id');
            $table->integer('point_differential')->nullable();
            $table->integer('passing_interception_percentage')->nullable();
            $table->integer('punt_return_average')->nullable();
            $table->integer('kick_return_average')->nullable();
            $table->integer('extra_point_percentage')->nullable();
            $table->integer('field_goal_percentage')->nullable();
            $table->integer('opponent_passing_interception_percentage')->nullable();
            $table->integer('opponent_punt_return_average')->nullable();
            $table->integer('opponent_kick_return_average')->nullable();
            $table->integer('opponent_extra_point_percentage')->nullable();
            $table->integer('opponent_field_goal_percentage')->nullable();
            $table->integer('penalty_yard_differential')->nullable();
            $table->integer('punt_return_yard_differential')->nullable();
            $table->integer('kick_return_yard_differential')->nullable();
            $table->integer('two_point_conversion_returns')->nullable();
            $table->integer('opponent_two_point_conversion_returns')->nullable();
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('global_team_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new TeamSeason)->getTable();
        Schema::drop($tablename);
    }
}
