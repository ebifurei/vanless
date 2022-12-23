<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResources extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'email_subscribe' => $this->email_subscribe,
            'created_at' => $this->created_at->timezone('Asia/Jakarta')->toDateTimeString(),
            'updated_at' => $this->updated_at->timezone('Asia/Jakarta')->toDateTimeString(),
        ];
    }
}
