<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Core\Location\Location;
use App\Http\Requests\Location\SaveLocation;

class OnBeforeSaveLocationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $errors = [], $location, $request, $sources;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Location $location, SaveLocation $request)
    {
        $this->location = $location;
        $this->request  = $request;
        $this->sources = new \Stdclass;
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
