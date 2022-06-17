<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'season',
        'season_type',
        'week',
        'waiver_period_enabled',
        'display_ads',
    ];
}
