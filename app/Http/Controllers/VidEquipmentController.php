<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Http\Controllers\BaseController;
use App\Models\VidEquipment;

class VidEquipmentController extends Controller
{
    public $title = 'Виды оборудования';
    public $route_name = 'vid_equipments';
    public $route_parameter = 'vid_equipment';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vid_equipments = VidEquipment::latest()
            ->paginate(12);

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'vid_equipments' => $vid_equipments
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

        BaseController::store(VidEquipment::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(VidEquipment $vid_equipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VidEquipment $vid_equipment)
    {
        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'vid_equipment' => $vid_equipment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VidEquipment $vid_equipment)
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

        BaseController::store($vid_equipment, $data, 1);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VidEquipment $vid_equipment)
    {
        BaseController::destroy($vid_equipment);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
