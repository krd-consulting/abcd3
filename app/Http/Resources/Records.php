<?php

namespace App\Http\Resources;

use App\RecordType;

use App\Http\Resources\RecordType as RecordTypeResource;

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
        if(empty($this->recordType))
            return [];

        return [
            'record_type' => new RecordTypeResource($this->recordType),

            // TODO: Remove n+1 query

            'fields' => [
                $this->recordType->identity->field1->name => 'field_1_value',
                $this->recordType->identity->field2->name => 'field_2_value',
                $this->recordType->identity->field3->name => 'field_3_value'
            ]
        ];
    }

    public function as(RecordType $recordType)
    {
        $this->recordType = $recordType;

        return $this;
    }
}
