<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerReceiving extends Model
{
    use SoftDeletes;

    protected $table = 'player_receiving';

    protected $fillable = [
        'player_game_id',
        'player_id',
        'short_name',
        'name',
        'team',
        'number',
        'position',
        'position_category',
        'fantasy_position',
        'fantasy_points',
        'updated',
        'receptions',
        'receiving_targets',
        'receiving_yards',
        'receiving_touchdowns',
        'receiving_long',
        'receiving_yards_per_reception',
        'receiving_yards_per_target',
        'reception_percentage',
        'fumbles_lost',
        'two_point_conversion_receptions',
    ];

    protected $casts = [
        'player_game_id' => 'integer',
        'player_id' => 'integer',
        'short_name' => 'string',
        'name' => 'string',
        'team' => 'string',
        'number' => 'integer',
        'position' => 'string',
        'position_category' => 'string',
        'fantasy_position' => 'string',
        'fantasy_points' => 'integer',
        'updated' => 'string',
        'receptions' => 'integer',
        'receiving_targets' => 'integer',
        'receiving_yards' => 'integer',
        'receiving_touchdowns' => 'integer',
        'receiving_long' => 'integer',
        'receiving_yards_per_reception' => 'integer',
        'receiving_yards_per_target' => 'integer',
        'reception_percentage' => 'integer',
        'fumbles_lost' => 'integer',
        'two_point_conversion_receptions' => 'integer',
    ];
}
