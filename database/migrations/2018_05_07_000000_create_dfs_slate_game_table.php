<?php

use App\Models\FantasyData\DfsSlateGame;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDfsSlateGameTable extends Migration
{
    public function up()
    {
        $tablename = (new DfsSlateGame)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slate_game_id')->nullable();
            $table->unsignedInteger('slate_id');
            $table->unsignedInteger('game_id');
            $table->unsignedInteger('operator_game_id');
            $table->boolean('removed_by_operator')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new DfsSlateGame)->getTable();
        Schema::drop($tablename);
    }
}
