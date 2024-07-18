<?php

namespace App\Http\Resources;

use App\Http\Resources\FormField;

use App\Group;
use App\Program;
use App\Team;
use App\Scope;

use Illuminate\Http\Resources\Json\JsonResource;

class Form extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'fields' => $this->fields(),
            'form_fields' => $this->fields,
            'description' => $this->description,
            'active' => $this->active,
            'table_name' => $this->table_name,
            'type' => $this->type,
            'scope_id' => $this->scope_id,
            'scope' => $this->scope,
            'target_type_id' => $this->target_type_id,
            'target_type' => $this->target_type,
            'target_id' => $this->target_id,
            'target' => $this->target,
            // TODO
            // 1. Generate list of entities (records and collections?) (based on scope)
            // 2. Generate instances of entities (based on selected entity from #1)
            // for getting instances --
            // maybe something like: TeamScope::availableFormEntryParents($user, $form)
            // or $scope->getAvailableParentsForFormEntry()
            'default_parent_entity_for_entry' => $this->when($request->loadDefaultParentEntityForEntry, function () use ($request) {
                return $this->getEntryDefaultParentEntity($request->entryParentEntitySearch);
            }),
            'possible_parent_entities_for_entry' => $this->when($request->loadDefaultParentEntityForEntry, function () use ($request) {
                return $this->getPossibleParentEntitiesForEntry();
            }),
            'target_name' => $this->target != null ? $this->target->name : $this->target_type->name,
            'field_layout' => $this->field_layout->all(),
            'path' => $this->path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by
        ];
    }

    public function fields()
    {
        $fields = [
            'name' => [
                'value' => $this->name,
                'slug' => 'name',
                'name' => 'Form Name',
                'key' => 'name'
            ],
            'about' => [
                'value' => $this->target != null ? $this->target->name : $this->target_type->name,
                'name' => 'About',
                'slug' => 'about',
                'key' => 'team_id',
            ],
            'type' => [
                'value' => $this->type,
                'slug' => 'type',
                'name' => 'Type',
                'key' => 'type'
              ],
        ];

        return $fields;
    }

    protected function getEntryDefaultParentEntity($keywords = '') {
        // TODO: scope classes?
        // each scope class has different behaviour
        // in the meantime...
        // hard code a switch block for getting parent entity values
        $entity = NULL;
        $options = [];
        $to = NULL;
        $user = auth()->user();
        $perPage = 10;
        $pageName = 'entryParentEntityPage';
        $values = [];

        switch($this->scope->name) {
            case config('auth.scopes.group.name'):
                $entity = 'Group';
                $values = Group::availableFor($user)
                    ->search($keywords)
                    ->paginate($perPage, ['*'], $pageName);
                break;
            case config('auth.scopes.program.name'):
                $entity = 'Program';
                $values = Program::availableFor($user)
                    ->search($keywords)
                    ->paginate($perPage, ['*'], $pageName);
                break;
            case config('auth.scopes.team.name'):
                $entity = 'Team';
                $values = Team::availableFor($user)
                    ->search($keywords)
                    ->paginate($perPage, ['*'], $pageName);
                break;
            default:
                $entity = NULL;
        }

        return [
            'name' => $entity,
            'values' => $values
        ];
    }
    
    protected function getPossibleParentEntitiesForEntry() {
        // what entity types can we choose from?
        // it depends on the scope of the form
        // if the form has universal scope, all entity types
        // if the form has team scope: team, program, group, case load, self
        // if the form has program scope: program, group, case load, self
        // if the form has group scope: group, case load, self
        // basically:
        return Scope::where('value' , '<=', $this->scope->value)->get()->pluck('name');

        // but for each entity type, they may differ in how they fetch entities.
        // the scopes that are also collections have their own tables
        // self just returns the user's records
        // case load just fetches the cases table (more or less)
        // $selectedScope -- given from request
        // load object for $selectedScope: $scope
        // $scope->getAvailableParentEntities($user)

    }
}
