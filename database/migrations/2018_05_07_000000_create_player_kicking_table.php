<?php

use App\Models\FantasyData\PlayerKicking;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerKickingTable extends Migration
{
    public function up()
    {
        $tablename = (new PlayerKicking)->getTable();
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
            $table->integer('extra_points_made')->nullable();
            $table->integer('extra_points_attempted')->nullable();
            $table->integer('field_goals_made')->nullable();
            $table->integer('field_goals_attempted')->nullable();
            $table->integer('field_goals_longest_made')->nullable();
            $table->integer('field_goal_percentage')->nullable();
            $table->integer('field_goals_made0to19')->nullable();
            $table->integer('field_goals_made20to29')->nullable();
            $table->integer('field_goals_made30to39')->nullable();
            $table->integer('field_goals_made40to49')->nullable();
            $table->integer('field_goals_made50_plus')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new PlayerKicking)->getTable();
        Schema::drop($tablename);
    }
}
