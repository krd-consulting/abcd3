<?php

namespace App\Observers;

use App\ClientStatus;
use App\ProgramClient;
use App\ProgramClientStatus;

class ProgramClientObserver
{
    /**
     * Handle the program client "created" event.
     *
     * @param  \App\ProgramClient  $programClient
     * @return void
     */
    public function created(ProgramClient $programClient)
    {
        $status = new ProgramClientStatus;
        $status->createForProgramRecord($programClient);
    }

    /**
     * Handle the program client "updated" event.
     *
     * @param  \App\ProgramClient  $programClient
     * @return void
     */
    public function updated(ProgramClient $programClient)
    {
        //
    }

    /**
     * Handle the program client "deleted" event.
     *
     * @param  \App\ProgramClient  $programClient
     * @return void
     */
    public function deleted(ProgramClient $programClient)
    {
        $status = new ProgramClientStatus();
        $status->createForProgramRecord(
            $programClient, 
            ClientStatus::where('name', config('app.program_client_statuses.removed.name'))->first()->id
        );
    }

    /**
     * Handle the program client "restored" event.
     *
     * @param  \App\ProgramClient  $programClient
     * @return void
     */
    public function restored(ProgramClient $programClient)
    {
        $status = new ProgramClientStatus;
        $status->createForProgramRecord($programClient);
    }

    /**
     * Handle the program client "force deleted" event.
     *
     * @param  \App\ProgramClient  $programClient
     * @return void
     */
    public function forceDeleted(ProgramClient $programClient)
    {
        //
    }
}
