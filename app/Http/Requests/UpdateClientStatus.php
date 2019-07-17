<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientStatus extends FormRequest
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
// <<<<<<< HEAD
            'id' => 'exists:client_statuses,id',
            'name' => 'unique:teams,name,' . $this->input('id'),
// =======
//             'id' => 'required|exists:client_statuses,id',
//             'name' => 'unique:client_statuses,name,' . $this->input('id'),
// >>>>>>> styles/june-11
            'description' => '',
            'enabled' => 'boolean'
        ];
    }
}
