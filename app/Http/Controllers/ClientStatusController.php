<?php

namespace App\Http\Controllers;

use App\ClientStatus;

use App\Http\Requests\StoreClientStatus;
use App\Http\Requests\UpdateClientStatus;

use Illuminate\Http\Request;

class ClientStatusController extends Controller
{
    public function index()
    {
        $disabled = request('disabled') == 'true';

    	return [
    		'data' => ClientStatus::disabled($disabled)->get()
    	];
    }

    public function store(StoreClientStatus $request)
    {
    	$this->authorize('write', ClientStatus::class);

    	$status = new ClientStatus();
    	$status->name = $request->input('name');
    	$status->description = $request->input('description');
    	$status->save();

    	return $status;
    }

    public function edit(ClientStatus $status)
    {
        $this->authorize('write', $status);

        return [ 'data' => $status];
    }

    public function update(ClientStatus $status, UpdateClientStatus $request)
    {
        $this->authorize('write', $status);

        $status->fill($request->validated());
        $status->save();

        return $status;
    }

    public function destroy(ClientStatus $status)
    {
    	abort_if($status->programs()->exists(), 422, 'Status is set as default in some programs.');

        abort_if($status->program_clients()->exists(), 422, 'Status is being used by some records.');

    	$status->delete();
    }
}
