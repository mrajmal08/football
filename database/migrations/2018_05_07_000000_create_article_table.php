<?php

use App\Models\FantasyData\Article;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleTable extends Migration
{
    public function up()
    {
        $tablename = (new Article)->getTable();
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->nullable();
            $table->string('title')->nullable();
            $table->string('source')->nullable();
            $table->string('updated')->nullable();
            $table->string('content')->nullable();
            $table->string('url')->nullable();
            $table->string('terms_of_use')->nullable();
            $table->string('author')->nullable();
            $table->text('players')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        $tablename = (new Article)->getTable();
        Schema::drop($tablename);
    }
}
