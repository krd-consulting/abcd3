<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    protected $resourceCollections = [
      'App\Program' => 'App\Http\Resources\Programs',
      'App\Group' => 'App\Http\Resources\Groups',
      'App\Team' => 'App\Http\Resources\Teams',
    ];

    public function index()
    {
      $data = Collection::all();

      return compact('data');
    }

    public function show(Collection $collection)
    {
        // We might require all collections to implement availableFor scope.
        $items = (new $collection->model_type)->availableFor(auth()->user());

        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $items = $items->sort($sortBy, $ascending);

        $perPage = request('perPage');
        $items = $items->paginate($perPage);

        return new $this->resourceCollections[$collection->model_type]($items);
    }
}
