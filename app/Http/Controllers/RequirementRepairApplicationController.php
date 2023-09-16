<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\RequirementRepairApplication;
use App\Models\TechnicalResource;

class RequirementRepairApplicationController extends Controller
{
    public $title = 'Потребность в узлах, деталях и материалах для ремонта';
    public $title_main = 'Заявки на ремонт';
    public $route_name = 'requirement_repair_applications';
    public $route_name_main = 'repair_applications';
    public $route_parameter = 'requirements_repair_application';
    public $route_parameter_main = 'repair_application';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $id_application = $request->id_application;
        $id_equipment = $request->id_equipment;

        $mtr = TechnicalResource::orderBy('catalog_name', 'ASC')
            ->get();

        //    $sub_table = RequirementRepairApplication::where('repair_application_id', $repairApplication->id)->orderBy('technical_resource_id', 'ASC')->get();

        

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'title_main' => $this->title_main,
            'route_name' => $this->route_name,
            'route_name_main' => $this->route_name_main,
/*            'route_parameter' => $this->route_parameter,
            'equipments' => $equipments,
            'month' => $month,
            'plan_remonts' => $plan_remonts, */
            'mtr' => $mtr,
            'id_application' => $id_application,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'technical_resource_id' => 'required|integer',
            'required_quantity' => 'required|integer',
            'warehouse_number' => 'required',
            'warehouse_date' => 'required',
            'warehouse_quantity' => 'required|integer',
            'declared_quantity' => 'required|integer',
            'delivery_date' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        BaseController::store(RequirementRepairApplication::class, $data);
//        OBSERVER
/*
        DB::beginTransaction();
        try {

            $requirement = BaseController::store(RequirementYearApplication::class, $data);

//            obnovit kolichcestvo zayavlennix godovogo grafika
            $year_application = YearApplication::find($data['year_application_id']);
            $inp = 'quantity_m'.$requirement->month+1;
            $year_application->update([
                $inp => $year_application->$inp + $requirement->declared_quantity
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

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
*/
        // var_dump($data);
        // die();  // repair_application_id
        return redirect()->route($this->route_name_main.'.show', [$this->route_parameter_main => $data['repair_application_id']])->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(RequirementRepairApplication $requirementRepairApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequirementRepairApplication $requirementRepairApplication)
    {
        $requirementRepairApplication = RequirementRepairApplication::find($requirementRepairApplication);

        $id_application = $requirementRepairApplication->repair_application_id;
        $id_equipment = $requirementRepairApplication->repairApplication->equipment_id;

        $mtr = TechnicalResource::orderBy('catalog_name', 'ASC')
            ->get();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'title_main' => $this->title_main,
            'route_name' => $this->route_name,
            'route_name_main' => $this->route_name_main,
            'mtr' => $mtr,
            'id_application' => $id_application,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequirementRepairApplication $requirementRepairApplication)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'technical_resource_id' => 'required|integer',
            'required_quantity' => 'required|integer',
            'warehouse_number' => 'required',
            'warehouse_date' => 'required',
            'warehouse_quantity' => 'required|integer',
            'declared_quantity' => 'required|integer',
            'delivery_date' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        BaseController::store($requirementRepairApplication, $data, 1);

        return redirect()->route('year_applications.show', ['year_application' => $data['year_application_id']])->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequirementRepairApplication $requirementRepairApplication)
    {
        BaseController::destroy($requirementRepairApplication);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
