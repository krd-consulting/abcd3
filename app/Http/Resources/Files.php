<?php

namespace App\Http\Resources;

use App\FileType;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Files extends ResourceCollection
{
    protected $fileType;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $files = $this->collection;

        return [
            'data' => $files,
            'file_type' => $this->fileType,
            'fields'=> [
                $this->fileType->field1->name => 'field_1_value',
                $this->fileType->field2->name => 'field_2_value',
                $this->fileType->field3->name => 'field_3_value'
            ]
        ];
    }

    public function as(FileType $fileType)
    {
        $this->fileType = $fileType;

        return $this;
    }
}
