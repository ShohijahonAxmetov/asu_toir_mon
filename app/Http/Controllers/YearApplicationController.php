<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Equipment;
use App\Models\PlanRemont;
use App\Models\RequirementYearApplication;
use App\Models\TechnicalResource;
use App\Models\TypeEquipment;
use App\Models\YearApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class YearApplicationController extends Controller
{
    public $title = 'Годовая заявка на ремонт';
    public $route_name = 'year_applications';
    public $route_parameter = 'year_application';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $year_applications = YearApplication::latest();
        $search = null;
        if(isset($request->department_id) && $request->department_id != '') {
            $year_applications = $year_applications->where('department_id', $request->department_id);
            $search = $request->department_id;
        }
        $year_applications = $year_applications->paginate(12);
        $departments = Department::all();

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'year_applications' => $year_applications,
            'departments' => $departments,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $technical_resources = TechnicalResource::orderBy('catalog_name', 'ASC')
            ->get();

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'departments' => $departments,
            'technical_resources' => $technical_resources,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'department_id' => 'required|integer',
            'technical_resource_id' => 'required|integer',
            'year' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }
//        OBSERVER
        $data['unit_id'] = TechnicalResource::find($data['technical_resource_id'])->unit_id;
        $data['quantity'] = 0;
        $data['quantity_m1'] = 0;
        $data['quantity_m2'] = 0;
        $data['quantity_m3'] = 0;
        $data['quantity_m4'] = 0;
        $data['quantity_m5'] = 0;
        $data['quantity_m6'] = 0;
        $data['quantity_m7'] = 0;
        $data['quantity_m8'] = 0;
        $data['quantity_m9'] = 0;
        $data['quantity_m10'] = 0;
        $data['quantity_m11'] = 0;
        $data['quantity_m12'] = 0;

        DB::beginTransaction();
        try {
            BaseController::store(YearApplication::class, $data);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with([
                'success' => false,
                'message' => $e->getMessage()
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
    public function show(YearApplication $yearApplication)
    {
        $departments = Department::all();
        $technical_resources = TechnicalResource::orderBy('catalog_name', 'ASC')
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

        return view('app.'.$this->route_name.'.show', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'departments' => $departments,
            'technical_resources' => $technical_resources,
            'year_application' => $yearApplication,
            'month' => $month,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(YearApplication $yearApplication)
    {
        $departments = Department::all();
        $technical_resources = TechnicalResource::orderBy('catalog_name', 'ASC')
            ->get();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'year_application' => $yearApplication,
            'technical_resources' => $technical_resources,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, YearApplication $yearApplication)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'department_id' => 'required|integer',
            'year' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }
        
        DB::beginTransaction();
        try {
            BaseController::store($yearApplication, $data, 1);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with([
                'success' => false,
                'message' => $e->getMessage()
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
    public function destroy(YearApplication $yearApplication)
    {
        DB::beginTransaction();
        try {

            foreach ($yearApplication->requirements as $item) {
                BaseController::destroy($item);
            }
            BaseController::destroy($yearApplication);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with([
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
