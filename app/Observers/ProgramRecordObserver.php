<?php

namespace App\Observers;

use App\ProgramRecord;

class ProgramRecordObserver
{
    /**
     * Handle the program record "created" event.
     *
     * @param  \App\ProgramRecord  $programRecord
     * @return void
     */
    public function created(ProgramRecord $programRecord)
    {
        $programRecord->record->teams()->syncWithoutDetaching([$programRecord->program->team->id]);
    }

    /**
     * Handle the program record "updated" event.
     *
     * @param  \App\ProgramRecord  $programRecord
     * @return void
     */
    public function updated(ProgramRecord $programRecord)
    {
        //
    }

    /**
     * Handle the program record "deleted" event.
     *
     * @param  \App\ProgramRecord  $programRecord
     * @return void
     */
    public function deleted(ProgramRecord $programRecord)
    {
        $programRecord->record->groups()->detach(
            $programRecord->program->groups->pluck('id')
        );
    }

    /**
     * Handle the program record "restored" event.
     *
     * @param  \App\ProgramRecord  $programRecord
     * @return void
     */
    public function restored(ProgramRecord $programRecord)
    {
        $programRecord->record->teams()->syncWithoutDetaching([$programRecord->program->team->id]);
    }

    /**
     * Handle the program record "force deleted" event.
     *
     * @param  \App\ProgramRecord  $programRecord
     * @return void
     */
    public function forceDeleted(ProgramRecord $programRecord)
    {
        //
    }
}
