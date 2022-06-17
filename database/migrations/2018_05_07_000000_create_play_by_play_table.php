<?php

use App\Models\FantasyData\PlayByPlay;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayByPlayTable extends Migration
{
    public function up()
    {
        $tablename = (new PlayByPlay)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->text('quarters')->nullable();
            $table->text('plays')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new PlayByPlay)->getTable();
        Schema::drop($tablename);
    }
}
