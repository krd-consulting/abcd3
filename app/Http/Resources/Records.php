<?php

namespace App\Http\Resources;

use App\RecordType;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Records extends ResourceCollection
{

    public $collects = 'App\Http\Resources\Record';

    protected $recordType;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $records = $this->collection;

        return [
            'data' => $records,
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'record_type' => $this->recordType,
            'fields' => [
                $this->recordType->field1->name => 'field_1_value',
                $this->recordType->field2->name => 'field_2_value',
                $this->recordType->field3->name => 'field_3_value'
            ]
        ];
    }

    public function as(RecordType $recordType)
    {
        $this->recordType = $recordType;

        return $this;
    }
}
