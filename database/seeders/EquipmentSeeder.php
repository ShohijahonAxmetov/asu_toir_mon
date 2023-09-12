<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Detail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $details = [
            'Двигатель',
            'Пневмосистема',
            'Ходовая часть, рама, платформа',
            'Механические передачи',
            'Гидравлическое оборудование',
            'Электрические машины',
            'Электрические цепи и  аппараты',
            'Смазочно-очистные и крепежные работы',
        ];

        for ($i=0; $i<20; $i++) {
            Equipment::create([
                'id' => $i+1,
                'name' => 'БЕЛАЗ-75303 №'.$i+1,
                'desc' => 'Opisanie oborudovaniya nomerom '.$i+1
            ]);

            foreach($details as $detail) {
                Detail::create([
                    'equipment_id' => $i+1,
                    'type_technical_inspection_id' => rand(1,7),
                    'name' => $detail,
                    'desc' => 'Opisanie detali',
                    'planned' => '2023-'.rand(1,11).'-'.rand(1,28)
                ]);
            }
        }
    }
}
