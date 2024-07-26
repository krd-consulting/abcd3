<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Collection as CollectionTable;
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

        $entries = $entry->availableFor(auth()->user());

        $entries->select($newFields);
        $entries->addSelect("$form->table_name.*");

        // load parent entity value for each entry
        $collectionTypes = CollectionTable::all();
        foreach($collectionTypes as $parentEntityType) {
          // TODO: format parent entity api value
          // add raw value, path, and secondary value
          // try to imitate how we do it for fields with referenced values
          $parentEntityTypeModel = new $parentEntityType->model_type;
          $parentEntityTypeModel->attachParentEntity($entries);
        }

        // include parent entity type columns
        $entries->leftJoin('collections',
          function($join) use ($entries) {
            $entriesTable = $entries->getModel()->getTable();

            $join->on("$entriesTable.parent_entity_type_id", '=', "collections.id");
        });
        $this->selectParentEntityColumn($entries, 'id', 'raw_value');
        $this->selectParentEntityColumn($entries, 'id', 'path', function($columns) use ($form) {
          return "CONCAT('/', collections.slug, '/', $columns)";
        });
        $this->selectParentEntityColumn($entries, 'name');

        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $entries->sort($sortBy, $ascending);
        
        $perPage = request('perPage');
        $entries = $entries->paginate($perPage);

        $entries->load('target');
        // Load record type to prevent duplicate n+1 queries
        $this->loadRecordType($entries);
        $entries->load('parent_entity_type');
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

    private function selectParentEntityColumn(
      $entries,
      $parentEntityColumn,
      $toColumn = 'value',
      $concatFunction = NULL) {
      // sort of a #hack to get the parent entity value
      // we're joining all collections tables to the entries query
      // and for every entry we know that only one of those tables will have a
      // non-null value, we just concatenate that value with all other null values
      // and we can get the value itself in one column
      $collectionTypes = CollectionTable::all();
      $columns = [];
      foreach($collectionTypes as $collection) {
        $collectionModel = new $collection->model_type;
        $columns[] = "COALESCE(`{$collectionModel->getTable()}`.`$parentEntityColumn`, '')";
      }
      $columns = implode(', ', $columns);
      if(is_null($concatFunction)) {
        $concat = "CONCAT($columns)";
      } else {
        $concat = $concatFunction($columns);
      }
      $entries->addSelect(DB::raw("$concat as parent_entity_$toColumn"));
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

        // TODO: Add form to collection specified (i.e. the parent entity) in entry.
        $parentEntityType = CollectionTable::find($request->parent_entity_type_id);
        $form->addParentEntity($parentEntityType, $request->parent_entity_id);
        
        // TODO: confirm with user if they want to do this
        // perhaps do this on the front end level
        

        // Here, we're automatically adding a record to a collection (the parent entity of the form)
        // other kinds of targets don't really have to be added to a collection
        $targetEntityType = (new $form->target_type->model);
        $scopeObject = new $form->scope->model_type;
        $collectionTypeModel = $parentEntityType->model_type;
        $collectionTypeObject = $collectionTypeModel::find($request->parent_entity_id);
        if($targetEntityType instanceof RecordType) {
          $collectionTypeObject->associateRecord(Record::find($request->input('target_id')));
        }

  		  return [
  			   'data' => $entry
  		  ];
    }
}
