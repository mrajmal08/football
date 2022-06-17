<?php

use App\Models\FantasyData\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamTable extends Migration
{
    public function up()
    {
        $tablename = (new Team)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->nullable();
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('player_id');
            $table->string('city')->nullable();
            $table->string('name')->nullable();
            $table->string('conference')->nullable();
            $table->string('division')->nullable();
            $table->string('full_name')->nullable();
            $table->unsignedInteger('stadium_id');
            $table->integer('bye_week')->nullable();
            $table->integer('average_draft_position')->nullable();
            $table->integer('average_draft_position_p_p_r')->nullable();
            $table->string('head_coach')->nullable();
            $table->string('offensive_coordinator')->nullable();
            $table->string('defensive_coordinator')->nullable();
            $table->string('special_teams_coach')->nullable();
            $table->string('offensive_scheme')->nullable();
            $table->string('defensive_scheme')->nullable();
            $table->integer('upcoming_salary')->nullable();
            $table->string('upcoming_opponent')->nullable();
            $table->integer('upcoming_opponent_rank')->nullable();
            $table->integer('upcoming_opponent_position_rank')->nullable();
            $table->integer('upcoming_fan_duel_salary')->nullable();
            $table->integer('upcoming_draft_kings_salary')->nullable();
            $table->integer('upcoming_yahoo_salary')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('tertiary_color')->nullable();
            $table->string('quaternary_color')->nullable();
            $table->string('wikipedia_logo_url')->nullable();
            $table->string('wikipedia_word_mark_url')->nullable();
            $table->unsignedInteger('global_team_id');
            $table->string('draft_kings_name')->nullable();
            $table->unsignedInteger('draft_kings_player_id');
            $table->string('fan_duel_name')->nullable();
            $table->unsignedInteger('fan_duel_player_id');
            $table->string('fantasy_draft_name')->nullable();
            $table->unsignedInteger('fantasy_draft_player_id');
            $table->string('yahoo_name')->nullable();
            $table->unsignedInteger('yahoo_player_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new Team)->getTable();
        Schema::drop($tablename);
    }
}
