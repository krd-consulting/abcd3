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
            'field_1_value' => $this->fieldRules()[$recordType->identity->field1->slug],
            'field_2_value' => $this->fieldRules()[$recordType->identity->field2->slug],
            'field_3_value' => $this->fieldRules()[$recordType->identity->field3->slug],
            'active' => 'sometimes|boolean'
        ];
    }

    private function fieldRules()
    {
        return [
            'first_name' => 'sometimes|required',
            'last_name' => 'sometimes|required',
            'business_name' => 'sometimes|required',
            'email_address' => 'sometimes|required|email',
            'contact_number' => 'sometimes|required',
            'birth_date' => 'sometimes|required|date|before:tomorrow',
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
