<?php

namespace App\Http\Controllers;

use App\Models\RepairApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Equipment;
use App\Models\PlanRemont;
use App\Models\RequirementRepairApplication;


class RepairApplicationController extends Controller
{
    public $title = 'Заявки на ремонт';
    public $route_name = 'repair_applications';
    public $route_parameter = 'repair_application';

    public $route_name_sub = 'requirement_repair_applications';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $repair_applications = RepairApplication::latest();
        $search = null;
        if(isset($request->equipment_id) && $request->equipment_id != '') {
            $repair_applications = $repair_applications->where('equipment_id', $request->equipment_id);
            $search = $request->equipment_id;
        }
        $repair_applications = $repair_applications->paginate(12);
        
        $equipments = Equipment::orderBy('garage_number', 'ASC')->get();

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'repair_applications' => $repair_applications,
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

        BaseController::store(RepairApplication::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairApplication $repairApplication)
    {
        $equipments = Equipment::orderBy('garage_number', 'ASC')->get();
        $plan_remonts = PlanRemont::orderBy('remont_begin', 'ASC')->get();

        $sub_table = RequirementRepairApplication::where('repair_application_id', $repairApplication->id)->orderBy('technical_resource_id', 'ASC')->get();

        return view('app.'.$this->route_name.'.show', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'route_name_sub' => $this->route_name_sub,
/*            'equipments' => $equipments,
            'plan_remonts' => $plan_remonts, */
            'repair_application' => $repairApplication,
            'sub_table' => $sub_table, 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepairApplication $repair_application)
    {
        //
        $equipments = Equipment::orderBy('garage_number', 'ASC')->get();
        $plan_remonts = PlanRemont::orderBy('remont_begin', 'ASC')->get();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'repair_application' => $repair_application,
            'equipments' => $equipments,
            'plan_remonts' => $plan_remonts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RepairApplication $repair_application)
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

        BaseController::store($repair_application, $data, 1);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairApplication $repairApplication)
    {
        DB::beginTransaction();
        try {

            foreach ($repairApplication->requirements as $item) {
                BaseController::destroy($item);
            }
            BaseController::destroy($repairApplication);

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
