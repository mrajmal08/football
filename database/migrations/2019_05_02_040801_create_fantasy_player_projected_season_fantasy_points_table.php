<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFantasyPlayerProjectedSeasonFantasyPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fantasy_player_projected_season_fantasy_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('fantasy_player_id');
            $table->integer('player_id')->default(null);
            $table->integer('season')->default(null);
            $table->integer('season_type')->default(null);
            $table->decimal('fantasy_points', 7, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fantasy_player_projected_season_fantasy_points');
    }
}
