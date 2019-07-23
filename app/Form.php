<?php

namespace App;

use App\Model;

use App\Scope;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Form extends Model
{
    public function createUsingRequest($request)
    {
        $this->name = $request->name;
        $this->description = $request->description;
        $this->type = $request->type;
        $this->setTableName(DB::table($this->getTable())->max('id')+1);
        $this->target_type_id = $request->target_type_id;
        $this->target_id = $request->target_id;
        $this->scope_id = $request->scope_id;

        DB::transaction(function () use ($request) {
            $this->save();

            // add form to team.
            $this->teams()->attach([$request->team_id]);

            if(isset($request->validated()['fields']))
                $this->fields()->createMany($request->validated()['fields']);

            $fields = $this->fields;

            // create form entry table for form
            Schema::create($this->table_name, function (Blueprint $table) use ($fields) {
                $table->bigIncrements('id');
                $table->string('type');
                $table->bigInteger('target_id');

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

                    $columnName = 'field_' . $field->id;

                    $table->$columnType($columnName);

                    // foreign keys
                    if(!empty($field->target_type)) {

                        if($field->target_type->name != config('app.form_target_types.form_field.name')) {
                            $class = $field->target_type->model;
                            $model = new $class;

                            $table
                                ->foreign($columnName)
                                ->references($model->getFormReferenceField())
                                ->on($model->getFormReferenceTable());
                        }
                    }

                    $table->byAttributes();
                }

                $class = $this->target_type->model;
                $model = new $class;

                $table
                    ->foreign('target_id')
                    ->references($model->getFormReferenceField())
                    ->on($model->getFormReferenceTable());

                $table->timestamps();
                $table->softDeletes();
            });
        });
    }

    public function fields()
    {
        return $this->hasMany('App\FormField');
    }

    public function target_type()
    {
    	return $this->belongsTo('App\FormTargetType');
    }

    public function target()
    {
    	return $this->belongsTo($this->target_type->model);
    }

    public function teams()
    {
        return $this->belongsToMany('App\Team')
            ->withTimestamps();
    }

    public function programs()
    {
        return $this->belongsToMany('App\Program')
            ->withTimestamps();
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany('App\User')
            ->withTimestamps();
    }

    protected function setTableName($id)
    {
        $this->table_name = str_pad($id, 3, STR_PAD_LEFT);
    }

    public function scopeAvailableFor($query, $user) {
        $universal =
            (clone $query)
                ->where('scope_id', Scope::where('name', config('auth.scopes.universal.name'))->first()->id);
        $teams = (clone $query)->inTeams($user->availableTeams);
        $programs = (clone $query)->inPrograms($user->availablePrograms);
        $groups = (clone $query)->inGroups($user->availableGroups);
        $self = (clone $query)->inSelf($user);

        $query =
            $universal
                ->union($teams)
                ->union($programs)
                ->union($groups)
                ->union($self);

        return $query;
    }

    public function scopeInTeams($query, $teams)
    {
        return
            $query
                ->where('scope_id', Scope::where('name', config('auth.scopes.team.name'))->first()->id)
                ->whereHas('teams', function ($query) use ($teams) {
                    return $query->whereIn('team_id', $teams->pluck('id'));
                });
    }

    public function scopeInPrograms($query, $programs)
    {
        return
            $query
                ->where('scope_id', Scope::where('name', config('auth.scopes.program.name'))->first()->id)
                ->whereHas('programs', function ($query) use ($programs) {
                    return $query->whereIn('program_id', $programs->pluck('id'));
                });
    }

    public function scopeInGroups($query, $groups)
    {
        return
            $query
                ->where('scope_id', Scope::where('name', config('auth.scopes.group.name'))->first()->id)
                ->whereHas('groups', function ($query) use ($groups) {
                    return $query->whereIn('group_id', $groups->pluck('id'));
                });
    }

    public function scopeInSelf($query, $user)
    {
        return
            $query
                ->where('scope_id', Scope::where('name', config('auth.scopes.self.name'))->first()->id)
                ->whereHas('users', function ($query) use ($user) {
                    return $query->where('user_id', $user);
                });
    }

    public function scopeSort($query, $column, $ascending)
    {
        if(empty($column))
            return ;

        if($ascending == 'true')
            $ascending = 'asc';
        else
            $ascending = 'desc';

        return $query->orderBy($column, $ascending);
    }

    public function scopeSearch($query, $term)
    {
        if(empty($term))
            return $query;

        return $query->where('name', 'LIKE' , '%' . $term . '%')
        ->orWhere('description', 'LIKE', '%' . $term . '%');
    }
}
