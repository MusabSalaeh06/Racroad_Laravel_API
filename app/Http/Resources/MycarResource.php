<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MycarResource extends JsonResource
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
            'mycar_id' => $this->mycar_id,
            'car_brand' => $this->car_data->brand,
            'car_model' => $this->car_data->model,
            'car_makeover' => $this->car_data->makeover,
            'car_subversion' => $this->car_data->subversion,
            'car_fuel' => $this->car_data->fuel,
            'owner_name' => $this->user_data->name,
        ];
    }
}
