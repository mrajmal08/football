<?php

use App\Models\FantasyTeamsPlayerTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFantasyPlayerTransactionSeason extends Migration
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
            $table->string('season')->nullable();
            $table->integer('season_type')->nullable();
            $table->boolean('bench')->default(false);
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
