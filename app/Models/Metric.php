<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    /**
     * Prevent to insert in the `update_at` column automatically
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'machine_id',
        'device_id',
        'state',
        'data',
        'date_from',
        'date_to',
        'created_at',
    ];
}
