<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DfsSlateGame extends Model
{
    use SoftDeletes;

    protected $table = 'dfs_slate_game';

    protected $fillable = [
        'slate_game_id',
        'slate_id',
        'game_id',
        'operator_game_id',
        'removed_by_operator',
    ];

    protected $casts = [
        'slate_game_id' => 'integer',
        'slate_id' => 'integer',
        'game_id' => 'integer',
        'operator_game_id' => 'integer',
        'removed_by_operator' => 'boolean',
    ];
}
