<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Forms extends ResourceCollection
{
    public $collects = 'App\Http\Resources\Form';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {

        return [
            'fields' => $this->fields(),
            'permissions' => $this->permissions()
        ];
    }

    public function fields()
    {
      return [
        'name' => [
          'name' => 'Form Name',
          'slug' => 'name',
          'key' => 'name',
        ],
        'about' => [
          'name' => 'About',
          'slug' => 'about',
          'key' => 'team_id',
        ],
        'type' => [
            'slug' => 'type',
            'name' => 'Type',
            'key' => 'type'
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
