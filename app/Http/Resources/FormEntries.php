<?php

namespace App\Http\Resources;

use App\Form;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FormEntries extends ResourceCollection
{
    public $collects = 'App\Http\Resources\FormEntry';

    protected $form;

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
}
