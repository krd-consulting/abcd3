<?php

namespace App\Http\Controllers;

use App\Role;
use App\Scope;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\Roles;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return new Roles(Role::with('scope')->get());
    }

    public function create()
    {
        return ['scopes' => Scope::all()];
    }

    public function edit()
    {
        return ['scopes' => Scope::all()];
    }

    public function store(Request $request)
    {
        // authorize

        // validate
        $validatedData = $request->validate([
            'role.name' => 'required|string|unique:roles,name',
            'role.scope_id' => 'required|numeric|exists:scopes,id'
        ]);
        // store
        $role = new Role();
        $role->name = $validatedData['role']['name'];
        $role->assignScope($validatedData['role']['scope_id']);
        $role->save();

        return new RoleResource($role);
    }

    public function update(Request $request)
    {
        // authorize

        // validate
        $validatedData = $request->validate([
            'role.id' => 'required|numeric|exists:roles,id',
            'role.name' => 'string',
            'role.scope_id' => 'numeric|exists:scopes,id'
        ]);

        // update
        $role = new Role();
        $role->exists = true;
        $role->id=$validatedData['role']['id'];
        $role->name = $validatedData['role']['name'];
        $role->assignScope($validatedData['role']['scope_id']);
        $role->save();

        return $validatedData;
    }

    public function delete(Role $role)
    {
        $role->delete();
    }
}
