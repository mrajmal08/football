<?php

use App\Models\FantasyData\PlayerOwnership;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerOwnershipTable extends Migration
{
    public function up()
    {
        $tablename = (new PlayerOwnership)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('player_id')->nullable();
            $table->integer('season')->nullable();
            $table->integer('season_type')->nullable();
            $table->integer('week')->nullable();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string('team')->nullable();
            $table->unsignedInteger('team_id');
            $table->integer('ownership_percentage')->nullable();
            $table->integer('delta_ownership_percentage')->nullable();
            $table->integer('start_percentage')->nullable();
            $table->integer('delta_start_percentage')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new PlayerOwnership)->getTable();
        Schema::drop($tablename);
    }
}
