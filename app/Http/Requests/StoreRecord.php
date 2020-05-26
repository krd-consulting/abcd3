<?php

namespace App\Http\Requests;

use App\RecordType;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecord extends FormRequest
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
        $recordType = $this->input('record_type_id');

        if(empty($recordType)) {
            return [
                'record_type_id' => 'exists:record_types,id',
            ];
        }

        $recordType = RecordType::find($recordType);

        return [
            'field_1_value' => $this->fieldRules()[$recordType->identity->field1->slug],
            'field_2_value' => $this->fieldRules()[$recordType->identity->field2->slug ?? 'none'],
            'field_3_value' => $this->fieldRules()[$recordType->identity->field3->slug ?? 'none'],
            'team_id' => 'required|exists:teams,id'
        ];
    }

    private function fieldRules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'name' => 'required',
            'email_address' => 'required|email',
            'contact_number' => 'required',
            'birth_date' => 'required|date|before:tomorrow',
            'none' => ''
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The field above is required.',
            'team_id.required' => 'Please select a team.',
            'date' => 'Please enter a valid date.',
            'email' => 'Please enter a valid email address.',
            'before' => 'Please enter a valid birth date.',
        ];
    }
}
