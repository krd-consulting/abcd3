<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
		$forms = (new Form);

		// Search
        $search = request('search');
        $forms = $forms->search($search);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $forms = $forms->sort($sortBy, $ascending);

        $forms = $forms->availableFor(auth()->user());

        // Paginate per request.
        $perPage = request('perPage');
        $forms = $forms->paginate($perPage);

        return $forms;

    }
}
