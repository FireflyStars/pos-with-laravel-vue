<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CampagnesListResource extends JsonResource
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
            'id'              => $this->id,
            'name'            => $this->name,
            'username'        => $this->user->name,  
            'datelancement'   => Carbon::parse($this->datelancement)->format('Y-m-d'),
            'created_at'      => Carbon::parse($this->created_at)->format('Y-m-d'),
            'type'            => $this->type,
            'status'          => $this->status,
            'nb'              => $this->nb,
            'montant'         => $this->montant,
        ];
    }
}
