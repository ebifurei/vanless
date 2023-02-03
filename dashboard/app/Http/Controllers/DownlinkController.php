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
            'command' => 'nullable|max:255',
            'payload' => 'required|integer|max:150',
            'port' => 'required|integer|max:255',
        ]);

        $device = Device::where('device_id', $request->device_id)->firstOrFail();

        // send downlink to device
        $device_eui = $device->device_eui;
        $downlink = new ChirpStackDownlink();
        $response = $downlink->sendDownlink($device_eui, $request->payload, $request->port);

        if ($response != 200) {
            return redirect()->back()->with('error', 'Downlink failed!');
        }

        // create downlink to table
        Downlink::create([
            'device_id' => $device->device_id,
            'command' => $request->command,
            'payload' => $request->payload,
            'port' => $request->port,
        ]);

        return redirect()->back()->with('success', 'Downlink sent!');
    }
}
