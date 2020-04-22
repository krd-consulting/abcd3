<?php

namespace App\ViewModels;

use App\Contracts\ViewModel\Resource;

use Spatie\ViewModels\ViewModel;

class FormEntry extends ViewModel
{
    public function __construct(Resource $target)
    {
        $this->target = $target;
    }
}
