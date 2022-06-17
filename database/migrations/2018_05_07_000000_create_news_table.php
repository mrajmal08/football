<?php

use App\Models\FantasyData\News;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsTable extends Migration
{
    public function up()
    {
        $tablename = (new News)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('news_id')->nullable();
            $table->string('source')->nullable();
            $table->string('updated')->nullable();
            $table->string('time_ago')->nullable();
            $table->string('title')->nullable();
            $table->string('content')->nullable();
            $table->string('url')->nullable();
            $table->string('terms_of_use')->nullable();
            $table->string('author')->nullable();
            $table->string('categories')->nullable();
            $table->unsignedInteger('player_id');
            $table->unsignedInteger('team_id');
            $table->string('team')->nullable();
            $table->unsignedInteger('player_id2');
            $table->unsignedInteger('team_id2');
            $table->string('team2')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new News)->getTable();
        Schema::drop($tablename);
    }
}
