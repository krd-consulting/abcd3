<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Form;
use App\Http\Resources\Forms;
use Illuminate\Http\Request;

class CollectionFormsController extends Controller
{
    // Query for all forms directly associated to the collection
    // and that can be seen by user (by form scopes)
    public function index(Collection $collection, $id)
    {
        $model = $collection->model_type;
        $forms = (new Form())->whereHas(
            $collection->slug,
            function($query) use ($collection, $id) {
                $query->where('model_type', '=', $collection->model_type)
                    ->where('id', $id);
            }
        );

        $forms = $forms->availableFor(auth()->user());

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
