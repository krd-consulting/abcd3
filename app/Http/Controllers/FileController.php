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
        return $fileType->files()->paginate(10);
    }
}
