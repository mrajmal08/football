<?php

use App\Models\FantasyData\PlayerKickPuntReturns;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerKickPuntReturnsTable extends Migration
{
    public function up()
    {
        $tablename = (new PlayerKickPuntReturns)->getTable();
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
            $table->integer('kick_returns')->nullable();
            $table->integer('kick_return_yards')->nullable();
            $table->integer('kick_return_yards_per_attempt')->nullable();
            $table->integer('kick_return_long')->nullable();
            $table->integer('kick_return_touchdowns')->nullable();
            $table->integer('punt_returns')->nullable();
            $table->integer('punt_return_yards')->nullable();
            $table->integer('punt_return_yards_per_attempt')->nullable();
            $table->integer('punt_return_long')->nullable();
            $table->integer('punt_return_touchdowns')->nullable();
            $table->integer('fumbles_lost')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new PlayerKickPuntReturns)->getTable();
        Schema::drop($tablename);
    }
}
