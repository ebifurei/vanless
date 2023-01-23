<?php

namespace Tests\Feature;

use App\Services\Downlink\ChirpStackDownlink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use GuzzleHttp\Client;

class ChirpStackDownlinkTest extends TestCase
{
    protected $chirpStackDownlink;

    public function setUp(): void
    {
        parent::setUp();

        $client = new Client();
        $this->chirpStackDownlink = new ChirpStackDownlink($client);
    }

    public function testSendDownlink()
    {
        $deviceEui = '374d742c65b7e2ca';
        $payload = '0';
        $port = 1;
        $response = $this->chirpStackDownlink->sendDownlink($deviceEui, $payload, $port);
        $this->assertEquals(200, $response);
    }
}
