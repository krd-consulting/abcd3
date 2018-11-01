<?php

namespace App\Http\Controllers;

use App\File;
use App\FileType;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(FileType $fileType) {

        // Files query object
        $files = $fileType->files();

        // Sort.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $files->sort($sortBy, $ascending);


        // Paginate.
        $perPage = request('perPage');
        $files = $files->paginate($perPage);

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
