<?php

namespace App\Listeners;

use App\ProgramClientStatus;

use App\Events\ProgramRecordSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateWaitlistProgramClientStatus
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
    public function handle(ProgramRecordSaved $event)
    {
        $status = new ProgramClientStatus;
        $status->createForProgramRecord($event->programRecord);
    }
}
