<?php

use App\Models\FantasyData\Schedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSchedulerGlobalGameIdUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = (new Schedule)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            $table->unsignedInteger('global_game_id')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tablename = (new Schedule)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            //
        });
    }
}
