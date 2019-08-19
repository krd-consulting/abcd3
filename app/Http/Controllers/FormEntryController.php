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
    	$entry->castFieldsToArray($form->fields()->where('type', 'checkbox')->pluck('column_name'));
		$entry->fill($request->validated());
		$entry->save();

		return [
			'data' => $entry->latest()->first()
		];
    }
}
