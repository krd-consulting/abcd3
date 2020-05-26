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
        $recordType = [];

        if(!empty($this->recordType))
            $recordType = new RecordTypeResource($this->recordType);

        return [
            'record_type' => $recordType,
            'permissions' => $this->permissions()
        ];
    }

    public function as(RecordType $recordType)
    {
        $this->recordType = $recordType;

        return $this;
    }

    public function permissions()
    {
        return [
            'can_write' => auth()->user()->can('write', $this->resource)
        ];
    }
}
