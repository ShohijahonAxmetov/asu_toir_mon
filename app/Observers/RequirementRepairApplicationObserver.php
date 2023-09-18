<?php

namespace App\Observers;

use App\Models\Application;
use App\Models\PlanRemont;
use App\Models\RequirementRepairApplication;
use App\Models\RepairApplication;

class RequirementRepairApplicationObserver
{
    /**
     * Handle the RequirementRepairApplication "created" event.
     */
    public function created(RequirementRepairApplication $requirementRepairApplication): void
    {
        $data = $this->getArr($requirementRepairApplication);

        try {
//            sozdanie obshego zapisa zayavok
            Application::create($data);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Handle the RequirementRepairApplication "updated" event.
     */
    public function updated(RequirementRepairApplication $requirementRepairApplication): void
    {
        $data = $this->getArr($requirementRepairApplication);

        try {
//            obnovit dannie obshey tablici
            Application::where([
                ['requirement_id', $requirementRepairApplication->id],
                ['type_application', 2]
            ])
                ->first()
                ->update($data);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Handle the RequirementRepairApplication "deleted" event.
     */
    public function deleted(RequirementRepairApplication $requirementRepairApplication): void
    {
        try {
            Application::where([
                ['requirement_id',$requirementRepairApplication->id],
                ['type_application', 2]
            ])
                ->first()
                ->delete();

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Handle the RequirementYearApplication "restored" event.
     */
    public function restored(RequirementYearApplication $requirementYearApplication): void
    {
        //
    }

    /**
     * Handle the RequirementYearApplication "force deleted" event.
     */
    public function forceDeleted(RequirementYearApplication $requirementYearApplication): void
    {
        //
    }

    /**
     * @param RequirementRepairApplication $requirementRepairApplication
     * @return array
     */
    public function getArr(RequirementRepairApplication $requirementRepairApplication): array
    {
        $data = $requirementRepairApplication->toArray();
        $data['type_application'] = 2;
        $data['requirement_id'] = $data['id'];

        $data['plan_remont_id'] = $requirementRepairApplication->repairApplication->plan_remont_id;
        $data['equipment_id'] = $requirementRepairApplication->repairApplication->equipment_id;
        $data['application_date'] = $requirementRepairApplication->repairApplication->application_date;
        $data['remont_begin'] = $requirementRepairApplication->repairApplication->planRemont->remont_begin;


        return $data;

//	4	technical_resource_id Индекс	bigint		UNSIGNED	Нет	Нет			Изменить	Удалить	
//	5	required_quantity	double(13,3)			Нет	Нет			Изменить	Удалить	
//	6	warehouse_number	varchar(255)	utf8mb4_unicode_ci		Да	NULL			Изменить	Удалить	
//	7	warehouse_date	date			Да	NULL			Изменить	Удалить	
//	8	warehouse_quantity	double(13,3)			Да	NULL			Изменить	Удалить	
//	12	declared_quantity	double(13,3)			Нет	Нет			Изменить	Удалить	
//	13	delivery_date	date			Нет	Нет			Изменить	Удалить	

/*
    'repair_application_id',
    'technical_resource_id',
    'required_quantity',
    'warehouse_number',
    'warehouse_date',
    'warehouse_quantity',
    'declared_quantity',
    'delivery_date'
*/

    }
}
