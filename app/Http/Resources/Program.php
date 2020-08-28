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
            'display_value' => $this->name,
            'description' => $this->description,
            'fields' => $this->fields(),
            'profile_fields' => $this->profile_fields(),
            'team' => $this->team,
            // 'team_id' => optional($this->team)->id,
            'active' => $this->active,
            'default_client_status_id' => $this->default_client_status_id,
            'case_client_status_id' => $this->case_client_status_id,
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
            'links' => [
                'to' => $this->path,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    public function fields()
    {
        $fields = [
          'name' => [
            'value' => $this->name,
            'slug' => 'name',
            'name' => 'Name',
            'key' => 'name'
          ],
          'team' => [
            'value' => $this->team->name,
            'slug' => 'team',
            'name' => 'Team',
            'key' => 'team_id'
          ],
          'volunteer_type' => [
            'value' => config("app.program_volunteer_types.$this->volunteer_type.name") ?? 'None',
            'slug' => 'volunteer_type',
            'name' => 'Volunteer Type',
            'key' => 'volunteer_type'
          ],
        ];

        return $fields;
    }

    public function profile_fields()
    {
        $fields[0] = $this->fields()['name'];

        $fields[1] = $this->fields()['team'];

        return $fields;
    }

    public function permissions()
    {
        $canWrite = auth()->user()->can('write', $this->resource);

        return [
            'can_write' => $canWrite,
            'can_edit' => $canWrite,
            'can_delete' => $canWrite,
        ];
    }

    public function links()
    {
        return [
            'to' => $this->path
        ];
    }
}
