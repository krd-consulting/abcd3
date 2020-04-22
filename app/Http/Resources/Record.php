<?php

namespace App\Http\Resources;

use App\Http\Resources\RecordType;
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

            // TODO: Remove n+1 query
            'type_slug' => $this->record_type->slug,
            'type' => new RecordType($this->record_type),

            'program_status' => $this->whenPivotLoaded(
                'program_record',
                function () {
                    if(!empty($this->program_statuses))
                        return $this->program_statuses->first();
                }
            ),
            'enrolled_at' => $this->whenPivotLoaded('program_record', function() {
                return $this->pivot->enrolled_at;
            }),

            'cases_count' => $this->countRelated('cases'),

            'groups_count' => $this->countRelated('groups'),

            'path' => $this->path,

            // TODO: Remove n+1 query
            $this->record_type->identity->field1->name => $this->field_1_value,
            $this->record_type->identity->field2->name => $this->field_2_value,
            $this->record_type->identity->field3->name => $this->field_3_value,
            'fields'=> [
                $this->record_type->identity->field1->name => 'field_1_value',
                $this->record_type->identity->field2->name => 'field_2_value',
                $this->record_type->identity->field3->name => 'field_3_value'
            ],

            'editable' => auth()->user()->can('write', $this->resource)
        ];
    }
}
