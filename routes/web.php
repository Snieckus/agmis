<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::middleware('role:0')->group(function() {
        Route::resource('appointments', AppointmentController::class);
        Route::post('/submit_temp_appointment', [App\Http\Controllers\AjaxController::class, 'submitTempAppointment'])->name('submitTempAppointment');
        Route::post('/get_used_times', [App\Http\Controllers\AjaxController::class, 'getUsedDates'])->name('getUsedDates');
    });

    Route::middleware('role:1')->group(function() {
        Route::resource('prescriptions', PrescriptionController::class);
    });

    Route::middleware('role:2')->group(function() {
        Route::resource('prescriptions', PrescriptionController::class);
    });

});

Route::get('/api', [App\Http\Controllers\ApiController::class, 'index'])->name('api_index');
Route::post('/api/auth', [App\Http\Controllers\ApiController::class, 'auth'])->name('api_auth');
Route::post('/get_api_data', [App\Http\Controllers\AjaxController::class, 'getApiData'])->name('getApiData');

