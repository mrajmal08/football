<?php

use App\Models\FantasyData\PlayerDefense;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerDefenseTable extends Migration
{
    public function up()
    {
        $tablename = (new PlayerDefense)->getTable();
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
            $table->integer('tackles')->nullable();
            $table->integer('solo_tackles')->nullable();
            $table->integer('assisted_tackles')->nullable();
            $table->integer('sacks')->nullable();
            $table->integer('sack_yards')->nullable();
            $table->integer('fumbles_forced')->nullable();
            $table->integer('fumbles_recovered')->nullable();
            $table->integer('passes_defended')->nullable();
            $table->integer('interceptions')->nullable();
            $table->integer('interception_return_yards')->nullable();
            $table->integer('interception_return_touchdowns')->nullable();
            $table->integer('tackles_for_loss')->nullable();
            $table->integer('quarterback_hits')->nullable();
            $table->integer('fumble_return_touchdowns')->nullable();
            $table->integer('safeties')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new PlayerDefense)->getTable();
        Schema::drop($tablename);
    }
}
