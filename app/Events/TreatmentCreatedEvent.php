<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Models\Treatments\Treatment;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TreatmentCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $treatment_id;
    public ?int $reportfile_id;
    public ?int $collectedreportfile_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Treatment $treatment)
    {
        $this->treatment_id = $treatment->id;
        $this->reportfile_id = $treatment->reportfile?->id;
        $this->collectedreportfile_id = $treatment->collectedreportfile?->id;
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

    public function broadcastWith() {

    }
}
