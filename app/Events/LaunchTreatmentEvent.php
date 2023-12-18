<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use App\Models\ReportFile\ReportFile;
use Illuminate\Queue\SerializesModels;
use App\Models\ReportTreatments\Treatment;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LaunchTreatmentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $treatmentId;
    public int $reportfileId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Treatment $treatment, ReportFile $reportfile)
    {
        $this->treatmentId = $treatment->id;
        $this->reportfileId = $reportfile->id;
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
