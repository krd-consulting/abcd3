<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Form;
use App\FormTargetType;
use App\Http\Resources\Forms;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordFormsController extends Controller
{

    // Query for all forms associated to this record
    // Forms in this record's programs
    // Forms in this record's teams
    // Forms directly assigned to this record
    public function index(Record $record)
    {
        // Assumes relationships between collections are plural.
        $collections = Collection::all();

        $forms = new Form();

        // select the right target type.
        $forms = $forms
            ->leftJoin(DB::Raw("(SELECT form_id, model_id, model_type FROM model_has_forms) as model_has_forms"), 'forms.id', '=', 'model_has_forms.form_id')
            ->where('forms.target_type_id', '=', FormTargetType::where('name', '=', config('app.form_target_types.record.name'))->first()->id)
            ->where('forms.target_id', '=', $record->record_type->id)
            ->selectRaw("forms.*")
            ->distinct();

        // grab all the forms per collection
        $forms->where(function ($query) use ($collections, $record) {
            $iteration = 0;
            foreach($collections as $collection) {
                $slug = $collection->slug;

                // collections and records always have a many to many relationship?
                // the dynamic collection's records() function may be well defined
                // for this to work (depending on how many to many works in Laravel Eloquent)
                $relationship = $record->belongsToMany($collection->model_type);

                $ids = $relationship->get()->pluck('id');

                // TODO: add extra layer of security for scope
                // say a group scope form F is attached to a team T,
                // F should only be viewable by users of F's groups
                // so, for instance, they cant be viewed by users' in
                // T unless they are a part of F's groups.
                // maybe: minimum_scope_value for Collections?
                if($iteration == 0) {
                    $query
                        ->whereIn('model_has_forms.model_id', $ids)
                        ->where('model_has_forms.model_type', $collection->model_type);
                } else {
                    $query->orWhere(function ($query) use ($collection, $ids) {
                        $query
                            ->whereIn('model_has_forms.model_id', $ids)
                            ->where('model_has_forms.model_type', $collection->model_type);
                    });
                }
                $iteration++;
            }
        });

        // Search
        $search = request('search');
        $forms = $forms->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $forms = $forms->sort($sortBy, $ascending);

        // TODO: create custom paginator to solve inaccurate total?
        // Paginate per request.
        $perPage = request('perPage');
        $forms = $forms->paginate($perPage);

        return (new Forms($forms));
    }
}
