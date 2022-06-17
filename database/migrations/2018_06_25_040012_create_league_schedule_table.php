<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeagueScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('home_team_id');
            $table->foreign('home_team_id')
             ->references('id')->on('fantasy_teams');
            $table->unsignedInteger('away_team_id');
            $table->foreign('away_team_id')
             ->references('id')->on('fantasy_teams');
            $table->unsignedInteger('league_id');
            $table->foreign('league_id')
             ->references('id')->on('leagues');
            $table->integer('week')->nullable();
            $table->integer('year')->nullable();
            $table->integer('game_type_id')->nullable();
            $table->integer('week_game')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('league_schedule');
    }
}
