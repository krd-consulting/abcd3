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

    /**
     * Returns all $fileType files (sorted and paginated per request) available to the user
     * with data about the files' file type and field names.
     *
     * @param  FileType $fileType
     * @return Collection
     */
    public function index(FileType $fileType)
    {

        $files = $fileType->files()->availableFor(auth()->user())->as($fileType);


        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $files->sort($sortBy, $ascending);

        // Paginate per request.
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

    /**
     * Show the profile of the selected user.
     *
     * @param  File  $file
     * @return File
     */
    public function show(File $file)
    {
        $this->authorize('read', $file);

        return $program->load('files');
    }
}
