<?php

use App\Models\FantasyData\PlayStat;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayStatTable extends Migration
{
    public function up()
    {
        $tablename = (new PlayStat)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('play_stat_id')->nullable();
            $table->unsignedInteger('play_id');
            $table->integer('sequence')->nullable();
            $table->unsignedInteger('player_id');
            $table->string('name')->nullable();
            $table->string('team')->nullable();
            $table->string('opponent')->nullable();
            $table->string('home_or_away')->nullable();
            $table->string('direction')->nullable();
            $table->string('updated')->nullable();
            $table->string('created')->nullable();
            $table->integer('passing_attempts')->nullable();
            $table->integer('passing_completions')->nullable();
            $table->integer('passing_yards')->nullable();
            $table->integer('passing_touchdowns')->nullable();
            $table->integer('passing_interceptions')->nullable();
            $table->integer('passing_sacks')->nullable();
            $table->integer('passing_sack_yards')->nullable();
            $table->integer('rushing_attempts')->nullable();
            $table->integer('rushing_yards')->nullable();
            $table->integer('rushing_touchdowns')->nullable();
            $table->integer('receiving_targets')->nullable();
            $table->integer('receptions')->nullable();
            $table->integer('receiving_yards')->nullable();
            $table->integer('receiving_touchdowns')->nullable();
            $table->integer('fumbles')->nullable();
            $table->integer('fumbles_lost')->nullable();
            $table->integer('two_point_conversion_attempts')->nullable();
            $table->integer('two_point_conversion_passes')->nullable();
            $table->integer('two_point_conversion_runs')->nullable();
            $table->integer('two_point_conversion_receptions')->nullable();
            $table->integer('two_point_conversion_returns')->nullable();
            $table->integer('solo_tackles')->nullable();
            $table->integer('assisted_tackles')->nullable();
            $table->integer('tackles_for_loss')->nullable();
            $table->integer('sacks')->nullable();
            $table->integer('sack_yards')->nullable();
            $table->integer('passes_defended')->nullable();
            $table->integer('safeties')->nullable();
            $table->integer('fumbles_forced')->nullable();
            $table->integer('fumbles_recovered')->nullable();
            $table->integer('fumble_return_yards')->nullable();
            $table->integer('fumble_return_touchdowns')->nullable();
            $table->integer('interceptions')->nullable();
            $table->integer('interception_return_yards')->nullable();
            $table->integer('interception_return_touchdowns')->nullable();
            $table->integer('punt_returns')->nullable();
            $table->integer('punt_return_yards')->nullable();
            $table->integer('punt_return_touchdowns')->nullable();
            $table->integer('kick_returns')->nullable();
            $table->integer('kick_return_yards')->nullable();
            $table->integer('kick_return_touchdowns')->nullable();
            $table->integer('blocked_kicks')->nullable();
            $table->integer('blocked_kick_returns')->nullable();
            $table->integer('blocked_kick_return_yards')->nullable();
            $table->integer('blocked_kick_return_touchdowns')->nullable();
            $table->integer('field_goal_returns')->nullable();
            $table->integer('field_goal_return_yards')->nullable();
            $table->integer('field_goal_return_touchdowns')->nullable();
            $table->integer('kickoffs')->nullable();
            $table->integer('kickoff_yards')->nullable();
            $table->integer('kickoff_touchbacks')->nullable();
            $table->integer('punts')->nullable();
            $table->integer('punt_yards')->nullable();
            $table->integer('punt_touchbacks')->nullable();
            $table->integer('punts_had_blocked')->nullable();
            $table->integer('field_goals_attempted')->nullable();
            $table->integer('field_goals_made')->nullable();
            $table->integer('field_goals_yards')->nullable();
            $table->integer('field_goals_had_blocked')->nullable();
            $table->integer('extra_points_attempted')->nullable();
            $table->integer('extra_points_made')->nullable();
            $table->integer('extra_points_had_blocked')->nullable();
            $table->integer('penalties')->nullable();
            $table->integer('penalty_yards')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new PlayStat)->getTable();
        Schema::drop($tablename);
    }
}
