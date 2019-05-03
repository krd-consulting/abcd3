<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgram extends FormRequest
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
            'name' => [
                    'required',

                    // Check whether the program name already exists within the team.
                    Rule::unique('programs')->where(function ($query) {
                        return $query->where('team_id', $this->team_id);
                    })
                ],
            'team_id' => 'required|exists:teams,id'
        ];
    }
}
