<?php

namespace App\Observers;

use App\FormField;

class FormFieldObserver
{
    public function creating(FormField $field)
    {
        dump($field->type);

        if($field->type == 'MatrixField')
            $field->type = 'RadioField';
    }
}
