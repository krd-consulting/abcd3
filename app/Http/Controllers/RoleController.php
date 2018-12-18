<?php

namespace App\Http\Controllers;

use App\Role;
use App\Http\Resources\Roles;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return new Roles(Role::with('scope')->get());
    }
}
