<?php

namespace Tests\Feature;

use Maatwebsite\Excel\Facades\Excel;
use App\Classes\VehicleImport;
use Tests\TestCase;

class CSVImportTest extends TestCase
{
    /**
    * Test the csv import feature
    */
    public function can_import_csv()
    {
        Excel::fake();


        Excel::assertImported('filename.xlsx', 'diskName');

        Excel::assertImported('filename.xlsx', 'diskName', function(VehicleImport $import) {
            return true;
        });

        // When passing the callback as 2nd param, the disk will be the default disk.
        Excel::assertImported('filename.xlsx', function(UsersImport $import) {
            return true;
        });
    }

}
