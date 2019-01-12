<?php

namespace App\Http\Controllers;

use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\Roles;
use App\Http\Requests\DeleteRole;
use App\Http\Requests\StoreRole;
use App\Http\Requests\UpdateRole;
use App\Role;
use App\Scope;

use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index()
    {
        $this->authorize('write', Role::class);

        return new Roles(
            Role::with('scope')->get()
        );
    }

    public function create()
    {
        $this->authorize('write', Role::class);

        return ['scopes' => Scope::all()];
    }

    public function edit(Role $role)
    {
        $this->authorize('write', $role);

        return ['scopes' => Scope::all()];
    }

    public function store(StoreRole $request)
    {

        $role = new Role();
        $role->name = $request->input('name');
        $role->assignScope(
            $request->input('scope_id')
        );
        $role->save();

        return new RoleResource($role);
    }

    public function update(UpdateRole $request)
    {
        $role = new Role();
        $role->exists = true;
        $role->id=$request->input('id');
        $role->name = $request->input('name');
        $role->assignScope(
            $request->input('scope_id')
        );
        $role->save();

        return new RoleResource($role->load('scope'));
    }

    public function delete(Role $role)
    {
        $this->authorize('write', $role);

        $role->delete();
    }
}
