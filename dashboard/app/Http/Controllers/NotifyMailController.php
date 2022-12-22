<?php

namespace App\Http\Controllers;

use App\Mail\NotifyMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotifyMailController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required',
            'message' => 'required',
            'device_name' => 'required',
            'link' => 'required',
        ]);

        $subscriber = User::where('email_subscribe', true)->get();

        foreach ($subscriber as $user) {
            Mail::to($user->email)->send(new NotifyMail($data));
        }
    }
}
