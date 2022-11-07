<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NoMilesResource extends JsonResource
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
            // 'owner_name' => $this->mycar_data->user_data->name,
            // 'car_brand' => $this->mycar_data->car_data->brand,
            // 'car_model' => $this->mycar_data->car_data->model,
            // 'car_makeover' => $this->mycar_data->car_data->makeover,
            // 'car_subversion' => $this->mycar_data->car_data->subversion,
            // 'car_fuel' => $this->mycar_data->car_data->fuel,
            'no_miles' => $this->no_miles,
        ];
    }
}
