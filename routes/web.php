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
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::resource('equipments', \App\Http\Controllers\EquipmentController::class);
    Route::resource('type_equipments', \App\Http\Controllers\TypeEquipmentController::class);
    Route::resource('technical_resources', \App\Http\Controllers\TechnicalResourceController::class);
    Route::resource('technical_resource_type_eqs', \App\Http\Controllers\TechnicalResourceTypeEquipmentController::class);
    Route::resource('plan_remonts', \App\Http\Controllers\PlanRemontController::class);
    Route::resource('year_applications', \App\Http\Controllers\YearApplicationController::class);
    Route::resource('departments', \App\Http\Controllers\DepartmentController::class);
    Route::resource('remont_types', \App\Http\Controllers\RemontTypeController::class);
    Route::resource('execution_statuses', \App\Http\Controllers\ExecutionStatusController::class);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/calendar/get_days', [App\Http\Controllers\HomeController::class, 'get_days']);
    Route::get('/calendar', [App\Http\Controllers\HomeController::class, 'calendar']);
    Route::get('/chart', [App\Http\Controllers\HomeController::class, 'chart'])->name('chart');
});

Auth::routes();
