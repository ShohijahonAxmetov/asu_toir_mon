<?php

namespace Database\Seeders;

use App\Models\TechMaps\TechMap;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechMapsSeeder extends Seeder
{
    public function run(): void
    {
        // minimalnoe vremya remonta 4 chasa 0 minut, chtobi drugie dannie rabotali normalno
        if(TechMap::count() == 0) DB::table('tech_maps')->insert([
            [
                'tech_map_group_id' => 1,
                'title' => 'ТО-1 для шахтного погрузчика',
                'agreed_at' => '2024-01-20',
                'code' => 'TO-001',
                'hours' => 5,
                'minutes' => 0,
                'comments' => 'Первичное ТО погрузчика',
            ],
            [
                'tech_map_group_id' => 1,
                'title' => 'Капитальный ремонт подъёмного механизма',
                'agreed_at' => '2024-03-10',
                'code' => 'RM-002',
                'hours' => 16,
                'minutes' => 30,
                'comments' => 'Полный ремонт подъёмного механизма',
            ],
            [
                'tech_map_group_id' => 2,
                'title' => 'ТО экскаватора ЭКГ-5',
                'agreed_at' => '2024-02-25',
                'code' => 'TO-003',
                'hours' => 6,
                'minutes' => 0,
                'comments' => 'Регламентное обслуживание экскаватора',
            ],
            [
                'tech_map_group_id' => 2,
                'title' => 'Замена гидравлического цилиндра',
                'agreed_at' => '2024-03-05',
                'code' => 'RM-004',
                'hours' => 4,
                'minutes' => 15,
                'comments' => 'Замена гидравлического цилиндра экскаватора',
            ],
            [
                'tech_map_group_id' => 3,
                'title' => 'Ремонт щековой дробилки СМД-118',
                'agreed_at' => '2024-04-12',
                'code' => 'RM-005',
                'hours' => 8,
                'minutes' => 45,
                'comments' => 'Полный ремонт щековой дробилки',
            ],
            [
                'tech_map_group_id' => 3,
                'title' => 'Ремонт молотковой дробилки',
                'agreed_at' => '2024-05-01',
                'code' => 'RM-006',
                'hours' => 7,
                'minutes' => 30,
                'comments' => 'Ремонт молотков и ротора дробилки',
            ],
            [
                'tech_map_group_id' => 4,
                'title' => 'ТО ленты конвейера ЛТ-1000',
                'agreed_at' => '2024-06-10',
                'code' => 'TO-007',
                'hours' => 4,
                'minutes' => 0,
                'comments' => 'Техническое обслуживание конвейерной ленты',
            ],
        ]);
    }
}
