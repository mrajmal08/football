<?php

use App\Models\FantasyData\PlayerDetail;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerDetailTable extends Migration
{
    public function up()
    {
        $tablename = (new PlayerDetail)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->text('latest_news')->nullable();
            $table->unsignedInteger('player_id');
            $table->string('team')->nullable();
            $table->integer('number')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('position')->nullable();
            $table->string('status')->nullable();
            $table->string('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('college')->nullable();
            $table->integer('experience')->nullable();
            $table->string('fantasy_position')->nullable();
            $table->boolean('active')->nullable();
            $table->string('position_category')->nullable();
            $table->string('name')->nullable();
            $table->integer('age')->nullable();
            $table->string('experience_string')->nullable();
            $table->string('birth_date_string')->nullable();
            $table->string('photo_url')->nullable();
            $table->integer('bye_week')->nullable();
            $table->string('upcoming_game_opponent')->nullable();
            $table->integer('upcoming_game_week')->nullable();
            $table->string('short_name')->nullable();
            $table->integer('average_draft_position')->nullable();
            $table->string('depth_position_category')->nullable();
            $table->string('depth_position')->nullable();
            $table->integer('depth_order')->nullable();
            $table->integer('depth_display_order')->nullable();
            $table->string('current_team')->nullable();
            $table->string('college_draft_team')->nullable();
            $table->integer('college_draft_year')->nullable();
            $table->integer('college_draft_round')->nullable();
            $table->integer('college_draft_pick')->nullable();
            $table->boolean('is_undrafted_free_agent')->nullable();
            $table->integer('height_feet')->nullable();
            $table->integer('height_inches')->nullable();
            $table->integer('upcoming_opponent_rank')->nullable();
            $table->integer('upcoming_opponent_position_rank')->nullable();
            $table->string('current_status')->nullable();
            $table->integer('upcoming_salary')->nullable();
            $table->unsignedInteger('fantasy_alarm_player_id');
            $table->unsignedInteger('sport_radar_player_id');
            $table->unsignedInteger('rotoworld_player_id');
            $table->unsignedInteger('roto_wire_player_id');
            $table->unsignedInteger('stats_player_id');
            $table->unsignedInteger('sports_direct_player_id');
            $table->unsignedInteger('xml_team_player_id');
            $table->unsignedInteger('fan_duel_player_id');
            $table->unsignedInteger('draft_kings_player_id');
            $table->unsignedInteger('yahoo_player_id');
            $table->string('injury_status')->nullable();
            $table->string('injury_body_part')->nullable();
            $table->string('injury_start_date')->nullable();
            $table->string('injury_notes')->nullable();
            $table->string('fan_duel_name')->nullable();
            $table->string('draft_kings_name')->nullable();
            $table->string('yahoo_name')->nullable();
            $table->integer('fantasy_position_depth_order')->nullable();
            $table->string('injury_practice')->nullable();
            $table->string('injury_practice_description')->nullable();
            $table->boolean('declared_inactive')->nullable();
            $table->integer('upcoming_fan_duel_salary')->nullable();
            $table->integer('upcoming_draft_kings_salary')->nullable();
            $table->integer('upcoming_yahoo_salary')->nullable();
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('global_team_id');
            $table->unsignedInteger('fantasy_draft_player_id');
            $table->string('fantasy_draft_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new PlayerDetail)->getTable();
        Schema::drop($tablename);
    }
}
