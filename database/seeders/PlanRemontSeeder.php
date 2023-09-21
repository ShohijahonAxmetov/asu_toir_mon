<?php

namespace Database\Seeders;

use App\Models\PlanRemont;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanRemontSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = PlanRemont::all();
		foreach($items as $item) {
			$item->delete();
		}
/*        for($i=0; $i<200; $i++) {
            $data['id'] = $i+1;
        	$data['equipment_id'] = rand(1,21);
        	$data['remont_type_id'] = rand(1,4);
        	$data['remont_begin'] = '2023-'.rand(01, 12).'-'.rand(01,28);
        	$data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(1, 50).' days'));

        	PlanRemont::create($data);
        } */

        for($i=0; $i<150; $i++) {
            $data['id'] = $i+1;
        	$data['equipment_id'] = rand(1, 30);
        	$data['remont_type_id'] = rand(1, 4);
            if ($data['remont_type_id'] == 1) {
                if ($plan_remont = PlanRemont::where('equipment_id', $data['equipment_id'])
                    ->where('remont_type_id', 1)->get()->count() > 0) {
                        $data['remont_type_id'] = 4;
                }
            }

        	$data['remont_begin'] = '2023-'.rand(03, 12).'-'.rand(01,28);
            if ($data['remont_type_id'] == 4) {
                $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(2, 4).' days'));    
            } else if ($data['remont_type_id'] == 3) {
                $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(5, 9).' days'));
            } else if ($data['remont_type_id'] == 2) {
                $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(10, 19).' days'));
            } else {
                $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(20, 40).' days'));
            }
            // 
            if ($plan_remont = PlanRemont::where('equipment_id', $data['equipment_id'])
                    ->whereBetween('remont_begin', [$data['remont_begin'], $data['remont_end']])->get()->count() > 0) {
                // повтор
                $data['remont_begin'] = '2023-'.rand(03, 12).'-'.rand(01,28);
                if ($data['remont_type_id'] == 4) {
                    $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(2, 4).' days'));    
                } else if ($data['remont_type_id'] == 3) {
                    $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(5, 9).' days'));
                } else if ($data['remont_type_id'] == 2) {
                    $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(10, 19).' days'));
                } else {
                    $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(20, 40).' days'));
                }
            }

        	PlanRemont::create($data);
        }
        for($i=150; $i<200; $i++) {
            $data['id'] = $i+1;
        	$data['equipment_id'] = rand(1, 30);
        	$data['remont_type_id'] = rand(1,4);
            if ($data['remont_type_id'] == 1) {
                if ($plan_remont = PlanRemont::where('equipment_id', $data['equipment_id'])
                    ->where('remont_type_id', 1)->get()->count() > 0) {
                        $data['remont_type_id'] = 4;
                }
            }

        	$data['remont_begin'] = '2024-'.rand(01, 03).'-'.rand(01,28);
            if ($data['remont_type_id'] == 4) {
                $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(2, 4).' days'));    
            } else if ($data['remont_type_id'] == 3) {
                $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(5, 9).' days'));
            } else if ($data['remont_type_id'] == 2) {
                $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(10, 19).' days'));
            } else {
                $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(20, 40).' days'));
            }

            if ($plan_remont = PlanRemont::where('equipment_id', $data['equipment_id'])
                    ->whereBetween('remont_begin', [$data['remont_begin'], $data['remont_end']])->get()->count() > 0) {
                // повтор
                $data['remont_begin'] = '2024-'.rand(01, 03).'-'.rand(01,28);
                if ($data['remont_type_id'] == 4) {
                    $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(2, 4).' days'));    
                } else if ($data['remont_type_id'] == 3) {
                    $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(5, 9).' days'));
                } else if ($data['remont_type_id'] == 2) {
                    $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(10, 19).' days'));
                } else {
                    $data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(20, 40).' days'));
                }
            }

        	PlanRemont::create($data);
        }

    }
}
