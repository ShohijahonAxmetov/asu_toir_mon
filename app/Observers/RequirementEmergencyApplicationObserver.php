<?php

namespace App\Observers;

use App\Models\Application;
use App\Models\PlanRemont;
use App\Models\RequirementEmergencyApplication;
use App\Models\EmergencyApplication;

class RequirementEmergencyApplicationObserver
{
    /**
     * Handle the RequirementEmergencyApplication "created" event.
     */
    public function created(RequirementEmergencyApplication $requirementEmergencyApplication): void
    {
        $data = $this->getArr($requirementEmergencyApplication);

        try {
//            sozdanie obshego zapisa zayavok
            Application::create($data);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Handle the RequirementEmergencyApplication "updated" event.
     */
    public function updated(RequirementEmergencyApplication $requirementEmergencyApplication): void
    {
        $data = $this->getArr($requirementEmergencyApplication);

        try {
//            obnovit dannie obshey tablici
            Application::where([
                ['requirement_id', $requirementEmergencyApplication->id],
                ['type_application', 3]
            ])
                ->first()
                ->update($data);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Handle the RequirementEmergencyApplication "deleted" event.
     */
    public function deleted(RequirementEmergencyApplication $requirementEmergencyApplication): void
    {
        try {
            Application::where([
                ['requirement_id',$requirementEmergencyApplication->id],
                ['type_application', 3]
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
     * @param RequirementEmergencyApplication $requirementEmergencyApplication
     * @return array
     */
    public function getArr(RequirementEmergencyApplication $requirementEmergencyApplication): array
    {
        $data = $requirementEmergencyApplication->toArray();
        $data['type_application'] = 3;
        $data['requirement_id'] = $data['id'];

        $data['plan_remont_id'] = $requirementEmergencyApplication->emergencyApplication->plan_remont_id;
        $data['equipment_id'] = $requirementEmergencyApplication->emergencyApplication->equipment_id;
        $data['application_date'] = $requirementEmergencyApplication->emergencyApplication->application_date;
        $data['remont_begin'] = $requirementEmergencyApplication->emergencyApplication->planRemont->remont_begin;


        return $data;

    }
}
