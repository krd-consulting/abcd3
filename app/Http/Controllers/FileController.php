<?php

namespace App\Http\Controllers;

use App\FileType;
use App\User;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(FileType $fileType)
    {
        $files = $fileType->files()->availableFor(auth()->user())->as($fileType);


        // Sort.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $files->sort($sortBy, $ascending);

        // Paginate.
        $perPage = request('perPage');
        $files = $files->paginate($perPage);

        // Create collection that includes the requested File Type
        // and a fields array with the assigned field names
        // for the File Type as keys and the generic File
        // fields as values.
        $collection = collect(
            [
                'file_type' => $fileType,
                'fields'=> [
                    $fileType->field1->name => 'field_1_value',
                    $fileType->field2->name => 'field_2_value',
                    $fileType->field3->name => 'field_3_value'
                ]
            ]
        );

        return $collection->merge($files);
    }
}
