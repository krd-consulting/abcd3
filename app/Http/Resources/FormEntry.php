<?php

namespace App\Http\Resources;

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

        $target = $this->getTarget();

        if(!empty($target)) {
            $response['target'] = $target;
        }

        return $response;
    }

    private function getTarget()
    {
        return $this->when($this->relationLoaded('target'), function () {
            $class = $this->resourceMap[
                get_class($this->target)
            ];

            return (new $class($this->target));
        });
    }
}
