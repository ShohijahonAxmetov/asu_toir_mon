<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\OrderResource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderResourceSeeder extends Seeder
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

/* Оригинал
        for($i=0; $i<2000; $i++) {
        	$application_id = rand(1,1999);
        	$application = Application::find($application_id);
            $order_date = date('Y-m-d', strtotime($application->application_date.'+'.rand(0,10).' day')); // заказ - 60

            $contract_number = '№ '.rand(1564,5486451);
        	$contract_date = date('Y-m-d', strtotime($order_date.'+'.rand(1,10).' days')); // контракт - 60
        	$local_foreign = rand(1,2);
        	$date_manufacture_contract = date('Y-m-d', strtotime($contract_date.'+'.rand(1,30).' days'));
        	$date_manufacture_fact = date('Y-m-d', strtotime($contract_date.'+'.rand(0,30).' days'));
        	$customs_date_receipt = null;
        	$customs_date_exit = null;
        	$date_delivery_object = date('Y-m-d', strtotime($date_manufacture_fact.'+'.rand(0,10).' days')); // 15
        	if($local_foreign == 2) {
        		$customs_date_receipt = date('Y-m-d', strtotime($date_manufacture_fact.'+'.rand(0, 4).' days'));
        		$customs_date_exit = date('Y-m-d', strtotime($customs_date_receipt.'+'.rand(0, 7).' days'));
        		$date_delivery_object = date('Y-m-d', strtotime($customs_date_exit.'+'.rand(0, 10).' days'));  //30
        	}

            $day_sum = (strtotime(date('Y-m-d')) - strtotime($application->application_date)) / (24*60*60);
            if ($day_sum > 30 && $application->application_type == 1) {
                $rand_status = 7;
                $contract_number = $day_sum;
            } else {
                $rand_status = rand(2,7);
                $contract_number = $day_sum;
            }

            

            switch ($rand_status) {
                case 2:
                    $contract_number = null;
                    $contract_date = null;
                    $local_foreign = null;
                    $date_manufacture_contract = null;
                    $date_manufacture_fact = null;
                    $customs_date_receipt = null;
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 3:
                    $date_manufacture_fact = null;
                    $customs_date_receipt = null;
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 4:
                    $customs_date_receipt = null;
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 5:
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 6:
                    $date_delivery_object = null;
                    break;
            }

        	$data = [
        		'application_id' => $application_id,
        		'order_number' => '№ '.rand(1564,5486451),
        		'order_date' => $order_date,
        		'order_quantity' => $application->declared_quantity,
        		'contract_number' => $contract_number,
        		'contract_date' => $contract_date,
        		'local_foreign' => $local_foreign,
        		'date_manufacture_contract' => $date_manufacture_contract,
        		'date_manufacture_fact' => $date_manufacture_fact,
        		'customs_date_receipt' => $customs_date_receipt,
        		'customs_date_exit' => $customs_date_exit,
        		'date_delivery_object' => $date_delivery_object,
        	];
        	$data['execution_statuse_id'] = $this->setStatus($data);

        	OrderResource::create($data);
        } */
		

        for($i=0; $i<2000; $i++) {
        	$application_id = $i + 1;
        	$application = Application::find($application_id);
			
            $order_date = date('Y-m-d', strtotime($application->application_date.'+'.rand(0,10).' day')); // заказ - 60

            $contract_number = '№ '.rand(1564,5486451);
        	$contract_date = date('Y-m-d', strtotime($order_date.'+'.rand(1,10).' days')); // контракт - 60
        	$local_foreign = rand(1,2);
        	$date_manufacture_contract = date('Y-m-d', strtotime($contract_date.'+'.rand(1,30).' days'));
        	$date_manufacture_fact = date('Y-m-d', strtotime($contract_date.'+'.rand(0,30).' days'));
            $exit_date = date('Y-m-d', strtotime($date_manufacture_fact.'+'.rand(0,3).' days'));
        	$customs_date_receipt = null;
        	$customs_date_exit = null;
        	$date_delivery_object = date('Y-m-d', strtotime($date_manufacture_fact.'+'.rand(0,10).' days')); // 15
        	if($local_foreign == 2) {
        		$customs_date_receipt = date('Y-m-d', strtotime($date_manufacture_fact.'+'.rand(0, 4).' days'));
        		$customs_date_exit = date('Y-m-d', strtotime($customs_date_receipt.'+'.rand(0, 7).' days'));
        		$date_delivery_object = date('Y-m-d', strtotime($customs_date_exit.'+'.rand(0, 10).' days'));  //30
        	}

            $day_sum = (strtotime(date('Y-m-d')) - strtotime($application->remont_begin)) / (24*60*60);
			/* или
            $day_sum = (strtotime($application->delivery_date) - strtotime($order_date)) / (24*60*60);
			*/
			
            if ($day_sum > 60 ) {
//                if ($day_sum > 30 && $application->application_type == 1) {
                $rand_status = 7;
                $contract_number = $day_sum;
            } else {
                $rand_status = rand(2,7);
                $contract_number = $day_sum;
            }

            
			$order_number = '№ '.rand(1564,5486451);

            switch ($rand_status) {
                case 1:
					$order_number = null;
					$order_date = null;
                    $contract_number = null;
                    $contract_date = null;
                    $local_foreign = null;
                    $date_manufacture_contract = null;
                    $date_manufacture_fact = null;
                    $exit_date = null;
                    $customs_date_receipt = null;
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 2:
                    $contract_number = null;
                    $contract_date = null;
                    $local_foreign = null;
                    $date_manufacture_contract = null;
                    $date_manufacture_fact = null;
                    $exit_date = null;
                    $customs_date_receipt = null;
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 3:
                    $date_manufacture_fact = null;
                    $exit_date = null;
                    $customs_date_receipt = null;
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 4:
                    $customs_date_receipt = null;
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 5:
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 6:
                    $date_delivery_object = null;
                    break;
            }

        	$data = [
        		'application_id' => $application_id,
        		'order_number' => $order_number,
        		'order_date' => $order_date,
        		'order_quantity' => $application->declared_quantity,
        		'contract_number' => $contract_number,
        		'contract_date' => $contract_date,
        		'local_foreign' => $local_foreign,
        		'date_manufacture_contract' => $date_manufacture_contract,
        		'date_manufacture_fact' => $date_manufacture_fact,
                'exit_date' => $exit_date,
        		'customs_date_receipt' => $customs_date_receipt,
        		'customs_date_exit' => $customs_date_exit,
        		'date_delivery_object' => $date_delivery_object,
        	];
        	$data['execution_statuse_id'] = $this->setStatus($data);

        	OrderResource::create($data);
        } 
		
    }

    public function setStatus($data)
    {
        $status_id = 0;

        if(is_null($data['contract_number'])) $status_id = 2;
        if(!is_null($data['contract_number']) && is_null($data['date_manufacture_fact'])) $status_id = 3;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 1) $status_id = 6;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 1 && !is_null($data['date_delivery_object'])) $status_id = 7;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && !is_null($data['exit_date']) && $data['local_foreign'] == 2) $status_id = 4;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 2 && !is_null($data['customs_date_receipt'])) $status_id = 5;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 2 && !is_null($data['customs_date_receipt']) && !is_null($data['customs_date_exit'])) $status_id = 6;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 2 && !is_null($data['customs_date_receipt']) && !is_null($data['customs_date_exit']) && !is_null($data['date_delivery_object'])) $status_id = 7;

        return $status_id;
    }
}
