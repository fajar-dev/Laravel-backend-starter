<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BdrsResource extends JsonResource
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
            'id' => $this->id_bdrs,
            'BDRS' => $this->bdrs_nama,
            'Kota' => $this->bdrs_kota,
            'Alamat' => $this->bdrs_alamat,
            'Kontak' => $this->bdrs_kontak,
            'Lat' => $this->bdrs_lat,
            'Lng' => $this->bdrs_lng,
        ];
    }
}
