<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Partner (admin) ki gaadiyan
| vehicle_types table pehle bani honi chahiye
|--------------------------------------------------------------------------
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            // Kiski gaadi hai + kaunsa type
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types')->restrictOnDelete();

            // 01 Basic details
            $table->string('vehicle_name', 100);
            $table->string('vehicle_number', 15)->unique();
            $table->string('brand', 60);
            $table->string('model', 60);
            $table->unsignedSmallInteger('manufacturing_year')->nullable();
            $table->string('color', 30)->nullable();

            // 02 Images: {"1": "vehicles/5/a.jpg", "2": "..."}
            $table->json('images')->nullable();

            // 03 Specifications
            $table->enum('transmission', ['manual', 'automatic', 'geared']);
            $table->enum('fuel_type', ['petrol', 'diesel', 'cng', 'electric', 'hybrid']);
            $table->unsignedTinyInteger('seating_capacity');
            $table->unsignedInteger('engine_cc')->nullable();
            $table->decimal('mileage', 7, 2)->nullable();
            $table->unsignedInteger('range_per_charge')->nullable();

            // 04 Pricing
            $table->decimal('price_per_hour', 10, 2)->nullable();
            $table->decimal('price_per_day', 10, 2);
            $table->decimal('price_per_week', 10, 2)->nullable();
            $table->decimal('security_deposit', 10, 2);
            $table->unsignedInteger('included_km');
            $table->decimal('extra_km_charge', 8, 2);

            // 05 Location
            $table->string('country', 60);
            $table->string('state', 60);
            $table->string('city', 60);
            $table->string('location_area', 100);
            $table->string('pickup_location', 150);
            $table->string('pincode', 6);
            $table->text('pickup_address');

            // 06 Availability
            $table->enum('status', ['available', 'inactive', 'maintenance'])->default('available');
            $table->date('available_from')->nullable();
            $table->date('available_to')->nullable();
            $table->unsignedSmallInteger('minimum_rental_days')->default(1);
            $table->unsignedSmallInteger('maximum_rental_days')->nullable();

            // 07 Features (vehicle type ke features me se chune hue)
            $table->json('features')->nullable();

            // 08 Description
            $table->text('description')->nullable();

            $table->timestamps();

            $table->index(['status', 'city']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};