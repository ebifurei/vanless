<?php

namespace App\Listeners;

use App\Events\UplinkReceived;
use App\Models\UplinkCounterDaily;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateDeviceProgressDaily
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
        $device = $event->device;
        $uplinks = $device->uplinks()->whereDate('date', now()->toDateString())->count();
        $device->progress_daily = $uplinks;
        $device->save();

        // first or create uplinkCounterDaily for today
        $uplinkCounterDaily = $device->uplinkCounterDaily()->firstOrCreate([
            'date' => now()->toDateString(),
        ]);
        $uplinkCounterDaily->uplink_counter = $uplinks;
        $uplinkCounterDaily->save();
    }
}
