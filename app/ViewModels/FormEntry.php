<?php

namespace App\ViewModels;

use App\Contracts\ViewModel\Resource;

use Spatie\ViewModels\ViewModel;

class FormViewModel extends ViewModel
{
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function entries()
    {

    }
}
