<?php

namespace App\Http\Resources;

use App\Http\Resources\Record as RecordResource;

use App\Record;

use Illuminate\Http\Resources\Json\JsonResource;

class FormEntry extends JsonResource
{
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = parent::toArray($request);

        $target = $this->when($this->relationLoaded('target'), function () {
            switch (true) {

                case $this->target instanceof Record:
                    return (new RecordResource($this->target));
            }
        });

        if(!empty($target)) {
            $response['target'] = $target;
        }

        return $response;
    }
}
