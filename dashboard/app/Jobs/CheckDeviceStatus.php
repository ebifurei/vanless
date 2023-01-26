<?php

namespace App\Jobs;

use App\Events\DeviceStatusChecked;
use App\Models\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class CheckDeviceStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $interval;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($interval = 10)
    {
        $this->interval = $interval;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $now = Carbon::now();
        $deviceIds = [];
        Device::where('status', 'active')->chunk(10, function ($devices) use ($now, &$deviceIds) {
            foreach ($devices as $device) {
                if ($device->latest_payload_at->diffInMinutes($now) > $this->interval) {
                    array_push($deviceIds, $device->id);
                }
            }
        });
        Device::whereIn('id', $deviceIds)->update(['status' => 'inactive']);
        event(new DeviceStatusChecked(count($deviceIds)));
    }
}
