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
        // authorize

        return ['scopes' => Scope::all()];
    }

    /**
     * Returns essential form data for editing a role:
     * 1. All scopes
     *
     * @return Collection
     */
    public function edit(Role $role)
    {
        $this->authorize('write', $role);

        return ['scopes' => Scope::all()];
    }

    public function store(StoreRole $request)
    {
        // authorize and validate
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
        // authorize and validate
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
        $this->authorize('write', $role);

        $role->delete();
    }
}
