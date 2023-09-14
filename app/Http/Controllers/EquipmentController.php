<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Equipment;
use App\Models\TypeEquipment;
use App\Models\Detail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EquipmentController extends Controller
{
    public $title = 'Оборудования';
    public $route_name = 'equipments';
    public $route_parameter = 'equipment';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $equipments = Equipment::latest();
        $search = null;
        if(isset($request->type_equipment_id) && $request->type_equipment_id != '') {
            $equipments = $equipments->where('type_equipment_id', $request->type_equipment_id);
            $search = $request->type_equipment_id;
        }
        $equipments = $equipments->paginate(12);
        $type_equipments = TypeEquipment::all();

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'equipments' => $equipments,
            'type_equipments' => $type_equipments,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_equipments = TypeEquipment::all();
        $departments = Department::all();

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'type_equipments' => $type_equipments,
            'departments' => $departments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'garage_number' => 'required',
            'type_equipment_id' => 'required|integer',
            'department_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        BaseController::store(Equipment::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        $type_equipments = TypeEquipment::all();
        $departments = Department::all();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'equipment' => $equipment,
            'type_equipments' => $type_equipments,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'garage_number' => 'required',
            'type_equipment_id' => 'required|integer',
            'department_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        BaseController::store($equipment, $data, 1);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        BaseController::destroy($equipment);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
