<?php

use App\Models\FantasyData\Injury;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInjuryTable extends Migration
{
    public function up()
    {
        $tablename = (new Injury)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('injury_id')->nullable();
            $table->integer('season_type')->nullable();
            $table->integer('season')->nullable();
            $table->integer('week')->nullable();
            $table->unsignedInteger('player_id');
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->integer('number')->nullable();
            $table->string('team')->nullable();
            $table->string('opponent')->nullable();
            $table->string('body_part')->nullable();
            $table->string('status')->nullable();
            $table->string('practice')->nullable();
            $table->string('practice_description')->nullable();
            $table->string('updated')->nullable();
            $table->boolean('declared_inactive')->nullable();
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('opponent_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new Injury)->getTable();
        Schema::drop($tablename);
    }
}
