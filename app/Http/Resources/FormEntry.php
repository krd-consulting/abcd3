<?php

namespace App\Http\Resources;

use App\Http\Resources\Record as RecordResource;
use App\Http\Resources\FormEntry\Program as ProgramResource;
use App\Http\Resources\FormEntry\Group as GroupResource;

use Illuminate\Http\Resources\Json\JsonResource;

class FormEntry extends JsonResource
{
    private $resourceMap = [
        'App\Record' => 'App\Http\Resources\Record',
        'App\Program' => 'App\Http\Resources\FormEntry\Program',
        'App\Group' => 'App\Http\Resources\FormEntry\Group'
    ];

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
            $class = $this->resourceMap[
                get_class($this->target)
            ];
        });

        if(!empty($target)) {
            $response['target'] = $target;
        }

        return $response;
    }
}
