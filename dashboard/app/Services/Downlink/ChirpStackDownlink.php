<?php

namespace App\Services\Downlink;

use App\Services\Contracts\DownlinkClientInterface;
use GuzzleHttp\Client;

class ChirpStackDownlink implements DownlinkClientInterface
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function sendDownlink($devId, $payload, $port)
    {
        $payloadRaw = base64_encode($payload);
        $token = env('CHIRPSTACK_API_KEY');

        $response = $this->client->post("http://45.32.120.146:8080/api/devices/{$devId}/queue", [
            'headers' => [
                'Grpc-Metadata-Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'deviceQueueItem' => [
                    'confirmed' => false,
                    'data' => $payloadRaw,
                    'devEUI' => $devId,
                    'fPort' => $port
                ]
            ]
        ]);

        return $response->getStatusCode();
    }
}
