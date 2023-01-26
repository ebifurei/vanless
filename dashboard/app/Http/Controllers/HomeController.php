<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeviceResourcePublic;
use App\Http\Resources\UplinkResource;
use App\Models\Device;
use App\Models\Uplink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $uplinks = Uplink::latest()->select('id', 'device_id', 'date', 'port', 'created_at')
            ->limit(4)
            ->get()
            ->map(function ($uplink) {
                return [
                    'id' => $uplink->id,
                    'device_id' => $uplink->device_id,
                    'date' => $uplink->date,
                    'port' => $uplink->port,
                    'time' => $uplink->created_at->timezone('Asia/Jakarta')->toTimeString(),
                ];
            });

        return Inertia::render('HomeView', [
            'uplinks' => $uplinks,
        ]);
    }
}
