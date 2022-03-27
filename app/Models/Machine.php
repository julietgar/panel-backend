<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MachineSetting;
use App\Models\Metric;

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

    /**
     * Get the setting associated with the machine.
     */
    public function setting()
    {
        return $this->hasOne(MachineSetting::class);
    }

     /**
     * Get the metrics associated with the machine.
     */
    public function metrics()
    {
        return $this->hasMany(Metric::class);
    }
}
