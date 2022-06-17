<?php

use App\Models\FantasyData\News;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterContentToNewstable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablename = (new News)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            $table->longText('content')->nullable()->change();
            $table->longText('terms_of_use')->nullable()->change();
            $table->unsignedInteger('player_id2')->nullable()->change();
            $table->unsignedInteger('team_id2')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tablename = (new News)->getTable();
        Schema::table($tablename, function (Blueprint $table) {
            //
        });
    }
}
