<?php

namespace App\Http\Resources;

use App\Permission;

use Illuminate\Http\Resources\Json\JsonResource;

class Role extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $role = $this;

        $permissions = Permission::all();

        $allPermissions = [];

        $allPermissions = $permissions->map(function($permission) use ($role) {
            return [
                'id' => $permission->id,
                'name' => $permission->name,
                'permitted' => $role->hasPermissionTo($permission)
            ];
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'scope_id' => $this->scope_id,
            'scope' => $this->scope,
            'all_permissions' => $allPermissions
        ];
    }
}
