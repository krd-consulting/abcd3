<?php

namespace App\Http\Resources;

use App\Http\Resources\Record as RecordResource;
use App\Http\Resources\FormEntry\Program as ProgramResource;
use App\Http\Resources\FormEntry\Group as GroupResource;

use App\Record;
use App\Program;

use Illuminate\Http\Resources\Json\JsonResource;

class FormEntry extends JsonResource
{
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

                case $this->target instanceof Program:
                    return (new ProgramResource($this->target));

                case $this->target instanceof Group:
                    return (new GroupResource($this->target));
            }
        });

        if(!empty($target)) {
            $response['target'] = $target;
        }

        return $response;
    }
}
