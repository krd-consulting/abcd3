<?php

namespace App\Http\Controllers;

use App\File;
use App\FileType;
use App\User;
use App\Http\Resources\Files;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Returns a list $fileType files (sorted and paginated per request) available to the user
     * with data about the files' file type and field names.
     *
     * @param  FileType $fileType
     * @return Collection
     */
    public function index(FileType $fileType)
    {
        $files = $fileType->files()->availableFor(
            auth()->user()
        )->as($fileType);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $files->sort($sortBy, $ascending);

        // Paginate per request.
        $perPage = request('perPage');
        $files = $files->paginate($perPage);

        return (new Files($files))->as($fileType);
    }

    /**
     * Show the profile of the selected user.
     *
     * @param  File  $file
     * @return File
     */
    public function show(FileType $fileType, File $file)
    {
        $this->authorize('read', $file);

        // Can be put into resource.
        return $file->with('file_type')->where('id', $file->id)->where('file_type_id', $fileType->id)->firstOrFail();
    }

    public function create()
    {
        $this->authorize('create', File::class);

        return auth()->user()->teams;
    }

    public function store()
    {
        $this->authorize('create', File::class);

        // Store file when user is authorized.
    }

    public function edit(File $file)
    {
        $this->authorize('write', File::class);

        // Return file after user is authorized.
    }

    public function update(File $file)
    {
        $this->authorize('write', File::class);

        // Update file after user is authorized.
    }

    public function destroy(File $file)
    {
        $this->authorize('write', $file);

        // Delete file after user is authorized.
    }
}
