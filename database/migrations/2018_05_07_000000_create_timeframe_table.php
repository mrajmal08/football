<?php

use App\Models\FantasyData\Timeframe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimeframeTable extends Migration
{
    public function up()
    {
        $tablename = (new Timeframe)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_type')->nullable();
            $table->integer('season')->nullable();
            $table->integer('week')->nullable();
            $table->string('name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('first_game_start')->nullable();
            $table->string('first_game_end')->nullable();
            $table->string('last_game_end')->nullable();
            $table->boolean('has_games')->nullable();
            $table->boolean('has_started')->nullable();
            $table->boolean('has_ended')->nullable();
            $table->boolean('has_first_game_started')->nullable();
            $table->boolean('has_first_game_ended')->nullable();
            $table->boolean('has_last_game_ended')->nullable();
            $table->string('api_season')->nullable();
            $table->string('api_week')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new Timeframe)->getTable();
        Schema::drop($tablename);
    }
}
