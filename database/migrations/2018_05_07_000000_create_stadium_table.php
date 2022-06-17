<?php

use App\Models\FantasyData\Stadium;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStadiumTable extends Migration
{
    public function up()
    {
        $tablename = (new Stadium)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stadium_id')->nullable();
            $table->string('name')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->integer('capacity')->nullable();
            $table->string('playing_surface')->nullable();
            $table->integer('geo_lat')->nullable();
            $table->integer('geo_long')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new Stadium)->getTable();
        Schema::drop($tablename);
    }
}
