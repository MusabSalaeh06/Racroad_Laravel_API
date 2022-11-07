<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClubDetailResource extends JsonResource
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
            'id' => $this->club_id,
            'club_name' => $this->club_name,
            'club_zone' => $this->club_zone,
            'description' => $this->description,
            'admin' => $this->admin->name,
        ];
    }
}
