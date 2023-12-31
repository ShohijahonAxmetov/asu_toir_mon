<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\TypeEquipment;
use App\Models\VidEquipment;


class TypeEquipmentController extends Controller
{
    public $title = 'Типы оборудования';
    public $route_name = 'type_equipments';
    public $route_parameter = 'type_equipment';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_equipments = TypeEquipment::latest();

        $search = null;
        if (isset($request->vid_equipment_id) && $request->vid_equipment_id != '') {
            $type_equipments = $type_equipments->where('vid_equipment_id', $request->vid_equipment_id);
            $search = $request->vid_equipment_id;
        }
    
        $type_equipments = $type_equipments->paginate(12);

        $vid_equipments = VidEquipment::all();

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'type_equipments' => $type_equipments,
            'vid_equipments' => $vid_equipments,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vid_equipments = VidEquipment::all();

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'vid_equipments' => $vid_equipments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'vid_equipment_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        BaseController::store(TypeEquipment::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeEquipment $type_equipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeEquipment $type_equipment)
    {
        $vid_equipments = VidEquipment::all();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'vid_equipments' => $vid_equipments,
            'type_equipment' => $type_equipment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeEquipment $type_equipment)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'vid_equipment_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        BaseController::store($type_equipment, $data, 1);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeEquipment $type_equipment)
    {
        BaseController::destroy($type_equipment);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
