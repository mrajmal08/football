<?php

use App\Models\FantasyData\ScoringDetail;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScoringDetailTable extends Migration
{
    public function up()
    {
        $tablename = (new ScoringDetail)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->string('game_key')->nullable();
            $table->integer('season_type')->nullable();
            $table->unsignedInteger('player_id');
            $table->string('team')->nullable();
            $table->integer('season')->nullable();
            $table->integer('week')->nullable();
            $table->string('scoring_type')->nullable();
            $table->integer('length')->nullable();
            $table->unsignedInteger('scoring_detail_id');
            $table->unsignedInteger('player_game_id');
            $table->unsignedInteger('score_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new ScoringDetail)->getTable();
        Schema::drop($tablename);
    }
}
