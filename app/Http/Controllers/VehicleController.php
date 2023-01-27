<?php

namespace App\Http\Controllers;

use App\Imports\VehicleImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    public function import()
    {
        Excel::import(new VehicleImport, 'example_stock.csv');

        return redirect('/')->with('success', 'All good!');
    }
}
