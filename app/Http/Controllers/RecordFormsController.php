<?php

namespace App\Http\Controllers;

use App\EntityType;
use App\Form;
use App\Http\Resources\Forms;
use App\Record;
use Illuminate\Http\Request;

class RecordFormsController extends Controller
{

    // Query for all forms associated to this record
    // (form scopes still apply):
    // Forms in this record's programs
    // Forms in this record's teams
    // Forms directly assigned to this record
    public function index(Record $record)
    {
        // Assumes relationships between collections are plural.
        // Entities from lowest to highest level hierarchy.
        // TODO: populate this array using EntityType.
        $neededRelationships = [
            1 => 'programs',
            2 => 'teams',
        ];

        $index = 0;
        $queries = [];

        // create forms query for each relationship
        foreach($neededRelationships as $relationship) {
            $type = EntityType::where('slug', $relationship)->first();

            $relatedIds = $record
                ->$relationship()
                ->availableFor(auth()->user())->pluck("$type->slug.id");

            // Query for forms directly associated with the entity.
            $queries[$index++] = (new Form())->whereHas(
                $relationship,
                function($query) use ($type, $relatedIds) {
                    $query->where('model_type', '=', $type->model)
                        ->whereIn('id', $relatedIds);
                }
            );
        }

        // combine the queries
        $query = 0;
        $forms = $queries[$query++]->availableFor(auth()->user());
        while($query < $index) {
          $forms->union($queries[$query++]);
        }

        // Search
        $search = request('search');
        $forms = $forms->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $forms = $forms->sort($sortBy, $ascending);

        // Paginate per request.
        $perPage = request('perPage');
        $forms = $forms->paginate($perPage);

        return (new Forms($forms));
    }
}
