<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StokResource extends JsonResource
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
            'Update' => $this->created_at,
            'A_pos' => $this->a_pos,
            'B_pos' => $this->b_pos,
            'O_pos' => $this->o_pos,
            'AB_pos' => $this->ab_pos,
            'A_neg' => $this->a_neg,
            'B_neg' => $this->b_neg,
            'O_neg' => $this->o_neg,
            'AB_neg' => $this->ab_neg,
        ];
    }
}
