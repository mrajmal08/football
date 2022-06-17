<?php

use App\Models\FantasyTeam;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLeagueTeamNumberToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = (new FantasyTeam)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            $table->unsignedInteger('league_team_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tablename = (new FantasyTeam)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            //
        });
    }
}
