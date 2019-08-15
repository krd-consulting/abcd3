<?php

namespace App\Http\Controllers;

use App\RecordType;

use Illuminate\Http\Request;

class RecordTypeController extends Controller
{
    public function index() {
        return [
        	'data' => RecordType::all()
        ];
    }

    public function show(RecordType $recordType) {
    	return [
    		'data' => $recordType
    	];
    }
}
