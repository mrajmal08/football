<?php

use App\Models\FantasyData\PlayerRushing;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerRushingTable extends Migration
{
    public function up()
    {
        $tablename = (new PlayerRushing)->getTable();
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
            $table->integer('rushing_attempts')->nullable();
            $table->integer('rushing_yards')->nullable();
            $table->integer('rushing_touchdowns')->nullable();
            $table->integer('rushing_long')->nullable();
            $table->integer('rushing_yards_per_attempt')->nullable();
            $table->integer('fumbles_lost')->nullable();
            $table->integer('two_point_conversion_runs')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new PlayerRushing)->getTable();
        Schema::drop($tablename);
    }
}
