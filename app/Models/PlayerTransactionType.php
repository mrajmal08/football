<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerTransactionType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
    ];

    public $timestamps = false;
}
