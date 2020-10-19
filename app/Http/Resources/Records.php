<?php

namespace App\Http\Resources;

use App\RecordType;

use App\Http\Resources\RecordType as RecordTypeResource;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Records extends ResourceCollection
{

    public $collects = 'App\Http\Resources\Record';

    private $pivots = [];

    protected $record_type;

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
        $record_type = [];

        if(!empty($this->record_type))
            $record_type = new RecordTypeResource($this->record_type);

        return [
            'record_type' => $record_type,
            'fields' => $this->fields(),
            'permissions' => $this->permissions()
        ];
    }

    public function as(RecordType $record_type)
    {
        $this->setRecordType($record_type);

        return $this;
    }

    public function setRecordType(RecordType $record_type)
    {
        $this->record_type = $record_type;

        return $this;
    }

    public function getRecordType()
    {
        return $this->record_type;
    }

    public function fields()
    {
        $fields = [];

        if($this->record_type->identity->name == config('app.record_identities.other.name')) {
            $fields['name']['name'] = 'Name';
            $fields['name']['slug'] = 'name';
            $fields['name']['key'] = 'field_1_value';
        } else {
            $fields['full_name']['name'] = 'Full Name';
            $fields['full_name']['slug'] = 'full_name';
            $fields['full_name']['key'] = 'field_1_value';

            $fields[$this->record_type->identity->field3->slug]['name'] = $this->record_type->identity->field3->name;
            $fields[$this->record_type->identity->field3->slug]['slug'] = $this->record_type->identity->field3->slug;
            $fields[$this->record_type->identity->field3->slug]['key'] = 'field_3_value';
        }

        foreach($this->pivots as $pivot) {
            $fields[$pivot['key']] = $pivot;
        }

        return $fields;
    }

    public function permissions()
    {
        return [
            'can_write' => auth()->user()->can('create', \App\Record::class)
        ];
    }

    public function addPivot($pivot)
    {
      $this->pivots[$pivot['key']] = $pivot;

      return $this;
    }

    public function addPivots($pivots)
    {
      foreach($pivots as $pivot) {
        $this->addPivot($pivot);
      }

      return $this;
    }
}
