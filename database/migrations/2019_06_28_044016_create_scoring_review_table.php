<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoringReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scoring_review', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('fantasy_player_id')->nullable();
            $table->foreign('fantasy_player_id')
             ->references('id')->on('fantasy_player');
            $table->string('game_key')->nullable();
            $table->integer('season_type')->nullable();
            $table->integer('season')->nullable();
            $table->integer('week')->nullable();
            $table->unsignedDecimal('adjustment_amount', 7, 3);
            $table->longText('comment');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scoring_review');
    }
}
