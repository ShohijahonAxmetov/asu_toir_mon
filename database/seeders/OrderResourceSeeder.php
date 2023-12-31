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
            if (in_array($i, [1998, 1990, 1982, 1970, 1960, 1950, 1932, 1918, 1890, 1872, 
            1858, 1845, 1832, 1821, 1805, 1789, 1775, 1690, 1682, 1670, 1660, 1650, 1632, 1518, 1590, 1582, 1570, 1560, 1550, 1532, 1518, 
            1490, 1482, 1470, 1460, 1450, 1432, 1418] ) && $application->application_type != 1) {
                continue;
            }
        	$application_id = $i + 1;
        	$application = Application::find($application_id);
			
            $order_date = date('Y-m-d', strtotime($application->application_date.'+'.rand(0,10).' day')); // заказ - 60

            $contract_number = '№ '.rand(1564,5486451);
        	$contract_date = date('Y-m-d', strtotime($order_date.'+'.rand(1,10).' days')); // контракт - 60
        	$local_foreign = rand(1,2);
        	$payment_date = date('Y-m-d', strtotime($contract_date.'+'.rand(1,10).' days'));
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
                $rand_status = $this->end_status_id();
            } else {
                $rand_status = rand(2,8);
            }

            
			$order_number = '№ '.rand(1564,5486451);

            switch ($rand_status) {
     //            case 1:
					// $order_number = null;
					// $order_date = null;
     //                $contract_number = null;
     //                $contract_date = null;
     //                $local_foreign = null;
     //                $date_manufacture_contract = null;
     //                $date_manufacture_fact = null;
     //                $exit_date = null;
     //                $customs_date_receipt = null;
     //                $customs_date_exit = null;
     //                $date_delivery_object = null;
     //                break;
                case 2:
                    $contract_number = null;
                    $contract_date = null;
                    $local_foreign = null;
                    $date_manufacture_contract = null;
                    $payment_date = null;
                    $date_manufacture_fact = null;
                    $exit_date = null;
                    $customs_date_receipt = null;
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 3:
                    $payment_date = null;
                    $date_manufacture_fact = null;
                    $exit_date = null;
                    $customs_date_receipt = null;
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 4:
                    $date_manufacture_fact = null;
                    $exit_date = null;
                    $customs_date_receipt = null;
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 5:
                    $exit_date = null;
                    $customs_date_receipt = null;
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 6:
                    $customs_date_receipt = null;
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 7:
                    $customs_date_exit = null;
                    $date_delivery_object = null;
                    break;
                case 8:
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
                'payment_date' => $payment_date,
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

        // оформляется договор
        if(is_null($data['contract_number'])) $status_id = $this->statuses_list()[2];

        // договор неоплачен
        if(!is_null($data['contract_number']) && is_null($data['payment_date'])) $status_id = $this->statuses_list()[3];

        // договор исполняется
        if(!is_null($data['contract_number']) && !is_null($data['payment_date']) && is_null($data['date_manufacture_fact'])) $status_id = $this->statuses_list()[4];

        //  в пути на объект (в пути после таможни)
        if(!is_null($data['contract_number']) && !is_null($data['payment_date']) && !is_null($data['date_manufacture_fact']) && !is_null($data['exit_date']) && $data['local_foreign'] == 1) $status_id = $this->statuses_list()[8];

        // исполнен + местный
        if(!is_null($data['contract_number']) && !is_null($data['payment_date']) && !is_null($data['date_manufacture_fact']) && !is_null($data['exit_date']) && $data['local_foreign'] == 1 && !is_null($data['date_delivery_object'])) $status_id = $this->end_status_id();

        // изготовлен
        if(!is_null($data['contract_number']) && !is_null($data['payment_date']) && !is_null($data['date_manufacture_fact']) && is_null($data['exit_date'])) $status_id = $this->statuses_list()[5];

        // в пути + зарубежный
        if(!is_null($data['contract_number']) && !is_null($data['payment_date']) && !is_null($data['date_manufacture_fact']) && !is_null($data['exit_date']) && $data['local_foreign'] == 2) $status_id = $this->statuses_list()[6];

        // на таможне + зарубежный
        if(!is_null($data['contract_number']) && !is_null($data['payment_date']) && !is_null($data['date_manufacture_fact']) && !is_null($data['exit_date']) && $data['local_foreign'] == 2 && !is_null($data['customs_date_receipt'])) $status_id = $this->statuses_list()[7];

        // в пути после таможни + зарубежный
        if(!is_null($data['contract_number']) && !is_null($data['payment_date']) && !is_null($data['date_manufacture_fact']) && !is_null($data['exit_date']) && $data['local_foreign'] == 2 && !is_null($data['customs_date_receipt']) && !is_null($data['customs_date_exit'])) $status_id = $this->statuses_list()[8];

        //  исполнен + зарубежный
        if(!is_null($data['contract_number']) && !is_null($data['payment_date']) && !is_null($data['date_manufacture_fact']) && !is_null($data['exit_date']) && $data['local_foreign'] == 2 && !is_null($data['customs_date_receipt']) && !is_null($data['customs_date_exit']) && !is_null($data['date_delivery_object'])) $status_id = $this->end_status_id();

        return $status_id;
    }

    public function statuses_list(): array
    {
        $statuses_list = [
            2 => 11,
            3 => 21,
            4 => 31,
            5 => 41,
            6 => 51,
            7 => 61,
            8 => 71

        ];

        return $statuses_list;
    }

    public function end_status_id()
    {
         return 81;
    }
}
