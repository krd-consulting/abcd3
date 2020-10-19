<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormTargetType;
use App\Scope;
use Illuminate\Support\Facades\DB;

use App\Http\Resources\Form as FormResource;
use App\Http\Resources\Forms;

use App\Http\Requests\StoreForm;
use App\Http\Requests\UpdateForm;

class FormController extends Controller
{
    public function index()
    {
		    $forms = new Form;

        // $active = request('active') ?? true;
        // $forms = $forms->active($active);

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

    public function show(Form $form)
    {
        return (new FormResource($form));
    }

    public function fieldData(Form $form, $field)
    {
        return DB::table($form->table_name)->where($field, 'like', '%'.request('search').'%')->pluck($field);
    }

    public function create()
    {
        $this->authorize('create', Form::class);

        return [
            'data' => [
                'target_types' => $this->generateTargetTypes(),
                'types' => config('app.form_types'),
                'scopes' => Scope::where('name', '!=', config('auth.scopes.case-load.name'))->get()
            ]
        ];
    }

    public function store(StoreForm $request)
    {
        $this->authorize('create', Form::class);

        $form = new Form();
        $form->createUsingRequest($request);

        return (new FormResource($form));
    }

    public function edit(Form $form)
    {
        return [
            'data' => [
                'form' => (new FormResource($form)),
                'target_types' => $this->generateTargetTypes(),
                'types' => config('app.form_types'),
                'scopes' => Scope::where('name', '!=', config('auth.scopes.case-load.name'))->get()
            ]
        ];
    }

    public function update(Form $form, UpdateForm $request)
    {
        // authorize

        $form->name = $request->name ?? $form->name;
        $form->description = $request->description ?? $form->description;
        $form->type = $request->type ?? $form->type;
        $form->target_type_id = $request->target_type_id ?? $form->target_type_id;
        $form->target_id = $request->target_id ?? $form->target_id;
        $form->scope_id = $request->scope_id ?? $form->scope_id;
        $form->active = $request->active ?? $form->active;
        $form->save();

        return (new FormResource($form));
    }

    protected function generateTargetTypes()
    {
        $targetTypes = FormTargetType::select('id', 'name')->get();

        $targetTypes = $targetTypes->filter(function($value, $key) {
            return $value->name != config('app.form_target_types.record.name');
        });

        $recordType = FormTargetType::where(
                'name',
                config('app.form_target_types.record.name')
            )->first();

        $recordTypes = (
            $recordType->model
        )::select('id as target_id', 'name')->get();

        $recordTypes->map(function($type) use ($recordType) {
            $type['id'] = $recordType->id;

            return $type;
        });

        $targetTypes = $recordTypes->concat($targetTypes);

        $targetTypes->map(function($type) {
            $type['target'] = !empty($type['target_id']) ? $type['id'] . '_' . $type['target_id'] : $type['id'];

            unset($type['id']);
            unset($type['target_id']);

            return $type;
        });

        return $targetTypes;

    }

    public function destroy(Form $form) {
        // TODO: Authorize deleting forms.

        $form->delete();
    }
}
