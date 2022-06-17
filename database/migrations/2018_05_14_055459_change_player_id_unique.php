<?php

use App\Models\FantasyData\Player;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePlayerIdUnique extends Migration
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
            $table->integer('player_id')->nullable()->unique()->change();
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
