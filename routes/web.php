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
    Route::get('equipments/{equipment}/graph', [\App\Http\Controllers\EquipmentController::class, 'graph'])->name('equipments.graph');
    Route::resource('equipments', \App\Http\Controllers\EquipmentController::class);
    Route::resource('type_equipments', \App\Http\Controllers\TypeEquipmentController::class);
    Route::resource('technical_resources', \App\Http\Controllers\TechnicalResourceController::class);
    Route::resource('technical_resource_type_eqs', \App\Http\Controllers\TechnicalResourceTypeEquipmentController::class);
    Route::resource('plan_remonts', \App\Http\Controllers\PlanRemontController::class);
    Route::resource('year_applications', \App\Http\Controllers\YearApplicationController::class);
    Route::resource('requirements_year_applications', \App\Http\Controllers\RequirementYearApplicationController::class);
    Route::resource('repair_applications', \App\Http\Controllers\RepairApplicationController::class);
    Route::resource('requirement_repair_applications', \App\Http\Controllers\RequirementRepairApplicationController::class);
    Route::resource('emergency_applications', \App\Http\Controllers\EmergencyApplicationController::class);
    Route::resource('req_emergency_applications', \App\Http\Controllers\RequirementEmergencyApplicationController::class);
    Route::resource('departments', \App\Http\Controllers\DepartmentController::class);
    Route::resource('remont_types', \App\Http\Controllers\RemontTypeController::class);
    Route::resource('execution_statuses', \App\Http\Controllers\ExecutionStatusController::class);
    Route::resource('units', \App\Http\Controllers\UnitController::class);
    Route::resource('order_resources', \App\Http\Controllers\OrderResourceController::class);
    Route::resource('vid_equipments', \App\Http\Controllers\VidEquipmentController::class);
    Route::get('/monitoring', [App\Http\Controllers\OrderResourceController::class, 'monitoring'])->name('monitoring');
    Route::get('/monitoring/{application_id}', [App\Http\Controllers\OrderResourceController::class, 'monitoringShow'])->name('monitoring.show');
    Route::resource('files', \App\Http\Controllers\UploadedFileController::class);


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/calendar/get_days', [App\Http\Controllers\HomeController::class, 'get_days']);
    Route::get('/calendar', [App\Http\Controllers\HomeController::class, 'calendar']);
    Route::get('/chart', [App\Http\Controllers\HomeController::class, 'chart'])->name('chart');

    // TECH MAPS
    Route::resource('tech_maps', \App\Http\Controllers\TechMaps\TechMapController::class);
    Route::resource('tech_map_groups', \App\Http\Controllers\TechMaps\TechMapGroupController::class);
    Route::resource('tech_operations', \App\Http\Controllers\TechMaps\TechOperationController::class);
    Route::resource('tech_operation_stages', \App\Http\Controllers\TechMaps\TechOperationStageController::class);

    foreach([['tech_resources', 'TechnicalResource'], ['qualifications', 'Qualification'], ['instruments', 'Instrument'], ['repair_equipments', 'RepairEquipment']] as $item) {
        Route::get('tech_operations/{tech_operation}/'.$item[0], [\App\Http\Controllers\TechMaps\TechOperationController::class, 'add'.$item[1]])->name('tech_operation.'.$item[0].'.add');
        Route::post('tech_operations/{tech_operation}/'.$item[0], [\App\Http\Controllers\TechMaps\TechOperationController::class, 'store'.$item[1]])->name('tech_operation.'.$item[0].'.store');
        Route::get('tech_operations/{tech_operation}/'.$item[0].'/{pivot_id}', [\App\Http\Controllers\TechMaps\TechOperationController::class, 'edit'.$item[1]])->name('tech_operation.'.$item[0].'.edit');
        Route::delete('tech_operations/{tech_operation}/'.$item[0].'/{pivot_id}', [\App\Http\Controllers\TechMaps\TechOperationController::class, 'destroy'.$item[1]])->name('tech_operation.'.$item[0].'.destroy');
        Route::put('tech_operations/{tech_operation}/'.$item[0].'/{pivot_id}', [\App\Http\Controllers\TechMaps\TechOperationController::class, 'update'.$item[1]])->name('tech_operation.'.$item[0].'.update');
    }

    foreach([['security_measures', 'SecurityMeasure'], ['tech_map_files', 'TechMapFile'], ['operations', 'Operation']] as $item) {
        Route::get('tech_maps/{tech_map}/'.$item[0], [\App\Http\Controllers\TechMaps\TechMapController::class, 'add'.$item[1]])->name('tech_map.'.$item[0].'.add');
        Route::post('tech_maps/{tech_map}/'.$item[0], [\App\Http\Controllers\TechMaps\TechMapController::class, 'store'.$item[1]])->name('tech_map.'.$item[0].'.store');
        Route::get('tech_maps/{tech_map}/'.$item[0].'/{pivot_id}', [\App\Http\Controllers\TechMaps\TechMapController::class, 'edit'.$item[1]])->name('tech_map.'.$item[0].'.edit');
        Route::delete('tech_maps/{tech_map}/'.$item[0].'/{pivot_id}', [\App\Http\Controllers\TechMaps\TechMapController::class, 'destroy'.$item[1]])->name('tech_map.'.$item[0].'.destroy');
        Route::put('tech_maps/{tech_map}/'.$item[0].'/{pivot_id}', [\App\Http\Controllers\TechMaps\TechMapController::class, 'update'.$item[1]])->name('tech_map.'.$item[0].'.update');
    }

    Route::resource('repairs', \App\Http\Controllers\Repairs\RepairController::class);

    foreach([['logs', 'Log']] as $item) {
        Route::get('repairs/{repair}/'.$item[0], [\App\Http\Controllers\Repairs\RepairController::class, 'add'.$item[1]])->name('repair.'.$item[0].'.add');
        Route::post('repairs/{repair}/'.$item[0], [\App\Http\Controllers\Repairs\RepairController::class, 'store'.$item[1]])->name('repair.'.$item[0].'.store');
        Route::get('repairs/{repair}/'.$item[0].'/{pivot_id}', [\App\Http\Controllers\Repairs\RepairController::class, 'edit'.$item[1]])->name('repair.'.$item[0].'.edit');
        Route::delete('repairs/{repair}/'.$item[0].'/{pivot_id}', [\App\Http\Controllers\Repairs\RepairController::class, 'destroy'.$item[1]])->name('repair.'.$item[0].'.destroy');
        Route::put('repairs/{repair}/'.$item[0].'/{pivot_id}', [\App\Http\Controllers\Repairs\RepairController::class, 'update'.$item[1]])->name('repair.'.$item[0].'.update');
    }

    Route::get('analysis', [\App\Http\Controllers\TechMaps\AnalysisController::class, 'index'])->name('analysis.index');
    Route::get('analysis/{tech_map}', [\App\Http\Controllers\TechMaps\AnalysisController::class, 'show'])->name('analysis.show');
});

Auth::routes();
