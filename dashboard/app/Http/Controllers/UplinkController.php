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
        // return inertial Uplink/Index or if theres a request, return json
        return Inertia::render('Uplink/Index', [
            'uplinks' => Uplink::latest()->paginate(6),
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
            'device_eui' => $mapper->getEui(),
            'latest_payload' => [],
            'latest_payload_at' => null
        ]);

        $device->latest_payload = $payload;
        $device->latest_payload_at = $uplink->created_at;
        $device->save();

        return response()->noContent();
    }
}
