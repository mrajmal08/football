<?php

use App\Models\FantasyData\TeamGame;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableInTeamGame extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = (new TeamGame)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            $table->unsignedInteger('team_game_id')->nullable()->change();
            $table->unsignedInteger('team_id')->nullable()->change();
            $table->unsignedInteger('opponent_id')->nullable()->change();
            $table->unsignedInteger('global_game_id')->nullable()->change();
            $table->unsignedInteger('global_team_id')->nullable()->change();
            $table->unsignedInteger('global_opponent_id')->nullable()->change();
            $table->unsignedInteger('score_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tablename = (new TeamGame)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
        });
    }
}
