<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Equipment;
use App\Models\PlanRemont;
use App\Models\RequirementYearApplication;
use App\Models\TypeEquipment;
use App\Models\YearApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RequirementYearApplicationController extends Controller
{
    public $title = 'Потребность в узлах, деталях и материалах к годовому графику ППР';
    public $route_name = 'requirements_year_applications';
    public $route_parameter = 'requirements_year_application';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $equipments = Equipment::orderBy('garage_number', 'ASC')
            ->get();
        $plan_remonts = PlanRemont::orderBy('remont_begin', 'ASC')
            ->get();
        $month = [
            'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Май',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
            'Октябрь',
            'Ноябрь',
            'Декабрь',
        ];
        $mtr = $request->mtr;
        $application = $request->application;

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'equipments' => $equipments,
            'month' => $month,
            'plan_remonts' => $plan_remonts,
            'mtr' => $mtr,
            'application' => $application,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'equipment_id' => 'required|integer',
            'month' => 'required|integer',
            'plan_remont_id' => 'required|integer',
            'required_quantity' => 'required|integer',
            'warehouse_number' => 'required',
            'warehouse_date' => 'required',
            'warehouse_quantity' => 'required|integer',
            'declared_quantity' => 'required|integer',
            'delivery_date' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        DB::beginTransaction();
        try {
            BaseController::store(RequirementYearApplication::class, $data);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return redirect()->route('year_applications.show', ['year_application' => $data['year_application_id']])->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(RequirementYearApplication $requirementYearApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $requirementYearApplication)
    {
        $requirementYearApplication = RequirementYearApplication::find($requirementYearApplication);
        $equipments = Equipment::orderBy('garage_number', 'ASC')
            ->get();
        $plan_remonts = PlanRemont::orderBy('remont_begin', 'ASC')
            ->get();
        $month = [
            'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Май',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
            'Октябрь',
            'Ноябрь',
            'Декабрь',
        ];
        $mtr = $request->mtr;
        $application = $request->application;

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'requirement_year_application' => $requirementYearApplication,
            'equipments' => $equipments,
            'month' => $month,
            'plan_remonts' => $plan_remonts,
            'mtr' => $mtr,
            'application' => $application,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $requirementYearApplication)
    {
        $requirementYearApplication = RequirementYearApplication::find($requirementYearApplication);
        $data = $request->all();

        $validator = Validator::make($data, [
            'equipment_id' => 'required|integer',
            'month' => 'required|integer',
            'plan_remont_id' => 'required|integer',
            'required_quantity' => 'required|integer',
            'warehouse_number' => 'required',
            'warehouse_date' => 'required',
            'warehouse_quantity' => 'required|integer',
            'declared_quantity' => 'required|integer',
            'delivery_date' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

//        OBSERVER
        DB::beginTransaction();
        try {
            BaseController::store($requirementYearApplication, $data, 1);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return redirect()->route('year_applications.show', ['year_application' => $data['year_application_id']])->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($requirementYearApplication)
    {
        $requirementYearApplication = RequirementYearApplication::find($requirementYearApplication);

        DB::beginTransaction();
        try {
            BaseController::destroy($requirementYearApplication);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with([
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
