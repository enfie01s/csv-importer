<?php

namespace App\Http\Controllers;

use App\Classes\VehicleImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\VehicleImportReport;
use App\Mail\VehicleImported;
use Illuminate\Support\Facades\Mail;

class VehicleController extends Controller
{
    public function import()
    {
        $file = './example_stock.csv';
        $import = new VehicleImport;
        Excel::import($import, './example_stock.csv');

        $report = VehicleImportReport::create([
            'filename' => $file,
            'successful' => $import->data['successful'],
            'failed_reg' => $import->data['failed_reg'],
            'failed_price' => $import->data['failed_price'],
            'failed_images' => $import->data['failed_images'],
        ]);

        # Send mail here
        Mail::to(env('APP_ADMINISTRATOR'))->send(new VehicleImported($report));
        return redirect('/success');
    }
}
