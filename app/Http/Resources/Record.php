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
            $this->record_type->field1->name => $this->field_1_value,
            $this->record_type->field2->name => $this->field_2_value,
            $this->record_type->field3->name => $this->field_3_value,
            'fields'=> [
                $this->record_type->field1->name => 'field_1_value',
                $this->record_type->field2->name => 'field_2_value',
                $this->record_type->field3->name => 'field_3_value'
            ]
        ];
    }
}
