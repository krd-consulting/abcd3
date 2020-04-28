<?php

namespace App;

class Attachment extends Model
{
    public function attachmentable()
    {
        return $this->morphTo();
    }

    public static function saveFile($file)
    {
        $path = $file->store('attachments');

        $attachment = (new Attachment([ 'path' => $path ]));
        $attachment->save();

        return $attachment;
    }
}
