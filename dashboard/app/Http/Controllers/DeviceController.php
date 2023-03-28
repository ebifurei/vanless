<?php

namespace App\Http\Controllers;

use App\Http\Resources\DownlinkResource;
use App\Http\Resources\UplinkResource;
use App\Models\Device;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::orderByRaw('FIELD(status, "danger", "inactive", "maintenance", "active")')
            ->latest()->get();

        return Inertia::render('Devices/Index', [
            'deviceList' => $devices,
        ]);
    }

    public function show(Device $device)
    {
        $uplinks = $device->uplinks()->latest()->paginate(6)
            ->through(fn ($uplink) => new UplinkResource($uplink));

        $downlinks = $device->downlinks()->latest()->paginate(6)
            ->through(fn ($downlink) => new DownlinkResource($downlink));

        return Inertia::render('Devices/Show', [
            'device' => $device,
            'uplinks' => $uplinks,
            'downlinks' => $downlinks,
        ]);
    }

    public function create()
    {
        return Inertia::render('Devices/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'device_id' => 'required|max:255',
            'device_eui' => 'required|max:255',
            'device_class' => 'nullable|max:255',
            'device_normal_interval' => 'nullable|max:255',
            'device_alert_interval' => 'nullable|max:255',
            'status' => 'nullable',
            'description' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        Device::create($request->all());

        return redirect()->route('device.index')
            ->with('success', 'Device created successfully.');
    }

    public function edit(Device $device)
    {
        return Inertia::render('Devices/Edit', [
            'device' => $device,
        ]);
    }

    public function update(Request $request, Device $device)
    {
        $request->validate([
            'name'  => 'nullable|max:255',
            'status' => 'nullable',
            'device_eui' => 'nullable|max:255',
            'device_class' => 'nullable',
            'device_normal_interval' => 'nullable',
            'device_alert_interval' => 'nullable',
            'description' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        $oldStatus = $device->status;
        $device->update($request->all());

        if ($oldStatus !== $device->status) {
            event(new \App\Events\DeviceStatusChanged($device, $oldStatus));
        }

        event(new \App\Events\DeviceUpdated($device));

        return redirect()->route('device.index')
            ->with('success', 'Device updated successfully');
    }

    public function destroy(Device $device)
    {
        $device->delete();

        return redirect()->route('device.index')
            ->with('success', 'Device deleted successfully');
    }

    public function getDeviceList()
    {
        $devices = Device::orderByRaw('FIELD(status, "danger", "inactive", "maintenance", "active")')
            ->latest()->get();

        return response()->json($devices);
    }
}
