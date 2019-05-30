<?php

namespace App\Http\Controllers;

use App\ClientStatus;

use App\Http\Requests\StoreClientStatus;

use Illuminate\Http\Request;

class ClientStatusController extends Controller
{
    public function index()
    {
    	return [
    		'data' => ClientStatus::all()
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

    public function destroy(ClientStatus $status)
    {
    	abort_if($status->programs()->exists(), 422, 'Status is set as default in some programs.');

    	$status->delete();
    }
}
