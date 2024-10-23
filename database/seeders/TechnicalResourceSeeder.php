<?php

namespace Database\Seeders;

use App\Models\TechnicalResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnicalResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (TechnicalResource::count() == 0) {
        	DB::table('technical_resources')->insert([
	            [
	                // 'tech_operation_id' => 1,
	                // 'unit' => 'л',
	                'id' => 1,
	                'unit_id' => 8,
	                'catalog_name' => 'Очиститель',
	                'catalog_number' => 'CLEAN-001',
	                'nomen_name' => 'Очиститель для техники',
	                'nomen_number' => 'NOM-101',
	                'time_complete_order' => 1, // 1 час
	                'delivery_time' => 3 // 3 дня
	            ],
	            [
	                // 'tech_operation_id' => 1,
	                // 'unit' => 'шт',
	                'id' => 2,
	                'unit_id' => 10,
	                'catalog_name' => 'Перчатки',
	                'catalog_number' => 'GLOVES-002',
	                'nomen_name' => 'Защитные перчатки',
	                'nomen_number' => 'NOM-102',
	                'time_complete_order' => 1,
	                'delivery_time' => 2
	            ],
	            [
	                // 'tech_operation_id' => 2,
	                // 'unit' => 'л',
	                'id' => 3,
	                'unit_id' => 8,
	                'catalog_name' => 'Тормозная жидкость',
	                'catalog_number' => 'BRAKEFLUID-003',
	                'nomen_name' => 'Тормозная жидкость',
	                'nomen_number' => 'NOM-103',
	                'time_complete_order' => 1,
	                'delivery_time' => 2
	            ],
	            [
	                // 'tech_operation_id' => 3,
	                // 'unit' => 'шт',
	                'id' => 4,
	                'unit_id' => 10,
	                'catalog_name' => 'Защитные очки',
	                'catalog_number' => 'GOGGLES-004',
	                'nomen_name' => 'Защитные очки',
	                'nomen_number' => 'NOM-104',
	                'time_complete_order' => 1,
	                'delivery_time' => 1
	            ],
	            [
	                // 'tech_operation_id' => 4,
	                // 'unit' => 'кг',
	                'id' => 5,
	                'unit_id' => 2,
	                'catalog_name' => 'Смазка',
	                'catalog_number' => 'LUBRICANT-005',
	                'nomen_name' => 'Смазка для механизмов',
	                'nomen_number' => 'NOM-105',
	                'time_complete_order' => 1,
	                'delivery_time' => 3
	            ],
	            [
	                // 'tech_operation_id' => 5,
	                // 'unit' => 'шт',
	                'id' => 6,
	                'unit_id' => 10,
	                'catalog_name' => 'Подшипники',
	                'catalog_number' => 'BEARINGS-006',
	                'nomen_name' => 'Подшипники для дробилки',
	                'nomen_number' => 'NOM-106',
	                'time_complete_order' => 1,
	                'delivery_time' => 4
	            ],
	            [
	                // 'tech_operation_id' => 6,
	                // 'unit' => 'м',
	                'id' => 7,
	                'unit_id' => 4,
	                'catalog_name' => 'Трос',
	                'catalog_number' => 'ROPE-007',
	                'nomen_name' => 'Гидравлический трос',
	                'nomen_number' => 'NOM-107',
	                'time_complete_order' => 1,
	                'delivery_time' => 5
	            ],
	            [
	                // 'tech_operation_id' => 7,
	                // 'unit' => 'л',
	                'id' => 8,
	                'unit_id' => 8,
	                'catalog_name' => 'Очиститель',
	                'catalog_number' => 'CLEANER-008',
	                'nomen_name' => 'Очиститель для экскаваторов',
	                'nomen_number' => 'NOM-108',
	                'time_complete_order' => 1,
	                'delivery_time' => 3
	            ],
	            [
	                // 'tech_operation_id' => 8,
	                // 'unit' => 'л',
	                'id' => 9,
	                'unit_id' => 8,
	                'catalog_name' => 'Гидравлическое масло',
	                'catalog_number' => 'HYDROIL-009',
	                'nomen_name' => 'Гидравлическое масло',
	                'nomen_number' => 'NOM-109',
	                'time_complete_order' => 1,
	                'delivery_time' => 3
	            ],
	            [
	                // 'tech_operation_id' => 9,
	                // 'unit' => 'шт',
	                'id' => 10,
	                'unit_id' => 10,
	                'catalog_name' => 'Датчик давления',
	                'catalog_number' => 'PRESSURE_SENSOR-010',
	                'nomen_name' => 'Датчик давления для гидравлики',
	                'nomen_number' => 'NOM-110',
	                'time_complete_order' => 1,
	                'delivery_time' => 2
	            ],
	            [
	                // 'tech_operation_id' => 10,
	                // 'unit' => 'кг',
	                'id' => 11,
	                'unit_id' => 2,
	                'catalog_name' => 'Смазка',
	                'catalog_number' => 'LUBRICANT-011',
	                'nomen_name' => 'Смазка для дробилки',
	                'nomen_number' => 'NOM-111',
	                'time_complete_order' => 1,
	                'delivery_time' => 3
	            ],
	            [
	                // 'tech_operation_id' => 11,
	                // 'unit' => 'шт',
	                'id' => 12,
	                'unit_id' => 10,
	                'catalog_name' => 'Щеки',
	                'catalog_number' => 'CHEEKS-012',
	                'nomen_name' => 'Щеки для дробилки',
	                'nomen_number' => 'NOM-112',
	                'time_complete_order' => 1,
	                'delivery_time' => 4
	            ],
	            [
	                // 'tech_operation_id' => 12,
	                // 'unit' => 'комплект',
	                'id' => 13,
	                'unit_id' => 11,
	                'catalog_name' => 'Запасные детали',
	                'catalog_number' => 'SPARE_PARTS-013',
	                'nomen_name' => 'Запасные детали для дробилки',
	                'nomen_number' => 'NOM-113',
	                'time_complete_order' => 1,
	                'delivery_time' => 5
	            ],
	        ]);

			// pivot таблицы
            DB::table('tech_operation_technical_resource')
                ->insert([
                    ['tech_operation_id' => 1, 'technical_resource_id' => 1, 'characteristics' => null, 'quantity' => 5, 'unit_id' => 8],
                    ['tech_operation_id' => '1', 'technical_resource_id' => '2', 'characteristics' => null, 'quantity' => '10', 'unit_id' => '10'],
                    ['tech_operation_id' => '2', 'technical_resource_id' => '3', 'characteristics' => null, 'quantity' => '2', 'unit_id' => '8'],
                    ['tech_operation_id' => '3', 'technical_resource_id' => '4', 'characteristics' => null, 'quantity' => '5', 'unit_id' => '10'],
                    ['tech_operation_id' => '4', 'technical_resource_id' => '5', 'characteristics' => null, 'quantity' => '1', 'unit_id' => '2'],
                    ['tech_operation_id' => '5', 'technical_resource_id' => '6', 'characteristics' => null, 'quantity' => '4', 'unit_id' => '10'],
                    ['tech_operation_id' => '6', 'technical_resource_id' => '7', 'characteristics' => null, 'quantity' => '1', 'unit_id' => '4'],
                    ['tech_operation_id' => '7', 'technical_resource_id' => '8', 'characteristics' => null, 'quantity' => '3', 'unit_id' => '8'],
                    ['tech_operation_id' => '8', 'technical_resource_id' => '9', 'characteristics' => null, 'quantity' => '10', 'unit_id' => '8'],
                    ['tech_operation_id' => '9', 'technical_resource_id' => '10', 'characteristics' => null, 'quantity' => '1', 'unit_id' => '10'],
                    ['tech_operation_id' => '10', 'technical_resource_id' => '11', 'characteristics' => null, 'quantity' => '2', 'unit_id' => '2'],
                    ['tech_operation_id' => '11', 'technical_resource_id' => '12', 'characteristics' => null, 'quantity' => '2', 'unit_id' => '10'],
                    ['tech_operation_id' => '12', 'technical_resource_id' => '13', 'characteristics' => null, 'quantity' => '1', 'unit_id' => '11'],
                ]);
		}
    }
}
