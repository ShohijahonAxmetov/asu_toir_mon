<?php

namespace App\Http\Controllers;

use App\Models\UploadedFile;

use App\Traits\UploadFile;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UploadedFileController extends Controller
{
    use UploadFile;

    public $title = 'Файлы';
    public $route_name = 'files';
    public $route_parameter = 'file';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('app.files.create', [
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
            'model_id' => 'required|integer',
            'model' => 'required',
            'files' => 'required',
            'files.*' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        DB::beginTransaction();
        try {

            // upload files
            if($request->hasFile('files')) $res = $this->upload($request->model, $request->model_id, $request->file('files'));
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

        return redirect()->route('technical_resources.show', ['technical_resource' => $request->model_id])->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(UploadedFile $uploadedFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UploadedFile $uploadedFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UploadedFile $uploadedFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uploadedFile)
    {
        $uploadedFile = UploadedFile::find($uploadedFile);
        
        BaseController::destroy($uploadedFile);

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
