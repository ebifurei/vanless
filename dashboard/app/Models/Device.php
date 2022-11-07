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

    public function uplinks()
    {
        return $this->hasMany(Uplink::class, 'device_id', 'device_id');
    }
}
