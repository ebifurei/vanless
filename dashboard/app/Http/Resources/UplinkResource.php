<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UplinkResource extends JsonResource
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
            'date' => $this->date,
            'port' => $this->port,
            'payloads' => $this->payloads,
            'created_at' => $this->created_at->timezone('Asia/Jakarta')->toTimeString(),
        ];
    }
}
