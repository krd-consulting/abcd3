<?php

namespace App\Http\Requests;

use App\Program;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgram extends FormRequest
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
            'id' => 'required|exists:programs,id',
            'name' => [
                    'required',

                    // Check whether the program name already exists within the team (excludes the group being edited).
                    Rule::unique('programs')->where(function ($query) {
                        return $query->where('team_id', $this->team_id)->where('id', '!=', $this->id);
                    })
                ]
            'team_id' => 'required|exists:teams,id'
        ];
    }
}
