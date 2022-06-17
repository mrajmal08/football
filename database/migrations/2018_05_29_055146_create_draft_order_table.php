<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('league_id');
            $table->foreign('league_id')
             ->references('id')->on('leagues');
            $table->unsignedInteger('fantasy_team_id');
            $table->foreign('fantasy_team_id')
             ->references('id')->on('fantasy_teams');
            $table->unsignedInteger('fantasy_player_id')->nullable();
            $table->foreign('fantasy_player_id')
             ->references('id')->on('fantasy_player');
            $table->integer('round')->nullable();
            $table->integer('league_overall_pick')->nullable();
            $table->integer('round_overall_pick')->nullable();
            $table->datetime('deadline')->nullable();
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
        Schema::dropIfExists('draft_order');
    }
}
