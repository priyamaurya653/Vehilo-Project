<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CareerController;


/*
|--------------------------------------------------------------------------
| Media: storage/app/public ki images seedha serve karo
| (Windows par storage:link na chale tab bhi photos dikhen)
|--------------------------------------------------------------------------
*/
Route::get('/media/{path}', function (string $path) {
    $base = realpath(storage_path('app/public'));
    $file = $base ? realpath($base . DIRECTORY_SEPARATOR . $path) : false;

    // Sirf storage/app/public ke andar ki files (../ se bahar nahi ja sakte)
    abort_unless($file && str_starts_with($file, $base) && is_file($file), 404);

    return response()->file($file, ['Cache-Control' => 'public, max-age=604800']);
})->where('path', '.*')->name('media');


/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.index')->name('home');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/vision', 'pages.vision')->name('pages.vision');
Route::view('/about', 'pages.about')->name('pages.about');
Route::view('/leadership', 'pages.leadership')->name('pages.leadership');

/*
|--------------------------------------------------------------------------
| Careers
|--------------------------------------------------------------------------
*/

Route::get('/careers', [CareerController::class, 'index'])->name('careers');

Route::post('/careers/apply', [CareerController::class, 'apply'])
    ->middleware('throttle:5,1')
    ->name('careers.apply');


/*
|--------------------------------------------------------------------------
| Partner / Rider registration
|--------------------------------------------------------------------------
*/

Route::view('/partner', 'pages.partner')->name('partner.register');

// Vehicle detail page (home page card se)
Route::get('/vehicles/{id}', fn (int $id) => view('pages.vehicle-detail', ['vehicleId' => $id]))
    ->whereNumber('id')->name('vehicles.show');

Route::view('/register', 'pages.register')->name('rider.register');
Route::redirect('/pages/register', '/register');


/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::view('/user-login', 'pages.userlogin')->name('user.login');
Route::view('/login', 'auth.login')->name('login');


/*
|--------------------------------------------------------------------------
| Role Wise Dashboards
|--------------------------------------------------------------------------
*/

Route::view('/superadmin/dashboard', 'front.superadmin')->name('superadmin.dashboard');
Route::view('/admin/dashboard', 'front.admin')->name('admin.dashboard');
Route::view('/user/dashboard', 'front.user')->name('user.dashboard');


/*
|--------------------------------------------------------------------------
| Super Admin - Partners
|--------------------------------------------------------------------------
*/

Route::view('/superadmin/partners', 'front.superadmin.partners')->name('superadmin.partners');

Route::view('/superadmin/partners/requests', 'front.superadmin.partners', ['defaultStatus' => 'pending'])
    ->name('superadmin.partners.requests');

Route::get('/superadmin/partners/{id}', fn (int $id) => view('front.superadmin.partner-show', ['partnerId' => $id]))
    ->whereNumber('id')->name('superadmin.partners.show');

Route::get('/superadmin/partners/{id}/edit', fn (int $id) => view('front.superadmin.partner-edit', ['partnerId' => $id]))
    ->whereNumber('id')->name('superadmin.partners.edit');


/*
|--------------------------------------------------------------------------
| Super Admin - Users / Riders
|--------------------------------------------------------------------------
*/

Route::view('/superadmin/users', 'front.superadmin.users')->name('superadmin.users');

Route::view('/superadmin/users/pending', 'front.superadmin.users', ['defaultStatus' => 'pending'])
    ->name('superadmin.users.pending');

Route::get('/superadmin/users/{id}', fn (int $id) => view('front.superadmin.user-show', ['riderId' => $id]))
    ->whereNumber('id')->name('superadmin.users.show');

Route::get('/superadmin/users/{id}/edit', fn (int $id) => view('front.superadmin.user-edit', ['riderId' => $id]))
    ->whereNumber('id')->name('superadmin.users.edit');


/*
|--------------------------------------------------------------------------
| Super Admin - Careers
|--------------------------------------------------------------------------
*/

Route::view('/superadmin/careers', 'superadmin.index')->name('superadmin.careers');
Route::view('/superadmin/careers/jobs', 'superadmin.Jobs')->name('superadmin.careers.jobs');


/*
|--------------------------------------------------------------------------
| Admin (Partner) - Vehicles
| resources/views/admin/vehicle/...
|--------------------------------------------------------------------------
*/

// All vehicles (list)
Route::view('/admin/vehicle/vehicles', 'admin.vehicle.vehicles')->name('admin.vehicle.vehicles');

// Add vehicle
Route::view('/admin/vehicles/create', 'admin.vehicle.create')->name('admin.vehicle.create');

// View vehicle
Route::get('/admin/vehicles/{id}', fn (int $id) => view('admin.vehicle.show', ['vehicleId' => $id]))
    ->whereNumber('id')->name('admin.vehicle.show');

// Edit vehicle (same form)
Route::get('/admin/vehicles/{id}/edit', fn (int $id) => view('admin.vehicle.create', ['vehicleId' => $id]))
    ->whereNumber('id')->name('admin.vehicle.edit');

// Vehicle types list
Route::view('/admin/vehicles/types', 'admin.vehicle.types')->name('admin.vehicle.types');

// Add vehicle type
Route::view('/admin/vehicles/add-feature', 'admin.vehicle.add-feature')->name('admin.vehicle.add-feature');

// Edit vehicle type (same form)
Route::get('/admin/vehicles/types/{id}/edit', fn (int $id) => view('admin.vehicle.add-feature', ['vehicleTypeId' => $id]))
    ->whereNumber('id')->name('admin.vehicle.types.edit');