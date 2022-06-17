<?php

use App\Models\League;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLeagueTableDraftStartedWithDefault extends Migration
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
            $table->boolean('draft_started')->default(0);
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
