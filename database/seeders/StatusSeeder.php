<?php

namespace Database\Seeders;

use App\Models\ExecutionStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    	$data = [
    		[
    			'id' => 1,
    			'name' => 'оформляется заказ'
    		],
    		[
    			'id' => 11,
    			'name' => 'оформляется договор'
    		],
    		[
    			'id' => 21,
    			'name' => 'договор не оплачен'
    		],
    		[
    			'id' => 31,
    			'name' => 'договор исполняется'
    		],
    		[
    			'id' => 41,
    			'name' => 'изготовлен'
    		],
    		[
    			'id' => 51,
    			'name' => 'в пути на таможню'
    		],
    		[
    			'id' => 61,
    			'name' => 'на таможне'
    		],
    		[
    			'id' => 71,
    			'name' => 'в пути на объект'
    		],
    		[
    			'id' => 81,
    			'name' => 'исполнен'
    		],
    	];

    	foreach ($data as $key => $value) {
    		ExecutionStatus::create($value);
    	}
    }
}
