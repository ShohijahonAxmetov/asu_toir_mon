<?php

namespace Database\Seeders;

use App\Models\TechMaps\TechMapGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechMapGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (TechMapGroup::count() == 0) DB::table('tech_map_groups')->insert([
            [
                'title' => 'Горно-шахтное оборудование',
                'desc' => 'Техкарты для горно-шахтных машин и механизмов',
            ],
            [
                'title' => 'Экскаваторы',
                'desc' => 'Техкарты для обслуживания экскаваторов и карьерной техники',
            ],
            [
                'title' => 'Дробильно-размольное оборудование',
                'desc' => 'Техкарты для ремонта дробилок и мельниц',
            ],
            [
                'title' => 'Конвейеры',
                'desc' => 'Техкарты для лентопротяжных машин и транспортировочных систем',
            ],
        ]);
    }
}
