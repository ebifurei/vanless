<?php

namespace App\Listeners;

use App\Events\DeviceUpdated;
use App\Events\UplinkReceived;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckDeviceStatus
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
    public function handle(DeviceUpdated $event)
    {
        $device = $event->device;
        $oldStatus = $event->oldStatus;
        $subscriber = User::where('email_subscriber', true)->get();

        if ($oldStatus != $device->status) {
            foreach ($subscriber as $user) {
                $user->notify(new \App\Notifications\DeviceStatusNotification($device));
            }
        }
    }
}
