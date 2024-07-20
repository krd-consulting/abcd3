<?php

namespace App\Http\Resources;

use App\Http\Resources\FormField;

use App\Group;
use App\Program;
use App\Team;
use App\Collection as CollectionTable;
use App\Scope\Scope;

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
            'default_parent_entity_type' => $this->when($request->loadParentEntityTypes, function () use ($request) {
                return $this->getDefaultParentEntityType($request->parentEntitySearch);
            }),
            // load the name and values for selected parent entity type in the request
            'selected_parent_entity_type' => $this->when($request->loadParentEntityTypes, function () use ($request) {
                return $this->getSelectedParentEntityType($request->selectedParentEntityType, $request->parentEntitySearch);
            }),
            'parent_entity_types' => $this->when($request->loadParentEntityTypes, function () use ($request) {
                return $this->getParentEntityTypes();
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

    protected function getDefaultParentEntityType($keywords = '') {
        $entity = NULL;
        $user = auth()->user();
        $perPage = 10;
        $pageName = 'parentEntityTypePage';
        $values = [];

        $scope = new $this->scope->model_type;

        if(!empty($entity = $scope->getCollectionTypeInstance())) {
            $values = $entity->availableFor($user)
                ->search($keywords)
                ->paginate($perPage, ['*'], $pageName);
        }

        $collectionType = $scope->getCollectionType();

        if(empty($collectionType)) {
            return null;
        }

        return [
            'id' => $collectionType->id,
            'name' => $collectionType->name,
            'values' => $values
        ];
    }
    
    protected function getParentEntityTypes() {
        return Scope::getCollectionTypes($this->scope);
    }

    protected function getSelectedParentEntityType($entityType, $keywords = '') {
        $collectionType = CollectionTable::find($entityType);

        $entity = NULL;
        $user = auth()->user();
        $perPage = 10;
        $pageName = 'parentEntityTypePage';
        $values = [];

        if(!empty($collectionType)) {
            $entity = new $collectionType->model_type;
            $values = $entity->availableFor($user)
                ->search($keywords)
                ->paginate($perPage, ['*'], $pageName);
        } else {
            return $this->getDefaultParentEntityType($keywords);
        }

        return [
            'id' => $collectionType->id,
            'name' => $collectionType->name,
            'values' => $values
        ];
    }
}
