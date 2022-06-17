<?php

use App\Models\League;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLeagueCommissionerIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = (new League)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            $table->unsignedInteger('league_commissioner_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tablename = (new League)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            //
        });
    }
}
