<?php

namespace App\Events;

use App\ProgramRecord;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProgramRecordCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $program;
    public $record;
    public $programRecord;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ProgramRecord $programRecord)
    {
        $this->program = $programRecord->program;
        $this->record = $programRecord->record;
        $this->programRecord = $programRecord;
    }
}
