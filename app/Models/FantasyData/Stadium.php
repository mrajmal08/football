<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stadium extends Model
{
    use SoftDeletes;

    protected $table = 'stadium';

    protected $fillable = [
        'stadium_id',
        'name',
        'city',
        'state',
        'country',
        'capacity',
        'playing_surface',
        'geo_lat',
        'geo_long',
    ];

    protected $casts = [
        'stadium_id' => 'integer',
        'name' => 'string',
        'city' => 'string',
        'state' => 'string',
        'country' => 'string',
        'capacity' => 'integer',
        'playing_surface' => 'string',
        'geo_lat' => 'integer',
        'geo_long' => 'integer',
    ];
}
