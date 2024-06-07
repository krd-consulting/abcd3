<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Form;
use App\FormEntry;
use App\FormField;

class FormFieldEntries extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(FormField $field)
    {
        $form = $field->form;

        $entries = new FormEntry; 
        $entries->setTable($form->table_name);

        // Search
        $search = request('search');
        $entries->searchColumns = [$field->column_name];
        $entries = $entries->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $entries = $entries->sort($sortBy, $ascending);

        $entries->select('id', "$field->column_name as value");

        // Paginate per request.
        $perPage = request('perPage');
        $entries = $entries->paginate($perPage);

        return $entries;
    }
}
