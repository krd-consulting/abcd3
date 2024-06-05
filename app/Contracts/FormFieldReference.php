<?php
namespace App\Contracts;

interface FormFieldReference
{

    // function that specify which fields to reference so that we can rename/alias them or
    public function attachFormFieldReference($formEntryQueryBuilder, $formTable, $fieldColumn);

}
