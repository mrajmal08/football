<?php

use App\Models\FantasyData\PlayerInfo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerInfoTable extends Migration
{
    public function up()
    {
        $tablename = (new PlayerInfo)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('player_id')->nullable();
            $table->string('name')->nullable();
            $table->unsignedInteger('team_id');
            $table->string('team')->nullable();
            $table->string('position')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new PlayerInfo)->getTable();
        Schema::drop($tablename);
    }
}
