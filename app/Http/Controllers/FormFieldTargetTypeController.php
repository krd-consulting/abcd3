<?php

namespace App\Http\Controllers;

use App\FieldTargetType;

use Illuminate\Http\Request;

class FormFieldTargetTypeController extends Controller
{
    public function index() 
    {
    	$targetTypes = FieldTargetType::select('id', 'name')->get();

        return [
            'data' => $targetTypes
        ];
    }

    public function show(FieldTargetType $targetType)
    {
        $response = [
            'data' => collect($targetType)
        ];

        if(request('target_id')) {
            $model = new $targetType->model;
            $response['data']['name'] = $model::find(request('target_id'))->name;
        }

        return $response;
    }
}
