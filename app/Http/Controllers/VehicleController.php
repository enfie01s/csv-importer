<?php

namespace App\Http\Controllers;

use App\Classes\VehicleImport;
use App\Classes\VehicleExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\VehicleImportReport;
use App\Models\Make;
use App\Mail\VehicleImported;
use Illuminate\Support\Facades\Mail;

class VehicleController extends Controller
{
    public function import()
    {
        $file = './example_stock.csv';
        $import = new VehicleImport;
        Excel::import($import, $file);

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

    public function export($make)
    {
        $file = date('Y_m_d_His') . '_' . $make . '_vehicles.csv';

        $make = Make::where('name', $make)
            ->with('vehicles')
            ->first();

        $vehiclesArray = [];
        foreach ($make->vehicles as $row) {
            $title = implode(' ', [$make->name, $row['model'], $row['derivative']]);
            $vatPerc = 1 + (int)env('VAT_PERCENT') / 100;
            $exvat = $row['price_inc_vat'] / $vatPerc;
            $vat = $row['price_inc_vat'] - $exvat;
            $images = explode(',', $row['images']);
            $newArray = [
                'registration' => $row['reg'],
                'title' => $title,
                'exvat' => round($exvat, 2),
                'vat' => round($vat, 2),
                'image' => $images[0],
            ];
            array_push($vehiclesArray, $newArray);
        }
        $export = new VehicleExport($vehiclesArray);

        if (strlen(env('FTP_HOST')) > 0) {  // Use ftp if it is configured
            Excel::store($export, $file, 'ftp');
            return redirect('/success');
        } else {  // else fallback to download
            return Excel::download($export, $file);
        }
    }
}
