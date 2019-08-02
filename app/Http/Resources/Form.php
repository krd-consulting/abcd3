<?php

namespace App\Http\Resources;

use App\Http\Resources\FormField;

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
            'description' => $this->description,
            'table_name' => $this->table_name,
            'type' => $this->type,
            'scope_id' => $this->scope_id,
            'scope' => $this->scope,
            'target_type_id' => $this->target_type_id,
            'target_type' => $this->target_type,
            'target_id' => $this->target_id,
            'target' => $this->target,
            'target_name' => $this->target != null ? $this->target->name : $this->target_type->name . 's', 
            'field_layout' => $this->field_layout->all(),
            'path' => $this->path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by
        ];
    }
}
