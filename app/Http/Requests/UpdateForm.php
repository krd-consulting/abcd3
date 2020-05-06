<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateForm extends FormRequest
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

    protected function prepareForValidation()
    {
        $target = explode('_', $this->target);

        $target_type_id = $target[0];

        $target_id = NULL;

        if(isset($target[1])) {
            $target_id = $target[1];
        }

        if(isset($this->name) && isset($this->target_type_id)) {
            $this->merge([
                'name' => $this->name,
                'target_type_id' => $target_type_id,
                'target_id' => $target_id,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required',
            'description' => '',
            'type' => [
                'sometimes',
                'required',
                Rule::in(config('app.form_types'))
            ],
            'target_type_id' => 'sometimes|required|exists:form_target_types,id',
            'target_id' => 'sometimes|nullable|exists:record_types,id',
            'scope_id' => 'sometimes|required|exists:scopes,id',
            'active' => 'sometimes|boolean'
        ];
    }
}
