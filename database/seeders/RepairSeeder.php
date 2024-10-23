<?php

namespace Database\Seeders;

use App\Models\TechMaps\TechMap;
use App\Models\Repair\Repair;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepairSeeder extends Seeder
{
	private $minutes = ['00', '15', '30'];
	private $plusMinus = ['+', '-'];
    private $techMapIds = [1,2,3,5];

    public function run(): void
    {
        // started_at - randomnaya data
        // ended_at - vichislim iz texkarti +- {0-1} chasa {15,30,45} minut
        if (Repair::count() == 0) for ($i=1; $i < 101; $i++) {
        	$startedAt = '202'.rand(0,4).'-0'.rand(1, 9).'-'.rand(10, 28).' '.rand(10, 23).':'.$this->minutes[rand(0, 1)];
    		$techMapId = $this->techMapIds[rand(0, 3)];

            $techMap = TechMap::findOrFail($techMapId);
    		$techMapDurationHours = $techMap->hours;
    		$techMapDurationMinutes = $techMap->minutes;
    		$endedAt = $this->addDateAndRandDate($startedAt, $techMapDurationHours, $techMapDurationMinutes);
            $amount = $techMap->onlyTechOperations()->sum('amount');
            $amount = $amount*(rand(75, 125)/100);
    		
        	Repair::create([
        		'id' => $i,
        		'tech_map_id' => $techMapId,
        		'started_at' => $startedAt,
        		'ended_at' => $endedAt,
                'amount' => $amount,
        		'comments' => null
        	]);
        }
    }

    function addDateAndRandDate($start, $durationHours, $durationMinutes): string
    {
    	$end = date("Y-m-d H:i", strtotime($start.'+'.$durationHours.' hours'));
    	$end = date("Y-m-d H:i", strtotime($end.'+'.$durationMinutes.' minute'));

    	$randHours = date("Y-m-d H:i", strtotime($end.' '.$this->plusMinus[rand(0, 1)].rand(0, 1).' hours'));
    	$randMinutes = date("Y-m-d H:i", strtotime($randHours.' '.$this->plusMinus[rand(0, 1)].$this->minutes[rand(0, 2)].' minute'));

    	return $randMinutes;
    }
}
