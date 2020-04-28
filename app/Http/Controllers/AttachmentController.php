<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use App\Attachment;

class AttachmentController extends Controller
{
    public function show(Attachment $attachment)
    {
        // TODO: authorize

        return [
            'data' => $attachment
        ];
    }

    public function download(Attachment $attachment)
    {
        // TODO: authorize

        return Storage::download($attachment->path, $attachment->name);
    }

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

        return [
            'data' => $attachment->delete()
        ];
    }
}
