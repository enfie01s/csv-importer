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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('make_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('make_id')->references('id')->on('makes');
            $table->foreign('type_id')->references('id')->on('vehicle_types');
            $table->string('reg');
            $table->string('range')->nullable();
            $table->string('model')->nullable();
            $table->string('derivative')->nullable();
            $table->decimal('price_inc_vat', 10, 2)->default(0);
            $table->string('colour')->default('Unknown');
            $table->integer('mileage')->default(0);
            $table->timestamp('date_on_forecourt')->nullable();
            $table->string('images')->nullable();
            $table->boolean('available')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
