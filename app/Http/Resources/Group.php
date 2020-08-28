<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Group extends JsonResource
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
            'display_value' => $this->name,
            'description' => $this->description,
            'fields' => $this->fields(),
            'profile_fields' => $this->profile_fields(),
            'program' => $this->program,
            'links' => [
                'to' => $this->path,
            ],
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
          'program' => [
            'value' => $this->program->name,
            'slug' => 'program',
            'name' => 'Program',
            'key' => 'program_id'
          ],
        ];

        return $fields;
    }

    public function profile_fields()
    {
        $fields[0] = $this->fields()['name'];

        $fields[1] = $this->fields()['program'];

        return $fields;
    }
}
