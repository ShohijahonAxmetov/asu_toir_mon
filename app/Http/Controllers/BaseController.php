<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public static function store($model, $data, $update = 0)
    {
        if($update) {
            $model->update($data);
        } else {
            $model = "\\".$model;

            $model::create($data);
        }
    }

    public static function destroy($model)
    {
        $model->delete();
    }
}
