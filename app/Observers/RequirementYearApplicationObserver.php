<?php

namespace App\Observers;

use App\Models\Application;
use App\Models\PlanRemont;
use App\Models\RequirementYearApplication;
use App\Models\YearApplication;

class RequirementYearApplicationObserver
{
    /**
     * Handle the RequirementYearApplication "created" event.
     */
    public function created(RequirementYearApplication $requirementYearApplication): void
    {
        $data = $this->getArr($requirementYearApplication);

        try {
//            sozdanie obshego zapisa zayavok
            Application::create($data);


//            obnovit kolichcestvo zayavlennix godovogo grafika
            $year_application = YearApplication::find($data['year_application_id']);
            $inp = 'quantity_m'.$requirementYearApplication->month+1;
            $year_application->update([
                $inp => $year_application->$inp + $requirementYearApplication->declared_quantity
            ]);

//            obnovlenie obshego kolichestvo
            $total = 0;
            for ($i=0; $i<12; $i++) {
                $monthKey = 'quantity_m'.($i+1);
                $total += $year_application->$monthKey;
            }
            $year_application->update([
                'quantity' => $total
            ]);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Handle the RequirementYearApplication "updated" event.
     */
    public function updated(RequirementYearApplication $requirementYearApplication): void
    {
        $data = $this->getArr($requirementYearApplication);

        try {
//            obnovit dannie obshey tablici
            Application::where([
                ['requirement_id',$requirementYearApplication->id],
                ['type_application', 1]
            ])
                ->first()
                ->update($data);


//            obnovit kolichcestvo zayavlennix godovogo grafika
            $comp = $requirementYearApplication->getOriginal('declared_quantity') - $requirementYearApplication->declared_quantity;
            $year_application = YearApplication::find($data['year_application_id']);
            $inp = 'quantity_m'.$requirementYearApplication->month+1;
            $year_application->update([
                $inp => $year_application->$inp - $comp
            ]);

//            obnovlenie obshego kolichestvo
            $total = 0;
            for ($i=0; $i<12; $i++) {
                $monthKey = 'quantity_m'.($i+1);
                $total += $year_application->$monthKey;
            }
            $year_application->update([
                'quantity' => $total
            ]);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Handle the RequirementYearApplication "deleted" event.
     */
    public function deleted(RequirementYearApplication $requirementYearApplication): void
    {
        try {
            Application::where([
                ['requirement_id',$requirementYearApplication->id],
                ['type_application', 1]
            ])
                ->first()
                ->delete();


//            obnovit(minusovat) kolichcestvo zayavlennix godovogo grafika
            $year_application = YearApplication::find($requirementYearApplication->year_application_id);
            $inp = 'quantity_m'.$requirementYearApplication->month+1;
            $year_application->update([
                $inp => $year_application->$inp - $requirementYearApplication->declared_quantity
            ]);


//            obnovlenie obshego kolichestvo
            $total = 0;
            for ($i=0; $i<12; $i++) {
                $monthKey = 'quantity_m'.($i+1);
                $total += $year_application->$monthKey;
            }
            $year_application->update([
                'quantity' => $total
            ]);
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
     * @param RequirementYearApplication $requirementYearApplication
     * @return array
     */
    public function getArr(RequirementYearApplication $requirementYearApplication): array
    {
        $data = $requirementYearApplication->toArray();
        $data['requirement_id'] = $data['id'];
        $data['application_date'] = date('Y-m-d', strtotime($data['created_at']));
        $data['remont_begin'] = PlanRemont::find($data['plan_remont_id'])->remont_begin;
        $data['type_application'] = 1;
        return $data;
    }
}
