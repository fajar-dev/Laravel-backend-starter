<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestsResource extends JsonResource
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
            'id' => $this->id_requests,
            'Slug' => $this->requests_slug,
            'Pasien' => $this->requests_pasien,
            'GolonganDarah' => $this->requests_goldar,
            'JenisDonor' => $this->requests_jenis,
            'BDRS' => $this->bdrs_nama,
            'Kota' => $this->bdrs_kota,
            'Created' => date('d F Y', strtotime($this->requests_waktu))
        ];
    }
}
