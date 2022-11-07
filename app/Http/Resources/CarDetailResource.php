<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarDetailResource extends JsonResource
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
            'id' => $this->car_id,
            'brand' => $this->brand,
            'model' => $this->model,
            'makeover' => $this->makeover,
            'subversion' => $this->subversion,
            'fuel' => $this->fuel,
        ];
    }
}
