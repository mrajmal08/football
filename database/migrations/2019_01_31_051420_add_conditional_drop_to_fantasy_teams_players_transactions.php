<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConditionalDropToFantasyTeamsPlayersTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fantasy_teams_player_transactions', function (Blueprint $table) {
            $table->integer('conditional_drop')->nullable();
            $table->integer('claim_request')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fantasy_teams_player_transactions', function (Blueprint $table) {
            $table->dropColumn('conditional_drop');
            $table->dropColumn('claim_request');
        });
    }
}
