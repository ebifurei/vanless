<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public const REAL_DEVICE_EUI = '9f3a728fb7242296';
    public const REAL_DEVICE_ID = 'testing-devices';
    public $user;

    public function login($user = null)
    {
        $this->user = $user ?? User::factory()->create();

        $this->actingAs($this->user);
    }

    public function generateRandomHex($byte = 32)
    {
        $byteList = "0123456789ABCDEF";
        $hex = '';

        for ($i = 0; $i < $byte; $i++) {
            $random = random_int(0, 15);
            $hex .= $byteList[$random];
        }

        return $hex;
    }

    /**
     * Generate fake lora server uplink
     *
     * @param string $deviceId
     * @return array
     */
    public function generateLoraServerUplink($deviceId = "sbiot-rfm01")
    {
        return [
            "applicationID" => "1",
            "applicationName" => "LunarApp1",
            "deviceName" => $deviceId,
            "devEUI" => "0002b82c9c62d66a",
            "rxInfo" => [
                [
                    "gatewayID" => "b827ebfffee12e02",
                    "name" => "vanless-loraserver",
                    "time" => "2019-07-21T11:45:01.389569Z",
                    "rssi" => -41,
                    "loRaSNR" => 11.2,
                    "location" => [
                        "latitude" => -7.72452,
                        "longitude" => 110.3797,
                        "altitude" => 232
                    ]
                ]
            ],
            "txInfo" => [
                "frequency" => 923200000,
                "dr" => 4
            ],
            "adr" => true,
            "fCnt" => 1,
            "fPort" => 1,
            "data" => "CK4=",
            "object" => [
                "batt" => 22.22
            ]
        ];
    }

    /**
     * Generate Fake chripstack uplink
     *
     * @param string $deviceId
     * @return void
     */
    public function generateChirpstackUplink($deviceId = "sbiot-rfm01")
    {
        $uplink = $this->generateLoraServerUplink($deviceId);
        $uplink['devEUI'] = "vVnh4aKM7Ho=";
        $uplink["objectJSON"] = "{\"valve\":0}";

        return $uplink;
    }

    public function generateChirpstackGateway($gatewayEui = "7276ff002e060f33")
    {
        return [
            "gateway" => [
                "id" => $gatewayEui,
                "name" => "Wirnet-iBTS-02",
                "description" => "Gateway kerlink 2021 w11",
                "location" => [
                    "latitude" => -6.7957549095154,
                    "longitude" => 110.83261108398,
                    "altitude" => 95,
                    "source" => "UNKNOWN",
                    "accuracy" => 0,
                ],
                "organizationID" => "2",
                "discoveryEnabled" => false,
                "networkServerID" => "8",
                "gatewayProfileID" => "",
                "boards" => [],
                "tags" => [],
                "metadata" => [],
            ],
            "createdAt" => "2021-03-16T08:24:36.804198Z",
            "updatedAt" => "2022-02-15T13:44:26.423106Z",
            "firstSeenAt" => "2021-03-16T09:56:45.251350Z",
            "lastSeenAt" => "2022-02-15T13:44:26.419635Z",
        ];
    }

    public function generateChirpstackLocation($deviceId = "EdgeTrackerAS923-2")
    {
        return [
            "applicationID" => "3",
            "applicationName" => "TrackerLR1110",
            "deviceName" => $deviceId,
            "devEUI" => "ABbAAfAAW5w=",
            "location" => [
                "latitude" => -7.763007,
                "longitude" => 110.388387,
                "altitude" => 0,
                "source" => "GEO_RESOLVER_WIFI",
                "accuracy" => 0
            ],
            "tags" => [],
            "uplinkIDs" => [],
            "fCnt" => 14,
            "publishedAt" => "2022-03-31T10:08:19.148330412Z"
        ];
    }
}
