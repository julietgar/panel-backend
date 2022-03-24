<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'name',
        'slug',
        'created_at',
    ];
}
