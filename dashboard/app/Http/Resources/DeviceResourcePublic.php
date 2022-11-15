<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResourcePublic extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'device_id' => $this->device_id,
            'name' => $this->name,
            'description' => $this->description,
            'timezone' => $this->timezone,
            'status' => $this->status,
            'last_payload' => $this->latest_payload,
            'last_payload_at' => $this->latest_payload_at,
            'latitude' => $this->latitude ?? -7.765955,
            'longitude' => $this->longitude ?? 110.371561,
        ];
    }
}
