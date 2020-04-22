<?php

namespace App\Http\Resources;

use App\Form;
use App\FormTargetType;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FormEntries extends ResourceCollection
{
    public $collects = 'App\Http\Resources\FormEntry';

    protected $form;

    protected $targetType;

    public function __construct($resource, FormTargetType $targetType)
    {
        parent::__construct($resource);
        $this->targetType = $targetType->name;
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

    public function with($request) {
        return [
            'target_type' => $this->targetType
        ];
    }
}
