<?php

use App\Models\FantasyData\PlayerReceiving;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerReceivingTable extends Migration
{
    public function up()
    {
        $tablename = (new PlayerReceiving)->getTable();
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
            $table->integer('receptions')->nullable();
            $table->integer('receiving_targets')->nullable();
            $table->integer('receiving_yards')->nullable();
            $table->integer('receiving_touchdowns')->nullable();
            $table->integer('receiving_long')->nullable();
            $table->integer('receiving_yards_per_reception')->nullable();
            $table->integer('receiving_yards_per_target')->nullable();
            $table->integer('reception_percentage')->nullable();
            $table->integer('fumbles_lost')->nullable();
            $table->integer('two_point_conversion_receptions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new PlayerReceiving)->getTable();
        Schema::drop($tablename);
    }
}
