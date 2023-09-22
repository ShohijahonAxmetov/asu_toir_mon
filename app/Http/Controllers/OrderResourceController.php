<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\OrderResource;
use App\Models\PlanRemont;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderResourceController extends Controller
{
    public $title = 'Учет исполнения заявок';
    public $route_name = 'order_resources';
    public $route_parameter = 'order_resource';

    public $subtitle = 'Мониторинг';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $applications = Application::latest();
        $equipment_id = null;
        $plan_remont_id = null;
        if(isset($request->equipment_id) && $request->equipment_id != '') {
            $applications = $applications->where('equipment_id', $request->equipment_id);
            $equipment_id = $request->equipment_id;
        }
        if(isset($request->plan_remont_id) && $request->plan_remont_id != '') {
            $applications = $applications->where('plan_remont_id', $request->plan_remont_id);
            $plan_remont_id = $request->plan_remont_id;
        }
        $applications = $applications->with('orderResource')->paginate(12);

        $plan_remonts = PlanRemont::latest()
            ->get();
        $equipments = Equipment::orderBy('garage_number', 'ASC')
            ->get();

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'applications' => $applications,
            'equipment_id' => $equipment_id,
            'plan_remont_id' => $plan_remont_id,
            'plan_remonts' => $plan_remonts,
            'equipments' => $equipments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $applications = Application::all();

        $filter = null;
        if(isset($request->filter)) $filter = json_encode($request->filter);

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'applications' => $applications,
            'filter' => $filter,
            'application_id' => $request->application_id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'application_id' => 'required|integer',
            'order_number' => 'required',
            'order_date' => 'required',
            'order_quantity' => 'required',
            'contract_number' => 'nullable',
            'contract_date' => 'nullable',
            'local_foreign' => 'nullable',
            'date_manufacture_contract' => 'nullable',
            'date_manufacture_fact' => 'nullable',
            'customs_date_receipt' => 'nullable',
            'customs_date_exit' => 'nullable',
            'date_delivery_object' => 'nullable',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        $data['execution_statuse_id'] = $this->setStatus($request);
        BaseController::store(OrderResource::class, $data);
        $data['filter'] = json_decode($data['filter'], true);

        return redirect()->route($this->route_name.'.index', ['equipment_id' => $data['filter']['equipment_id'] ?? null,
            'plan_remont_id' => $data['filter']['plan_remont_id'] ?? null])->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderResource $orderResource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, OrderResource $orderResource)
    {
        $applications = Application::all();

        // $equipment_id = null;
        // $plan_remont_id = null;
        // if(isset($request->filter)) {
        //     if(isset($request->filter['equipment_id'])) $equipment_id = $request->filter['equipment_id'];
        //     if(isset($request->filter['plan_remont_id'])) $plan_remont_id = $request->filter['equipment_id'];
        // }
        $filter = null;
        if(isset($request->filter)) $filter = json_encode($request->filter);


        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'order_resource' => $orderResource,
            'applications' => $applications,
            'filter' => $filter,
            'application_id' => $request->application_id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderResource $orderResource)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'application_id' => 'required|integer',
            'order_number' => 'required',
            'order_date' => 'required',
            'order_quantity' => 'required',
            'contract_number' => 'nullable',
            'contract_date' => 'nullable',
            'local_foreign' => 'nullable',
            'date_manufacture_contract' => 'nullable',
            'date_manufacture_fact' => 'nullable',
            'customs_date_receipt' => 'nullable',
            'customs_date_exit' => 'nullable',
            'date_delivery_object' => 'nullable',
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        $data['execution_statuse_id'] = $this->setStatus($request);
        BaseController::store($orderResource, $data, 1);
        $data['filter'] = json_decode($data['filter'], true);

        return redirect()->route($this->route_name.'.index', ['equipment_id' => $data['filter']['equipment_id'] ?? null,
            'plan_remont_id' => $data['filter']['plan_remont_id'] ?? null])->with([
            'success' => true,
            'message' => 'Успешно сохранен',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderResource $orderResource)
    {
        BaseController::destroy($orderResource);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }

    public function setStatus(Request $request)
    {
        $data = $request->all();
        $status_id = 0;

        if(is_null($data['contract_number'])) $status_id = 2;
        if(!is_null($data['contract_number']) && is_null($data['date_manufacture_fact'])) $status_id = 3;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 1) $status_id = 6;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 1 && !is_null($data['date_delivery_object'])) $status_id = 7;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 2) $status_id = 4;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 2 && !is_null($data['customs_date_receipt'])) $status_id = 5;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 2 && !is_null($data['customs_date_receipt']) && !is_null($data['customs_date_exit'])) $status_id = 6;
        if(!is_null($data['contract_number']) && !is_null($data['date_manufacture_fact']) && $data['local_foreign'] == 2 && !is_null($data['customs_date_receipt']) && !is_null($data['customs_date_exit']) && !is_null($data['date_delivery_object'])) $status_id = 7;

        return $status_id;
    }

    public function monitoring(Request $request)
    {
        $applications = Application::latest();
        $equipment_id = null;
        $plan_remont_id = null;
        if(isset($request->equipment_id) && $request->equipment_id != '') {
            $applications = $applications->where('equipment_id', $request->equipment_id);
            $equipment_id = $request->equipment_id;
        }
        if(isset($request->plan_remont_id) && $request->plan_remont_id != '') {
            $applications = $applications->where('plan_remont_id', $request->plan_remont_id);
            $plan_remont_id = $request->plan_remont_id;
        }
        $applications = $applications->with('orderResource')
            ->select('applications.*')
            ->join('equipment', 'equipment.id', '=', 'applications.equipment_id')
            ->join('type_equipments', 'type_equipments.id', '=', 'equipment.type_equipment_id')
            ->orderBy('type_equipments.name')
            ->orderBy('equipment.garage_number')
            ->paginate(12);

        $plan_remonts = PlanRemont::latest()
            ->get();
        $equipments = Equipment::orderBy('garage_number', 'ASC')
            ->get();

        return view('app.'.$this->route_name.'.index2', [
            'title' => $this->subtitle,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'applications' => $applications,
            'equipment_id' => $equipment_id,
            'plan_remont_id' => $plan_remont_id,
            'plan_remonts' => $plan_remonts,
            'equipments' => $equipments,
        ]);
    }

    public function monitoringShow(Request $request, $application_id)
    {

        $application = Application::where('id', $application_id)
            ->with('orderResource')
            ->first();

        return view('app.'.$this->route_name.'.show', [
            'title' => $this->subtitle,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'item' => $application,
        ]);
    }
}
