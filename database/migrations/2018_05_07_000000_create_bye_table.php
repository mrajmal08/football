<?php

use App\Models\FantasyData\Bye;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateByeTable extends Migration
{
    public function up()
    {
        $tablename = (new Bye)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season')->nullable();
            $table->integer('week')->nullable();
            $table->string('team')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new Bye)->getTable();
        Schema::drop($tablename);
    }
}
