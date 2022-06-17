<?php

use App\Models\FantasyData\PlayerGameProjection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePlayerGameProjections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = (new PlayerGameProjection)->getTable();
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
        $tablename = (new PlayerGameProjection)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            //
        });
    }
}
