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
        return $this->user()->can('write', Group::find($this->route('group')));
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
                    Rule::unique('groups')->where(function ($query) {
                        return $query->where('program_id', $this->program_id)->where('id', '!=', $this->id);
                    })
                ],
            'program_id' => 'required|exists:programs,id'
        ];
    }
}
