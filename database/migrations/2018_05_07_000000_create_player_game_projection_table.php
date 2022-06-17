<?php

use App\Models\FantasyData\PlayerGameProjection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerGameProjectionTable extends Migration
{
    public function up()
    {
        $tablename = (new PlayerGameProjection)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->string('game_key')->nullable();
            $table->unsignedInteger('player_id');
            $table->integer('season_type')->nullable();
            $table->integer('season')->nullable();
            $table->string('game_date')->nullable();
            $table->integer('week')->nullable();
            $table->string('team')->nullable();
            $table->string('opponent')->nullable();
            $table->string('home_or_away')->nullable();
            $table->integer('number')->nullable();
            $table->string('name')->nullable();
            $table->decimal('fantasy_points_acme', 7, 3)->nullable();
            $table->string('position')->nullable();
            $table->string('position_category')->nullable();
            $table->integer('activated')->nullable();
            $table->integer('played')->nullable();
            $table->integer('started')->nullable();
            $table->integer('passing_attempts')->nullable();
            $table->integer('passing_completions')->nullable();
            $table->integer('passing_yards')->nullable();
            $table->integer('passing_completion_percentage')->nullable();
            $table->integer('passing_yards_per_attempt')->nullable();
            $table->integer('passing_yards_per_completion')->nullable();
            $table->integer('passing_touchdowns')->nullable();
            $table->integer('passing_interceptions')->nullable();
            $table->integer('passing_rating')->nullable();
            $table->integer('passing_long')->nullable();
            $table->integer('passing_sacks')->nullable();
            $table->integer('passing_sack_yards')->nullable();
            $table->integer('rushing_attempts')->nullable();
            $table->integer('rushing_yards')->nullable();
            $table->integer('rushing_yards_per_attempt')->nullable();
            $table->integer('rushing_touchdowns')->nullable();
            $table->integer('rushing_long')->nullable();
            $table->integer('receiving_targets')->nullable();
            $table->integer('receptions')->nullable();
            $table->integer('receiving_yards')->nullable();
            $table->integer('receiving_yards_per_reception')->nullable();
            $table->integer('receiving_touchdowns')->nullable();
            $table->integer('receiving_long')->nullable();
            $table->integer('fumbles')->nullable();
            $table->integer('fumbles_lost')->nullable();
            $table->integer('punt_returns')->nullable();
            $table->integer('punt_return_yards')->nullable();
            $table->integer('punt_return_yards_per_attempt')->nullable();
            $table->integer('punt_return_touchdowns')->nullable();
            $table->integer('punt_return_long')->nullable();
            $table->integer('kick_returns')->nullable();
            $table->integer('kick_return_yards')->nullable();
            $table->integer('kick_return_yards_per_attempt')->nullable();
            $table->integer('kick_return_touchdowns')->nullable();
            $table->integer('kick_return_long')->nullable();
            $table->integer('solo_tackles')->nullable();
            $table->integer('assisted_tackles')->nullable();
            $table->integer('tackles_for_loss')->nullable();
            $table->integer('sacks')->nullable();
            $table->integer('sack_yards')->nullable();
            $table->integer('quarterback_hits')->nullable();
            $table->integer('passes_defended')->nullable();
            $table->integer('fumbles_forced')->nullable();
            $table->integer('fumbles_recovered')->nullable();
            $table->integer('fumble_return_yards')->nullable();
            $table->integer('fumble_return_touchdowns')->nullable();
            $table->integer('interceptions')->nullable();
            $table->integer('interception_return_yards')->nullable();
            $table->integer('interception_return_touchdowns')->nullable();
            $table->integer('blocked_kicks')->nullable();
            $table->integer('special_teams_solo_tackles')->nullable();
            $table->integer('special_teams_assisted_tackles')->nullable();
            $table->integer('misc_solo_tackles')->nullable();
            $table->integer('misc_assisted_tackles')->nullable();
            $table->integer('punts')->nullable();
            $table->integer('punt_yards')->nullable();
            $table->integer('punt_average')->nullable();
            $table->integer('field_goals_attempted')->nullable();
            $table->integer('field_goals_made')->nullable();
            $table->integer('field_goals_longest_made')->nullable();
            $table->integer('extra_points_made')->nullable();
            $table->integer('two_point_conversion_passes')->nullable();
            $table->integer('two_point_conversion_runs')->nullable();
            $table->integer('two_point_conversion_receptions')->nullable();
            $table->integer('fantasy_points')->nullable();
            $table->integer('fantasy_points_p_p_r')->nullable();
            $table->integer('reception_percentage')->nullable();
            $table->integer('receiving_yards_per_target')->nullable();
            $table->integer('tackles')->nullable();
            $table->integer('offensive_touchdowns')->nullable();
            $table->integer('defensive_touchdowns')->nullable();
            $table->integer('special_teams_touchdowns')->nullable();
            $table->integer('touchdowns')->nullable();
            $table->string('fantasy_position')->nullable();
            $table->integer('field_goal_percentage')->nullable();
            $table->unsignedInteger('player_game_id');
            $table->integer('fumbles_own_recoveries')->nullable();
            $table->integer('fumbles_out_of_bounds')->nullable();
            $table->integer('kick_return_fair_catches')->nullable();
            $table->integer('punt_return_fair_catches')->nullable();
            $table->integer('punt_touchbacks')->nullable();
            $table->integer('punt_inside20')->nullable();
            $table->integer('punt_net_average')->nullable();
            $table->integer('extra_points_attempted')->nullable();
            $table->integer('blocked_kick_return_touchdowns')->nullable();
            $table->integer('field_goal_return_touchdowns')->nullable();
            $table->integer('safeties')->nullable();
            $table->integer('field_goals_had_blocked')->nullable();
            $table->integer('punts_had_blocked')->nullable();
            $table->integer('extra_points_had_blocked')->nullable();
            $table->integer('punt_long')->nullable();
            $table->integer('blocked_kick_return_yards')->nullable();
            $table->integer('field_goal_return_yards')->nullable();
            $table->integer('punt_net_yards')->nullable();
            $table->integer('special_teams_fumbles_forced')->nullable();
            $table->integer('special_teams_fumbles_recovered')->nullable();
            $table->integer('misc_fumbles_forced')->nullable();
            $table->integer('misc_fumbles_recovered')->nullable();
            $table->string('short_name')->nullable();
            $table->string('playing_surface')->nullable();
            $table->boolean('is_game_over')->nullable();
            $table->integer('safeties_allowed')->nullable();
            $table->string('stadium')->nullable();
            $table->integer('temperature')->nullable();
            $table->integer('humidity')->nullable();
            $table->integer('wind_speed')->nullable();
            $table->integer('fan_duel_salary')->nullable();
            $table->integer('draft_kings_salary')->nullable();
            $table->integer('fantasy_data_salary')->nullable();
            $table->integer('offensive_snaps_played')->nullable();
            $table->integer('defensive_snaps_played')->nullable();
            $table->integer('special_teams_snaps_played')->nullable();
            $table->integer('offensive_team_snaps')->nullable();
            $table->integer('defensive_team_snaps')->nullable();
            $table->integer('special_teams_team_snaps')->nullable();
            $table->integer('victiv_salary')->nullable();
            $table->integer('two_point_conversion_returns')->nullable();
            $table->integer('fantasy_points_fan_duel')->nullable();
            $table->integer('field_goals_made0to19')->nullable();
            $table->integer('field_goals_made20to29')->nullable();
            $table->integer('field_goals_made30to39')->nullable();
            $table->integer('field_goals_made40to49')->nullable();
            $table->integer('field_goals_made50_plus')->nullable();
            $table->integer('fantasy_points_draft_kings')->nullable();
            $table->integer('yahoo_salary')->nullable();
            $table->integer('fantasy_points_yahoo')->nullable();
            $table->string('injury_status')->nullable();
            $table->string('injury_body_part')->nullable();
            $table->string('injury_start_date')->nullable();
            $table->string('injury_notes')->nullable();
            $table->string('fan_duel_position')->nullable();
            $table->string('draft_kings_position')->nullable();
            $table->string('yahoo_position')->nullable();
            $table->integer('opponent_rank')->nullable();
            $table->integer('opponent_position_rank')->nullable();
            $table->string('injury_practice')->nullable();
            $table->string('injury_practice_description')->nullable();
            $table->boolean('declared_inactive')->nullable();
            $table->integer('fantasy_draft_salary')->nullable();
            $table->string('fantasy_draft_position')->nullable();
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('opponent_id');
            $table->string('day')->nullable();
            $table->string('date_time')->nullable();
            $table->unsignedInteger('global_game_id');
            $table->unsignedInteger('global_team_id');
            $table->unsignedInteger('global_opponent_id');
            $table->unsignedInteger('score_id');
            $table->integer('fantasy_points_fantasy_draft')->nullable();
            $table->text('scoring_details')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new PlayerGameProjection)->getTable();
        Schema::drop($tablename);
    }
}
