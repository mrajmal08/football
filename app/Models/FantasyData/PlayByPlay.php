<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayByPlay extends Model
{
    use SoftDeletes;

    protected $table = 'play_by_play';

    protected $fillable = [
        'quarters',
        'plays',
    ];

    protected $casts = [
        'quarters' => 'array',
        'plays' => 'array',
    ];
}
