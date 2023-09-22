<?php

namespace App\Http\Controllers;

use App\Models\UploadedFile;
use Illuminate\Http\Request;

class UploadedFileController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
