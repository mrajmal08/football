<?php

use App\Models\FantasyData\DailyFantasyPlayer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDailyFantasyPlayerTable extends Migration
{
    public function up()
    {
        $tablename = (new DailyFantasyPlayer)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('player_id')->nullable();
            $table->string('date')->nullable();
            $table->string('short_name')->nullable();
            $table->string('name')->nullable();
            $table->string('team')->nullable();
            $table->string('opponent')->nullable();
            $table->string('home_or_away')->nullable();
            $table->string('position')->nullable();
            $table->integer('salary')->nullable();
            $table->integer('last_game_fantasy_points')->nullable();
            $table->integer('projected_fantasy_points')->nullable();
            $table->integer('opponent_rank')->nullable();
            $table->integer('opponent_position_rank')->nullable();
            $table->string('status')->nullable();
            $table->string('status_code')->nullable();
            $table->string('status_color')->nullable();
            $table->integer('fan_duel_salary')->nullable();
            $table->integer('draft_kings_salary')->nullable();
            $table->integer('yahoo_salary')->nullable();
            $table->integer('fantasy_data_salary')->nullable();
            $table->integer('fantasy_draft_salary')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new DailyFantasyPlayer)->getTable();
        Schema::drop($tablename);
    }
}
