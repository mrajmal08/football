<?php

use App\Models\FantasyData\ScoringPlay;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScoringPlayTable extends Migration
{
    public function up()
    {
        $tablename = (new ScoringPlay)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->string('game_key')->nullable();
            $table->integer('season_type')->nullable();
            $table->unsignedInteger('scoring_play_id');
            $table->integer('season')->nullable();
            $table->integer('week')->nullable();
            $table->string('away_team')->nullable();
            $table->string('home_team')->nullable();
            $table->string('date')->nullable();
            $table->integer('sequence')->nullable();
            $table->string('team')->nullable();
            $table->string('quarter')->nullable();
            $table->string('time_remaining')->nullable();
            $table->string('play_description')->nullable();
            $table->integer('away_score')->nullable();
            $table->integer('home_score')->nullable();
            $table->unsignedInteger('score_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new ScoringPlay)->getTable();
        Schema::drop($tablename);
    }
}
