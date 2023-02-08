<?php

namespace App\Services\Chirpstack;

use App\Services\Contracts\DownlinkClientInterface;

class ChirpStackDownlink extends BaseClient implements DownlinkClientInterface
{
    public function sendDownlink($devId, $payload, $port)
    {
        $payloadHex = dechex($payload);
        $payloadHex = str_pad($payloadHex, 2, '0', STR_PAD_LEFT);
        $payloadBin = pack("H*", $payloadHex);
        $payloadRaw = base64_encode($payloadBin);

        try {
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
        } catch (\Exception $e) {
            return $e->getCode();
        }

        return $response->getStatusCode();
    }
}
