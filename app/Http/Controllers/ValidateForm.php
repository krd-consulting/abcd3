<?php

namespace App\Http\Controllers;

use App\FormTargetType;

use App\Http\Requests\InitializeForm;

class ValidateForm extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(InitializeForm $form)
    {
        $target = [];
        $targetType = FormTargetType::find($form->validated()['target']['type']);
        $class = $targetType->model;

        if(!empty($form->validated()['target']['id']))
            $target = (new $class)::find($form->validated()['target']['id']);

        $target['type'] = $targetType;

        $data = [
            'name' => $form->validated()['name'],
            'description' => $form->validated()['description'],
            'type' => $form->validated()['type'],
            'team_id' => $form->validated()['team_id'],
            'scope_id' => $form->validated()['scope_id'],
            'target' => $target
        ];

        return [
            'data' => $data
        ];
    }
}
