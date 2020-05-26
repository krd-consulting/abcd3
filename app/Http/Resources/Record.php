<?php

namespace App\Http\Resources;

use App\Http\Resources\RecordType;
use App\Http\Resources\Groups;
use App\Traits\Resources\CountRelated;

use Illuminate\Http\Resources\Json\JsonResource;

class Record extends JsonResource
{

    use CountRelated;

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

            'field_values' => $this->record_field_values(),
            // TODO: Remove n+1 query
            'type' => new RecordType($this->record_type),

            'pivot' => $this->pivot,

            'relationships' => [
                'cases_count' => $this->countRelated('cases'),
                'groups_count' => $this->countRelated('groups'),
            ],

            'links' => $this->links(),

            'permissions' => $this->permissions()
        ];
    }

    public function record_field_values()
    {
        $values = array();

        for($field = 1; $field <= 3; $field++) {
            $column = 'field' . $field;
            $recordColumn = 'field_' . $index . '_value';

            if($this->record_type->identity->$column != null) {
                $values[$this->record_type->identity->$column->slug] = $this->$recordColumn;
            }
        }

        return $values;
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
