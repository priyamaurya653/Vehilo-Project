<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PartnerAuthController;
use App\Http\Controllers\Api\PartnerDashboardController;
use App\Http\Controllers\Api\RiderAuthController;
use App\Http\Controllers\Api\SuperAdminDashboardController;
use App\Http\Controllers\Api\SuperAdminPartnerController;
use App\Http\Controllers\Api\SuperAdminRiderController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\VehicleTypeController;
use App\Http\Controllers\Api\SuperAdmin\CareerApplicationController;
use App\Http\Controllers\Api\SuperAdmin\CareerJobController;
// NOTE: apne PublicCareerJobController ka sahi namespace yahan check kar lena
use App\Http\Controllers\Api\PublicCareerJobController;


Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PUBLIC
    |--------------------------------------------------------------------------
    */

    Route::post('login', [AuthController::class, 'login'])->name('api.login');

    Route::post('partner/register', [PartnerAuthController::class, 'register'])->name('api.partner.register');

    // Rider (user) registration
    Route::post('rider/send-otp', [RiderAuthController::class, 'sendOtp'])
        ->middleware('throttle:5,1')
        ->name('api.rider.send-otp');

    Route::post('rider/verify-otp', [RiderAuthController::class, 'verifyOtp'])
        ->middleware('throttle:10,1')
        ->name('api.rider.verify-otp');

    Route::post('rider/register', [RiderAuthController::class, 'register'])
        ->middleware('throttle:10,1')
        ->name('api.rider.register');

    // Active vehicle types (website / app dropdown ke liye, bina token)
    Route::get('vehicle-types', [VehicleTypeController::class, 'publicIndex'])
        ->middleware('throttle:60,1')
        ->name('api.vehicle-types.public');

    // Ek vehicle type ke features (Add Vehicle form)
    Route::get('vehicle-features', [VehicleTypeController::class, 'publicFeatures'])
        ->middleware('throttle:120,1')
        ->name('api.vehicle-features.public');

    // Available vehicles for riders (bina token)
    Route::get('vehicles', [VehicleController::class, 'publicIndex'])
        ->middleware('throttle:60,1')
        ->name('api.vehicles.public');

    Route::get('vehicles/cities', [VehicleController::class, 'publicCities'])
        ->middleware('throttle:60,1')
        ->name('api.vehicles.public.cities');

    Route::get('vehicles/{id}', [VehicleController::class, 'publicShow'])
        ->whereNumber('id')
        ->middleware('throttle:60,1')
        ->name('api.vehicles.public.show');

    // Career job openings (public)
    Route::get('careers/jobs', [PublicCareerJobController::class, 'index'])
        ->name('api.careers.jobs.public');


    /*
    |--------------------------------------------------------------------------
    | PROTECTED (Bearer token)
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        /* ---------- COMMON ---------- */
        Route::get('me', [AuthController::class, 'me'])->name('api.me');
        Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');


        /* ---------- RIDER (user) ---------- */
        Route::get('rider/me', [RiderAuthController::class, 'me'])->name('api.rider.me');


        /* ---------- VEHICLE TYPES (admin / superadmin) ---------- */
        Route::get('admin/vehicle-types', [VehicleTypeController::class, 'index'])
            ->name('api.vehicle-types.index');

        Route::post('admin/vehicle-types', [VehicleTypeController::class, 'store'])
            ->name('api.vehicle-types.store');

        Route::get('admin/vehicle-types/{id}', [VehicleTypeController::class, 'show'])
            ->whereNumber('id')->name('api.vehicle-types.show');

        // PUT/PATCH = JSON, POST = multipart (icon upload)
        Route::match(['put', 'patch', 'post'], 'admin/vehicle-types/{id}', [VehicleTypeController::class, 'update'])
            ->whereNumber('id')->name('api.vehicle-types.update');

        Route::patch('admin/vehicle-types/{id}/toggle', [VehicleTypeController::class, 'toggle'])
            ->whereNumber('id')->name('api.vehicle-types.toggle');

        Route::delete('admin/vehicle-types/{id}', [VehicleTypeController::class, 'destroy'])
            ->whereNumber('id')->name('api.vehicle-types.destroy');


        /* ---------- VEHICLES (partner: apni, superadmin: sab) ---------- */
        Route::get('admin/vehicles', [VehicleController::class, 'index'])
            ->name('api.vehicles.index');

        Route::post('admin/vehicles', [VehicleController::class, 'store'])
            ->name('api.vehicles.store');

        Route::get('admin/vehicles/{id}', [VehicleController::class, 'show'])
            ->whereNumber('id')->name('api.vehicles.show');

        // POST = multipart (images), PUT/PATCH = JSON
        Route::match(['put', 'patch', 'post'], 'admin/vehicles/{id}', [VehicleController::class, 'update'])
            ->whereNumber('id')->name('api.vehicles.update');

        Route::patch('admin/vehicles/{id}/status', [VehicleController::class, 'updateStatus'])
            ->whereNumber('id')->name('api.vehicles.status');

        Route::delete('admin/vehicles/{id}', [VehicleController::class, 'destroy'])
            ->whereNumber('id')->name('api.vehicles.destroy');


        /* ---------- SUPER ADMIN ---------- */
        Route::get('superadmin/dashboard', [SuperAdminDashboardController::class, 'index'])
            ->name('api.superadmin.dashboard');

        // Partners
        Route::get('superadmin/partners', [SuperAdminPartnerController::class, 'index'])
            ->name('api.superadmin.partners.index');
        Route::get('superadmin/partners/{id}', [SuperAdminPartnerController::class, 'show'])
            ->whereNumber('id')->name('api.superadmin.partners.show');
        Route::put('superadmin/partners/{id}', [SuperAdminPartnerController::class, 'update'])
            ->whereNumber('id')->name('api.superadmin.partners.update');
        Route::patch('superadmin/partners/{id}/status', [SuperAdminPartnerController::class, 'updateStatus'])
            ->whereNumber('id')->name('api.superadmin.partners.status');

        // Riders (users)
        Route::get('superadmin/riders', [SuperAdminRiderController::class, 'index'])
            ->name('api.superadmin.riders.index');
        Route::get('superadmin/riders/{id}', [SuperAdminRiderController::class, 'show'])
            ->whereNumber('id')->name('api.superadmin.riders.show');
        Route::put('superadmin/riders/{id}', [SuperAdminRiderController::class, 'update'])
            ->whereNumber('id')->name('api.superadmin.riders.update');
        Route::delete('superadmin/riders/{id}', [SuperAdminRiderController::class, 'destroy'])
            ->whereNumber('id')->name('api.superadmin.riders.destroy');
        Route::get('superadmin/riders/{id}/documents/{type}', [SuperAdminRiderController::class, 'document'])
            ->whereNumber('id')
            ->whereIn('type', ['government_id', 'address_proof', 'passport_photo'])
            ->name('api.superadmin.riders.document');

        // Career applications
        Route::post('superadmin/careers', [CareerApplicationController::class, 'store']);
        Route::get('superadmin/careers', [CareerApplicationController::class, 'index']);
        Route::get('superadmin/careers/{id}', [CareerApplicationController::class, 'show'])->whereNumber('id');
        Route::match(['put', 'patch'], 'superadmin/careers/{id}', [CareerApplicationController::class, 'update'])->whereNumber('id');
        Route::delete('superadmin/careers/{id}', [CareerApplicationController::class, 'destroy'])->whereNumber('id');
        Route::get('superadmin/careers/{id}/resume', [CareerApplicationController::class, 'resume'])->whereNumber('id');

        // Career job openings
        Route::get('superadmin/career-jobs', [CareerJobController::class, 'index']);
        Route::post('superadmin/career-jobs', [CareerJobController::class, 'store']);
        Route::get('superadmin/career-jobs/{id}', [CareerJobController::class, 'show'])->whereNumber('id');
        Route::match(['put', 'patch'], 'superadmin/career-jobs/{id}', [CareerJobController::class, 'update'])->whereNumber('id');
        Route::patch('superadmin/career-jobs/{id}/toggle', [CareerJobController::class, 'toggle'])->whereNumber('id');
        Route::delete('superadmin/career-jobs/{id}', [CareerJobController::class, 'destroy'])->whereNumber('id');


        /* ---------- PARTNER ---------- */
        Route::get('partner/dashboard', [PartnerDashboardController::class, 'index'])->name('api.partner.dashboard');
        Route::get('partner/me', [PartnerAuthController::class, 'me'])->name('api.partner.me');
        Route::post('partner/logout', [PartnerAuthController::class, 'logout'])->name('api.partner.logout');
    });
});