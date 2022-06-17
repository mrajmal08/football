<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FantasyPlayerGameFantasyPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fantasy_player_game_fantasy_points', function (Blueprint $table) {
            $table->increments('id');
            //$table->unsignedInteger('player_id');
            $table->unsignedInteger('fantasy_player_id');
            $table->foreign('fantasy_player_id')
                        ->references('id')->on('fantasy_player');
            $table->integer('player_id')->default(null);
            $table->integer('season')->default(null);
            $table->integer('season_type')->default(null);
            $table->integer('week')->default(null);
            $table->string('game_key')->default(null);
            $table->decimal('fantasy_points', 7, 3);
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
        Schema::dropIfExists('fantasy_player_game_fantasy_points');
    }
}
