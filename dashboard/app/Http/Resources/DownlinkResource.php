<?php

namespace App\Http\Resources;

use App\Models\Device;
use Illuminate\Http\Resources\Json\JsonResource;

class DownlinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $timezone = Device::where('device_id', $this->device_id)->firstOrFail()->timezone;
        return [
            'id' => $this->id,
            'device_id' => $this->device_id,
            'command' => $this->command,
            'status' => $this->status,
            'payload' => $this->payload,
            'port' => $this->port,
            'created_at' => $this->created_at->timezone($timezone)->toDateTimeString(),
            'updated_at' => $this->created_at->timezone($timezone)->toDateTimeString(),
        ];
    }
}
