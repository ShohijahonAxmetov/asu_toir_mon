<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\PlanRemont;
use App\Models\RepairApplication;
use App\Models\OrderResource;
use App\Models\EmergencyApplication;
use App\Models\YearApplication;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = OrderResource::all();
        foreach($items as $item) {
            $item->delete();
        }
		$items = Application::all();
		foreach($items as $item) {
			$item->delete();
		}
		$items = RepairApplication::all();
		foreach($items as $item) {
			$item->delete();
		}

		$curreny_date = date('Y-m-d');

		// Заявки на ремонт
    	for($i=0; $i<500; $i++) {
    		$required_quantity = rand(51,99);
    		$plan_remont_id = rand(1,200);
    		$plan_remont = PlanRemont::find($plan_remont_id);
    		$warehouse_quantity = $required_quantity - rand(1,50);
			// Проверить дату заявки и склада
			if ($plan_remont->remont_begin < $curreny_date) {
				$warehouse_date = date('Y-m-d', strtotime($plan_remont->remont_begin.'-'.rand(20,50).' day'));
			} else {
				$warehouse_date = date('Y-m-d', strtotime($curreny_date.'-'.rand(20,50).' day'));
			}

			// Вставка заявки на ремонт
			// Если заявка на этот ремонт
			//$application2 ;
			//var_dump($application2);
			//die();
			if (RepairApplication::where('plan_remont_id', $plan_remont_id)->get()->count() > 0) {
				// есть
				$application2 = RepairApplication::where('plan_remont_id', $plan_remont_id)->latest()->first();
				$warehouse_date = $application2->application_date;
			} else {
				// нет
				$data_app = [
					'application_date' => $warehouse_date,
					'equipment_id' => $plan_remont->equipment_id,
					'plan_remont_id' => $plan_remont_id,
				];
				RepairApplication::create($data_app);
				$application2 = RepairApplication::where('plan_remont_id', $plan_remont_id)->latest()->first();
			}
			// Вставка дочерней записи
	/*		$data_sub = [
				'repair_application_id' => $application2-,
				'technical_resource_id' => $warehouse_date,
				'required_quantity' => $warehouse_date,
				'warehouse_number' => $warehouse_date,
				'warehouse_date' => $warehouse_date,
				'warehouse_quantity' => $warehouse_date,
				'declared_quantity' => $warehouse_date,
				'delivery_date' => $warehouse_date
			];*/
    		
    		$data = [
    			'id' => $i+1,
    			'plan_remont_id' => $plan_remont_id,
    			'equipment_id' => $plan_remont->equipment_id,
    			'technical_resource_id' => rand(1,50),
    			'required_quantity' => $required_quantity,
    			'warehouse_number' => '№'.rand(1,1598),
    			'warehouse_date' => $warehouse_date,
    			'warehouse_quantity' => $warehouse_quantity,
    			'type_application' => 2,
    			'requirement_id' => $i+1,
    			'application_date' => $warehouse_date,
    			'declared_quantity' => $required_quantity - $warehouse_quantity,
    			'delivery_date' => date('Y-m-d', strtotime($plan_remont->remont_begin.'-5 day')), // Дата поставки (план)
    			'remont_begin' => $plan_remont->remont_begin
    		];

        	Application::create($data);
    	}

		for($i=0; $i<500; $i++) {
    		$required_quantity = rand(51,99);
    		$plan_remont_id = rand(1,200);
    		$plan_remont = PlanRemont::find($plan_remont_id);
    		$warehouse_quantity = $required_quantity - rand(1,50);
    		$warehouse_date = date('Y-m-d', strtotime($plan_remont->remont_begin.'-'.rand(20,50).' day'));

			// Вставка аварийной заявки
			// Если заявка на этот ремонт
			if (EmergencyApplication::where('plan_remont_id', $plan_remont_id)->get()->count() > 0) {
				// есть
				$application3 = EmergencyApplication::where('plan_remont_id', $plan_remont_id)->latest()->first();
				$warehouse_date = $application3->application_date;
			} else {
				// нет
				$data_app = [
					'application_date' => $warehouse_date,
					'equipment_id' => $plan_remont->equipment_id,
					'plan_remont_id' => $plan_remont_id,
				];
				EmergencyApplication::create($data_app);
			}

    		$data = [
    			'id' => $i+1+500,
    			'plan_remont_id' => $plan_remont_id,
    			'equipment_id' => $plan_remont->equipment_id,
    			'technical_resource_id' => rand(1,50),
    			'required_quantity' => $required_quantity,
    			'warehouse_number' => '№'.rand(1,1598),
    			'warehouse_date' => $warehouse_date,
    			'warehouse_quantity' => $warehouse_quantity,
    			'type_application' => 3,
    			'requirement_id' => $i+1,
    			'application_date' => $warehouse_date,
    			'declared_quantity' => $required_quantity - $warehouse_quantity,
    			'delivery_date' => date('Y-m-d', strtotime($plan_remont->remont_begin.'-5 day')),
    			'remont_begin' => $plan_remont->remont_begin
    		];

        	Application::create($data);
    	}

		for($i=0; $i<1000; $i++) {
    		$required_quantity = rand(51,99);
			// $plan_remont_id = rand(1,200);
    		$plan_remont_id = rand(1,100);
    		$plan_remont = PlanRemont::find($plan_remont_id);
    		$warehouse_quantity = $required_quantity - rand(1,50);
    		// $warehouse_date = date('Y-m-d', strtotime($plan_remont->remont_begin.'-'.rand(20,50).' day'));
    		 $warehouse_date = '2022-12-'.rand(01,28);

			$technical_resource_id = rand(1,50);
			$department_id =  $plan_remont->equipment->department_id;
			// Вставка годовой заявки
			// Если заявка на этот ремонт
			if (YearApplication::where('technical_resource_id', $technical_resource_id)->where('department_id', $department_id)->get()->count() > 0) {
		/*		// есть
				$application3 = YearApplication::where('plan_remont_id', $plan_remont_id)->latest()->first();
				$warehouse_date = $application3->application_date; */
			} else {
				// нет
				$data_app = [
					'department_id' => $department_id,
					'technical_resource_id' => $technical_resource_id,
					'unit_id' => 1,
					'quantity' => 0,
					'quantity_m1' => 0,
					'quantity_m2' => 0,
					'quantity_m3' => 0,
					'quantity_m4' => 0,
					'quantity_m5' => 0,
					'quantity_m6' => 0,
					'quantity_m7' => 0,
					'quantity_m8' => 0,
					'quantity_m9' => 0,
					'quantity_m10' => 0,
					'quantity_m11' => 0,
					'quantity_m12' => 0,
					'year' => 2023,
				];
				YearApplication::create($data_app);
			} 

    		$data = [
    			'id' => $i+1+1000,
    			'plan_remont_id' => $plan_remont_id,
    			'equipment_id' => $plan_remont->equipment_id,
    			'technical_resource_id' => $technical_resource_id,
    			'required_quantity' => $required_quantity,
    			'warehouse_number' => '№'.rand(1,1598),
    			'warehouse_date' => $warehouse_date,
    			'warehouse_quantity' => $warehouse_quantity,
    			'type_application' => 1,
    			'requirement_id' => $i+1,
    			'application_date' => $warehouse_date,
    			'declared_quantity' => $required_quantity - $warehouse_quantity,
    			'delivery_date' => date('Y-m-d', strtotime($plan_remont->remont_begin.'-5 day')),
    			'remont_begin' => $plan_remont->remont_begin
    		];

        	Application::create($data);
    	}
    }
}
