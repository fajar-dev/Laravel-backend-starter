<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'Name' => $this->name,
            'Email' => $this->email,
            'Photo' => $this->photo,
            'Created_at' => $this->created_at,
            'Updated_at' => $this->updated_at,
        ];
    }
}
