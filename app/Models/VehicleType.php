<?php

namespace App\Models;

class VehicleType extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * All the prescribed records
     *
     * @return HasMany
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'type_id', 'id');
    }
}
