<?php

namespace Tests\Feature;

use App\Jobs\CheckDeviceStatus;
use App\Models\Device;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class JobsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_job_changes_status_of_inactive_devices()
    {
        // Create some devices
        Device::factory()->create([
            'status' => 'active',
            'latest_payload_at' => Carbon::now()->subMinutes(11)
        ]);
        Device::factory()->create([
            'status' => 'active',
            'latest_payload_at' => Carbon::now()
        ]);
        Device::factory()->create([
            'status' => 'active',
            'latest_payload_at' => Carbon::now()->subMinutes(2)
        ]);

        // Dispatch the job
        dispatch(new CheckDeviceStatus());

        // Assert that the status of inactive devices is not changed
        $this->assertEquals(1, Device::where('status', 'inactive')->count());
    }

    /** @test */
    public function it_fires_the_device_status_checked_event()
    {
        Event::fake();
        // Create some active devices
        Device::factory()->create([
            'status' => 'active',
            'latest_payload_at' => Carbon::now()->subMinutes(11)
        ]);

        // Dispatch the job
        dispatch(new CheckDeviceStatus());

        // Assert that the event is fired
        Event::assertDispatched(\App\Events\DeviceStatusChecked::class);
    }
}
