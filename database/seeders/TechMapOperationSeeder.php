<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechMapOperationSeeder extends Seeder
{
    public function run(): void
    {
    	if (DB::table('tech_map_operations')->count() == 0) DB::table('tech_map_operations')
    		->insert([
    			[
    				'tech_map_id' => 1,
    				'model' => 'App\Models\TechMaps\TechOperation',
    				'model_id' => 1,
    				'position' => 1,
    			],
    			[
    				'tech_map_id' => 1,
    				'model' => 'App\Models\TechMaps\TechOperation',
    				'model_id' => 2,
    				'position' => 2,
    			],
    			[
    				'tech_map_id' => 1,
    				'model' => 'App\Models\TechMaps\TechOperation',
    				'model_id' => 3,
    				'position' => 3,
    			],

    			[
    				'tech_map_id' => 2,
    				'model' => 'App\Models\TechMaps\TechOperation',
    				'model_id' => 4,
    				'position' => 1,
    			],
    			[
    				'tech_map_id' => 2,
    				'model' => 'App\Models\TechMaps\TechOperation',
    				'model_id' => 5,
    				'position' => 2,
    			],
    			[
    				'tech_map_id' => 2,
    				'model' => 'App\Models\TechMaps\TechOperation',
    				'model_id' => 6,
    				'position' => 3,
    			],

    			[
    				'tech_map_id' => 3,
    				'model' => 'App\Models\TechMaps\TechOperation',
    				'model_id' => 7,
    				'position' => 1,
    			],
    			[
    				'tech_map_id' => 3,
    				'model' => 'App\Models\TechMaps\TechOperation',
    				'model_id' => 8,
    				'position' => 2,
    			],
    			[
    				'tech_map_id' => 3,
    				'model' => 'App\Models\TechMaps\TechOperation',
    				'model_id' => 9,
    				'position' => 3,
    			],

    			[
    				'tech_map_id' => 5,
    				'model' => 'App\Models\TechMaps\TechOperation',
    				'model_id' => 10,
    				'position' => 1,
    			],
    			[
    				'tech_map_id' => 5,
    				'model' => 'App\Models\TechMaps\TechOperation',
    				'model_id' => 11,
    				'position' => 2,
    			],
    			[
    				'tech_map_id' => 5,
    				'model' => 'App\Models\TechMaps\TechOperation',
    				'model_id' => 12,
    				'position' => 3,
    			],
    		]);
    }
}
