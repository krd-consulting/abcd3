<?php

namespace App\Http\Controllers;

use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\Roles;
use App\Http\Requests\StoreRole;
use App\Http\Requests\UpdateRole;
use App\Role;
use App\Scope;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Returns all roles (along with their scope) from the database.
     *
     *  @return ResourceCollection
     */
    public function index()
    {
        return new Roles(Role::with('scope')->get());
    }

    /**
     * Returns essential form data for creating a role:
     * 1. All scopes
     *
     * @return Collection
     */
    public function create()
    {
        return ['scopes' => Scope::all()];
    }

    /**
     * Returns essential form data for editing a role:
     * 1. All scopes
     *
     * @return Collection
     */
    public function edit()
    {
        return ['scopes' => Scope::all()];
    }

    public function store(StoreRole $request)
    {
        // validate
        $validated = $request->validated();

        // store
        $role = new Role();
        $role->name = $validated['name'];
        $role->assignScope($validated['scope_id']);
        $role->save();

        return new RoleResource($role);
    }

    public function update(UpdateRole $request)
    {
        // validate
        $validated = $request->validated();

        // update
        $role = new Role();
        $role->exists = true;
        $role->id=$validated['id'];
        $role->name = $validated['name'];
        $role->assignScope($validated['scope_id']);
        $role->save();

        return new RoleResource($role);
    }

    public function delete(Role $role)
    {
        $role->delete();
    }
}
