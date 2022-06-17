<?php

use App\Models\FantasyData\Quarter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuarterTable extends Migration
{
    public function up()
    {
        $tablename = (new Quarter)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quarter_id')->nullable();
            $table->unsignedInteger('score_id');
            $table->integer('number')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('away_team_score')->nullable();
            $table->integer('home_team_score')->nullable();
            $table->string('updated')->nullable();
            $table->string('created')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new Quarter)->getTable();
        Schema::drop($tablename);
    }
}
