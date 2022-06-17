<?php

use App\Models\FantasyData\DfsSlatePlayer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDfsSlatePlayerTable extends Migration
{
    public function up()
    {
        $tablename = (new DfsSlatePlayer)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slate_player_id')->nullable();
            $table->unsignedInteger('slate_id');
            $table->unsignedInteger('slate_game_id');
            $table->unsignedInteger('player_id');
            $table->unsignedInteger('player_game_projection_stat_id');
            $table->unsignedInteger('fantasy_defense_projection_stat_id');
            $table->unsignedInteger('operator_player_id');
            $table->unsignedInteger('operator_slate_player_id');
            $table->string('operator_player_name')->nullable();
            $table->string('operator_position')->nullable();
            $table->text('operator_roster_slots')->nullable();
            $table->integer('operator_salary')->nullable();
            $table->string('team')->nullable();
            $table->unsignedInteger('team_id');
            $table->boolean('removed_by_operator')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new DfsSlatePlayer)->getTable();
        Schema::drop($tablename);
    }
}
