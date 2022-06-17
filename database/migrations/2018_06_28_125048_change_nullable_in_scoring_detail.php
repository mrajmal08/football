<?php

use App\Models\FantasyData\ScoringDetail;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableInScoringDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = (new ScoringDetail)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            $table->unsignedInteger('score_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tablename = (new ScoringDetail)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
        });
    }
}
