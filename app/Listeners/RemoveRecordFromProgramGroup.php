<?php

namespace App\Listeners;

use App\Events\ProgramRecordDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveRecordFromProgramGroup
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProgramRecordDeleted  $event
     * @return void
     */
    public function handle(ProgramRecordDeleted $event)
    {
        $programGroups = $event->programRecord->program->groups;

        $event->programRecord->record->groups()->detach($programGroups->pluck('id'));
    }
}
