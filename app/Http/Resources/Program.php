<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Program extends JsonResource
{
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
            'name' => $this->name,
            'description' => $this->description,
            'team' => $this->team,
            'pivot' => $this->pivot,
            'available_record_types' => $this->available_record_types,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
