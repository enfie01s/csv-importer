<?php

namespace App\Models;

class Vehicle extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reg',
        'range',
        'model',
        'derivative',
        'price_inc_vat',
        'colour',
        'mileage',
        'date_on_forecourt',
        'images',
        'available',
        'type_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_on_forecourt' => 'datetime',
    ];

    /**
     * Linked Make
     *
     * @return BelongsTo
     */
    public function make()
    {
        return $this->belongsTo(Make::class, 'make_id', 'id');
    }

    /**
     * Linked Type
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'type_id', 'uid');
    }
}
