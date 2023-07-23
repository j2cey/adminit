<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportFileImportedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $reportfileId;
    public int $reporttreatmentresultId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $reportfileId, int $reporttreatmentresultId)
    {
        //
        $this->reportfileId = $reportfileId;
        $this->reporttreatmentresultId = $reporttreatmentresultId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
