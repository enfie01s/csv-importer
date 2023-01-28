<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_import_reports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('filename');
            $table->bigInteger('successful')->default(0);
            $table->bigInteger('failed_reg')->default(0);
            $table->bigInteger('failed_price')->default(0);
            $table->bigInteger('failed_images')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_import_reports');
    }
};
