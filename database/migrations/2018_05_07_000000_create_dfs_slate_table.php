<?php

use App\Models\FantasyData\DfsSlate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDfsSlateTable extends Migration
{
    public function up()
    {
        $tablename = (new DfsSlate)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slate_id')->nullable();
            $table->string('operator')->nullable();
            $table->unsignedInteger('operator_slate_id');
            $table->string('operator_name')->nullable();
            $table->string('operator_day')->nullable();
            $table->string('operator_start_time')->nullable();
            $table->integer('number_of_games')->nullable();
            $table->boolean('is_multi_day_slate')->nullable();
            $table->boolean('removed_by_operator')->nullable();
            $table->string('operator_game_type')->nullable();
            $table->text('dfs_slate_games')->nullable();
            $table->text('dfs_slate_players')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new DfsSlate)->getTable();
        Schema::drop($tablename);
    }
}
