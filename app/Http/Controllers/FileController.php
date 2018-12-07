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
        $files = $this->retrieveFiles($fileType, auth()->user())->as($fileType);


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

    /**
     *
     * Retrieve files based on a given file type, and the user's scope.
     *
     * @param App\FileType $fileType
     * @param App\User $user
     * @return Illuminate\Database\Eloquent\Collection $files
     */

    protected function retrieveFiles(Filetype $fileType, User $user)
    {
        $files;

        // Get user scope.
        $scope = $user->scope;

        // Get $fileType files based on $scope
        switch($scope) {
            case 'universal':
                // Get all $fileType files
                $files = $fileType->files();
                break;

            case 'team':
                // Get $fileType files that belong to teams $teams
                $teams = $user->teams;
                $files = $fileType->files()->inTeams($teams);

                break;

            case 'program':
                // Get $fileType files that belong to programs $programs
                $programs = $user->programs;
                $files = $fileType->files()->inPrograms($programs);

                break;

            case 'case load':
                // Get $fileType files that belongs to the user.
                $files = $fileType->files()->inCaseLoad($user);

                break;

            default:
                $files = [];
        }

        return $files;
    }
}
