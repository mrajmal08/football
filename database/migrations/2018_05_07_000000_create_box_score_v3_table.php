<?php

use App\Models\FantasyData\BoxScoreV3;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBoxScoreV3Table extends Migration
{
    public function up()
    {
        $tablename = (new BoxScoreV3)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->text('quarters')->nullable();
            $table->text('team_games')->nullable();
            $table->text('player_games')->nullable();
            $table->text('fantasy_defense_games')->nullable();
            $table->text('scoring_plays')->nullable();
            $table->text('scoring_details')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new BoxScoreV3)->getTable();
        Schema::drop($tablename);
    }
}
