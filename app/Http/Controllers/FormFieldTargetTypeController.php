<?php

namespace App\Http\Controllers;

use App\FieldTargetType;

use Illuminate\Http\Request;

class FormFieldTargetTypeController extends Controller
{
    public function index() 
    {
    	$targetTypes = FieldTargetType::select('id', 'name')->get();

        $targetTypes = $targetTypes->filter(function($value, $key) {
            return $value->name != config('app.form_target_types.record.name');
        });

        $recordType = FieldTargetType::where(
                'name', 
                config('app.form_target_types.record.name')
            )->first();

        $recordTypes = (
            $recordType->model
        )::select('id as target_id', 'name')->get();

        $recordTypes->map(function($type) use ($recordType) {
            $type['id'] = $recordType->id;

            return $type;
        });

        $targetTypes = $targetTypes->concat($recordTypes);

        $targetTypes->map(function($type) {
            $type['target'] = !empty($type['target_id']) ? $type['id'] . '_' . $type['target_id'] : $type['id'];

            unset($type['id']);
            unset($type['target_id']);

            return $type;
        });

        return [
            'data' => $targetTypes
        ];
    }
}
