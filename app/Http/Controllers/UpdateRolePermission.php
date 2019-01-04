<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRolePermission as Update;
use App\Role;

use Illuminate\Http\Request;

class UpdateRolePermission extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Update $request)
    {
        // validate
        $validated = $request->validated();

        // store
        $role = Role::findOrFail($validated['role']['id']);
        $permission = $validated['permission']['id'];

        $role->giveOrRevokePermissionTo($permission, $validated['permitted']);

        return $validated;
    }
}
