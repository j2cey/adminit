<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobProcessedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $job_id;
    public int $launcher_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $job_id, int $launcher_id)
    {
        //
        $this->job_id = $job_id;
        $this->launcher_id = $launcher_id;
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
