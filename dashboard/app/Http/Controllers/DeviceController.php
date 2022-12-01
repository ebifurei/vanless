<?php

namespace App\Http\Controllers;

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
        $device = $device->load('uplinks');

        return Inertia::render('Devices/Show', [
            'device' => $device,
        ]);
    }

    public function create()
    {
        return Inertia::render('Devices/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'device_id' => 'required',
            'device_eui' => 'required',
            'description' => 'nullable',
            'address' => 'nullable',
            'latitude' => 'required',
            'longitude' => 'required',
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
            'name'  => 'required',
            'device_id' => 'required',
            'device_eui' => 'nullable',
            'description' => 'nullable',
            'address' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        $device->update($request->all());

        return redirect()->route('devices.index')
            ->with('success', 'Device updated successfully');
    }

    public function destroy(Device $device)
    {
        $device->delete();

        return redirect()->route('devices.index')
            ->with('success', 'Device deleted successfully');
    }

    public function getDeviceList()
    {
        $devices = Device::orderByRaw('FIELD(status, "danger", "inactive", "maintenance", "active")')
            ->latest()->get();

        return response()->json($devices);
    }
}
