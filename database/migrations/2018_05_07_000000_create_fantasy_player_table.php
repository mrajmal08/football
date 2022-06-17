<?php

use App\Models\FantasyData\FantasyPlayer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFantasyPlayerTable extends Migration
{
    public function up()
    {
        $tablename = (new FantasyPlayer)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->string('fantasy_player_key')->nullable();
            $table->unsignedInteger('player_id');
            $table->string('name')->nullable();
            $table->string('team')->nullable();
            $table->string('position')->nullable();
            $table->integer('average_draft_position')->nullable();
            $table->integer('average_draft_position_p_p_r')->nullable();
            $table->integer('bye_week')->nullable();
            $table->integer('last_season_fantasy_points')->nullable();
            $table->integer('projected_fantasy_points')->nullable();
            $table->integer('auction_value')->nullable();
            $table->integer('auction_value_p_p_r')->nullable();
            $table->unsignedInteger('average_draft_position_id_p');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new FantasyPlayer)->getTable();
        Schema::drop($tablename);
    }
}
