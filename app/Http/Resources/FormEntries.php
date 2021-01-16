<?php

namespace App\Http\Resources;

use App\Form;
use App\FormTargetType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FormEntries extends ResourceCollection
{
    public $collects = 'App\Http\Resources\FormEntry';

    protected $form;

    protected $targetType;

    protected $fields;

    public function __construct($resource, Form $form, FormTargetType $targetType, Collection $fields)
    {
        parent::__construct($resource);
        $this->form = $form;
        $this->targetType = $targetType->name;
        $this->fields = $fields;
    }

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

    public function with($request)
    {
        return [
            'target_type' => $this->targetType,
            'fields' => $this->fields(),
        ];
    }

    public function fields()
    {
        $fields = [];

        $keyed = $this->fields->mapWithKeys(function ($field, $key) {
          return [
            $field['column_name'] => [
              'name' => $field['title'],
              'slug' => $field['column_name'],
              'key' => $field['column_name'],
              'type' => $field['type'],
            ]
          ];
        });

        return $keyed->all();
    }
}
