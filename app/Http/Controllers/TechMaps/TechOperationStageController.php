<?php

namespace App\Http\Controllers\TechMaps;

use App\Models\TechMaps\TechOperationStage;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TechOperationStageController extends Controller
{
    public $title = 'Этапы';
    public $route_name = 'tech_operation_stages';
    public $route_parameter = 'tech_operation_stage';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ${$this->route_name} = TechOperationStage::latest()
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
            'title' => 'required',
            'desc' => 'nullable'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->getErrors()
            ]);
        }

        BaseController::store(TechOperationStage::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TechOperationStage $techOperationStage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TechOperationStage $techOperationStage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TechOperationStage $techOperationStage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TechOperationStage $techOperationStage)
    {
        //
    }
}
