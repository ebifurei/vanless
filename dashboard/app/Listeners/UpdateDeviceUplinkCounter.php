<?php

namespace App\Listeners;

use App\Events\UplinkReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateDeviceUplinkCounter implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UplinkReceived $event)
    {
        if ($event->mapper->getPort() > 3) {
            return;
        };
        $device = $event->device;
        $uplink_counter = $device->uplink_counter ?? 0;
        $uplink_counter += 1;
        $device->uplink_counter = $uplink_counter;
        $device->save();
    }
}
