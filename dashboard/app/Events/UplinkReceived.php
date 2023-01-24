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

class UplinkReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $device;
    public $mapper;
    public $count;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Device $device, UplinkMapperInterface $mapper, $count)
    {
        $this->device = $device;
        $this->mapper = $mapper;
        $this->count = $count;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['uplink-received'];
    }

    public function broadcastWith()
    {
        return [
            'device_id' => $this->device['device_id'],
            'status' => $this->device['status'],
            'payload' => $this->getLatestPayload(),
            'time_device' => $this->mapper->getTime()->toDateString(),
            'time_server' => now()->toDateString(),
            'count' => $this->count,
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
