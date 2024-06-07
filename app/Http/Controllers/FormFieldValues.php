<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\FormField;
use App\FieldTargetType;

class FormFieldValues extends Controller
{
    public function __invoke(FormField $field) {
        $referredModel = FieldTargetType::find($field->reference_target_type_id)->model;
        $object = new $referredModel;

        // TODO: search

        return $object->getFormFieldReferenceValues(
            $field->reference_target_id,
            request('search')
        )->availableFor(auth()->user())->paginate();
    }
}
