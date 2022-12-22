<?php

namespace App\Listeners;

use App\Events\DeviceStatusChanged;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDeviceStatusNotification
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
    public function handle(DeviceStatusChanged $event)
    {
        $device = $event->device;
        $oldStatus = $event->oldStatus;
        $subscriber = User::where('email_subscribe', true)->get();

        if ($oldStatus != $device->status) {
            foreach ($subscriber as $user) {
                $user->notify(new \App\Notifications\DeviceStatusNotification($device));
            }
        }
    }
}
