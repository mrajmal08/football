<?php

use App\Models\League;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLeagueTableDraftCompletedNullable extends Migration
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
            $table->boolean('draft_completed')->default(0);
            $table->boolean('draft_order_generated')->default(0);
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
