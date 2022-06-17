<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLeagueInvitations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_invitations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('league_id');
            $table->foreign('league_id')
             ->references('id')->on('leagues');
            $table->unsignedInteger('fantasy_team_id')->nullable();
            $table->foreign('fantasy_team_id')
             ->references('id')->on('fantasy_teams');
            $table->string('email');
            $table->string('role')->default('user');
            $table->string('token');
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
        Schema::dropIfExists('league_invitations');
    }
}
