<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Form;
use App\FormEntry;
use App\Http\Requests\StoreFormEntry;
use App\Http\Resources\FormEntries;
use App\Http\Resources\Teams;
use App\Record;
use App\RecordType;
use App\FieldTargetType;
use App\Team;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\RelationNotFoundException;

class FormEntryController extends Controller
{
  	public function index(Form $form)
  	{
        $entry = new FormEntry();
        $entry->setTable($form->table_name);

        $entry->castFieldsToArray($form->fields()->whereIn('type', ['checkbox', 'file'])->pluck('column_name'));

        $referencedFields = $form->fields()->whereNotNull('reference_target_type_id')->get();
        $newFields = [];

        // TODO: what to do when a referenced value has been deleted?
        // join references
        foreach ($referencedFields as $field) {
          $referredModel = FieldTargetType::find($field->reference_target_type_id)->model;
          $object = new $referredModel;
          $referredTable = $object->getTable();
          $entry = $entry->select("$form->table_name.*");
          $newFields = $object->attachFormFieldReference($entry, $form->table_name, $field->column_name, $field->reference_target_type_id);
        }

        $perPage = request('perPage');
        $entries = $entry->availableFor(auth()->user());

        // Specify which fields to select to avoid joins replacing values for
        // column names with same name
        $entries->select($newFields);
        $entries->addSelect("$form->table_name.*");
        
        $entries = $entries->paginate($perPage);

        $entries->load('target');
        // Load record type to prevent duplicate n+1 queries
        $this->loadRecordType($entries);
        $entries->load('team');
        $entries->load('creator');
        $form->load('fields.target_type');

        $entries = (new FormEntries(
          $entries, 
          $form, 
          $form->target_type, 
          $form->fields
        ));

        return $entries;
  	}

    private function loadRecordType($entries) {
      // #hack
      // could be done for other indirect relations
      // but for now, record type (through a record target)
      // is the only indirect relation we need.

      $hasRecordType = true;
      try {
        $entries->load('target.record_type');
      } catch(RelationNotFoundException $e) {
        $hasRecordType = false;
      }
      if($hasRecordType) {
        $entries->load('target.record_type');
      } else {
        $entries->load('target');
      }
    }

    public function teams(Form $form)
    {
        $entry = new FormEntry();
        $entry->setTable($form->table_name);
        $entries = $entry
          ->select(
            "$form->table_name.team_id",
            DB::raw('count(*) as entry_count'),
            DB::raw('MAX(created_at) as last_entry_created_at')
          )
          ->groupBy("$form->table_name.team_id")
          ->orderBy("$form->table_name.team_id", 'ASC')
          ->get()
          ->keyBy('team_id');
        $teams = $form->teams()->availableFor(auth()->user())->get();

        // return $teams;

        $teams = $teams->map(function ($team, $key) use ($entries) {
          $team['entries_history'] = [
            'count' => $entries[$team['id']]['entry_count'] ?? 0,
            'last_entry_created_at' => $entries[$team['id']]['last_entry_created_at'] ?? null,
          ];
          return $team;
        });

        return new Teams($teams);
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

            $attachmentPaths = $request->input($field->column_name);
            $attachments = [];

            foreach($attachmentPaths as $path) {
                $attachments[] = Attachment::where('path', $path)->first();
            }

            $target = $form->target;

            $model = (new $target)->getFormReferenceClass();
            $model = ($model)::find($request->input('target_id'));
            $model->attachments()->saveMany($attachments);
        }

  		  $entry->fill($request->validated());
  		  $entry->save();

        // Add form to team specified in entry.
        $form->teams()->syncWithoutDetaching([
            $request->input('team_id') => [
              'required' => false
            ]
        ]);

        // Add target entity (if it is a record) to team.
        $targetEntity = (new $form->target_type->model);
        if($targetEntity instanceof RecordType) {
          Record::find($request->input('target_id'))
            ->teams()
            ->attach($request->input('team_id'));
        }

  		  return [
  			   'data' => $entry
  		  ];
    }
}
