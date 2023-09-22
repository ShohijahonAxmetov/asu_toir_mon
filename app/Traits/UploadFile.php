<?php

namespace App\Traits;

use App\Models\UploadedFile;
use Illuminate\Support\Str;

trait UploadFile
{
    public function upload($model, $model_id, $files)
    {
        $allowedfileExtension=['pdf','jpg','png','docx'];

        foreach($files as $file){
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);

            if($check) {
                $name = (string)Str::uuid();

                $path = $file->storeAs('upload/files/technical_resources', $name, 'public');

                // $path = $file->store('public/upload/files/technical_resources');
                // $path = 
                UploadedFile::create([
                    'model' => $model,
                    'model_id' => $model_id,
                    'name' => $path,
                    'ext' => $extension,
                    'original_name' => $filename,
                    'desc' => null
                ]);
            } else {
                return [
                    'error' => 'Формат файла не поддерживается'
                ];
            }
        }

        return 'OK';
    }

    public function get($model, $model_id)
    {
        $files = UploadedFile::where([
            ['model', $model],
            ['model_id', $model_id]
        ])
        ->get();

        return $files;
    }
}
