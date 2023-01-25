<?php

namespace Tests\Feature;

use App\Jobs\CheckDeviceStatus;
use App\Models\Device;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobsTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_changes_status_of_inactive_devices()
    {
        // Create some devices
        Device::factory()->create([
            'status' => 'active',
            'latest_payload_at' => Carbon::now()->subMinutes(12)
        ]);
        Device::factory()->create([
            'status' => 'active',
            'latest_payload_at' => Carbon::now()
        ]);
        Device::factory()->create([
            'status' => 'active',
            'latest_payload_at' => Carbon::now()->subMinutes(5)
        ]);

        // Dispatch the job
        dispatch(new CheckDeviceStatus());

        // Assert that the status of inactive devices is not changed
        $this->assertEquals(1, Device::where('status', 'inactive')->count());
    }
}
