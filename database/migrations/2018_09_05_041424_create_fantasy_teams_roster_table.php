<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFantasyTeamsRosterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fantasy_teams_roster', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fantasy_player_id');
            $table->foreign('fantasy_player_id')
             ->references('id')->on('fantasy_player');
            $table->unsignedInteger('fantasy_team_id');
            $table->foreign('fantasy_team_id')
             ->references('id')->on('fantasy_teams');
            $table->unsignedInteger('player_transaction_type_id');
            $table->foreign('player_transaction_type_id')
             ->references('id')->on('player_transaction_types');
            $table->unsignedInteger('league_id');
            $table->foreign('league_id')
             ->references('id')->on('leagues');
            $table->boolean('active')->nullable();
            $table->integer('week')->nullable();
            //$table->boolean('is_st')->nullable();
            //$table->boolean('is_def')->nullable();
            $table->string('season')->nullable();
            $table->integer('season_type')->nullable();
            $table->boolean('bench')->default(false);
            $table->boolean('game_started')->default(false);
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
        Schema::dropIfExists('fantasy_teams_roster');
    }
}
