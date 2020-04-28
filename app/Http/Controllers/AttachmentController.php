<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Attachment;

class AttachmentController extends Controller
{
    public function store()
    {
        // TODO: authorize

        return [
            'data' => [
                'id' => (Attachment::saveFile(request()->file('file')))->id
            ]
        ];
    }

    public function destroy(Attachment $attachment)
    {
        // TODO: authorize

        return $attachment->delete();
    }
}
