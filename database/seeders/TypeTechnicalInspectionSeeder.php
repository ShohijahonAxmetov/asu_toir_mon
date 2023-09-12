<?php

namespace Database\Seeders;

use App\Models\TypeTechnicalInspection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeTechnicalInspectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Первое техническое обслуживание',
                'key' => 'hours',
                'value' => 250
            ],
            [
                'id' => 2,
                'name' => 'Второе техническое обслуживание',
                'key' => 'hours',
                'value' => 500
            ],
            [
                'id' => 3,
                'name' => 'Третое техническое обслуживание',
                'key' => 'hours',
                'value' => 1000
            ],
            [
                'id' => 4,
                'name' => 'Сезонное техническое обслуживание (СО)',
                'key' => 'month',
                'value' => 6
            ],
            [
                'id' => 5,
                'name' => 'Регламентированный ремонт - ПР-1',
                'key' => 'hours',
                'value' => 5000
            ],
            [
                'id' => 6,
                'name' => 'Регламентированный ремонт - ПР-2',
                'key' => 'hours',
                'value' => 8000
            ],
            [
                'id' => 7,
                'name' => 'Капитальный ремонт - КР',
                'key' => 'hours',
                'value' => 50000
            ]
        ];

        foreach ($data as $item) {
            if(!TypeTechnicalInspection::find($item['id'])) TypeTechnicalInspection::create($item);
        }
    }
}
