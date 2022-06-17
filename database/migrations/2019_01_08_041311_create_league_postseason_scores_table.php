<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaguePostseasonScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_postseason_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('league_id');
            $table->foreign('league_id')
                  ->references('id')->on('leagues');
            $table->unsignedInteger('fatasy_team_id');
            $table->foreign('fatasy_team_id')
                  ->references('id')->on('fantasy_teams');
            $table->integer('season')->default(null);
            $table->integer('season_type')->default(null);
            $table->integer('week')->default(null);
            $table->integer('points_for')->default(null);
            $table->softDeletes();
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
        Schema::dropIfExists('league_postseason_scores');
    }
}
