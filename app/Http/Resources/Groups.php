<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Groups extends ResourceCollection
{
    public $collects = 'App\Http\Resources\Group';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection
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
        $record_type = [];

        if(!empty($this->record_type))
            $record_type = new RecordTypeResource($this->record_type);

        return [
            'record_type' => $record_type,
            'fields' => $this->fields(),
            'permissions' => $this->permissions()
        ];
    }

    public function fields()
    {
      return [
        'name' => [
          'name' => 'Name',
          'slug' => 'name',
          'key' => 'name',
        ],
        'program' => [
          'name' => 'Program',
          'slug' => 'program',
          'key' => 'program_id',
        ],
      ];
    }

    public function permissions()
    {
        return [
            'can_write' => auth()->user()->can('write', $this->resource)
        ];
    }
}
