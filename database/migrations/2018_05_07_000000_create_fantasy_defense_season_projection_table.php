<?php

use App\Models\FantasyData\FantasyDefenseSeasonProjection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFantasyDefenseSeasonProjectionTable extends Migration
{
    public function up()
    {
        $tablename = (new FantasyDefenseSeasonProjection)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_type')->nullable();
            $table->integer('season')->nullable();
            $table->string('team')->nullable();
            $table->decimal('fantasy_points_acme', 7, 3)->nullable();
            $table->integer('points_allowed')->nullable();
            $table->integer('touchdowns_scored')->nullable();
            $table->integer('solo_tackles')->nullable();
            $table->integer('assisted_tackles')->nullable();
            $table->integer('sacks')->nullable();
            $table->integer('sack_yards')->nullable();
            $table->integer('passes_defended')->nullable();
            $table->integer('fumbles_forced')->nullable();
            $table->integer('fumbles_recovered')->nullable();
            $table->integer('fumble_return_yards')->nullable();
            $table->integer('fumble_return_touchdowns')->nullable();
            $table->integer('interceptions')->nullable();
            $table->integer('interception_return_yards')->nullable();
            $table->integer('interception_return_touchdowns')->nullable();
            $table->integer('blocked_kicks')->nullable();
            $table->integer('safeties')->nullable();
            $table->integer('punt_returns')->nullable();
            $table->integer('punt_return_yards')->nullable();
            $table->integer('punt_return_touchdowns')->nullable();
            $table->integer('punt_return_long')->nullable();
            $table->integer('kick_returns')->nullable();
            $table->integer('kick_return_yards')->nullable();
            $table->integer('kick_return_touchdowns')->nullable();
            $table->integer('kick_return_long')->nullable();
            $table->integer('blocked_kick_return_touchdowns')->nullable();
            $table->integer('field_goal_return_touchdowns')->nullable();
            $table->integer('fantasy_points_allowed')->nullable();
            $table->integer('quarterback_fantasy_points_allowed')->nullable();
            $table->integer('runningback_fantasy_points_allowed')->nullable();
            $table->integer('wide_receiver_fantasy_points_allowed')->nullable();
            $table->integer('tight_end_fantasy_points_allowed')->nullable();
            $table->integer('kicker_fantasy_points_allowed')->nullable();
            $table->integer('games')->nullable();
            $table->integer('blocked_kick_return_yards')->nullable();
            $table->integer('field_goal_return_yards')->nullable();
            $table->integer('quarterback_hits')->nullable();
            $table->integer('tackles_for_loss')->nullable();
            $table->integer('defensive_touchdowns')->nullable();
            $table->integer('special_teams_touchdowns')->nullable();
            $table->integer('fantasy_points')->nullable();
            $table->integer('temperature')->nullable();
            $table->integer('humidity')->nullable();
            $table->integer('wind_speed')->nullable();
            $table->integer('third_down_attempts')->nullable();
            $table->integer('third_down_conversions')->nullable();
            $table->integer('fourth_down_attempts')->nullable();
            $table->integer('fourth_down_conversions')->nullable();
            $table->integer('points_allowed_by_defense_special_teams')->nullable();
            $table->integer('auction_value')->nullable();
            $table->integer('auction_value_p_p_r')->nullable();
            $table->integer('two_point_conversion_returns')->nullable();
            $table->integer('fantasy_points_fan_duel')->nullable();
            $table->integer('fantasy_points_draft_kings')->nullable();
            $table->integer('offensive_yards_allowed')->nullable();
            $table->unsignedInteger('player_id');
            $table->integer('fantasy_points_yahoo')->nullable();
            $table->integer('average_draft_position')->nullable();
            $table->integer('average_draft_position_p_p_r')->nullable();
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('global_team_id');
            $table->integer('fan_duel_fantasy_points_allowed')->nullable();
            $table->integer('fan_duel_quarterback_fantasy_points_allowed')->nullable();
            $table->integer('fan_duel_runningback_fantasy_points_allowed')->nullable();
            $table->integer('fan_duel_wide_receiver_fantasy_points_allowed')->nullable();
            $table->integer('fan_duel_tight_end_fantasy_points_allowed')->nullable();
            $table->integer('fan_duel_kicker_fantasy_points_allowed')->nullable();
            $table->integer('draft_kings_fantasy_points_allowed')->nullable();
            $table->integer('draft_kings_quarterback_fantasy_points_allowed')->nullable();
            $table->integer('draft_kings_runningback_fantasy_points_allowed')->nullable();
            $table->integer('draft_kings_wide_receiver_fantasy_points_allowed')->nullable();
            $table->integer('draft_kings_tight_end_fantasy_points_allowed')->nullable();
            $table->integer('draft_kings_kicker_fantasy_points_allowed')->nullable();
            $table->integer('yahoo_fantasy_points_allowed')->nullable();
            $table->integer('yahoo_quarterback_fantasy_points_allowed')->nullable();
            $table->integer('yahoo_runningback_fantasy_points_allowed')->nullable();
            $table->integer('yahoo_wide_receiver_fantasy_points_allowed')->nullable();
            $table->integer('yahoo_tight_end_fantasy_points_allowed')->nullable();
            $table->integer('yahoo_kicker_fantasy_points_allowed')->nullable();
            $table->integer('fantasy_points_fantasy_draft')->nullable();
            $table->integer('fantasy_draft_fantasy_points_allowed')->nullable();
            $table->integer('fantasy_draft_quarterback_fantasy_points_allowed')->nullable();
            $table->integer('fantasy_draft_runningback_fantasy_points_allowed')->nullable();
            $table->integer('fantasy_draft_wide_receiver_fantasy_points_allowed')->nullable();
            $table->integer('fantasy_draft_tight_end_fantasy_points_allowed')->nullable();
            $table->integer('fantasy_draft_kicker_fantasy_points_allowed')->nullable();
            $table->text('scoring_details')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new FantasyDefenseSeasonProjection)->getTable();
        Schema::drop($tablename);
    }
}
