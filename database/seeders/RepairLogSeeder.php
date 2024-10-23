<?php

namespace Database\Seeders;

use App\Models\Repair\Repair;
use App\Models\Repair\RepairLog;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepairLogSeeder extends Seeder
{
    public function run(): void
    {
        // RepairLog::query()->truncate();
        if (RepairLog::count() == 0) for ($i=1; $i < 101; $i++) { 
        	$repair = Repair::findOrfail($i);
        	$techMap = $repair->techMap;

            $techMapTechOperations = $repair->techMap->onlyTechOperations();
            $iteration = 0;
            $allMinutes = 0;
        	foreach ($techMapTechOperations as $techOperation) {
                $iteration ++;
                if ($iteration == 3) {
                    $techMapMinutes = Carbon::parse($repair->started_at)->diffInMinutes(Carbon::parse($repair->ended_at));
                    $repair->repairLogs()->create([
                                                'tech_map_id' => null,
                                                'tech_map_tech_operation_id' => null,
                                                'tech_operation_id' => $techOperation->id,
                                                'duration_hours' => floor(($techMapMinutes-$allMinutes)/60),
                                                'duration_minutes' => ($techMapMinutes-$allMinutes)%60,
                                                'comments' => null,
                                            ]);
                }
                else $repair->repairLogs()->create([
        	        		'tech_map_id' => null,
        	        		'tech_map_tech_operation_id' => null,
        	        		'tech_operation_id' => $techOperation->id,
        	        		'duration_hours' => $techOperation->hours,
        	        		'duration_minutes' => $techOperation->minutes,
        	        		'comments' => null,
        	        	]);

                $allMinutes += $techOperation->hours*60 + $techOperation->minutes;
        	}
        }
    }
}
