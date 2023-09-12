<?php

namespace App\Http\Controllers;

use App\Models\TypeTechnicalInspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TypeTechnicalInspectionController extends Controller
{
    public $title = 'Типы технических обслужований';
    public $route_name = 'type_technical_inspections';
    public $route_parameter = 'type_technical_inspection';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $type_technical_inspections = TypeTechnicalInspection::latest()
            ->paginate(12);

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'type_technical_inspections' => $type_technical_inspections
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
            'name' => 'required',
            'key' => 'required|in:hours,month',
            'value' => 'integer|required'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        DB::beginTransaction();
        try {
            BaseController::store(TypeTechnicalInspection::class, $data);

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
    public function show(TypeTechnicalInspection $typeTechnicalInspection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeTechnicalInspection $typeTechnicalInspection)
    {
        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'typeTechnicalInspection' => $typeTechnicalInspection
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeTechnicalInspection $typeTechnicalInspection)
    {
        $data = $request->all();
        $data['date'] = isset($data['date']) ? date('Y-m-d', strtotime($data['date'])) : date('Y-m-d');

        $validator = Validator::make($data, [
            'name' => 'required',
            'key' => 'required|in:hours,month',
            'value' => 'integer|required'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        DB::beginTransaction();
        try {
            BaseController::store($typeTechnicalInspection, $data, 1);

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
    public function destroy(TypeTechnicalInspection $typeTechnicalInspection)
    {
        BaseController::destroy($typeTechnicalInspection);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
