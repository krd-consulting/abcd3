<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;

use Illuminate\Http\Request;

class RolePermissionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Role $role, Permission $permission)
    {
        $this->authorize('write', $role);

        $role->givePermissionTo($permission);

        return $role->load('permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role, Permission $permission)
    {
        $this->authorize('write', $role);

        $role->revokePermissionTo($permission);

        return $role->load('permissions');
    }
}
