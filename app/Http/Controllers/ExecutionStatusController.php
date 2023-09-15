<?php

namespace App\Http\Controllers;

use App\Models\ExecutionStatus;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ExecutionStatusController extends Controller
{
    public $title = 'Статусы исполнения';
    public $route_name = 'execution_statuses';
    public $route_parameter = 'execution_status';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Обищий список
        $execution_statuses = ExecutionStatus::latest()
            ->paginate(12);

        return view('app.execution_statuses.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'execution_statuses' => $execution_statuses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Добавление
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
        // Проверка и сохранеие
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

        BaseController::store(ExecutionStatus::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExecutionStatus $executionStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExecutionStatus $execution_status)
    {
        // Редактирование
        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'execution_status' => $execution_status
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExecutionStatus $execution_status)
    {
        // обновление данных
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

        BaseController::store($execution_status, $data, 1);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExecutionStatus $execution_status)
    {
        //
        BaseController::destroy($execution_status);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
