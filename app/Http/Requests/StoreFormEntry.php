<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Carbon\Carbon;

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

    protected function prepareForValidation()
    {
        $this->castDateFields();
    }

    protected function castDateFields()
    {
        $fields = $this->form->fields;

        $toBeMerged = [];

        foreach($fields as $field) {
            if($field->type == 'date') {
                $columnName = $field->column_name;

                $toBeMerged[$columnName]
                     = Carbon::parse($this->$columnName)->toDateTimeString();
            }
        }

        $this->merge($toBeMerged);
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
