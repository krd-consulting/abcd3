<?php

namespace App\Http\Resources;

use App\RecordType;

use Illuminate\Http\Resources\Json\JsonResource;

class Record extends JsonResource
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
            'type' => $this->record_type,
            'type_slug' => $this->record_type->slug,
            'program_status' => $this->when(!empty($this->program_statuses), $this->program_statuses->last()),
            'enrolled_at' => $this->when(!empty($this->program_records), $this->program_records->firstWhere('id', $this->program_statuses->last()['program_client_id'])['enrolled_at']),
            $this->record_type->identity->field1->name => $this->field_1_value,
            $this->record_type->identity->field2->name => $this->field_2_value,
            $this->record_type->identity->field3->name => $this->field_3_value,
            'fields'=> [
                $this->record_type->identity->field1->name => 'field_1_value',
                $this->record_type->identity->field2->name => 'field_2_value',
                $this->record_type->identity->field3->name => 'field_3_value'
            ]
        ];
    }
}
