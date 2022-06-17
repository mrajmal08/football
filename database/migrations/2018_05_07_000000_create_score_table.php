<?php

use App\Models\FantasyData\Score;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScoreTable extends Migration
{
    public function up()
    {
        $tablename = (new Score)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->string('game_key')->nullable();
            $table->integer('season_type')->nullable();
            $table->integer('season')->nullable();
            $table->integer('week')->nullable();
            $table->string('date')->nullable();
            $table->string('away_team')->nullable();
            $table->string('home_team')->nullable();
            $table->integer('away_score')->nullable();
            $table->integer('home_score')->nullable();
            $table->string('channel')->nullable();
            $table->integer('point_spread')->nullable();
            $table->integer('over_under')->nullable();
            $table->string('quarter')->nullable();
            $table->string('time_remaining')->nullable();
            $table->string('possession')->nullable();
            $table->integer('down')->nullable();
            $table->string('distance')->nullable();
            $table->integer('yard_line')->nullable();
            $table->string('yard_line_territory')->nullable();
            $table->string('red_zone')->nullable();
            $table->integer('away_score_quarter1')->nullable();
            $table->integer('away_score_quarter2')->nullable();
            $table->integer('away_score_quarter3')->nullable();
            $table->integer('away_score_quarter4')->nullable();
            $table->integer('away_score_overtime')->nullable();
            $table->integer('home_score_quarter1')->nullable();
            $table->integer('home_score_quarter2')->nullable();
            $table->integer('home_score_quarter3')->nullable();
            $table->integer('home_score_quarter4')->nullable();
            $table->integer('home_score_overtime')->nullable();
            $table->boolean('has_started')->nullable();
            $table->boolean('is_in_progress')->nullable();
            $table->boolean('is_over')->nullable();
            $table->boolean('has1st_quarter_started')->nullable();
            $table->boolean('has2nd_quarter_started')->nullable();
            $table->boolean('has3rd_quarter_started')->nullable();
            $table->boolean('has4th_quarter_started')->nullable();
            $table->boolean('is_overtime')->nullable();
            $table->string('down_and_distance')->nullable();
            $table->string('quarter_description')->nullable();
            $table->unsignedInteger('stadium_id');
            $table->string('last_updated')->nullable();
            $table->integer('geo_lat')->nullable();
            $table->integer('geo_long')->nullable();
            $table->integer('forecast_temp_low')->nullable();
            $table->integer('forecast_temp_high')->nullable();
            $table->string('forecast_description')->nullable();
            $table->integer('forecast_wind_chill')->nullable();
            $table->integer('forecast_wind_speed')->nullable();
            $table->integer('away_team_money_line')->nullable();
            $table->integer('home_team_money_line')->nullable();
            $table->boolean('canceled')->nullable();
            $table->boolean('closed')->nullable();
            $table->string('last_play')->nullable();
            $table->string('day')->nullable();
            $table->string('date_time')->nullable();
            $table->unsignedInteger('away_team_id');
            $table->unsignedInteger('home_team_id');
            $table->unsignedInteger('global_game_id');
            $table->unsignedInteger('global_away_team_id');
            $table->unsignedInteger('global_home_team_id');
            $table->integer('point_spread_away_team_money_line')->nullable();
            $table->integer('point_spread_home_team_money_line')->nullable();
            $table->unsignedInteger('score_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new Score)->getTable();
        Schema::drop($tablename);
    }
}
