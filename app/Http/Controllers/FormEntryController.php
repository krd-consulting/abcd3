<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormEntry;
use App\Http\Requests\StoreFormEntry;
use App\Http\Resources\FormEntries;

use Barryvdh\Debugbar\Facade as Debugbar;

class FormEntryController extends Controller
{
	public function index(Form $form)
	{
        $entry = new FormEntry;
        $entry->setTable($form->table_name);

        $perPage = request('perPage');
        $entries = $entry->paginate($perPage);

        $entries->load('target');

        $entries = (new FormEntries($entries, $form->target_type));

        return $entries;
	}

    public function store(Form $form, StoreFormEntry $request)
    {
        // TODO: authorize

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
