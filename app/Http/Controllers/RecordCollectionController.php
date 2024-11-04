<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Record;
use App\RecordType;
use Illuminate\Http\Request;

class RecordCollectionController extends Controller
{
    protected $resourceCollections = [
      'App\Program' => 'App\Http\Resources\Programs',
      'App\Group' => 'App\Http\Resources\Groups',
      'App\Team' => 'App\Http\Resources\Teams',
    ];

    protected $relationshipNames = [
      'App\Program' => 'programs',
      'App\Group' => 'groups',
      'App\Team' => 'teams',
    ];

    public function index(
      RecordType $recordType,
      Record $record,
      Collection $collection
    )
    {
        $collectionModel = $this->relationshipNames[$collection->model_type];
        $items = $record->$collectionModel()->availableFor(auth()->user());

        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $items = $items->sort($sortBy, $ascending);

        $perPage = request('perPage');
        $items = $items->paginate($perPage);

        return new $this->resourceCollections[$collection->model_type]($items);
    }

    public function store(
      RecordType $recordType,
      Record $record,
      Collection $collection,
      $item
    )
    {
      $model = (new $collection->model_type())->find($item);

      $this->authorize('write', $record);
      $this->authorize('write', $model);

      return $model->associateRecord($record);
    }

    public function available(
      RecordType $recordType,
      Record $record,
      Collection $collection
    )
    {
        $collectionModel = $this->relationshipNames[$collection->model_type];

        $selected = $record->$collectionModel()->pluck("$collectionModel.id");
        $items = (new $collection->model_type())->availableFor(auth()->user())->whereNotIn("$collectionModel.id", $selected);

        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $items = $items->sort($sortBy, $ascending);

        $items->search(request('search'));

        $perPage = request('perPage');
        $items = $items->paginate($perPage);

        return new $this->resourceCollections[$collection->model_type]($items);
    }
}
