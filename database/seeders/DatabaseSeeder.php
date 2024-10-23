<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,

            // для техкарт
            TechMapGroupsSeeder::class,
	        TechMapsSeeder::class,
	        TechOperationStagesSeeder::class,
	        TechOperationsSeeder::class,
            TechMapOperationSeeder::class,

	        // справочники
	        InstrumentSeeder::class,
	        QualificationSeeder::class,
	        RepairEquipmentSeeder::class,
	        UnitSeeder::class,
            TechnicalResourceSeeder::class,

	        // другие
	        StatusSeeder::class,
            RepairSeeder::class,
            RepairLogSeeder::class,
       		// TypeTechnicalInspectionSeeder::class,
       		// EquipmentSeeder::class,
        ]);
    }
}
