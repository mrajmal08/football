<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DfsSlatePlayer extends Model
{
    use SoftDeletes;

    protected $table = 'dfs_slate_player';

    protected $fillable = [
        'slate_player_id',
        'slate_id',
        'slate_game_id',
        'player_id',
        'player_game_projection_stat_id',
        'fantasy_defense_projection_stat_id',
        'operator_player_id',
        'operator_slate_player_id',
        'operator_player_name',
        'operator_position',
        'operator_roster_slots',
        'operator_salary',
        'team',
        'team_id',
        'removed_by_operator',
    ];

    protected $casts = [
        'slate_player_id' => 'integer',
        'slate_id' => 'integer',
        'slate_game_id' => 'integer',
        'player_id' => 'integer',
        'player_game_projection_stat_id' => 'integer',
        'fantasy_defense_projection_stat_id' => 'integer',
        'operator_player_id' => 'string',
        'operator_slate_player_id' => 'string',
        'operator_player_name' => 'string',
        'operator_position' => 'string',
        'operator_roster_slots' => 'array',
        'operator_salary' => 'integer',
        'team' => 'string',
        'team_id' => 'integer',
        'removed_by_operator' => 'boolean',
    ];
}
