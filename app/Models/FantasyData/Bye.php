<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bye extends Model
{
    use SoftDeletes;

    protected $table = 'bye';

    protected $fillable = [
        'season',
        'week',
        'team',
    ];

    protected $casts = [
        'season' => 'integer',
        'week' => 'integer',
        'team' => 'string',
    ];
}
