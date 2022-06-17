<?php

use App\Models\FantasyData\Schedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScheduleTable extends Migration
{
    public function up()
    {
        $tablename = (new Schedule)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->string('game_key')->nullable();
            $table->integer('season_type')->nullable();
            $table->integer('season')->nullable();
            $table->integer('week')->nullable();
            $table->string('date')->nullable();
            $table->string('away_team')->nullable();
            $table->string('home_team')->nullable();
            $table->string('channel')->nullable();
            $table->integer('point_spread')->nullable();
            $table->integer('over_under')->nullable();
            $table->unsignedInteger('stadium_id');
            $table->boolean('canceled')->nullable();
            $table->integer('geo_lat')->nullable();
            $table->integer('geo_long')->nullable();
            $table->integer('forecast_temp_low')->nullable();
            $table->integer('forecast_temp_high')->nullable();
            $table->string('forecast_description')->nullable();
            $table->integer('forecast_wind_chill')->nullable();
            $table->integer('forecast_wind_speed')->nullable();
            $table->integer('away_team_money_line')->nullable();
            $table->integer('home_team_money_line')->nullable();
            $table->string('day')->nullable();
            $table->string('date_time')->nullable();
            $table->unsignedInteger('global_game_id');
            $table->unsignedInteger('global_away_team_id');
            $table->unsignedInteger('global_home_team_id');
            $table->unsignedInteger('score_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new Schedule)->getTable();
        Schema::drop($tablename);
    }
}
