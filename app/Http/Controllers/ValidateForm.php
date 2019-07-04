<?php

namespace App\Http\Controllers;

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
        return [
            'data' => $form->validated()
        ];
    }
}
