<?php

namespace Database\Seeders;

use App\Models\Catalog\Qualification;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
        	'Слесарь по ремонту горного оборудования 3 разряда',
        	'Слесарь по ремонту горного оборудования 4 разряда',
        	'Слесарь по ремонту горного оборудования 5 разряда',
        	'Слесарь по ремонту горного оборудования 6 разряда',
        	'Электрослесарь по ремонту и обслуживанию горного оборудования 3 разряда',
        	'Электрослесарь по ремонту и обслуживанию горного оборудования 4 разряда',
        	'Электрослесарь по ремонту и обслуживанию горного оборудования 5 разряда',
        	'Электрослесарь по ремонту и обслуживанию горного оборудования 6 разряда',
        	'Сварщик по ремонту горного оборудования 3 разряда',
        	'Сварщик по ремонту горного оборудования 4 разряда',
        	'Сварщик по ремонту горного оборудования 5 разряда',
        	'Сварщик по ремонту горного оборудования 6 разряда',
        	'Токарь 3 разряда',
        	'Токарь 4 разряда',
        	'Токарь 5 разряда',
        	'Токарь 6 разряда',
        	'Автомеханик по ремонту горной техники 3 разряда',
        	'Автомеханик по ремонту горной техники 4 разряда',
        	'Автомеханик по ремонту горной техники 5 разряда',
        	'Автомеханик по ремонту горной техники 6 разряда',
        	'Инженер-механик по ремонту горного оборудования',
        	'Мастер по ремонту бурового и взрывного оборудования 4 разряда',
        	'Мастер по ремонту бурового и взрывного оборудования 5 разряда',
        	'Мастер по ремонту бурового и взрывного оборудования 6 разряда',
        	'Механик по карьерной технике 3 разряда',
        	'Механик по карьерной технике 4 разряда',
        	'Механик по карьерной технике 5 разряда',
        	'Механик по карьерной технике 6 разряда',
        ];

        $counter = 1;
        $dataNew = [];
        foreach ($data as $value) {
            $dataNew[$counter-1]['id'] = $counter;
            $dataNew[$counter-1]['title'] = $value;

            $counter ++;
        }

        if (Qualification::count() == 0) {
            foreach ($dataNew as $item) {
            	Qualification::create(['id' => $item['id'], 'title' => $item['title']]);
            }

            DB::table('qualification_tech_operation')->insert([
                ['tech_operation_id' => 1, 'qualification_id' => 17, 'characteristics' => null, 'count' => 1, 'hours' => 1, 'minutes' => 30],
                ['tech_operation_id' => 2, 'qualification_id' => 18, 'characteristics' => null, 'count' => 1, 'hours' => 2, 'minutes' => 0],
                ['tech_operation_id' => 3, 'qualification_id' => 19, 'characteristics' => null, 'count' => 1, 'hours' => 1, 'minutes' => 0],
                ['tech_operation_id' => 4, 'qualification_id' => 20, 'characteristics' => null, 'count' => 2, 'hours' => 3, 'minutes' => 0],
                ['tech_operation_id' => 5, 'qualification_id' => 17, 'characteristics' => null, 'count' => 1, 'hours' => 5, 'minutes' => 0],
                ['tech_operation_id' => 6, 'qualification_id' => 21, 'characteristics' => null, 'count' => 1, 'hours' => 2, 'minutes' => 0],
                ['tech_operation_id' => 7, 'qualification_id' => 18, 'characteristics' => null, 'count' => 1, 'hours' => 1, 'minutes' => 0],
                ['tech_operation_id' => 8, 'qualification_id' => 19, 'characteristics' => null, 'count' => 1, 'hours' => 2, 'minutes' => 0],
                ['tech_operation_id' => 9, 'qualification_id' => 21, 'characteristics' => null, 'count' => 1, 'hours' => 1, 'minutes' => 30],
                ['tech_operation_id' => 10, 'qualification_id' => 20, 'characteristics' => null, 'count' => 2, 'hours' => 2, 'minutes' => 30],
                ['tech_operation_id' => 11, 'qualification_id' => 17, 'characteristics' => null, 'count' => 1, 'hours' => 3, 'minutes' => 0],
                ['tech_operation_id' => 12, 'qualification_id' => 21, 'characteristics' => null, 'count' => 1, 'hours' => 1, 'minutes' => 0],
            ]);
        }
    }
}
