<?php

namespace App\Http\Controllers;

use App\RecordType;
use App\Http\Resources\RecordTypes;

use Illuminate\Http\Request;

class RecordTypeController extends Controller
{
    public function index() {
        return (new RecordTypes(RecordType::paginate()));
    }

    public function show(RecordType $recordType) {
    	return [
    		'data' => $recordType
    	];
    }
}
