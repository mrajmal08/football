<?php

use App\Models\FantasyData\FantasyPlayer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFantasyPlayerAverageDraftPositionIdPToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        $tablename = (new FantasyPlayer)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            $table->integer('average_draft_position_id_p')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
