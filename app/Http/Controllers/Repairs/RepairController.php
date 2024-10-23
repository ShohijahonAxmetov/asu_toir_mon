<?php

namespace App\Http\Controllers\Repairs;

use App\Models\TechMaps\TechMap;
use App\Models\Repair\Repair;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public $title = 'Ремонты';
    public $route_name = 'repairs';
    public $route_parameter = 'repair';



    public function index()
    {
        ${$this->route_name} = Repair::latest()
            ->paginate(12);

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            $this->route_name => ${$this->route_name}
        ]);
    }

    public function create()
    {
        $techMaps = TechMap::get();

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'tech_maps' => $techMaps,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'tech_map_id' => 'required|integer|exists:tech_maps,id',
            'started_at' => 'required|date_format:Y-m-d H:i',
            'ended_at' => 'nullable|date_format:Y-m-d H:i',
            'comments' => 'nullable|string|max:65535', // text
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        BaseController::store(Repair::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Repair $repair)
    {
        $deviations = '-';
        if ($repair->ended_at) {
            $startedAt = new Carbon($repair->started_at);
            $endedAt = new Carbon($repair->ended_at);

            $normative = $startedAt->addHours(TechMap::findOrFail($repair->tech_map_id)->hours);
            $normative = $normative->addMinutes(TechMap::findOrFail($repair->tech_map_id)->minutes);
            $deviations = $normative->diff($endedAt);
        }
        return view('app.'.$this->route_name.'.show', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'item' => $repair,
            'deviations' => $deviations,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Repair $repair)
    {
        $techMaps = TechMap::get();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'repair' => $repair,
            'tech_maps' => $techMaps,
        ]);
    }

    public function update(Request $request, Repair $repair)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'tech_map_id' => 'required|integer|exists:tech_maps,id',
            'started_at' => 'required|date_format:Y-m-d H:i',
            'ended_at' => 'nullable|date_format:Y-m-d H:i',
            'comments' => 'nullable|string|max:65535', // text
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        BaseController::store($repair, $data, 1);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    public function destroy(Repair $repair)
    {
        BaseController::destroy($repair);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }


    // Logs
    public function addLog(Repair $repair)
    {
        // dd($repair->techMap);
        $techMapOperations = DB::table('tech_map_operations')
                                ->where('tech_map_id', $repair->tech_map_id)
                                ->get();
                                // dd($techMapOperations);

        return view('app.'.$this->route_name.'.logs.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'repair' => $repair,
            'tech_map_operations' => $techMapOperations,
        ]);
    }

    public function storeLog(Request $request, Repair $repair)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'action' => 'required|in:Сохранить,Сохранить и добавить еще',
            'technical_resource_id' => 'required|integer|exists:technical_resources,id',
            'unit_id' => 'required|integer|exists:units,id',
            'quantity' => 'required|integer|min:1',
            'characteristics' => 'nullable|string|max:65535'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->getErrors()
            ]);
        }

        $repair->technicalResources()->attach($data['technical_resource_id'], [
            'quantity' => $data['quantity'],
            'unit_id' => $data['unit_id'],
            'characteristics' => $data['characteristics'],
        ]);

        return $data['action'] == 'Сохранить и добавить еще'
            ? redirect()->route($this->route_parameter.'.tech_resources.add', ['tech_operation' => $repair])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ])
            : redirect()->route($this->route_name.'.show', ['tech_operation' => $repair])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ]);
    }

    public function editLog(Request $request, Repair $repair, int $pivotId)
    {
        $units = Unit::get();
        $technicalResources = TechnicalResource::get();
        $pivot = DB::table('tech_operation_technical_resource')
            ->where('id', $pivotId)
            ->first();

        return view('app.'.$this->route_name.'.technical_resources.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'units' => $units,
            'repair' => $repair,
            'technicalResources' => $technicalResources,
            'pivot' => $pivot,
        ]);
    }

    public function updateLog(Request $request, Repair $repair, int $pivotId)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            // 'action' => 'required|in:Сохранить,Сохранить и добавить еще',
            // 'tech_operation_id' => 'required|integer|exists:tech_operations,id',
            'technical_resource_id' => 'required|integer|exists:technical_resources,id',
            'characteristics' => 'nullable|string',
            'quantity' => 'required|numeric|min:0.001|max:999999.999',
            'unit_id' => 'required|integer|exists:units,id'
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        
        DB::table('tech_operation_technical_resource')
            ->where('id', $pivotId)
            ->update([
                // 'tech_operation_id' => $data['tech_operation_id'],
                'technical_resource_id' => $data['technical_resource_id'],
                'characteristics' => $data['characteristics'],
                'quantity' => $data['quantity'],
                'unit_id' => $data['unit_id'],
            ]);

        return redirect()->route($this->route_name.'.show', ['tech_operation' => $repair])->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    public function destroyLog(Repair $repair, int $pivotId)
    {
        DB::table('tech_operation_technical_resource')
            ->where('id', $pivotId)
            ->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
