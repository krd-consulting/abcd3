<?php

namespace App\Listeners;

use App\ProgramClientStatus;

use App\Events\ProgramRecordDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateRemovedProgramClientStatus
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
        $status = new ProgramClientStatus();
        $status->createForProgramRecord($event->programRecord, 5);
    }
}
