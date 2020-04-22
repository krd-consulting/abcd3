<?php

namespace App\Http\Resources\FormEntry;

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
            'secondary_data' => $this->team->name,
            'path' => $this->path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
