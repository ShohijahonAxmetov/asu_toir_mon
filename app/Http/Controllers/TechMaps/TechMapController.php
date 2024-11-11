<?php

namespace App\Http\Controllers\TechMaps;

use App\Traits\UploadFile;

use App\Models\Catalog\SecurityMeasure;
use App\Models\Unit;
use App\Models\TechMaps\TechOperation;
use App\Models\TechMaps\TechMapGroup;
use App\Models\TechMaps\TechMap;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class TechMapController extends Controller
{
    use UploadFile;

    public $title = 'Технологические карты';
    public $route_name = 'tech_maps';
    public $route_parameter = 'tech_map';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ${$this->route_name} = TechMap::latest()
            ->paginate(12);

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            $this->route_name => ${$this->route_name}
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $techMapGroups = TechMapGroup::get();

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'tech_map_groups' => $techMapGroups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'tech_map_group_id' => 'required|integer|exists:tech_map_groups,id',
            'title' => 'required|string|max:65535',
            // 'agreed_at' => 'nullable|date',
            'agreed' => 'required|in:yes,no',
            'code' => 'required|string|max:255',
            'hours' => 'required|integer|min:0',
            'minutes' => 'required|integer|min:0|max:59',
            'comments' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        BaseController::store(TechMap::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TechMap $techMap)
    {
        $files = $this->get('App\Models\TechMaps\TechMap', $techMap->id);
        $operations = DB::table('tech_map_operations')
                        ->get();
        $techMapOperations = DB::table('tech_map_operations')
                                ->where('tech_map_id', $techMap->id)
                                ->join('tech_operations', 'tech_map_operations.model_id', '=', 'tech_operations.id')
                                ->orderBy('position')
                                ->get();

        return view('app.'.$this->route_name.'.show', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'item' => $techMap,
            'files' => $files,
            'operations' => $operations,
            'tech_map_operations' => $techMapOperations,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TechMap $techMap)
    {
        $techMapGroups = TechMapGroup::get();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'tech_map' => $techMap,
            'tech_map_groups' => $techMapGroups,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TechMap $techMap)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'tech_map_group_id' => 'required|integer|exists:tech_map_groups,id',
            'title' => 'required|string|max:65535',
            // 'agreed_at' => 'nullable|date',
            'agreed' => 'required|in:yes,no',
            'code' => 'required|string|max:255',
            'hours' => 'required|integer|min:0',
            'minutes' => 'required|integer|min:0|max:59',
            'comments' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        if (is_null($techMap->agreed_at) && $data['agreed'] == 'yes') $data['agreed_at'] = '2000-01-01';

        BaseController::store($techMap, $data, 1);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TechMap $techMap)
    {
        BaseController::destroy($techMap);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }


    public function addOperation(TechMap $techMap)
    {
        $techMaps = TechMap::latest()
            ->get()
            ->except($techMap->id);
        $techOperations = TechOperation::latest()
            ->get();
        $techMapOperations = DB::table('tech_map_operations')
                                ->where('tech_map_id', $techMap->id)
                                ->get();

        return view('app.'.$this->route_name.'.operations.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'tech_map' => $techMap,
            'tech_maps' => $techMaps,
            'tech_operations' => $techOperations,
            'tech_map_operations' => $techMapOperations,
        ]);
    }

    public function storeOperation(Request $request, TechMap $techMap)
    {
        $data = $request->all();
        // dd($data);

        $validator = Validator::make($data, [
            'position' => 'required|array',
            'position.*' => 'nullable|min:1|max:100',
            'tech_operation_id' => 'required|array',
            'tech_operation_id.*' => 'nullable|exists:tech_operations,id',
            'tech_map_id' => 'required|array',
            'tech_map_id.*' => 'nullable|exists:tech_maps,id',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        DB::beginTransaction();
        try {
            DB::table('tech_map_operations')
                ->where('tech_map_id', $techMap->id)
                ->delete();
            for ($i=1; $i < 101; $i++) { 
                if ($data['position'][$i] && ($data['tech_operation_id'][$i] || $data['tech_map_id'][$i])) {
                    if ($data['tech_operation_id'][$i]) DB::table('tech_map_operations')
                                                            ->insert([
                                                                'tech_map_id' => $techMap->id,
                                                                'model' => 'App\Models\TechMaps\TechOperation',
                                                                'model_id' => $data['tech_operation_id'][$i],
                                                                'position' => $data['position'][$i],
                                                            ]);
                    else DB::table('tech_map_operations')
                            ->insert([
                                'tech_map_id' => $techMap->id,
                                'model' => 'App\Models\TechMaps\TechMap',
                                'model_id' => $data['tech_map_id'][$i],
                                'position' => $data['position'][$i],
                            ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        return redirect()
                ->route($this->route_name.'.show', ['tech_map' => $techMap])
                ->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ]);
    }

    public function editOperation(Request $request, TechMap $techMap, int $pivotId)
    {
        //
    }

    public function updateOperation(Request $request, TechMap $techMap, int $pivotId)
    {
        //
    }

    public function destroyOperation(TechMap $techMap, int $pivotId)
    {
        $securityMeasurePivot = DB::table('security_measure_tech_map')
                                ->where('id', $pivotId)
                                ->first();

        $securityMeasure = SecurityMeasure::findOrFail($securityMeasurePivot->security_measure_id);
        if ($securityMeasure->techMaps->count() == 1) $securityMeasure->delete();
        else DB::table('security_measure_tech_map')
            ->where('id', $pivotId)
            ->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }


    public function addSecurityMeasure(TechMap $techMap)
    {
        $techMapSecurityMeasures = $techMap->securityMeasures->pluck('security_measures_id');
        $securityMeasures = SecurityMeasure::whereNotIn('id', $techMapSecurityMeasures)->get();

        return view('app.'.$this->route_name.'.security_measures.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'tech_map' => $techMap,
            'security_measures' => $securityMeasures,
        ]);
    }

    public function storeSecurityMeasure(Request $request, TechMap $techMap)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'action' => 'required|in:Сохранить,Сохранить и добавить еще',
            'security_measure_id' => 'nullable|integer|exists:security_measures,id',
            'title' => [Rule::requiredIf(!isset($data['security_measure_id'])), 'max:65535'],
            'desc' => [Rule::requiredIf(!isset($data['security_measure_id'])), 'max:65535'],
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        if (isset($data['security_measure_id'])) $techMap->securityMeasures()->attach($data['security_measure_id']);
        else {
            DB::beginTransaction();
            try {
                $securityMeasure = SecurityMeasure::create([
                    'title' => $data['title'],
                    'desc' => $data['desc'],
                    'tech_map_id' => $techMap->id
                ]);
                $techMap->securityMeasures()->attach($securityMeasure->id);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                return back()->withInput()->with([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }

        return $data['action'] == 'Сохранить и добавить еще'
            ? redirect()->route($this->route_parameter.'.security_measures.add', ['tech_map' => $techMap])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ])
            : redirect()->route($this->route_name.'.show', ['tech_map' => $techMap])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ]);
    }

    public function editSecurityMeasure(Request $request, TechMap $techMap, int $pivotId)
    {
        //
    }

    public function updateSecurityMeasure(Request $request, TechMap $techMap, int $pivotId)
    {
        //
    }

    public function destroySecurityMeasure(TechMap $techMap, int $pivotId)
    {
        $securityMeasurePivot = DB::table('security_measure_tech_map')
                                ->where('id', $pivotId)
                                ->first();

        $securityMeasure = SecurityMeasure::findOrFail($securityMeasurePivot->security_measure_id);
        if ($securityMeasure->techMaps->count() == 1) $securityMeasure->delete();
        else DB::table('security_measure_tech_map')
            ->where('id', $pivotId)
            ->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }


    public function addTechMapFile(TechMap $techMap)
    {
        $techMapSecurityMeasures = $techMap->securityMeasures->pluck('security_measures_id');
        $securityMeasures = SecurityMeasure::whereNotIn('id', $techMapSecurityMeasures)->get();

        return view('app.'.$this->route_name.'.tech_map_files.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'tech_map' => $techMap,
            'tech_map_files' => $securityMeasures,
        ]);
    }

    public function storeTechMapFile(Request $request, TechMap $techMap)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'action' => 'required|in:Сохранить,Сохранить и добавить еще',
            'files' => 'required|array',
            'files.*' => 'required|file',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        // upload files
        if($request->hasFile('files')) $res = $this->upload('App\Models\TechMaps\TechMap', $techMap->id, $request->file('files'));
        if(isset($res['error'])) return back()->with([
            'success' => false,
            'message' => $res['error']
        ]);

        return $data['action'] == 'Сохранить и добавить еще'
            ? redirect()->route($this->route_parameter.'.tech_map_files.add', ['tech_map' => $techMap])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ])
            : redirect()->route($this->route_name.'.show', ['tech_map' => $techMap])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ]);
    }

    public function editTechMapFile(Request $request, TechMap $techMap, int $pivotId)
    {
        //
    }

    public function updateTechMapFile(Request $request, TechMap $techMap, int $pivotId)
    {
        //
    }

    public function destroyTechMapFile(TechMap $techMap, int $pivotId)
    {
        // $securityMeasurePivot = DB::table('security_measure_tech_map')
        //                         ->where('id', $pivotId)
        //                         ->first();

        // $securityMeasure = SecurityMeasure::findOrFail($securityMeasurePivot->security_measure_id);
        // if ($securityMeasure->techMaps->count() == 1) $securityMeasure->delete();
        // else DB::table('security_measure_tech_map')
        //     ->where('id', $pivotId)
        //     ->delete();

        // return back()->with([
        //     'success' => true,
        //     'message' => 'Успешно удален'
        // ]);
    }
}
