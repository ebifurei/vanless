<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{


    public function index()
    {
        return view('devices.index');
    }
}
