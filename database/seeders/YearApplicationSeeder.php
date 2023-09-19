<?php

namespace Database\Seeders;

use App\Models\YearApplication;
use App\Models\Department;
use App\Models\TechnicalResource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YearApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    	$departments = Department::all();
    	$technicalResources = TechnicalResource::all();

        foreach ($departments as $key => $department) {
        	foreach ($technicalResources as $key1 => $technicalResource) {

        		$data = [
        			'department_id' => $department->id,
        			'technical_resource_id' => $technicalResource->id,
        			'year' => 2023
        		];
        		$data['unit_id'] = TechnicalResource::find($data['technical_resource_id'])->unit_id;
		        $data['quantity'] = 0;
		        $data['quantity_m1'] = 0;
		        $data['quantity_m2'] = 0;
		        $data['quantity_m3'] = 0;
		        $data['quantity_m4'] = 0;
		        $data['quantity_m5'] = 0;
		        $data['quantity_m6'] = 0;
		        $data['quantity_m7'] = 0;
		        $data['quantity_m8'] = 0;
		        $data['quantity_m9'] = 0;
		        $data['quantity_m10'] = 0;
		        $data['quantity_m11'] = 0;
		        $data['quantity_m12'] = 0;

        		YearApplication::create($data);
        	}
        }
    }
}
