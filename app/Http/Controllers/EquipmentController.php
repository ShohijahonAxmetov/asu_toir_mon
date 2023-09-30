<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Equipment;
use App\Models\TypeEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
		$type_equipments = TypeEquipment::orderBy('name', 'ASC')->get();
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
        $type_equipments = TypeEquipment::orderBy('name', 'ASC')->get();
        $departments = Department::all();

        return view('app.'.$this->route_name.'.show', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'type_equipments' => $type_equipments,
            'departments' => $departments,
            'equipment' => $equipment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
		$type_equipments = TypeEquipment::orderBy('name', 'ASC')->get();
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

    public $currentLvl;
    public function setCurrentLevel($value = 0)
    {
        $this->currentLvl = $value;
    }

    public $allUzels;
    public function setAllUzels(Equipment $equipment)
    {
        $equipmentUzels = $equipment->typeEquipment->technicalResourceTypeEquipments()
            ->with('technicalResource')
            ->get();

        $this->allUzels = $equipmentUzels;
    }

    public function graph(Equipment $equipment)
    {
        $this->setAllUzels($equipment);
        $this->setCurrentLevel();

        $subCollection = $this->allUzels->where('parent_id', null);
        foreach ($subCollection as $key => $item) {
            $item->name = $item->technicalResource->catalog_name;
            $item->originalName = $item->technicalResource->catalog_name;
            $this->ch($item, 1);
        }

        $graph = [
            'id' => 99999999999,
            'name' => $equipment->typeEquipment->name,
            'children' => $this->allUzels->where('parent_id', null)->toArray()
        ];
        // dd($graph['children'][8]);

        return view('app.'.$this->route_name.'.graph', [
            'equipment' => $equipment,
            'graph' => $graph,
            'uzels' => $this->allUzels,
        ]);
    }

    function ch($uzel, $lvl)
    {
        $temp = [];

        foreach ($this->allUzels as $key => $item) {
            if($uzel->id == $item->parent_id) {
                $item->lvl = $lvl;
                $temp[] = $item;
            }
        }

        if(isset($temp[0])) {
            $uzel->children = $temp;

            $lvl = $lvl + 1;
            foreach ($uzel->children as $child) {
                $this->ch($child, $lvl);
            }
        }
    }

    public function getDesignations()
    {
        return ['X', 'Y', 'Z', 'M', 'N', 'P', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20', '20'];
    }
}
