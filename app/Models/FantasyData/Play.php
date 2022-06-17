<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Play extends Model
{
    use SoftDeletes;

    protected $table = 'play';

    protected $fillable = [
        'play_id',
        'quarter_id',
        'quarter_name',
        'sequence',
        'time_remaining_minutes',
        'time_remaining_seconds',
        'play_time',
        'updated',
        'created',
        'team',
        'opponent',
        'down',
        'distance',
        'yard_line',
        'yard_line_territory',
        'yards_to_end_zone',
        'type',
        'yards_gained',
        'description',
        'is_scoring_play',
        'play_stats',
    ];

    protected $casts = [
        'play_id' => 'integer',
        'quarter_id' => 'integer',
        'quarter_name' => 'string',
        'sequence' => 'integer',
        'time_remaining_minutes' => 'integer',
        'time_remaining_seconds' => 'integer',
        'play_time' => 'string',
        'updated' => 'string',
        'created' => 'string',
        'team' => 'string',
        'opponent' => 'string',
        'down' => 'integer',
        'distance' => 'integer',
        'yard_line' => 'integer',
        'yard_line_territory' => 'string',
        'yards_to_end_zone' => 'integer',
        'type' => 'string',
        'yards_gained' => 'integer',
        'description' => 'string',
        'is_scoring_play' => 'boolean',
        'play_stats' => 'array',
    ];
}
