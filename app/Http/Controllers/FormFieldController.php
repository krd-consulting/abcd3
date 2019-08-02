<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormField;

use Illuminate\Http\Request;

class FormFieldController extends Controller
{
    public function index(Form $form)
    {
    	$fields = $form->fields();

		// Search
        $search = request('search');
        $fields = $fields->search($search);

        // Filter
        $type = request('field_type');
        $fields = $fields->filter(['type' => $type]);

        // Sort per request.
        $ascending = request('ascending');
        $sortBy = request('sortBy');
        $fields = $fields->sort($sortBy, $ascending);

        // Paginate per request.
        $perPage = request('perPage');
        $fields = $fields->paginate($perPage);

        return $fields;
    }
}
