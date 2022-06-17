<?php

use App\Models\FantasyData\Standing;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStandingTable extends Migration
{
    public function up()
    {
        $tablename = (new Standing)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_type')->nullable();
            $table->integer('season')->nullable();
            $table->string('conference')->nullable();
            $table->string('division')->nullable();
            $table->string('team')->nullable();
            $table->string('name')->nullable();
            $table->integer('wins')->nullable();
            $table->integer('losses')->nullable();
            $table->integer('ties')->nullable();
            $table->integer('percentage')->nullable();
            $table->integer('points_for')->nullable();
            $table->integer('points_against')->nullable();
            $table->integer('net_points')->nullable();
            $table->integer('touchdowns')->nullable();
            $table->integer('division_wins')->nullable();
            $table->integer('division_losses')->nullable();
            $table->integer('conference_wins')->nullable();
            $table->integer('conference_losses')->nullable();
            $table->unsignedInteger('team_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new Standing)->getTable();
        Schema::drop($tablename);
    }
}
