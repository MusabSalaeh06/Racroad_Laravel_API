<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->avatar == null) {
            if ($this->sub_district == null || $this->sub_district == 'null') {
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'tel' => $this->tel,
                    'email' => $this->email,
                    'card_id' => $this->card_id,
                    //'password' => $this->show_password,
                    'role' => $this->role,
                    //'profile_image' => asset('/storage/no_image.png'),
                    'avatar' => asset('/storage/user.png'),
                    'address' => "ไม่ระบุที่อยู่",
                    'county' => $this->county,
                    'road' => $this->road,
                    'alley' => $this->alley,
                    'house_number' => $this->house_number,
                    'group_no' => $this->group_no,
                    'sub_district' => $this->sub_district,
                    'district' => $this->district,
                    'province' => $this->province,
                    'ZIP_code' => $this->ZIP_code,
                ];

            } else {
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'tel' => $this->tel,
                    'email' => $this->email,
                    'card_id' => $this->card_id,
                    //'password' => $this->show_password,
                    'role' => $this->role,
                    //'profile_image' => asset('/storage/no_image.png'),
                    'avatar' => asset('/storage/user.png'),
                    'address' => "เขต :" . " " . $this->county . " " . "ถนน :" . " " . $this->road . " " .
                                "ตรอก/ซอย :" . " " . $this->alley . " " . "บ้านเลขที่ :" . " " . $this->house_number . " " .
                                "หมู่ :" . " " . $this->group_no . " " . "ตำบล :" . " " . $this->sub_district . " " .
                                "อำเภอ :" . $this->district . " " . "จังหวัด :" . " " . $this->province . " " .
                                "รหัสไปรษณีย์ :" . " " . $this->ZIP_code,
                    'county' => $this->county,
                    'road' => $this->road,
                    'alley' => $this->alley,
                    'house_number' => $this->house_number,
                    'group_no' => $this->group_no,
                    'sub_district' => $this->sub_district,
                    'district' => $this->district,
                    'province' => $this->province,
                    'ZIP_code' => $this->ZIP_code,
                ];
            }

        } else {
            if ($this->sub_district == null || $this->sub_district == 'null') {
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'tel' => $this->tel,
                    'email' => $this->email,
                    'card_id' => $this->card_id,
                    //'password' => $this->show_password,
                    'role' => $this->role,
                    //'profile_image' => asset('/storage/no_image.png'),
                    'avatar' => asset('/storage/user/user_image_assets/' . $this->avatar),
                    'address' => "ไม่ระบุที่อยู่",
                    'county' => $this->county,
                    'road' => $this->road,
                    'alley' => $this->alley,
                    'house_number' => $this->house_number,
                    'group_no' => $this->group_no,
                    'sub_district' => $this->sub_district,
                    'district' => $this->district,
                    'province' => $this->province,
                    'ZIP_code' => $this->ZIP_code,
                ];

            } else {
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'tel' => $this->tel,
                    'email' => $this->email,
                    'card_id' => $this->card_id,
                    //'password' => $this->show_password,
                    'role' => $this->role,
                    //'profile_image' => asset('/storage/no_image.png'),
                    'avatar' => asset('/storage/user/user_image_assets/' . $this->avatar),
                    'address' => "เขต :" . " " . $this->county . " " . "ถนน :" . " " . $this->road . " " .
                                "ตรอก/ซอย :" . " " . $this->alley . " " . "บ้านเลขที่ :" . " " . $this->house_number . " " .
                                "หมู่ :" . " " . $this->group_no . " " . "ตำบล :" . " " . $this->sub_district . " " .
                                "อำเภอ :" . $this->district . " " . "จังหวัด :" . " " . $this->province . " " .
                                "รหัสไปรษณีย์ :" . " " . $this->ZIP_code,
                    'county' => $this->county,
                    'road' => $this->road,
                    'alley' => $this->alley,
                    'house_number' => $this->house_number,
                    'group_no' => $this->group_no,
                    'sub_district' => $this->sub_district,
                    'district' => $this->district,
                    'province' => $this->province,
                    'ZIP_code' => $this->ZIP_code,
                ];
            }
        }
    }
}
