<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\FormTargetType;
use App\Scope;

class InitializeForm extends FormRequest
{

    protected $hasTargetId = false;

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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $target = explode('_', $this->target);

        $this->target = [];

        $this->target['type'] = $target[0];


        if(isset($target[1])) {
            $this->target['id'] = $target[1];
            $this->hasTargetId = true;
        }

        $this->merge([
            'name' => $this->name,
            'target' => $this->target
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $universal = Scope::where('name' , config('auth.scopes.universal.name'))->first()->id;
        $self = Scope::where('name' , config('auth.scopes.self.name'))->first()->id;

        return [
            'name' => 'required',
            'description' => '',
            'owner_id' => "sometimes|nullable|required_unless:scope_id,$universal,$self",
            'type' => [
                'required',
                Rule::in(config('app.form_types'))
            ],
            'target.type' => 'required|exists:form_target_types,id',
            'target.id' => 'exists:record_types,id',
            'scope_id' => 'required|exists:scopes,id'
        ];
    }
}
