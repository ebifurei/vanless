<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Downlink;
use App\Services\Chirpstack\ChirpStackDownlink;
use Illuminate\Http\Request;

class DownlinkController extends Controller
{
    public function sendDownlink(Request $request)
    {
        $request->validate([
            'device_id' => 'required',
            'payload' => 'required',
            'port' => 'required',
        ]);

        $device = Device::where('device_id', $request->device_id)->firstOrFail();

        // create downlink to table
        $downlink_data = Downlink::create([
            'device_id' => $device->device_id,
            'payload' => $request->payload,
            'port' => $request->port,
        ]);

        // send downlink to device
        $device_eui = $device->device_eui;
        $downlink = new ChirpStackDownlink();
        $downlink->sendDownlink($device_eui, $request->payload, $request->port);

        return response()->noContent();
    }
}
