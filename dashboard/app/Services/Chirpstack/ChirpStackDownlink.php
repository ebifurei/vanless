<?php

namespace App\Services\Chirpstack;

use App\Services\Contracts\DownlinkClientInterface;

class ChirpStackDownlink extends BaseClient implements DownlinkClientInterface
{
    public function sendDownlink($devId, $payload, $port)
    {
        if ($payload === 0) {
            $payloadRaw = 'AA==';
        } else {
            $t = gmp_init($payload);
            $payload = gmp_export($t, 1);
            $payloadRaw = base64_encode($payload);
        }

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
