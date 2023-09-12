<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Equipment;
use App\Models\TechnicalInspection;
use App\Models\TypeTechnicalInspection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TechnicalInspectionController extends Controller
{
    public $title = 'Технические обслуживания';
    public $route_name = 'technical_inspections';
    public $route_parameter = 'technical_inspection';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $technical_inspections = TechnicalInspection::latest();
        $search = null;
        if(isset($request->equipment_id) && $request->equipment_id != '') {
            $technical_inspections = $technical_inspections->whereHas('detail', function ($q) use ($request) {
                $q->where('equipment_id', $request->equipment_id);
            });
            $search = $request->equipment_id;
        }
        $technical_inspections = $technical_inspections->paginate(12);
        $equipments = Equipment::all();

        return view('app.'.$this->route_name.'.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'technical_inspections' => $technical_inspections,
            'equipments' => $equipments,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $equipments = Equipment::all();
        $type_technical_inspections = TypeTechnicalInspection::all();
        $details = Detail::where([
            ['equipment_id', $equipments[0]->id],
            // ['type_technical_inspection_id', $type_technical_inspections[0]->id]
        ])
        ->get();

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'details' => $details,
            'equipments' => $equipments,
            'type_technical_inspections' => $type_technical_inspections
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['date'] = isset($data['date']) ? date('Y-m-d', strtotime($data['date'])) : date('Y-m-d');

        $validator = Validator::make($data, [
            'type_technical_inspection_id' => 'required',
            'who_conducted' => 'required',
            'desc' => 'required',
            'details' => 'required|array',
            'details.*' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        DB::beginTransaction();
        try {
            foreach($data['details'] as $item) {
                $data['detail_id'] = $item;
                BaseController::store(TechnicalInspection::class, $data);

                Detail::find($data['detail_id'])
                    ->update([
                        'planned' => $data['next']
                    ]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка транзакции'
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
    public function show(TechnicalInspection $technicalInspection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TechnicalInspection $technicalInspection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TechnicalInspection $technicalInspection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TechnicalInspection $technicalInspection)
    {
        DB::beginTransaction();
        try {
            BaseController::destroy($technicalInspection);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with([
                'success' => false,
                'message' => 'Transaction error'
            ]);
        }

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
