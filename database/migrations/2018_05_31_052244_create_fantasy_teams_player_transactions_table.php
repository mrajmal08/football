<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFantasyTeamsPlayerTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fantasy_teams_player_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fantasy_player_id');
            $table->foreign('fantasy_player_id')
             ->references('id')->on('fantasy_player');
            $table->unsignedInteger('fantasy_team_id');
            $table->foreign('fantasy_team_id')
             ->references('id')->on('fantasy_teams');
            $table->unsignedInteger('player_transaction_type_id');
            $table->foreign('player_transaction_type_id', 'transaction_type_id_foreign')
             ->references('id')->on('player_transaction_types');
            $table->boolean('active')->nullable();
            $table->integer('week')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fantasy_teams_player_transactions');
    }
}
