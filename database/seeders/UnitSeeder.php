<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
        	'тонна (т)',
        	'килограмм (кг)',
        	'грамм (г)',
        	'метр (м)',
        	'сантиметр (см)',
        	'миллиметр (мм)',
        	'кубический метр (м³)',
        	'литр (л)',
        	'квадратный метр (м²)',
        	'штука (шт)',
        	'комплект (компл)'
        ];

        if (Unit::count() == 0) foreach ($data as $item) {
        	Unit::create(['name' => $item]);
        }
    }
}
