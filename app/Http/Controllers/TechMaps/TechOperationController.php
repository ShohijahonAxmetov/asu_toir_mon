<?php

namespace App\Http\Controllers\TechMaps;

use App\Models\Catalog\Instrument;
use App\Models\Catalog\RepairEquipment;
use App\Models\Catalog\Qualification;
use App\Models\Unit;
use App\Models\TechnicalResource;
use App\Models\TechMaps\TechOperationStage;
use App\Models\TechMaps\TechOperation;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TechOperationController extends Controller
{
    public $title = 'Технологические операции';
    public $route_name = 'tech_operations';
    public $route_parameter = 'tech_operation';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ${$this->route_name} = TechOperation::latest()
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
        $units = Unit::get();
        $techOperationStages = TechOperationStage::get();

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'units' => $units,
            'techOperationStages' => $techOperationStages,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'tech_operation_stage_id' => 'required|integer|exists:tech_operation_stages,id',
            'title' => 'required|string|max:65535', // Максимальная длина для поля типа text
            'full_title' => 'nullable|string|max:65535',
            'hours' => 'required|integer|min:0',
            'minutes' => 'required|integer|min:0|max:59',
            'amount' => 'nullable|integer|min:0', // Так как это bigint, используем integer, который поддерживает большие числа
            'content' => 'nullable|string|max:16777215', // mediumtext
            'comments' => 'nullable|string|max:16777215', // mediumtext
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->getErrors()
            ]);
        }

        BaseController::store(TechOperation::class, $data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TechOperation $techOperation)
    {
        // $files = $this->get('App\Models\TechnicalResource', $technicalResource->id);
        // $units = Unit::get();

        return view('app.'.$this->route_name.'.show', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'item' => $techOperation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TechOperation $techOperation)
    {
        $units = Unit::get();
        $techOperationStages = TechOperationStage::get();

        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'tech_operation' => $techOperation,
            'units' => $units,
            'tech_operation_stages' => $techOperationStages,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TechOperation $techOperation)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'tech_operation_stage_id' => 'required|integer|exists:tech_operation_stages,id',
            'title' => 'required|string|max:65535', // Максимальная длина для поля типа text
            'full_title' => 'nullable|string|max:65535',
            'hours' => 'required|integer|min:0',
            'minutes' => 'required|integer|min:0|max:59',
            'amount' => 'nullable|integer|min:0', // Так как это bigint, используем integer, который поддерживает большие числа
            'content' => 'nullable|string|max:16777215', // mediumtext
            'comments' => 'nullable|string|max:16777215', // mediumtext
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        BaseController::store($techOperation, $data, 1);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TechOperation $techOperation)
    {
        BaseController::destroy($techOperation);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }

    public function addTechnicalResource(TechOperation $techOperation)
    {
        $units = Unit::get();
        $technicalResources = TechnicalResource::get();

        return view('app.'.$this->route_name.'.technical_resources.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'units' => $units,
            'techOperation' => $techOperation,
            'technicalResources' => $technicalResources,
        ]);
    }

    public function storeTechnicalResource(Request $request, TechOperation $techOperation)
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

        $techOperation->technicalResources()->attach($data['technical_resource_id'], [
            'quantity' => $data['quantity'],
            'unit_id' => $data['unit_id'],
            'characteristics' => $data['characteristics'],
        ]);

        return $data['action'] == 'Сохранить и добавить еще'
            ? redirect()->route($this->route_parameter.'.tech_resources.add', ['tech_operation' => $techOperation])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ])
            : redirect()->route($this->route_name.'.show', ['tech_operation' => $techOperation])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ]);
    }

    public function editTechnicalResource(Request $request, TechOperation $techOperation, int $pivotId)
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
            'techOperation' => $techOperation,
            'technicalResources' => $technicalResources,
            'pivot' => $pivot,
        ]);
    }

    public function updateTechnicalResource(Request $request, TechOperation $techOperation, int $pivotId)
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

        return redirect()->route($this->route_name.'.show', ['tech_operation' => $techOperation])->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    public function destroyTechnicalResource(TechOperation $techOperation, int $pivotId)
    {
        DB::table('tech_operation_technical_resource')
            ->where('id', $pivotId)
            ->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }

    // Трудовые затраты
    public function addQualification(TechOperation $techOperation)
    {
        $qualifications = Qualification::get();

        return view('app.'.$this->route_name.'.qualifications.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'techOperation' => $techOperation,
            'qualifications' => $qualifications,
        ]);
    }

    public function storeQualification(Request $request, TechOperation $techOperation)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'action' => 'required|in:Сохранить,Сохранить и добавить еще',
            // 'tech_operation_id' => 'required|integer|exists:tech_operations,id',
            'qualification_id' => 'required|integer|exists:qualifications,id',
            'characteristics' => 'nullable|string',
            'count' => 'required|integer|min:1',  // Минимум один сотрудник
            'hours' => 'required|integer|min:0',  // Часы >= 0
            'minutes' => 'required|integer|min:0|max:59',  // Минуты должны быть от 0 до 59
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $techOperation->qualifications()->attach($data['qualification_id'], [
            'count' => $data['count'],
            'hours' => $data['hours'],
            'minutes' => $data['minutes'],
            'characteristics' => $data['characteristics'],
        ]);

        return $data['action'] == 'Сохранить и добавить еще'
            ? redirect()->route($this->route_parameter.'.qualifications.add', ['tech_operation' => $techOperation])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ])
            : redirect()->route($this->route_name.'.show', ['tech_operation' => $techOperation])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ]);
    }

    public function editQualification(Request $request, TechOperation $techOperation, int $pivotId)
    {
        $qualifications = Qualification::get();
        $pivot = DB::table('qualification_tech_operation')
            ->where('id', $pivotId)
            ->first();

        return view('app.'.$this->route_name.'.qualifications.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'techOperation' => $techOperation,
            'qualifications' => $qualifications,
            'pivot' => $pivot,
        ]);
    }

    public function updateQualification(Request $request, TechOperation $techOperation, int $pivotId)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            // 'tech_operation_id' => 'required|integer|exists:tech_operations,id',
            'qualification_id' => 'required|integer|exists:qualifications,id',
            'characteristics' => 'nullable|string',
            'count' => 'required|integer|min:1',  // Минимум один сотрудник
            'hours' => 'required|integer|min:0',  // Часы >= 0
            'minutes' => 'required|integer|min:0|max:59',  // Минуты должны быть от 0 до 59
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        
        DB::table('qualification_tech_operation')
            ->where('id', $pivotId)
            ->update([
                'qualification_id' => $data['qualification_id'],
                'characteristics' => $data['characteristics'],
                'count' => $data['count'],
                'hours' => $data['hours'],
                'minutes' => $data['minutes'],
            ]);

        return redirect()->route($this->route_name.'.show', ['tech_operation' => $techOperation])->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    public function destroyQualification(TechOperation $techOperation, int $pivotId)
    {
        DB::table('qualification_tech_operation')
            ->where('id', $pivotId)
            ->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }




    // Техника
    public function addRepairEquipment(TechOperation $techOperation)
    {
        $repairEquipments = RepairEquipment::get();

        return view('app.'.$this->route_name.'.repair_equipments.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'techOperation' => $techOperation,
            'repairEquipments' => $repairEquipments,
        ]);
    }

    public function storeRepairEquipment(Request $request, TechOperation $techOperation)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'action' => 'required|in:Сохранить,Сохранить и добавить еще',
            // 'tech_operation_id' => 'required|integer|exists:tech_operations,id',
            'repair_equipment_id' => 'required|integer|exists:repair_equipments,id',
            'characteristics' => 'nullable|string',
            'count' => 'required|integer|min:1',  // Минимум один сотрудник
            'hours' => 'required|integer|min:0',  // Часы >= 0
            'minutes' => 'required|integer|min:0|max:59',  // Минуты должны быть от 0 до 59
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $techOperation->repairEquipments()->attach($data['repair_equipment_id'], [
            'count' => $data['count'],
            'hours' => $data['hours'],
            'minutes' => $data['minutes'],
            'characteristics' => $data['characteristics'],
        ]);

        return $data['action'] == 'Сохранить и добавить еще'
            ? redirect()->route($this->route_parameter.'.repair_equipments.add', ['tech_operation' => $techOperation])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ])
            : redirect()->route($this->route_name.'.show', ['tech_operation' => $techOperation])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ]);
    }

    public function editRepairEquipment(Request $request, TechOperation $techOperation, int $pivotId)
    {
        $repairEquipments = RepairEquipment::get();
        $pivot = DB::table('repair_equipment_tech_operation')
            ->where('id', $pivotId)
            ->first();

        return view('app.'.$this->route_name.'.repair_equipments.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'techOperation' => $techOperation,
            'repairEquipments' => $repairEquipments,
            'pivot' => $pivot,
        ]);
    }

    public function updateRepairEquipment(Request $request, TechOperation $techOperation, int $pivotId)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            // 'tech_operation_id' => 'required|integer|exists:tech_operations,id',
            'repair_equipment_id' => 'required|integer|exists:repair_equipments,id',
            'characteristics' => 'nullable|string',
            'count' => 'required|integer|min:1',  // Минимум один сотрудник
            'hours' => 'required|integer|min:0',  // Часы >= 0
            'minutes' => 'required|integer|min:0|max:59',  // Минуты должны быть от 0 до 59
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        
        DB::table('repair_equipment_tech_operation')
            ->where('id', $pivotId)
            ->update([
                'repair_equipment_id' => $data['repair_equipment_id'],
                'characteristics' => $data['characteristics'],
                'count' => $data['count'],
                'hours' => $data['hours'],
                'minutes' => $data['minutes'],
            ]);

        return redirect()->route($this->route_name.'.show', ['tech_operation' => $techOperation])->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    public function destroyRepairEquipment(TechOperation $techOperation, int $pivotId)
    {
        DB::table('repair_equipment_tech_operation')
            ->where('id', $pivotId)
            ->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }





    // Инструменты
    public function addInstrument(TechOperation $techOperation)
    {
        $instruments = Instrument::get();

        return view('app.'.$this->route_name.'.instruments.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'techOperation' => $techOperation,
            'instruments' => $instruments,
        ]);
    }

    public function storeInstrument(Request $request, TechOperation $techOperation)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'action' => 'required|in:Сохранить,Сохранить и добавить еще',
            // 'tech_operation_id' => 'required|integer|exists:tech_operations,id',
            'instrument_id' => 'required|integer|exists:instruments,id',
            'characteristics' => 'nullable|string',
            'count' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $techOperation->instruments()->attach($data['instrument_id'], [
            'count' => $data['count'],
            'characteristics' => $data['characteristics'],
        ]);

        return $data['action'] == 'Сохранить и добавить еще'
            ? redirect()->route($this->route_parameter.'.instruments.add', ['tech_operation' => $techOperation])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ])
            : redirect()->route($this->route_name.'.show', ['tech_operation' => $techOperation])->with([
                    'success' => true,
                    'message' => 'Успешно сохранен'
                ]);
    }

    public function editInstrument(Request $request, TechOperation $techOperation, int $pivotId)
    {
        $instruments = Instrument::get();
        $pivot = DB::table('instrument_tech_operation')
            ->where('id', $pivotId)
            ->first();

        return view('app.'.$this->route_name.'.instruments.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'techOperation' => $techOperation,
            'instruments' => $instruments,
            'pivot' => $pivot,
        ]);
    }

    public function updateInstrument(Request $request, TechOperation $techOperation, int $pivotId)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            // 'tech_operation_id' => 'required|integer|exists:tech_operations,id',
            'instrument_id' => 'required|integer|exists:instruments,id',
            'characteristics' => 'nullable|string',
            'count' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        
        DB::table('instrument_tech_operation')
            ->where('id', $pivotId)
            ->update([
                'instrument_id' => $data['instrument_id'],
                'characteristics' => $data['characteristics'],
                'count' => $data['count'],
            ]);

        return redirect()->route($this->route_name.'.show', ['tech_operation' => $techOperation])->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    public function destroyInstrument(TechOperation $techOperation, int $pivotId)
    {
        DB::table('instrument_tech_operation')
            ->where('id', $pivotId)
            ->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
