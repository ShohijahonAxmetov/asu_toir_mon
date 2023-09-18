<?php

namespace App\Http\Controllers;

use App\Models\EmergencyApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Equipment;
use App\Models\PlanRemont;
use App\Models\RequirementEmergencyApplication;


class EmergencyApplicationController extends Controller
{
    public $title = 'Аварийные заявки';
    public $route_name = 'emergency_applications';
    public $route_parameter = 'emergency_application';

    public $route_name_sub = 'req_emergency_applications';
	
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $emergency_applications = EmergencyApplication::latest();
        $search = null;
        if(isset($request->equipment_id) && $request->equipment_id != '') {
            $emergency_applications = $emergency_applications->where('equipment_id', $request->equipment_id);
            $search = $request->equipment_id;
        }
        $emergency_applications = $emergency_applications->paginate(12);
        
        $equipments = Equipment::orderBy('garage_number', 'ASC')->get();

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'emergency_applications' => $emergency_applications,
            'equipments' => $equipments,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $equipments = Equipment::orderBy('garage_number', 'ASC')->get();
        $plan_remonts = PlanRemont::orderBy('remont_begin', 'ASC')->get();

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'equipments' => $equipments,
            'plan_remonts' => $plan_remonts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();

        $validator = Validator::make($data, [
            'equipment_id' => 'required|integer',
            'plan_remont_id' => 'required|integer',
            'application_date' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        BaseController::store(EmergencyApplication::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */

    public function show(EmergencyApplication $emergencyApplication)
    {
        $equipments = Equipment::orderBy('garage_number', 'ASC')->get();
        $plan_remonts = PlanRemont::orderBy('remont_begin', 'ASC')->get();

        $sub_table = RequirementEmergencyApplication::where('emergency_application_id', $emergencyApplication->id)->orderBy('technical_resource_id', 'ASC')->get();

        return view('app.'.$this->route_name.'.show', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'route_name_sub' => $this->route_name_sub,
            'emergency_application' => $emergencyApplication,
            'sub_table' => $sub_table, 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmergencyApplication $emergencyApplication)
    {
        $equipments = Equipment::orderBy('garage_number', 'ASC')->get();
        $plan_remonts = PlanRemont::orderBy('remont_begin', 'ASC')->get();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'emergency_application' => $emergencyApplication,
            'equipments' => $equipments,
            'plan_remonts' => $plan_remonts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmergencyApplication $emergencyApplication)
    {
         //
        $data = $request->all();

        $validator = Validator::make($data, [
            'equipment_id' => 'required|integer',
            'plan_remont_id' => 'required|integer',
            'application_date' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        BaseController::store($emergencyApplication, $data, 1);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmergencyApplication $emergencyApplication)
    {
        DB::beginTransaction();
        try {

            foreach ($emergencyApplication->requirements as $item) {
                BaseController::destroy($item);
            }
            BaseController::destroy($emergencyApplication);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
