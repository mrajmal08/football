<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'article';

    protected $fillable = [
        'article_id',
        'title',
        'source',
        'updated',
        'content',
        'url',
        'terms_of_use',
        'author',
        'players',
    ];

    protected $casts = [
        'article_id' => 'integer',
        'title' => 'string',
        'source' => 'string',
        'updated' => 'string',
        'content' => 'string',
        'url' => 'string',
        'terms_of_use' => 'string',
        'author' => 'string',
        'players' => 'array',
    ];
}
