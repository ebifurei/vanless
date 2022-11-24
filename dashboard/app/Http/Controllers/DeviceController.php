<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeviceController extends Controller
{
    public function index()
    {
        \sleep(1);

        $devices = Device::orderByRaw('FIELD(status, "danger", "inactive", "maintenance", "active")')
        ->latest()->get();

        return Inertia::render('Devices/Index', [
            'deviceList' => $devices,
        ]);
    }
}
