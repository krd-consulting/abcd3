<?php

namespace App\Http\Resources;

use App\FileType;

use Illuminate\Http\Resources\Json\JsonResource;

class File extends JsonResource
{
    protected $fileType;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'file_type_id' => $this->id,
            $this->fileType->field1->name => $this->field_1_value,
            $this->fileType->field2->name => $this->field_2_value,
            $this->fileType->field3->name => $this->field_3_value
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
