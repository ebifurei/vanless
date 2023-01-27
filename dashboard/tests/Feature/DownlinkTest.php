<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Services\Chirpstack\ChirpStackDownlink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use GuzzleHttp\Client;

class DownlinkTest extends TestCase
{
    protected $chirpStackDownlink;

    public function setUp(): void
    {
        parent::setUp();

        $client = new Client();
        $this->chirpStackDownlink = new ChirpStackDownlink($client);
    }

    // when execute this test, it will send downlink to device carefully
    public function testSendDownlink()
    {
        $deviceEui = '374d742c65b7e2ca';
        $payload = 1;
        $port = 1;
        $response = $this->chirpStackDownlink->sendDownlink($deviceEui, $payload, $port);
        $this->assertNotNull($response);
    }


    public function testSendDownlinkEndPoint()
    {
        $this->login();
        $device = Device::factory()->create([
            'device_id' => 'VanLess-1',
            'device_eui' => '374d742c65b7e2ca'
        ]);
        $downlinkData = [
            'device_id' => $device->device_id,
            'payload' => 1,
            'port' => 5,
        ];

        // send a request to the endpoint with downlink data
        $response = $this->post(route('downlink.send'), $downlinkData);

        $response->assertStatus(302);
    }
}
