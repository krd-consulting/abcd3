<?php

namespace App\Http\Controllers;

use App\Group;
use App\Team;
use App\Http\Requests\StoreGroup;
use App\Http\Requests\UpdateGroup;

class GroupController extends Controller
{
    public function index()
    {
        $groups = (new Group)->availableFor(auth()->user())->with('program');

        $active = request('active') ?? true;
        $groups->active($active);

        $perPage = request('perPage');
        return $groups->paginate($perPage);
    }

    public function show(Group $group)
    {
        $this->authorize('read', $group);

        // TODO: Create Group Resource
        return [ 'data' => $group->load('program')];
    }

    public function create(Team $team = null)
    {
        $this->authorize('create', Group::class);

        $query = auth()->user()->availablePrograms(null);

        if(isset($team)) {
            $query = $query->where('team_id', $team->id);
        }

        return $query->get();
    }

    public function store(StoreGroup $request)
    {
        $this->authorize('create', Group::class);

        // Store program when user is authorized.
        $group = new Group();
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->program_id = $request->input('program_id');
        $group->save();

        return $group;
    }

    public function edit(Group $group)
    {
        $this->authorize('write', $group);

        return [
            'data' => $group->load('program')
        ];
    }

    public function update(Group $group, UpdateGroup $request)
    {
        $this->authorize('write', $group);

        // Update group when user is authorized.
        $group->name = $request->input('name') ?? $group->name;
        $group->description = $request->input('description') ?? $group->description;
        $group->active  = $request->input('active') ?? $group->active;
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
