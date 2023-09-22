<?php

namespace App\Http\Controllers;

use App\Models\TechnicalResource;
use App\Models\Unit;

use App\Traits\UploadFile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TechnicalResourceController extends Controller
{
    use UploadFile;

    public $title = 'Материально-технические ресурсы';
    public $route_name = 'technical_resources';
    public $route_parameter = 'technical_resource';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $technical_resources = TechnicalResource::latest()
            ->paginate(12);

        return view('app.technical_resources.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'technical_resources' => $technical_resources
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::orderBy('name', 'ASC')
                ->get();

        return view('app.'.$this->route_name.'.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'units' => $units,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'catalog_name' => 'required',
            'catalog_number' => 'required',
            'nomen_name' => 'required',
            'nomen_number' => 'required',
            'time_complete_order' => 'required|integer',
            'delivery_time' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        DB::beginTransaction();
        try {

            $model = BaseController::store(TechnicalResource::class, $data);

            // upload files
            if($request->hasFile('files')) $res = $this->upload('App\Models\TechnicalResource', $model->id, $request->file('files'));
            if(isset($res['error'])) return back()->with([
                'success' => false,
                'message' => $res['error']
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with([
                'success' => false,
                'message' => $e->getMessage()
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
    public function show(TechnicalResource $technicalResource)
    {
        $files = $this->get('App\Models\TechnicalResource', $technicalResource->id);
        $units = Unit::orderBy('name', 'ASC')
            ->get();


        return view('app.'.$this->route_name.'.show', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'item' => $technicalResource,
            'units' => $units,
            'files' => $files,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TechnicalResource $technicalResource)
    {
        $units = Unit::orderBy('name', 'ASC')
            ->get();


        return view('app.'.$this->route_name.'.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'technical_resource' => $technicalResource,
            'units' => $units,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TechnicalResource $technicalResource)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'catalog_name' => 'required',
            'catalog_number' => 'required',
            'nomen_name' => 'required',
            'nomen_number' => 'required',
            'time_complete_order' => 'required|integer',
            'delivery_time' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return back()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        DB::beginTransaction();
        try {

            BaseController::store($technicalResource, $data, 1);

            // upload files
            if($request->hasFile('files')) $res = $this->upload('App\Models\TechnicalResource', $technicalResource->id, $request->file('files'));
            if(isset($res['error'])) return back()->with([
                'success' => false,
                'message' => $res['error']
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TechnicalResource $technicalResource)
    {
        BaseController::destroy($technicalResource);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
