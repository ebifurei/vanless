<?php

namespace App\Services\Chirpstack;

use App\Services\Contracts\DownlinkClientInterface;

class ChirpStackDownlink extends BaseClient implements DownlinkClientInterface
{
    public function sendDownlink($devId, $payload, $port)
    {
        $payloadRaw = base64_encode($payload);

        $response = $this->client->post("api/devices/{$devId}/queue", [
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
