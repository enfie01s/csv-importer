<?php

namespace App\Models;

class VehicleImportReport extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'filename',
        'successful',
        'failed_reg',
        'failed_price',
        'failed_images',
    ];

    public function total() {
        return $this->successful + $this->failed_reg + $this->failed_price + $this->failed_images;
    }

}
