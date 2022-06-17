<?php

use App\Models\FantasyData\DailyFantasyScoring;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDailyFantasyScoringTable extends Migration
{
    public function up()
    {
        $tablename = (new DailyFantasyScoring)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('player_id')->nullable();
            $table->string('name')->nullable();
            $table->string('team')->nullable();
            $table->string('position')->nullable();
            $table->integer('fantasy_points')->nullable();
            $table->integer('fantasy_points_p_p_r')->nullable();
            $table->integer('fantasy_points_fan_duel')->nullable();
            $table->integer('fantasy_points_draft_kings')->nullable();
            $table->integer('fantasy_points_yahoo')->nullable();
            $table->boolean('has_started')->nullable();
            $table->boolean('is_in_progress')->nullable();
            $table->boolean('is_over')->nullable();
            $table->string('date')->nullable();
            $table->integer('fantasy_points_fantasy_draft')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new DailyFantasyScoring)->getTable();
        Schema::drop($tablename);
    }
}
