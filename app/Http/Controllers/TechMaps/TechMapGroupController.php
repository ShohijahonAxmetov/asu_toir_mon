<?php

namespace App\Http\Controllers\TechMaps;

use App\Models\TechMaps\TechMapGroup;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TechMapGroupController extends Controller
{
    public $title = 'Группа технологических карт';
    public $route_name = 'tech_map_groups';
    public $route_parameter = 'tech_map_group';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ${$this->route_name} = TechMapGroup::latest()
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

        BaseController::store(TechMapGroup::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TechMapGroup $techMapGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TechMapGroup $techMapGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TechMapGroup $techMapGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TechMapGroup $techMapGroup)
    {
        //
    }
}
