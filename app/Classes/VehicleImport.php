<?php

namespace App\Classes;

use DateTime;
use App\Models\Make;
use App\Models\VehicleType;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VehicleImport implements OnEachRow, WithHeadingRow
{
    public $data = [
        'successful' => 0,
        'failed_reg' => 0,
        'failed_price' => 0,
        'failed_images' => 0,
    ];

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        if ($this->validate($row)) {
            # Get/Create parent model
            $make = Make::firstOrCreate([
                'name' => $row['make'],
            ]);

            # Get/Create the vehicle type
            $type = VehicleType::firstOrCreate([
                'name' => $row['vehicle_type'],
            ]);

            # Create the entry for this vehicle
            $vehicle = $make->vehicles()->create([
                'reg' => $row['reg'],
                'type_id' => $type->id,
                'range' => $row['range'],
                'model' => $row['model'],
                'derivative' => $row['derivative'],
                'price_inc_vat' => str_replace(",", "", $row['price_inc_vat']),
                'colour' => $row['colour'],
                'mileage' => $row['mileage'],
                'date_on_forecourt' => $this->dateOnForecourt($row['date_on_forecourt']),
                'images' => $row['images'],
                'available' => $this->isAvailable($row['date_on_forecourt']),
            ]);
            $this->data['successful']++;
        }
    }

    public function dateOnForecourt($string) {
        $date = str_replace('/', '-', $string);
        if (strlen($string) < 1 || strtotime($date) <= 0) return null;
        $timestamp = strtotime($date);
        $dt = new DateTime();
        $dt->setTimestamp($timestamp);
        return $dt;
    }

    public function isAvailable($string) {
        $dof = $this->dateOnForecourt($string);
        if ($dof == null) return false;
        $now = new DateTime();
        if ($dof > $now) return false;
        return true;
    }

    public function validate($row) {

        if (strlen($row['reg']) < 1) {
            $this->data['failed_reg']++;
            return false;
        }
        if (str_replace(",", "", $row['price_inc_vat']) <= 0) {
            $this->data['failed_price']++;
            return false;
        }
        if (count(explode(",", $row['images'])) < 3) {
            $this->data['failed_images']++;
            return false;
        }
        return true;
    }
}
