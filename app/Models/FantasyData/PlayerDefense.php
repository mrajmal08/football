<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerDefense extends Model
{
    use SoftDeletes;

    protected $table = 'player_defense';

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
        'tackles',
        'solo_tackles',
        'assisted_tackles',
        'sacks',
        'sack_yards',
        'fumbles_forced',
        'fumbles_recovered',
        'passes_defended',
        'interceptions',
        'interception_return_yards',
        'interception_return_touchdowns',
        'tackles_for_loss',
        'quarterback_hits',
        'fumble_return_touchdowns',
        'safeties',
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
        'tackles' => 'integer',
        'solo_tackles' => 'integer',
        'assisted_tackles' => 'integer',
        'sacks' => 'integer',
        'sack_yards' => 'integer',
        'fumbles_forced' => 'integer',
        'fumbles_recovered' => 'integer',
        'passes_defended' => 'integer',
        'interceptions' => 'integer',
        'interception_return_yards' => 'integer',
        'interception_return_touchdowns' => 'integer',
        'tackles_for_loss' => 'integer',
        'quarterback_hits' => 'integer',
        'fumble_return_touchdowns' => 'integer',
        'safeties' => 'integer',
    ];
}
