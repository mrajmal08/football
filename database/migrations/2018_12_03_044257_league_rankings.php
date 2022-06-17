<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeagueRankings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_team_rankings', function (Blueprint $table) {
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
            $table->boolean('is_finished')->default(null);
            $table->tinyInteger('win')->default(null);
            $table->tinyInteger('loss')->default(null);
            $table->tinyInteger('tie')->default(null);
            $table->tinyInteger('head_to_head_pts')->default(null);
            $table->integer('points_against')->default(null);
            $table->integer('points_for')->default(null);
            $table->tinyInteger('points_for_pts')->default(null);
            $table->integer('sim_overall_win')->default(null);
            $table->integer('sim_overall_loss')->default(null);
            $table->integer('sim_overall_tie')->default(null);
            $table->tinyInteger('sim_overall_rank')->default(null);
            $table->tinyInteger('sim_overall_pts')->default(null);
            $table->integer('tournament_rank')->default(null);
            $table->integer('tournament_pts')->default(null);
            $table->integer('coach_score')->default(null);
            $table->integer('overall_coach_rank')->default(null);
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
        Schema::dropIfExists('league_team_rankings');
    }
}
