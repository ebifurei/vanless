<?php

namespace Tests\Feature;

use App\Events\UplinkReceived;
use App\Models\User;
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

    // /** @test */ not use beacuse we using port to determine status rather then payload
    // public function it_can_update_device_status_when_storing_chirpstack_uplink()
    // {
    //     $uplink = $this->generateChirpstackUplink();

    //     $uplink["objectJSON"] = "{\"status\": \"inactive\"}";

    //     $this->post(route('uplink.chirpstack', [
    //         'event' => 'up'
    //     ]), $uplink);

    //     $this->assertDatabaseHas('devices', [
    //         'device_id' => $uplink['deviceName'],
    //         'status' => 'inactive'
    //     ]);
    // }

    // /** @test */
    // public function it_can_send_notification_when_status_change()
    // {
    //     $uplink = $this->generateChirpstackUplink();
    //     $user = User::factory()->create([
    //         'email_subscribe' => true
    //     ]);

    //     $this->post(route('uplink.chirpstack', [
    //         'event' => 'up'
    //     ]), $uplink);

    //     $uplink["objectJSON"] = "{\"status\": \"danger\"}";

    //     $this->post(route('uplink.chirpstack', [
    //         'event' => 'up'
    //     ]), $uplink);

    //     $this->assertDatabaseHas('devices', [
    //         'device_id' => $uplink['deviceName'],
    //         'status' => 'danger'
    //     ]);

    //     $this->assertDatabaseHas('notifications', [
    //         'notifiable_id' => $user->id,
    //         'type' => 'App\Notifications\DeviceStatusNotification',
    //     ]);
    // }

    /** @test */
    public function it_can_change_device_status_from_port_when_uplink_received()
    {
        $uplink = $this->generateChirpstackUplink();

        $uplink["fPort"] = 2;

        $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);

        $this->assertDatabaseHas('devices', [
            'device_id' => $uplink['deviceName'],
            'status' => 'danger'
        ]);
    }

    /** @test */
    public function it_can_change_device_status_from_port_when_uplink_received_2()
    {
        $uplink = $this->generateChirpstackUplink();

        $uplink["fPort"] = 3;

        $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);

        $this->assertDatabaseHas('devices', [
            'device_id' => $uplink['deviceName'],
            'status' => 'onrepair'
        ]);
    }
}
