<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\TechnicalResource;
use App\Models\TechnicalResourceTypeEquipment;
use App\Models\TypeEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TechnicalResourceTypeEquipmentController extends Controller
{
    public $title = 'Узлы для типа оборудования';
    public $route_name = 'technical_resource_type_eqs';
    public $route_parameter = 'technical_resource_type_eq';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $details = TechnicalResourceTypeEquipment::latest();
        $search = null;
//        if(isset($request->type_equipment_id) && $request->type_equipment_id != '') {
//            $equipments = $equipments->where('type_equipment_id', $request->type_equipment_id);
//            $search = $request->type_equipment_id;
//        }
        $details = $details->paginate(12);
//        $type_equipments = TypeEquipment::all();

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'details' => $details,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_equipments = TypeEquipment::all();
        $technical_resources = TechnicalResource::all();
        $details = TechnicalResourceTypeEquipment::all();

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'type_equipments' => $type_equipments,
            'technical_resources' => $technical_resources,
            'details' => $details,
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
            'type_equipment_id' => 'required|integer',
            'parent_id' => 'nullable|integer',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        BaseController::store(TechnicalResourceTypeEquipment::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TechnicalResourceTypeEquipment $technicalResourceTypeEquipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($technicalResourceTypeEquipment)
    {
        $technicalResourceTypeEquipment = TechnicalResourceTypeEquipment::find($technicalResourceTypeEquipment);
        $type_equipments = TypeEquipment::all();
        $technical_resources = TechnicalResource::all();
        $details = TechnicalResourceTypeEquipment::where('id', '!=', $technicalResourceTypeEquipment->id)
            ->get();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'detail' => $technicalResourceTypeEquipment,
            'type_equipments' => $type_equipments,
            'technical_resources' => $technical_resources,
            'details' => $details,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $technicalResourceTypeEquipment)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'technical_resource_id' => 'required|integer',
            'type_equipment_id' => 'required|integer',
            'parent_id' => 'nullable|integer',
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        $technicalResourceTypeEquipment = TechnicalResourceTypeEquipment::find($technicalResourceTypeEquipment);
        BaseController::store($technicalResourceTypeEquipment, $data, 1);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($technicalResourceTypeEquipment)
    {
        $technicalResourceTypeEquipment = TechnicalResourceTypeEquipment::find($technicalResourceTypeEquipment);
        BaseController::destroy($technicalResourceTypeEquipment);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
