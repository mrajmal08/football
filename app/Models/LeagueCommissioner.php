<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueCommissioner extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'league_id',
    ];

    /**
     * Get the leagues that owned by league commisoner.
     */
    public function leauges()
    {
        return $this->belongsTo(\App\Models\League::class);
    }
}
