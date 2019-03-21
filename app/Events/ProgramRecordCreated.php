<?php

namespace App\Events;

use App\Program;
use App\Record;

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
    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Program $program, Record $record)
    {
        $this->program = $program;
        $this->record = $record;
    }
}
