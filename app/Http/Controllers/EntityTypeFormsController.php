<?php

namespace App\Http\Controllers;

use App\EntityType;
use App\Http\Resources\Forms;
use Illuminate\Http\Request;

class EntityTypeFormsController extends Controller
{
    public function index(EntityType $entityType, $id)
    {
        $forms = new \App\Form();

        $forms = $forms->whereHas($entityType->slug, function($query) use ($entityType, $id) {
            $query->where('model_type', '=', $entityType->model)
              ->where('id', '=', $id);
        });

        // Search
        $search = request('search');
        $forms = $forms->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $forms = $forms->sort($sortBy, $ascending);

        $forms = $forms->availableFor(auth()->user());

        // Paginate per request.
        $perPage = request('perPage');
        $forms = $forms->paginate($perPage);

        return (new Forms($forms));
    }
}
