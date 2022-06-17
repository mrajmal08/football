<?php

use App\Models\FantasyData\BoxScore;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBoxScoreTable extends Migration
{
    public function up()
    {
        $tablename = (new BoxScore)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->text('scoring_plays')->nullable();
            $table->text('scoring_details')->nullable();
            $table->text('away_passing')->nullable();
            $table->text('away_rushing')->nullable();
            $table->text('away_receiving')->nullable();
            $table->text('away_kicking')->nullable();
            $table->text('away_punting')->nullable();
            $table->text('away_kick_punt_returns')->nullable();
            $table->text('away_defense')->nullable();
            $table->text('home_passing')->nullable();
            $table->text('home_rushing')->nullable();
            $table->text('home_receiving')->nullable();
            $table->text('home_kicking')->nullable();
            $table->text('home_punting')->nullable();
            $table->text('home_kick_punt_returns')->nullable();
            $table->text('home_defense')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new BoxScore)->getTable();
        Schema::drop($tablename);
    }
}
