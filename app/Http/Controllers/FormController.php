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
		$forms = (new Form);

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

        return [
            'data' => [
                'target_types' => $targetTypes,
                'types' => config('app.form_types'),
                'scopes' => Scope::where('name', '!=', config('auth.scopes.case-load.name'))->get()
            ]
        ];
    }

    public function store(StoreForm $request)
    {
        $this->authorize('create', Form::class);

        $request = $request->validated();

        $form = new Form;
        $form->name = $request['name'];
        $form->description = $request['description'];
        $form->type = $request['type'];
        $form->table_name =  'form_' . (DB::table($form->getTable())->max('id')+1);
        $form->target_type_id = $request['target_type_id'];;
        $form->target_id = $request['target_id'];
        $form->scope_id = $request['scope_id'];
        

        DB::transaction(function () use ($form, $request) {
            $form->save();

            // add form to team.
            $form->teams()->attach([$request['team_id']]);

            // insert fields into field registry
            $form->fields()->createMany($request['fields']);

            $fields = $form->fields;

            Schema::create($form->table_name, function (Blueprint $table) use ($fields) {
                $table->bigIncrements('id');

                foreach($fields as $field) {
                    if($field->type == 'SectionDivider') {
                        continue;
                    }

                    $columnType = $field->columnType;

                    if($field->type == 'MatrixField') {
                        foreach($field->options['questions'] as $key=>$question) {
                            $table->$columnType('field_' . $field->id . '_' . $key);
                        }

                        continue;
                    }

                    $table->$columnType('field_' . $field->id, $field->settings['max']);
                }
            });
        });

        return $form;
    }
}
