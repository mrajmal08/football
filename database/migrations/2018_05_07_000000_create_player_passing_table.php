<?php

use App\Models\FantasyData\PlayerPassing;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerPassingTable extends Migration
{
    public function up()
    {
        $tablename = (new PlayerPassing)->getTable();
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
            $table->integer('passing_attempts')->nullable();
            $table->integer('passing_completions')->nullable();
            $table->integer('passing_yards')->nullable();
            $table->integer('passing_touchdowns')->nullable();
            $table->integer('passing_interceptions')->nullable();
            $table->integer('passing_long')->nullable();
            $table->integer('passing_sacks')->nullable();
            $table->integer('passing_sack_yards')->nullable();
            $table->integer('passing_completion_percentage')->nullable();
            $table->integer('passing_yards_per_attempt')->nullable();
            $table->integer('passing_yards_per_completion')->nullable();
            $table->integer('passing_rating')->nullable();
            $table->integer('two_point_conversion_passes')->nullable();
            $table->integer('fumbles_lost')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new PlayerPassing)->getTable();
        Schema::drop($tablename);
    }
}
