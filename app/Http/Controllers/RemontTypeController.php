<?php

namespace App\Http\Controllers;

use App\Models\RemontType;
use App\Models\TypeEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RemontTypeController extends Controller
{
    public $title = 'Вид ремонта';
    public $route_name = 'remont_types';
    public $route_parameter = 'remont_type';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $remont_types = RemontType::latest()
            ->paginate(12);

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'remont_types' => $remont_types
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
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        BaseController::store(RemontType::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(RemontType $remontType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RemontType $remontType)
    {
        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'remont_type' => $remontType
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RemontType $remontType)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        BaseController::store($remontType, $data, 1);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RemontType $remontType)
    {
        BaseController::destroy($remontType);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
