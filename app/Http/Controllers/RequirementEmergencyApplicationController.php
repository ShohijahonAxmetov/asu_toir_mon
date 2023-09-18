<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\RequirementEmergencyApplication;
use App\Models\TechnicalResource;
use App\Models\EmergencyApplication;

class RequirementEmergencyApplicationController extends Controller
{
    public $title = 'Потребность в узлах и деталях для ремонта';
    public $title_main = 'Аварийные заявки';
    public $route_name = 'req_emergency_applications';
    public $route_name_main = 'emergency_applications';
    public $route_parameter = 'req_emergency_application';
    public $route_parameter_main = 'emergency_application';

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

        $repairApp =  EmergencyApplication::find($id_application);

        $t1 =  isset($repairApp->planRemont->remont_begin) ? date('d-m-Y', strtotime($repairApp->planRemont->remont_begin)) : '--';
        $t2 =  isset($repairApp->planRemont->remont_end) ? date('d-m-Y', strtotime($repairApp->planRemont->remont_end)) : '--';
        $repair_str = $t1 . ' - ' . $t2;  

        $mtr = TechnicalResource::orderBy('catalog_name', 'ASC')
            ->get();

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title . ' ' . $repair_str,
            'title_main' => $this->title_main,
            'route_name' => $this->route_name,
            'route_name_main' => $this->route_name_main,
            'route_parameter_main' =>  $this->route_parameter_main,
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

        BaseController::store(RequirementEmergencyApplication::class, $data);

        return redirect()->route($this->route_name_main.'.show', [$this->route_parameter_main => $data['emergency_application_id']])->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(RequirementEmergencyApplication $requirementEmergencyApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $requirementEmergencyApplication)
    {

   //     var_dump($requirementEmergencyApplication);
     //   die();

        $requirementEmergencyApplication = RequirementEmergencyApplication::find($requirementEmergencyApplication);

        $id_application = $requirementEmergencyApplication->emergency_application_id;
        $id_equipment = $requirementEmergencyApplication->emergencyApplication->equipment_id;

        $mtr = TechnicalResource::orderBy('catalog_name', 'ASC')
            ->get();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'title_main' => $this->title_main,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'route_name_main' => $this->route_name_main,
            'req_emergency_application' => $requirementEmergencyApplication,
            'mtr' => $mtr,
            'id_application' => $id_application,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $requirementEmergencyApplication)
    {
        $requirementEmergencyApplication = RequirementEmergencyApplication::find($requirementEmergencyApplication);

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

        BaseController::store($requirementEmergencyApplication, $data, 1);

        return redirect()->route($this->route_name_main . '.show', [$this->route_parameter_main => $data['emergency_application_id']])->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequirementEmergencyApplication $requirementEmergencyApplication)
    {
        BaseController::destroy($requirementEmergencyApplication);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
