<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeagueGamesSimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_games_sims', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('league_schedule_id');
            //$table->unsignedInteger('league_schedule_id');
            //$table->foreign('league_schedule_id')
            //->references('id')->on('league_schedule');
            $table->integer('team_id');
            $table->integer('opponent_id');
            $table->integer('away_team_id');
            $table->integer('home_team_id');
            $table->float('team_score', 8, 2);
            $table->float('opponent_score', 8, 2);
            $table->boolean('win')->nullable();
            $table->boolean('loss')->nullable();
            $table->boolean('tie')->nullable();
            $table->integer('year');
            $table->integer('week');
            $table->integer('game_type_id');
            $table->boolean('is_finished')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('league_games_sims');
    }
}
