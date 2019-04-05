<?php

namespace App\Listeners;

use App\ProgramClientStatus as Status;

use App\Events\ProgramRecordCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateProgramClientStatus
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
     * @param  ProgramRecordCreated  $event
     * @return void
     */
    public function handle(ProgramRecordCreated $event)
    {
        // If record identity isn't Client (id: 1), don't generate a status.
        if($event->record->record_type->identity->name != 'Client')
            return;

        $status = new Status;
        $status->program_client_id = $event->programRecord->id;
        $status->status = 'waitlist';
        $status->previous_status = '';
        $status->previous_status_duration = 0;
        $status->notes = '';
        $status->created_by = $event->programRecord->created_by;
        $status->updated_by = $event->programRecord->created_by;
        $status->save();
    }
}
