<?php

namespace App\Http\Resources;

use App\Traits\Resources\CountRelated;

use Illuminate\Http\Resources\Json\JsonResource;

class Program extends JsonResource
{
    use CountRelated;

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
            'team_id' => $this->team->id,
            'active' => $this->active,
            'default_client_status_id' => $this->default_client_status_id,
            'group_client_status_id' => $this->group_client_status_id,
            'program_status' => $this->whenPivotLoaded(
                'program_record',
                function () {
                    if(!empty($this->record_statuses))
                        return $this->record_statuses->first();
                }
            ),
            // 'program_status' => $this->when(
            //     !empty($this->record_statuses),
            //     function () {
            //         return $this->record_statuses->first()[0];
            //     }
            // ),
            'enrolled_at' => $this->whenPivotLoaded('program_record', function() {
                return $this->pivot->enrolled_at;
            }),

            'cases_count' => $this->countRelated('caseRecords'),

            'groups_count' => $this->countRelated('groups'),

            'enrolled_at' => $this->whenPivotLoaded('program_record', function() {
                return $this->pivot->enrolled_at;
            }),

            'available_record_types' => $this->available_record_types,
            'path' => $this->path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
