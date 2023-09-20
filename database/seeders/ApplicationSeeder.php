<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\PlanRemont;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    	for($i=0; $i<1000; $i++) {
    		$required_quantity = rand(51,99);
    		$warehouse_quantity = $required_quantity - rand(1,50);
    		$warehouse_date = '2023-'.rand(01, 12).'-'.rand(01,28);
    		$plan_remont_id = rand(1,200);
    		$plan_remont = PlanRemont::find($plan_remont_id);
    		$data = [
    			'id' => $i+1,
    			'plan_remont_id' => $plan_remont_id,
    			'equipment_id' => $plan_remont->equipment_id,
    			'technical_resource_id' => rand(1,50),
    			'required_quantity' => $required_quantity,
    			'warehouse_number' => '№'.rand(1,1598),
    			'warehouse_date' => $warehouse_date,
    			'warehouse_quantity' => $warehouse_quantity,
    			'type_application' => 1,
    			'requirement_id' => $i+1,
    			'application_date' => $warehouse_date,
    			'declared_quantity' => $required_quantity - $warehouse_quantity,
    			'delivery_date' => date('Y-m-d', strtotime($plan_remont->remont_begin.'-1 day')),
    			'remont_begin' => $plan_remont->remont_begin
    		];

        	Application::create($data);
    	}
    }
}
