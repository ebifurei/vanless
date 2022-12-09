<?php

namespace Tests\Feature;

use App\Events\UplinkReceived;
use App\Models\Device;
use App\Models\Uplink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UplinkFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_chirpstack_uplink()
    {
        $uplink = $this->generateChirpstackUplink();

        $response = $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);

        $this->assertDatabaseHas('uplinks', [
            'device_id' => $uplink['deviceName']
        ]);
    }

    /** @test */
    public function it_can_store_chirpstack_uplink_and_make_a_new_device()
    {
        $uplink = $this->generateChirpstackUplink();

        $response = $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);

        $this->assertDatabaseHas('devices', [
            'device_id' => $uplink['deviceName']
        ]);
    }

    /** @test */
    public function it_can_launch_event_when_storing_chirpstack_uplink()
    {
        Event::fake();
        $uplink = $this->generateChirpstackUplink();

        $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);

        // assert event is dispatched
        Event::assertDispatched(UplinkReceived::class);
    }

    /** @test */
    public function it_can_update_progress_daily_when_storing_chirpstack_uplink()
    {
        $uplink = $this->generateChirpstackUplink();

        $uplink['rxInfo'][0]['time'] = now();
        $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);
        $uplink['rxInfo'][0]['time'] = now()->addHour();
        $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);

        $this->assertDatabaseHas('devices', [
            'device_id' => $uplink['deviceName'],
            'progress_daily' => 2
        ]);
    }

    /** @test */
    public function it_can_reset_progress_daily_when_storing_chirpstack_uplink()
    {
        $uplink = $this->generateChirpstackUplink();

        $uplink['rxInfo'][0]['time'] = now()->subDay();
        $response = $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);
        $uplink['rxInfo'][0]['time'] = now()->subDay()->addHour();
        $response = $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);

        // 1 today uplink
        $uplink['rxInfo'][0]['time'] = now();
        $response = $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);

        $this->assertDatabaseHas('devices', [
            'device_id' => $uplink['deviceName'],
            'progress_daily' => 1
        ]);
    }

    /** @test */
    public function it_can_store_uplink_counter_daily_when_storing_chirpstack_uplink()
    {
        $uplink = $this->generateChirpstackUplink();

        $uplink['rxInfo'][0]['time'] = now();
        $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);
        $uplink['rxInfo'][0]['time'] = now()->addHour();
        $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);

        $this->assertDatabaseHas('uplink_counter_dailies', [
            'device_id' => $uplink['deviceName'],
            'date' => now()->toDateString(),
            'uplink_counter' => 2
        ]);
    }

    /** @test */
    public function it_can_store_uplink_counter_when_storing_chirpstack_uplink()
    {
        $uplink = $this->generateChirpstackUplink();

        $uplink['rxInfo'][0]['time'] = now();
        $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);
        $uplink['rxInfo'][0]['time'] = now()->addHour();
        $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);

        $this->assertDatabaseHas('devices', [
            'device_id' => $uplink['deviceName'],
            'uplink_counter' => 2
        ]);
    }
}
