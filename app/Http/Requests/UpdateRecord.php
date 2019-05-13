<?php

namespace App\Http\Requests;

use App\Record;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecord extends FormRequest
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
        $recordType = $this->route('recordType');

        return [
            'field_1_value' => $this->fieldRules()[$recordType->identity->field1->name],
            'field_2_value' => $this->fieldRules()[$recordType->identity->field2->name],
            'field_3_value' => $this->fieldRules()[$recordType->identity->field3->name]
        ];
    }

    private function fieldRules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'business_name' => 'required',
            'email_address' => 'required|email',
            'contact_number' => 'required',
            'birth_date' => 'required|date|before:tomorrow',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The field above can\`t be empty.',
            'date' => 'Please enter a valid date.',
            'email' => 'Please enter a valid email address.',
            'before' => 'Please enter a valid birth date.',
        ];
    }
}
