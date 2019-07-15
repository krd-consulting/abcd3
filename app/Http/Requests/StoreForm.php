<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class StoreForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => '',
            'target_type_id' => 'required|exists:form_target_types,id',
            'target_id' => 'nullable|exists:record_types,id',
            'type' => 'required|in:pre-post,static',
            'team_id' => 'required|exists:teams,id',
            'scope_id' => 'required|exists:scopes,id',
            'fields.*.type' => 'required',
            'fields.*.label' => 'required',
            'fields.*.description' => '',
            'fields.*.target_type_id' => 'nullable|exists:form_target_types,id',
            'fields.*.target_id' => 'nullable|exists:record_types,id',
            'fields.*.settings.max' => 'integer',
            'fields.*.questions.*.text' => 'required_if:fields.*.type,matrix',
            'fields.*.choices.*.text' => 'required_if:fields.*.type,matrix,radio,checkbox,dropdown',
            'fields.*.choices.*.value' => 'required_if:fields.*.type,matrix,radio,checkbox,dropdown',
        ];
    }
}
