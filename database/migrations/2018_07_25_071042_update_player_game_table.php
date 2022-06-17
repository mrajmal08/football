<?php

use App\Models\FantasyData\PlayerGame;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePlayerGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = (new PlayerGame)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            $table->text('injury_notes')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tablename = (new PlayerGame)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            //
        });
    }
}
