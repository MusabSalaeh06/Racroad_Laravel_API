<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TechnicianDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->std_history == null && $this->tnc_name == null) {
            return [
                'tnc_name' => 'ไม่ระบุ',
                'name' => $this->user_data->name,
                'tel1' => $this->tel1,
                'tel2' => $this->tel2,
                'address' => $this->address,
                'std_history' => 'ไม่ระบุ',
                'service_zone' => $this->service_zone,
                'service_time' => $this->service_time,
                'service_type' => $this->service_type,
                'work_history' => $this->work_history,
            ];
        }
        if ($this->tnc_name == null) {
            return [
                'tnc_name' => 'ไม่ระบุ',
                'name' => $this->user_data->name,
                'tel1' => $this->tel1,
                'tel2' => $this->tel2,
                'address' => $this->address,
                'std_history' => $this->std_history,
                'service_zone' => $this->service_zone,
                'service_time' => $this->service_time,
                'service_type' => $this->service_type,
                'work_history' => $this->work_history,
            ];
        }
        if ($this->std_history == null) {
            return [
                'tnc_name' => $this->tnc_name,
                'name' => $this->user_data->name,
                'tel1' => $this->tel1,
                'tel2' => $this->tel2,
                'address' => $this->address,
                'std_history' => 'ไม่ระบุ',
                'service_zone' => $this->service_zone,
                'service_time' => $this->service_time,
                'service_type' => $this->service_type,
                'work_history' => $this->work_history,
            ];
        }
        return [
            'tnc_name' => $this->tnc_name,
            'name' => $this->user_data->name,
            'tel1' => $this->tel1,
            'tel2' => $this->tel2,
            'address' => $this->address,
            'std_history' => $this->std_history,
            'service_zone' => $this->service_zone,
            'service_time' => $this->service_time,
            'service_type' => $this->service_type,
            'work_history' => $this->work_history,
        ];
    }
}
