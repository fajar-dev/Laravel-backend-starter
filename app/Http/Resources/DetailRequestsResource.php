<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailRequestsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $numeroTelefone = $this->requests_hp;
        if (substr($numeroTelefone, 0, 1) === "0") {
            $numeroTelefone = "62" . substr($numeroTelefone, 1);
        }
        if($this->requests_status == 1){
            $status = 'Show';
        }else{
            $status = 'Pending';
        }
        return[
            'id' => $this->id_requests,
            'Status' => $status,
            'Pasien' => $this->requests_pasien,
            'GolonganDarah' => $this->requests_goldar,
            'JenisDonor' => $this->requests_jenis,
            'Kebutuhan' => $this->requests_jumlah,
            'ContactPerson' => $this->requests_hp.'('.$this->requests_nama.')',
            'WALink' => 'https://wa.me/'.$numeroTelefone,
            'Catatan' => $this->requests_catatan,
            'BDRS' => $this->bdrs_nama,
            'Kota' => $this->bdrs_kota,
            'Lat' => $this->bdrs_lat,
            'Lng' => $this->bdrs_lng,
            'Maps' => 'https://www.google.com/maps/search/?api=1&query='.$this->bdrs_lat.','.$this->bdrs_lng,
            'Link' => 'https://bloodconnect.social/link/'.$this->requests_slug,
            'User' => $this->name,
            'UserPhoto' => $this->photo,
            'Created' => date('d F Y', strtotime($this->requests_waktu))
        ];
    }
}
