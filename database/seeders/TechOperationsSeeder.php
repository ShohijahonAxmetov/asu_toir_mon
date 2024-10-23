<?php

namespace Database\Seeders;

use App\Models\TechMaps\TechOperation;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechOperationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (TechOperation::count() == 0) DB::table('tech_operations')->insert([
            // Операции для ТО-1 шахтного погрузчика
            [
                'id' => 1,
                'tech_operation_stage_id' => 1,
                'title' => 'Отключение и очистка погрузчика',
                'full_title' => 'Проверка и очистка перед обслуживанием',
                'hours' => 1,
                'minutes' => 30,
                'amount' => 500000,
                'content' => 'Очистка поверхностей, снятие защитных кожухов',
                'comments' => NULL,
            ],
            [
                'id' => 2,
                'tech_operation_stage_id' => 2,
                'title' => 'Проверка тормозной системы',
                'full_title' => 'Диагностика и регулировка тормозов',
                'hours' => 2,
                'minutes' => 30,
                'amount' => 1000000,
                'content' => 'Регулировка тормозных колодок и уровней жидкости',
                'comments' => 'Необходимо использование специальных инструментов',
            ],
            [
                'id' => 3,
                'tech_operation_stage_id' => 3,
                'title' => 'Тестирование тормозной системы',
                'full_title' => 'Тест тормозов после обслуживания',
                'hours' => 1,
                'minutes' => 0,
                'amount' => 600000,
                'content' => 'Проверка на безопасность',
                'comments' => 'Тест проводится при полной загрузке',
            ],

            // Операции для капремонта подъёмного механизма
            [
                'id' => 4,
                'tech_operation_stage_id' => 1,
                'title' => 'Демонтаж узлов подъёмника',
                'full_title' => 'Снятие подшипников, тросов и барабанов',
                'hours' => 3,
                'minutes' => 0,
                'amount' => 2000000,
                'content' => 'Снятие всех основных узлов',
                'comments' => 'Использовать механический подъёмник',
            ],
            [
                'id' => 5,
                'tech_operation_stage_id' => 2,
                'title' => 'Замена подшипников и тросов',
                'full_title' => 'Установка новых подшипников и тросов',
                'hours' => 11,
                'minutes' => 0,
                'amount' => 3500000,
                'content' => 'Установка сертифицированных деталей',
                'comments' => 'Следить за правильной посадкой деталей',
            ],
            [
                'id' => 6,
                'tech_operation_stage_id' => 3,
                'title' => 'Проверка грузоподъемности',
                'full_title' => 'Тест с грузом на максимальной нагрузке',
                'hours' => 2,
                'minutes' => 30,
                'amount' => 1200000,
                'content' => 'Грузоподъемность до 10 тонн',
                'comments' => 'Протестировать перед вводом в эксплуатацию',
            ],

            // Операции для ТО экскаватора ЭКГ-5
            [
                'id' => 7,
                'tech_operation_stage_id' => 1,
                'title' => 'Очистка и проверка узлов экскаватора',
                'full_title' => 'Очистка и визуальный осмотр',
                'hours' => 2,
                'minutes' => 0,
                'amount' => 700000,
                'content' => 'Очистка от грязи, масла и проверка узлов',
                'comments' => NULL,
            ],
            [
                'id' => 8,
                'tech_operation_stage_id' => 2,
                'title' => 'Замена гидравлического масла',
                'full_title' => 'Замена масла в гидравлической системе',
                'hours' => 3,
                'minutes' => 0,
                'amount' => 1500000,
                'content' => 'Полная замена масла с фильтрацией системы',
                'comments' => 'Не допустить попадания воздуха в систему',
            ],
            [
                'id' => 9,
                'tech_operation_stage_id' => 3,
                'title' => 'Тестирование гидравлики',
                'full_title' => 'Проверка давления и уровня жидкости',
                'hours' => 1,
                'minutes' => 0,
                'amount' => 800000,
                'content' => 'Проверка всех систем под давлением',
                'comments' => NULL,
            ],

            // Операции для ремонта щековой дробилки
            [
                'id' => 10,
                'tech_operation_stage_id' => 1,
                'title' => 'Демонтаж щек',
                'full_title' => 'Снятие изношенных щек и ротора',
                'hours' => 2,
                'minutes' => 30,
                'amount' => 1800000,
                'content' => 'Демонтаж с использованием специнструмента',
                'comments' => NULL,
            ],
            [
                'id' => 11,
                'tech_operation_stage_id' => 2,
                'title' => 'Установка новых щек',
                'full_title' => 'Монтаж новых щек и ротора',
                'hours' => 4,
                'minutes' => 45,
                'amount' => 2200000,
                'content' => 'Монтаж с последующей регулировкой',
                'comments' => 'Использовать калибровочный инструмент',
            ],
            [
                'id' => 12,
                'tech_operation_stage_id' => 3,
                'title' => 'Тестирование щековой дробилки',
                'full_title' => 'Проверка работоспособности щек и ротора',
                'hours' => 1,
                'minutes' => 30,
                'amount' => 900000,
                'content' => 'Тестирование при полной загрузке',
                'comments' => NULL,
            ],
        ]);
    }
}
