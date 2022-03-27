<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'machine_id',
        'psum_min_value',
        'psum_max_value',
    ];
}
