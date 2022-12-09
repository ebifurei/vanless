<?php

namespace App\Events;

use App\Mappers\UplinkMapperInterface;
use App\Models\Device;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UplinkReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $device;
    public $mapper;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Device $device, UplinkMapperInterface $mapper)
    {
        $this->device = $device;
        $this->mapper = $mapper;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['device.' . $this->device['device_id']];
    }

    public function broadcastWith()
    {
        return [
            'device_id' => $this->device['device_id'],
            'payload' => $this->getLatestPayload(),
            'time_device' => $this->mapper->getTime()->toDateString(),
            'time_server' => now()->toDateString(),
        ];
    }

    public function getLatestPayload()
    {
        $payload = $this->mapper->getPayload();

        if (is_array($payload)) {
            $payload = json_encode($payload);
        }
    }
}
