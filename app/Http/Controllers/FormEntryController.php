<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Form;
use App\FormEntry;
use App\Http\Requests\StoreFormEntry;
use App\Http\Resources\FormEntries;

use Illuminate\Http\Request;

use Barryvdh\Debugbar\Facade as Debugbar;

class FormEntryController extends Controller
{
  	public function index(Form $form)
  	{
        $entry = new FormEntry;
        $entry->setTable($form->table_name);

        $entry->castFieldsToArray($form->fields()->whereIn('type', ['checkbox', 'file'])->pluck('column_name'));

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
        $entry->castFieldsToArray($form->fields()->whereIn('type', ['checkbox', 'file'])->pluck('column_name'));

        // Loop through fields; look for file fields; attach files to the target.
        foreach($form->fields as $field) {
            if($field->type != 'file') {
                continue;
            }

            $attachmentIds = $request->input($field->column_name);
            $attachments = [];

            foreach($attachmentIds as $id) {
                $attachments[] = Attachment::find($id);
            }

            $target = $form->target;

            $model = (new $target)->getFormReferenceClass();
            $model = ($model)::find($request->input('target_id'));
            $model->attachments()->saveMany($attachments);
        }

  		  $entry->fill($request->validated());
  		  $entry->save();

  		  return [
  			   'data' => $entry
  		  ];
    }
}
