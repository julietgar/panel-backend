<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'device_id',
        'data',
        'date_from',
        'date_to',
        'created_at',
    ];
}
