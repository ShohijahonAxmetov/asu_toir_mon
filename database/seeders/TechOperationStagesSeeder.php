<?php

namespace Database\Seeders;

use App\Models\TechMaps\TechOperationStage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechOperationStagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(TechOperationStage::count() == 0) DB::table('tech_operation_stages')->insert([
            [
                'title' => 'Подготовительные работы',
                'desc' => 'Проверка, отключение оборудования, подготовка инструментов',
            ],
            [
                'title' => 'Основные работы',
                'desc' => 'Выполнение ключевых технических операций',
            ],
            [
                'title' => 'Заключительные работы',
                'desc' => 'Тестирование и ввод в эксплуатацию',
            ],
        ]);
    }
}
