<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uplink extends Model
{
    use HasFactory;

    protected $guarded = ['_id'];
    protected $casts = [
        'payloads' => 'array',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'device_id');
    }

    public function latestPayload()
    {
        $payload = collect($this->payloads)->last();

        return collect($payload)->except(['batt', 'rssi', 'counter', 'frequency', 'charge'])->toArray();
    }
}
