<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSportRadarPlayerIdInPlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('player', function (Blueprint $table) {
            $table->string('sport_radar_player_id', 191)->nullable()->change();
            $table->unsignedInteger('fan_duel_player_id')->nullable()->change();
            $table->unsignedInteger('fantasy_draft_player_id')->nullable()->change();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('player', function (Blueprint $table) {
            //
        });
    }
}
