<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Form;
use App\FormEntry;
use App\Http\Requests\StoreFormEntry;

class FormEntryController extends Controller
{
    public function store(Form $form, StoreFormEntry $request) 
    {
    	$entry = new FormEntry;
    	$entry->setTable($form->table_name);

		$entry->create($request->validated());

		return $entry->first();
    }
}
