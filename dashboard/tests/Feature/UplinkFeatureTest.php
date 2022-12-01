<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Uplink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
