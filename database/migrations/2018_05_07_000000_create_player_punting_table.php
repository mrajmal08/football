<?php

use App\Models\FantasyData\PlayerPunting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerPuntingTable extends Migration
{
    public function up()
    {
        $tablename = (new PlayerPunting)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('player_game_id')->nullable();
            $table->unsignedInteger('player_id');
            $table->string('short_name')->nullable();
            $table->string('name')->nullable();
            $table->string('team')->nullable();
            $table->integer('number')->nullable();
            $table->string('position')->nullable();
            $table->string('position_category')->nullable();
            $table->string('fantasy_position')->nullable();
            $table->integer('fantasy_points')->nullable();
            $table->string('updated')->nullable();
            $table->integer('punts')->nullable();
            $table->integer('punt_average')->nullable();
            $table->integer('punt_inside20')->nullable();
            $table->integer('punt_touchbacks')->nullable();
            $table->integer('punt_yards')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new PlayerPunting)->getTable();
        Schema::drop($tablename);
    }
}
