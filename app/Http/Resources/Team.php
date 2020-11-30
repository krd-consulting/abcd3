<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Team extends JsonResource
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
            'active' => $this->active,
            'name' => $this->name,
            'display_value' => $this->name,
            'description' => $this->description,
            'required_by_form' => $this->whenPivotLoaded('model_has_forms', function() {
              return $this->pivot->required;
            }),
            'entries_history' => $this->whenPivotLoaded('model_has_forms', function() {
              return $this->entries_history;
            }),
            'fields' => $this->fields(),
            'profile_fields' => $this->profile_fields(),
            'available_record_types' => $this->available_record_types,
            'links' => [
                'to' => $this->path,
            ],
            'permissions' => $this->permissions(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    public function fields()
    {
        $fields = [
          'name' => [
            'value' => $this->name,
            'slug' => 'name',
            'name' => 'Name',
            'key' => 'name'
          ],
          'description' => [
            'value' => $this->description,
            'slug' => 'description',
            'name' => 'Description',
            'key' => 'description'
          ],
          'required_by_form' => $this->whenPivotLoaded('model_has_forms', function() {
              return [
                'value' => $this->pivot->required,
                'slug' => 'required_by_form',
                'name' => 'Required',
                'key' => 'required_by_form'
              ];
            })
        ];

        return $fields;
    }

    public function profile_fields()
    {
        $fields[0] = $this->fields()['name'];

        $fields[1] = [
            'value' => '',
        ];

        return $fields;
    }

    public function permissions()
    {
        $canWrite = auth()->user()->can('write', $this->resource);

        return [
            'can_write' => $canWrite,
            'can_edit' => $canWrite,
            'can_delete' => $canWrite,
        ];
    }

    public function links()
    {
        return [
            'to' => $this->path
        ];
    }
}
