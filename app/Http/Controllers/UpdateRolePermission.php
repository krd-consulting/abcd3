<?php

namespace App\Http\Controllers;

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
    public function __invoke(Request $request)
    {
        // authorize

        // validate
        $validatedData = $request->validate([
            'role.id' => 'required|exists:roles,id',
            'permission.id' => 'exists:permissions,id',
            'permitted' => 'boolean'
        ]);

        // store
        $role = Role::findOrFail($validatedData['role']['id']);
        $permission = $validatedData['permission']['id'];

        $role->giveOrRevokePermissionTo($permission, $validatedData['permitted']);

        return $validatedData;
    }
}
