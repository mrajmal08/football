<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /** Tables we can help improve query speed by indexing **/
    public function up()
    {
        Schema::table('player_season', function (Blueprint $table) {
            $table->index('player_id');
        });

        Schema::table('player_season_projection', function (Blueprint $table) {
            $table->index('player_id');
        });

        Schema::table('fantasy_player', function (Blueprint $table) {
            $table->index('player_id');
        });

        // Schema::table('player_season', function (Blueprint $table) {
        //     $table->index('player_id');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('player_season', function (Blueprint $table) {
            $table->dropIndex(['player_id']);
        });

        Schema::table('player_season_projection', function (Blueprint $table) {
            $table->dropIndex(['player_id']);
        });

        Schema::table('fantasy_player', function (Blueprint $table) {
            $table->dropIndex(['player_id']);
        });
    }
}
