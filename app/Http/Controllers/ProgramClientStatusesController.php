<?php

namespace App\Http\Controllers;

use App\ClientStatus;

use Illuminate\Http\Request;

class ProgramClientStatusesController extends Controller
{
    public function index()
    {
    	return [
    		'data' => ClientStatus::all()
    	];
    }
}
