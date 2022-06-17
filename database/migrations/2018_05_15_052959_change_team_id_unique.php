<?php

use App\Models\FantasyData\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTeamIdUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = (new Team)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            $table->unsignedInteger('team_id')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tablename = (new Team)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            //
        });
    }
}
