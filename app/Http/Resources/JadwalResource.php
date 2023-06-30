<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JadwalResource extends JsonResource
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
            'Instansi' => $this->instansi,
            'Waktu' => date('d F Y', strtotime($this->waktu)),
            'Target' => $this->target.' Kantong',
            'Alamat' => $this->alamat,
        ];
    }
}
