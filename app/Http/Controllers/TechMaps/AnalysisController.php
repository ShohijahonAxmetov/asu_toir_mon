<?php

namespace App\Http\Controllers\TechMaps;

use App\Models\Repair\RepairLog;
use App\Models\TechMaps\TechMap;
use App\Models\Repair\Repair;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function index()
    {
    	$techMaps = TechMap::get();

		// kakaya texkarta skolko raz ispolzovalas (kolichestvo takogo tipa remontov)
		foreach ($techMaps as $techMap) {
			$techMap->used = Repair::where('tech_map_id', $techMap->id)
				->count();

			$repairs = Repair::where('tech_map_id', $techMap->id)
				->get();
			$sumInMinutes = 0;
			foreach ($repairs as $repair) {
				$sumInMinutes += Carbon::parse($repair->started_at)->diffInMinutes(Carbon::parse($repair->ended_at));
			}
			$techMap->avg_time_in_minutes = $techMap->used != 0 ? ($sumInMinutes/$techMap->used)/60 : 0;

			$techMap->normativeInHours = round($techMap->hours + ($techMap->minutes/60), 1);

			$techMap->avg_amount = $techMap->used != 0 ? ($repairs->sum('amount')/$techMap->used) : 0;

		}

		$techMapDataForChats = $techMaps->pluck('code')->toArray();

    	return view('app.analysis.index', [
    		'tech_maps' => $techMaps,
    		'tech_map_data_for_bar' => $techMapDataForChats,
    	]);
    }

    public function show(TechMap $techMap)
    {
    	$techMapOperations = DB::table('tech_map_operations')
                                ->where('tech_map_id', $techMap->id)
                                ->join('tech_operations', 'tech_map_operations.model_id', '=', 'tech_operations.id')
                                ->get();
        $repairLogs = RepairLog::get();
        foreach ($techMapOperations as $operation) {
        	$durationHoursSum = $repairLogs->where('tech_operation_id', $operation->model_id)->sum('duration_hours');
        	$operationDurationMinutes_sum = $repairLogs->where('tech_operation_id', $operation->model_id)->sum('duration_minutes');
        	$operationDurationInMinutes = $durationHoursSum*60 + $operationDurationMinutes_sum;
        	$operation->avg_duration = round($operationDurationInMinutes/$repairLogs->where('tech_operation_id', $operation->model_id)->count(), 1);
        }

        $techMap->used = Repair::where('tech_map_id', $techMap->id)
			->count();

		$repairs = Repair::where('tech_map_id', $techMap->id)
			->get();
		$sumInMinutes = 0;
		foreach ($repairs as $repair) {
			$sumInMinutes += Carbon::parse($repair->started_at)->diffInMinutes(Carbon::parse($repair->ended_at));
		}
		$techMap->avg_time_in_minutes = $techMap->used != 0 ? round(($sumInMinutes/$techMap->used)/60, 1) : 0;

		$techMap->normativeInHours = round($techMap->hours + ($techMap->minutes/60), 1);

		$techMap->avg_amount = $techMap->used != 0 ? ($repairs->sum('amount')/$techMap->used) : 0;

    	return view('app.analysis.show', [
    		'item' => $techMap,
    		'tech_map_operations' => $techMapOperations,
    	]);
    }
}
