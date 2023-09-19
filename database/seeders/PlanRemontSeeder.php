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
        for($i=0; $i<200; $i++) {
        	$data['equipment_id'] = rand(1,21);
        	$data['remont_type_id'] = rand(1,4);
        	$data['remont_begin'] = '2023-'.rand(01, 12).'-'.rand(01,28);
        	$data['remont_end'] = date('Y-m-d', strtotime($data['remont_begin'].'+ '.rand(1, 50).' days'));

        	PlanRemont::create($data);
        }
    }
}
