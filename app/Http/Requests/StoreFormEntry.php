<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormEntry extends FormRequest
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
        $form = $this->form;

        $rules = [
            'target_id' 
                => 'required|exists:' . (new $form->target_type->model)->getFormReferenceTable() . ',id',
            'completed_at' => 'required|date'
        ];

        $fieldsRules = [];

        foreach($form->fields as $field) {
             if($field->settings->required == true) {
                $fieldsRules[$field->column_name] = 'required';
            }else {
                $fieldsRules[$field->column_name] = 'nullable';
            }
        }

        $rules = array_merge($rules, $fieldsRules);

        return $rules;
    }
}
