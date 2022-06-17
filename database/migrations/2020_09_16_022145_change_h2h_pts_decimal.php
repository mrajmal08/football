<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeH2hPtsDecimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('league_team_rankings', function (Blueprint $table) {
            $table->decimal('head_to_head_pts', 8, 2)->change();
            $table->decimal('points_for_pts', 8, 2)->change();
            $table->decimal('sim_overall_pts', 8, 2)->change();
            $table->decimal('coach_score', 8, 2)->change();
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
