<?php

use App\Models\FantasyTeamsPlayerTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeagueIdInFantasyPlayerTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = (new FantasyTeamsPlayerTransaction)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            $table->unsignedInteger('league_id');
            $table->foreign('league_id')
             ->references('id')->on('leagues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tablename = (new FantasyTeamsPlayerTransaction)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            //
        });
    }
}
