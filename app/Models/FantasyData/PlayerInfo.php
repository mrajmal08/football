<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerInfo extends Model
{
    use SoftDeletes;

    protected $table = 'player_info';

    protected $fillable = [
        'player_id',
        'name',
        'team_id',
        'team',
        'position',
    ];

    protected $casts = [
        'player_id' => 'integer',
        'name' => 'string',
        'team_id' => 'integer',
        'team' => 'string',
        'position' => 'string',
    ];
}
