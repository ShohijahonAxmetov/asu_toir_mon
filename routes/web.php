<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('equipments/{id}/getDetails', [\App\Http\Controllers\EquipmentController::class, 'getDetails']);
    Route::resource('equipments', \App\Http\Controllers\EquipmentController::class);
    Route::resource('details', \App\Http\Controllers\DetailController::class);
    Route::resource('technical_inspections', \App\Http\Controllers\TechnicalInspectionController::class);
    Route::resource('type_technical_inspections', \App\Http\Controllers\TypeTechnicalInspectionController::class);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/calendar/get_days', [App\Http\Controllers\HomeController::class, 'get_days']);
    Route::get('/calendar', [App\Http\Controllers\HomeController::class, 'calendar']);
    Route::get('/chart', [App\Http\Controllers\HomeController::class, 'chart'])->name('chart');
});

Auth::routes();
