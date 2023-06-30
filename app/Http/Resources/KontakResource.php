<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KontakResource extends JsonResource
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
            'ID' => $this->id,
            'UDD' => $this->nama,
            'Provinsi' => $this->provinsi,
            'Telp' => $this->telp,
            'Alamat' => $this->alamat,
        ];
    }
}
