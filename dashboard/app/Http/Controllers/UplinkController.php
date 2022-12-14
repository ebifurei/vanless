<?php

namespace App\Http\Controllers;

use App\Http\Resources\UplinkResource;
use App\Mappers\ChirpstackUplinkMapper;
use App\Mappers\UplinkMapperInterface;
use App\Models\Device;
use App\Models\Uplink;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UplinkController extends Controller
{
    public function index()
    {
        return Inertia::render('Uplink/Index', [
            'uplinks' => Uplink::latest()->paginate(6)
                ->withQueryString()
                ->through(fn ($uplink) => new UplinkResource($uplink)),
        ]);
    }

    public function chirpstack(Request $request)
    {
        if ($request->query('event') == 'up') {
            $mapper = new ChirpstackUplinkMapper($request->all());

            return $this->storeUplink($mapper);
        }
        return response(null, 204);
    }

    private function storeUplink(UplinkMapperInterface $mapper)
    {
        $data = [
            'device_id' => $mapper->getDeviceId(),
            'date' => $mapper->getTime()->toDateString(),
            'port' => $mapper->getPort(),
        ];

        $payload = $mapper->getPayload();

        $uplink = Uplink::create($data, [
            'payloads' => [],
        ]);

        $uplink->payloads = $payload;
        $uplink->save();


        $device = Device::firstOrCreate([
            'device_id' => $mapper->getDeviceId(),
        ], [
            'name' => null,
            'timezone' => 'Asia/Jakarta',
            'status' => 'active',
            'device_eui' => $mapper->getEui(),
            'latest_payload' => [],
            'latest_payload_at' => null
        ]);

        if (isset($payload['status'])) {
            if ($device->status != $payload['status']) {
                event(new \App\Events\DeviceStatusChanged($device, $payload['status']));
            }
            $device->status = $payload['status'];
        }

        $device->latest_payload = $payload;
        $device->latest_payload_at = $uplink->created_at->timezone($device->timezone);
        $device->save();

        event(new \App\Events\UplinkReceived($device, $mapper));

        return response()->noContent();
    }
}
