<?php

namespace App\Http\Controllers;

use App\EntityType;
use App\Http\Resources\Forms;
use Illuminate\Http\Request;

class EntityTypeFormsController extends Controller
{
    public function index(EntityType $entityType, $id)
    {
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
        // $forms = (new \App\Form());
        // $forms = $forms->whereHas(
        //     $entityType->slug,
        //     function($query) use ($entityType, $id) {
        //         $query->where('model_type', '=', $entityType->model)
        //           ->where('id', '=', $id);
        // });

        $index = 0;
        $mainEntityTypeSlug = $neededRelationships[0];
        $mainEntityType = EntityType::where('slug', $mainEntityTypeSlug)->first();
        $mainEntity = (new $mainEntityType->model())->find($id);
        foreach($neededRelationships as $relationship) {

            $type = EntityType::where('slug', $relationship)->first();

            // get form ids
            // 1. Get ids of related entity that might have forms
            if($relationship == $mainEntityTypeSlug) {
              $relatedIds = [$id];
            } else {
              $relatedIds = $mainEntity->$relationship()->availableFor(auth()->user())->pluck("$type->slug.id");
            }

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
