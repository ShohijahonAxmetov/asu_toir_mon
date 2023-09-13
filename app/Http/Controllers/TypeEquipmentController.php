<?php

namespace App\Http\Controllers;

use App\Models\TypeEquipment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TypeEquipmentController extends Controller
{
    public $title = 'Типы оборудования';
    public $route_name = 'type_equipments';
    public $route_parameter = 'type_equipment';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $type_equipments = TypeEquipment::latest()
            ->paginate(12);

        return view('app.type_equipments.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'type_equipments' => $type_equipments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required'
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
        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
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
            'name' => 'required'
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
