<?php

namespace App\Http\Controllers;

use App\Role;
use App\Scope;
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
        return Scope::all();
    }

    public function store()
    {
        // authorize

        // validate

        // store
    }

    public function update(Request $request)
    {

    }
}
