<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormTargetType;
use App\Scope;

use App\Http\Requests\StoreForm;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class FormController extends Controller
{
    public function index()
    {
		$forms = new Form;

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

        return $forms;

    }

    public function create()
    {
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

        $form = new Form;

        $form->createUsingRequest($request);

        return $form;
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

        $targetTypes = $targetTypes->concat($recordTypes);

        $targetTypes->map(function($type) {
            $type['target'] = !empty($type['target_id']) ? $type['id'] . '_' . $type['target_id'] : $type['id'];

            unset($type['id']);
            unset($type['target_id']);

            return $type;
        });

        return $targetTypes;

    }
}
