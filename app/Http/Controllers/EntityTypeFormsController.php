<?php

namespace App\Http\Controllers;

use App\EntityType;
use App\Http\Resources\Forms;
use Illuminate\Http\Request;

class EntityTypeFormsController extends Controller
{
    public function index(EntityType $entityType, $id)
    {
        // TODO: pass url params.

        if($entityType->model == config('app.entity_types.record.model')) {
            return redirect()->action(
                'RecordFormsController@index',
                [
                    'record' => $id,
                    'search' => request('search'),
                    'ascending' => request('ascending'),
                    'sortBy' => request('sortBy'),
                    'perPage' => request('perPage'),
                    'page' => request('page')
                ]
            );
        }

        return redirect()->action(
            'CollectionFormsController@index',
            [
              'collection' => $entityType->slug,
              'id' => $id,
            ]
        );
    }
}
