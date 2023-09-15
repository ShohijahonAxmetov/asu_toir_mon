<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public static function store($model, $data, $update = 0)
    {
        if($update) {
            $result = $model->update($data);
        } else {
            $model = "\\".$model;

            $result = $model::create($data);
        }

        return $result;
    }

    public static function destroy($model)
    {
        $model->delete();
    }
}
