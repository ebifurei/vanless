<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $casts = [
        'latest_payload' => 'array',
    ];
    protected $dates = [
        'latest_payload_at',
    ];

    public function uplinks()
    {
        return $this->hasMany(Uplink::class, 'device_id', 'device_id');
    }

    public function downlinks()
    {
        return $this->hasMany(Downlink::class, 'device_id', 'device_id');
    }

    public function uplinkCounterDaily()
    {
        return $this->hasOne(UplinkCounterDaily::class, 'device_id', 'device_id');
    }
}
