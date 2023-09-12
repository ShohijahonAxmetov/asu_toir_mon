<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Equipment;
use App\Models\TypeTechnicalInspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DetailController extends Controller
{
    public $title = 'Агрегаты, узлы';
    public $route_name = 'details';
    public $route_parameter = 'detail';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $details = Detail::latest();
        $search = null;
        if(isset($request->equipment_id) && $request->equipment_id != '') {
            $details = $details->where('equipment_id', $request->equipment_id);
            $search = $request->equipment_id;
        }
        $details = $details->paginate(12);
        $equipments = Equipment::all();

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'details' => $details,
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
        $type_technical_inspections = TypeTechnicalInspection::all();

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'equipments' => $equipments,
            'type_technical_inspections' => $type_technical_inspections,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['date'] = isset($data['date']) ? date('Y-m-d', strtotime($data['date'])) : date('Y-m-d');

        $validator = Validator::make($data, [
            'name' => 'required',
            'equipment_id' => 'integer|required',
            'type_technical_inspection_id' => 'integer|required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        DB::beginTransaction();
        try {
            BaseController::store(Detail::class, $data);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка транзакции'
            ]);
        }

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Detail $detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Detail $detail)
    {
        $equipments = Equipment::all();
        $type_technical_inspections = TypeTechnicalInspection::all();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'equipments' => $equipments,
            'type_technical_inspections' => $type_technical_inspections,
            'detail' => $detail
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Detail $detail)
    {
        $data = $request->all();
        $data['date'] = isset($data['date']) ? date('Y-m-d', strtotime($data['date'])) : date('Y-m-d');

        $validator = Validator::make($data, [
            'name' => 'required',
            'equipment_id' => 'integer|required',
            'type_technical_inspection_id' => 'integer|required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        DB::beginTransaction();
        try {
            BaseController::store($detail, $data, 1);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка транзакции'
            ]);
        }

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Detail $detail)
    {
        BaseController::destroy($detail);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
