<?php

namespace App\Http\Resources;

use App\Http\Resources\RecordType;

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
            'type_slug' => $this->record_type->slug,
            'type' => new RecordType($this->record_type),
            'program_status' => $this->whenPivotLoaded('program_record', function() {
                return $this->client_statuses()->with('status')->latest()->first();
            }),
            'enrolled_at' => $this->whenPivotLoaded('program_record', function() {
                return $this->program_records->firstWhere('id', $this->client_statuses()->latest()->first()['program_client_id'])['enrolled_at'];
            }),
            //'pivot' => $this->pivot,
            'path' => $this->path,
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
