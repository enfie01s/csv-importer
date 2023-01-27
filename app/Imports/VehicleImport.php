<?php

namespace App\Imports;

use App\Models\Make;
use App\Models\VehicleType;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class UsersImport implements OnEachRow
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        # Get/Create parent model
        $make = Make::firstOrCreate([
            'name' => $row[1],
        ]);

        # Get/Create the vehicle type
        $type = VehicleType::firstOrCreate([
            'name' => $row[8],
        ]);

        # Create the entry for this vehicle
        $make->vehicle()->create([
            'reg' => $row[0],
            'type_id' => $type->uid,
            'range' => $row[2],
            'model' => $row[3],
            'derivative' => $row[4],
            'price_inc_vat' => $row[5],
            'colour' => $row[6],
            'mileage' => $row[7],
            'date_on_forecourt' => $row[9],
            'images' => $row[10],
        ]);
    }
}
