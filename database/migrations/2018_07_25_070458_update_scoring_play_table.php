<?php

use App\Models\FantasyData\ScoringPlay;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateScoringPlayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = (new ScoringPlay)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            $table->text('play_description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tablename = (new ScoringPlay)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            //
        });
    }
}
