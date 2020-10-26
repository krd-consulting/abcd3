<?php

namespace App\Http\Controllers;

use App\EntityType;
use App\Http\Resources\Forms;
use Illuminate\Http\Request;

class EntityTypeFormsController extends Controller
{
    public function index(EntityType $entityType, $id)
    {
        // All forms directly associated to an entity
        // is inherited by the next lower level entity (form scope still applies).
        // For example, suppose staff member Jeff is in Program One.
        // All forms in Program One (under the program-forms view) can be
        // seen in the record-forms view of staff member Jeff's profile.
        // Of course, if a self-scoped form made by another staff member
        // is assigned to Program One, it shouldn't be seen under Jeff's profile.

        // Assumes relationships between collections are plural.
        // Entities from lowest to highest level hierarchy.
        // TODO: populate this array using EntityType.
        $relationships = [
            0 => 'records',
            1 => 'programs',
            2 => 'teams',
        ];

        $start = 0;
        foreach($relationships as $relationship) {
            if($relationship == $entityType->slug) {
                break;
            }
            $start++;
        }

        $neededRelationships = array_slice($relationships, $start);

        $queries = [];

        $index = 0;
        // We shall use mainEntity to get ids of related entities that
        // might have forms associated to them.
        $mainEntityTypeSlug = $neededRelationships[0];
        $mainEntityType = EntityType::where('slug', $mainEntityTypeSlug)->first();
        $mainEntity = (new $mainEntityType->model())->find($id);

        foreach($neededRelationships as $relationship) {

            $type = EntityType::where('slug', $relationship)->first();

            // Get ids of related entity that might have forms
            if($relationship == $mainEntityTypeSlug) {
              $relatedIds = [$id];
            } else {
              $relatedIds = $mainEntity->$relationship()->availableFor(auth()->user())->pluck("$type->slug.id");
            }

            // Query for forms directly associated with the entity.
            $queries[$index++] = (new \App\Form())->whereHas(
                $relationship,
                function($query) use ($type, $relatedIds) {
                    $query->where('model_type', '=', $type->model)
                        ->whereIn('id', $relatedIds);
                }
            );
        }

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
