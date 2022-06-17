<?php

use App\Models\FantasyData\Player;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePlayerTableNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = (new Player)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            $table->unsignedInteger('fantasy_alarm_player_id')->nullable()->change();
            $table->unsignedInteger('rotoworld_player_id')->nullable()->change();
            $table->unsignedInteger('roto_wire_player_id')->nullable()->change();
            $table->unsignedInteger('stats_player_id')->nullable()->change();
            $table->unsignedInteger('sports_direct_player_id')->nullable()->change();
            $table->unsignedInteger('xml_team_player_id')->nullable()->change();
            $table->unsignedInteger('draft_kings_player_id')->nullable()->change();
            $table->unsignedInteger('yahoo_player_id')->nullable()->change();
            $table->unsignedInteger('team_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tablename = (new Player)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            //
        });
    }
}
