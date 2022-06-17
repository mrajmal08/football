<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApproveDenyToTrans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fantasy_teams_player_transactions', function (Blueprint $table) {
            $table->boolean('approved')->nullable();
            $table->boolean('rejected')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trans', function (Blueprint $table) {
            //
        });
    }
}
