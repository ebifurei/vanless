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

        // response data base has device_id in uplinks table
        $this->assertDatabaseHas('uplinks', [
            'device_id' => $uplink['deviceName']
        ]);

        // response data base has device_id in devices table
        $this->assertDatabaseHas('devices', [
            'device_id' => $uplink['deviceName']
        ]);
    }

    /** @test */
    public function it_can_store_chirpstack_uplink_with_latest_payload()
    {
        $uplink = $this->generateChirpstackUplink();

        $response = $this->post(route('uplink.chirpstack', [
            'event' => 'up'
        ]), $uplink);

        // response data base has device_id in uplinks table
        $this->assertDatabaseHas('uplinks', [
            'device_id' => $uplink['deviceName']
        ]);

        // response data base has device_id in devices table
        $this->assertDatabaseHas('devices', [
            'device_id' => $uplink['deviceName']
        ]);

        // response data base has latest_payload in devices table
        $this->assertDatabaseHas('devices', [
            'latest_payload' => json_encode($uplink['objectFields'])
        ]);
    }
}
