<?php

namespace App\Http\Requests;

use App\Group;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroup extends FormRequest
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

                    // Check whether the group name already exists within the program (excludes the group being edited).
                    Rule::unique('groups')->where(function ($query) {
                        return $query->where('program_id', $this->program_id)->where('id', '!=', $this->id);
                    })
                ],
            'program_id' => 'required|exists:programs,id'
        ];
    }
}
