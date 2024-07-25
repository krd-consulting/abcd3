<?php

namespace App\Http\Requests;

use App\File;

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
        $this->castMultiValueFields();
        $this->castDateFields();
    }

    // Apparently, in order to store an array in the db, you need
    // to serialize the value to json before saving (to a TEXT column).
    protected function castMultiValueFields() {
        $toBeMerged = [];

        foreach($this->form->fields as $field) {
            if(!$field->settings['single']) {
                $columnName = $field->column_name;
                $toBeMerged[$columnName] = json_encode($this->$columnName);
            }
        }

        $this->merge($toBeMerged);
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
            if($field->type == 'datetime') {
                $columnName = $field->column_name;

                $toBeMerged[$columnName]
                     = Carbon::parse($this->$columnName)->toDateTimeString();
            }
            if($field->type == 'time') {
                $columnName = $field->column_name;

                $toBeMerged[$columnName]
                     = Carbon::parse($this->$columnName)->toTimeString();
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
            'parent_entity_type_id'
                => 'required',    
            'parent_entity_id'
                => 'required',
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

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'This field is required'
        ];
    }
}
