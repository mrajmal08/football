<?php

use App\Models\FantasyData\Schedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSheduleTableNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = (new Schedule)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            $table->unsignedInteger('stadium_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tablename = (new Schedule)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            //
        });
    }
}
