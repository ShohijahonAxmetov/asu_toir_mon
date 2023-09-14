<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Equipment;
use App\Models\PlanRemont;
use App\Models\RemontType;
use App\Models\TypeEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanRemontController extends Controller
{
    public $title = 'Запланированные ремонты';
    public $route_name = 'plan_remonts';
    public $route_parameter = 'plan_remont';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $plan_remonts = PlanRemont::latest();
        $search = null;
        if(isset($request->equipment_id) && $request->equipment_id != '') {
            $plan_remonts = $plan_remonts->where('equipment_id', $request->equipment_id);
            $search = $request->equipment_id;
        }
        $plan_remonts = $plan_remonts->paginate(12);
        $equipments = Equipment::all();

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'plan_remonts' => $plan_remonts,
            'equipments' => $equipments,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $equipments = Equipment::all();
        $remont_types = RemontType::all();

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'equipments' => $equipments,
            'remont_types' => $remont_types,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'remont_type_id' => 'required|integer',
            'equipment_id' => 'required|integer',
            'remont_begin' => 'required',
            'remont_end' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        $data['remont_begin'] = date('Y-m-d', strtotime($data['remont_begin']));
        $data['remont_end'] = date('Y-m-d', strtotime($data['remont_end']));
        BaseController::store(PlanRemont::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanRemont $planRemont)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlanRemont $planRemont)
    {
        $equipments = Equipment::all();
        $remont_types = RemontType::all();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'plan_remont' => $planRemont,
            'equipments' => $equipments,
            'remont_types' => $remont_types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlanRemont $planRemont)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'remont_type_id' => 'required|integer',
            'equipment_id' => 'required|integer',
            'remont_begin' => 'required',
            'remont_end' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        $data['remont_begin'] = date('Y-m-d', strtotime($data['remont_begin']));
        $data['remont_end'] = date('Y-m-d', strtotime($data['remont_end']));
        BaseController::store($planRemont, $data, 1);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanRemont $planRemont)
    {
        BaseController::destroy($planRemont);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
