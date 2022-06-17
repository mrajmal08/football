<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DfsSlate extends Model
{
    use SoftDeletes;

    protected $table = 'dfs_slate';

    protected $fillable = [
        'slate_id',
        'operator',
        'operator_slate_id',
        'operator_name',
        'operator_day',
        'operator_start_time',
        'number_of_games',
        'is_multi_day_slate',
        'removed_by_operator',
        'operator_game_type',
        'dfs_slate_games',
        'dfs_slate_players',
    ];

    protected $casts = [
        'slate_id' => 'integer',
        'operator' => 'string',
        'operator_slate_id' => 'integer',
        'operator_name' => 'string',
        'operator_day' => 'string',
        'operator_start_time' => 'string',
        'number_of_games' => 'integer',
        'is_multi_day_slate' => 'boolean',
        'removed_by_operator' => 'boolean',
        'operator_game_type' => 'string',
        'dfs_slate_games' => 'array',
        'dfs_slate_players' => 'array',
    ];
}
