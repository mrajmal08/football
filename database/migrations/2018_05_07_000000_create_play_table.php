<?php

use App\Models\FantasyData\Play;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayTable extends Migration
{
    public function up()
    {
        $tablename = (new Play)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('play_id')->nullable();
            $table->unsignedInteger('quarter_id');
            $table->string('quarter_name')->nullable();
            $table->integer('sequence')->nullable();
            $table->integer('time_remaining_minutes')->nullable();
            $table->integer('time_remaining_seconds')->nullable();
            $table->string('play_time')->nullable();
            $table->string('updated')->nullable();
            $table->string('created')->nullable();
            $table->string('team')->nullable();
            $table->string('opponent')->nullable();
            $table->integer('down')->nullable();
            $table->integer('distance')->nullable();
            $table->integer('yard_line')->nullable();
            $table->string('yard_line_territory')->nullable();
            $table->integer('yards_to_end_zone')->nullable();
            $table->string('type')->nullable();
            $table->integer('yards_gained')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_scoring_play')->nullable();
            $table->text('play_stats')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new Play)->getTable();
        Schema::drop($tablename);
    }
}
