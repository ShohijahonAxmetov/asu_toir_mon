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
        for($i=0; $i<500; $i++) {
        	$application_id = rand(1,999);
        	$application = Application::find($application_id);
        	$contract_date = date('Y-m-d', strtotime($application->application_date.'+'.rand(1,20).' days'));
        	$local_foreign = rand(1,2);
        	$date_manufacture_contract = date('Y-m-d', strtotime($contract_date.'+'.rand(1,20).' days'));
        	$date_manufacture_fact = date('Y-m-d', strtotime($date_manufacture_contract.'+'.rand(0,20).' days'));
        	$customs_date_receipt = null;
        	$customs_date_exit = null;
        	$date_delivery_object = date('Y-m-d', strtotime($date_manufacture_fact.'+'.rand(0,5).' days'));
        	if($local_foreign == 2) {
        		$customs_date_receipt = date('Y-m-d', strtotime($date_manufacture_fact.'+'.rand(0, 4).' days'));
        		$customs_date_exit = date('Y-m-d', strtotime($customs_date_receipt.'+'.rand(0, 7).' days'));
        		$date_delivery_object = date('Y-m-d', strtotime($customs_date_exit.'+'.rand(0, 5).' days'));
        	}

        	$data = [
        		'application_id' => $application_id,
        		'order_number' => '№ '.rand(1564,5486451),
        		'order_date' => date('Y-m-d', strtotime($application->application_date.'+'.rand(0,60).' day')),
        		'order_quantity' => $application->declared_quantity,
        		'contract_number' => '№ '.rand(1564,5486451),
        		'contract_date' => $contract_date,
        		'local_foreign' => $local_foreign,
        		'date_manufacture_contract' => $date_manufacture_contract,
        		'date_manufacture_fact' => $date_manufacture_fact,
        		'customs_date_receipt' => $customs_date_receipt,
        		'customs_date_exit' => $customs_date_exit,
        		'date_delivery_object' => $date_delivery_object,
        		'application_id' => $application_id,
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
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 2) $status_id = 4;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 2 && !is_null($data['customs_date_receipt'])) $status_id = 5;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 2 && !is_null($data['customs_date_receipt']) && !is_null($data['customs_date_exit'])) $status_id = 6;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 2 && !is_null($data['customs_date_receipt']) && !is_null($data['customs_date_exit']) && !is_null($data['date_delivery_object'])) $status_id = 7;

        return $status_id;
    }
}
