<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Equipment;
use App\Models\TypeEquipment;
use App\Models\YearApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class YearApplicationController extends Controller
{
    public $title = 'Годовая заявка на ремонт';
    public $route_name = 'year_applications';
    public $route_parameter = 'year_application';
    /**
     * Display a listing of the resource.
     */
    public function index()
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
            'department_id' => 'required|integer',
            'year' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        BaseController::store(YearApplication::class, $data);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(YearApplication $yearApplication)
    {
        $type_equipments = TypeEquipment::orderBy('name', 'ASC')->get();
        $departments = Department::all();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'year_application' => $yearApplication,
            'type_equipments' => $type_equipments,
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

        BaseController::store($yearApplication, $data, 1);

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
        BaseController::destroy($yearApplication);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
