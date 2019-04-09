<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\StoreGroup;
use App\Http\Requests\UpdateGroup;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        return (new Group())->availableFor(auth()->user())->with('program')->get();
    }

    public function show(Group $group)
    {
        $this->authorize('read', $group);

        return $group->load('program');
    }

    public function create()
    {
        $this->authorize('create', Group::class);

        return auth()->user()->availablePrograms;
    }

    public function store(StoreGroup $request)
    {
        $this->authorize('create', Group::class);

        // Store program when user is authorized.
        $group = new Group();
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->program_id = $request->input('program_id');
        $group->created_by = auth()->user()->id;
        $group->updated_by = auth()->user()->id;
        $group->save();

        return $group;
    }

    public function edit(Group $group)
    {
        $this->authorize('write', $group);

        return auth()->user()->availablePrograms;
    }

    public function update(UpdateGroup $request)
    {
        // Update group when user is authorized.
        $group = new Group();
        $group->exists = true;
        $group->id = $request->input('id');
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->updated_by = auth()->user()->id;
        $group->save();

        return $group;
    }

    public function destroy(Group $group)
    {
        $this->authorize('write', $group);

        // Delete group when user is authorized.
        $group->delete();
    }
}
