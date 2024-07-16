<?php

namespace App\Http\Resources;

use App\Http\Resources\FormField;

use App\Group;
use App\Program;
use App\Team;

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
            'entry_default_parent_entity' => $this->when($request->loadEntryDefaultParentEntity, function () use ($request) {
                return $this->getEntryDefaultParentEntity($request->entryParentEntitySearch);
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
        $entity = NULL;
        $options = [];
        $to = NULL;
        $user = auth()->user();
        $perPage = 10;
        $pageName = 'entryParentEntityPage';

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
}
