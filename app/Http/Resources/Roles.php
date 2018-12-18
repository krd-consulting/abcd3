<?php

namespace App\Http\Resources;

use App\Permission;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Roles extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $permissions = Permission::all()->pluck('name');
        $roles = $this->collection;

        $roles = $roles->map(function($role) use ($permissions) {
            $role['all_permissions'] = [];

            $role['all_permissions'] = $permissions->map(function($permission) use ($role) {
                return [
                    'name' => $permission,
                    'permitted' => $role->hasPermissionTo($permission)
                ];
            });

            return $role;
        });

        return [
            'roles' => $roles
        ];
    }
}
