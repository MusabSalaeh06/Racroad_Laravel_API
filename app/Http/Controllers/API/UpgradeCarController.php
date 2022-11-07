<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UpgradeCarResource;
use App\Models\UpgradeCar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpgradeCarController extends Controller
{
    public function upgc_cal($id)
    {
        $brake_cal = UpgradeCar::where('mycar_id',$id)->where('type',"brake")->where('status',"ล่าสุด")->get();
        $battery_cal = UpgradeCar::where('mycar_id',$id)->where('type',"battery")->where('status',"ล่าสุด")->get();
        $air = UpgradeCar::where('mycar_id',$id)->where('type',"air")->where('status',"ล่าสุด")->get();
        $engine_oil = UpgradeCar::where('mycar_id',$id)->where('type',"engine_oil")->where('status',"ล่าสุด")->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'brake_cal' => UpgradeCarResource::collection($brake_cal),
                    'battery_cal' => UpgradeCarResource::collection($battery_cal),
                    'air' => UpgradeCarResource::collection($air),
                    'engine_oil' => UpgradeCarResource::collection($engine_oil),
                ],
                'message' => "ข้อมูลอะไหล่ของรถยนต์ที่ฉันขับ",
            ], 200);
    }
    public function upgc_store(Request $request)
    {
        $customMessage = [
            "mycar_id.required" => "กรุณาส่งค่า mycar_id(ข้อมูลรถ) มาด้วยน่ะครับ",
            "type.required" => "กรุณาส่งค่า type(รายการที่อัปเกรด) มาด้วยน่ะครับ",
            "type.in" => "กรุณาส่งค่า type เป็น brake,battery,air,engine_oil",
            "date.required" => "กรุณาส่งค่า date(วันที่) มาด้วยน่ะครับ",
        ];

        $validator = Validator::make($request->all(), [
            'mycar_id' => 'required',
            'type' => 'required|in:brake,battery,air,engine_oil',
            'date' => 'required',
        ], $customMessage);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json(
                [
                    'status' => false,
                    'data' => [],
                    'message' => $errors->first(),
                ], 400
            );
        }
        $count = UpgradeCar::where('type',$request->input('type'))->where('status',"ล่าสุด")->get()->count();
        if ($count == 0) {
            $post = new UpgradeCar;
            $post->mycar_id = $request->input('mycar_id');
            $post->type = $request->input('type');
            $post->date = $request->input('date');
            $post->status = "ล่าสุด";
            $post->save();
            return response()->json(
                [
                    'status' => true,
                    'data' => [],
                    'message' => "บันทึกข้อมูลการอัปเกรดรถเรียบร้อยเเล้ว",
                ], 200);
        } else { 
            UpgradeCar::where('type',$request->input('type'))->where('status',"ล่าสุด")->update(array('status'=>"",));
            $post = new UpgradeCar;
            $post->mycar_id = $request->input('mycar_id');
            $post->type = $request->input('type');
            $post->date = $request->input('date');
            $post->status = "ล่าสุด";
            $post->save();
            return response()->json(
                [
                    'status' => true,
                    'data' => [],
                    'message' => "บันทึกข้อมูลการอัปเกรดรถเรียบร้อยเเล้ว",
                ], 200);
        }
    }
    // public function upgc_update(Request $request, $id)
    // {
    //     $customMessage = [
    //         "mycar_id.required" => "กรุณาส่งค่า mycar_id(ข้อมูลรถ) มาด้วยน่ะครับ",
    //         "type.required" => "กรุณาส่งค่า type(รายการที่อัปเกรด) มาด้วยน่ะครับ",
    //         "date.required" => "กรุณาส่งค่า date(วันที่) มาด้วยน่ะครับ",
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'mycar_id' => ['required'],
    //         'type' => ['required'],
    //         'date' => ['required'],
    //     ], $customMessage);

    //     if ($validator->fails()) {
    //         $errors = $validator->errors();

    //         return response()->json(
    //             [
    //                 'status' => false,
    //                 'data' => [],
    //                 'message' => $errors->first(),
    //             ], 400
    //         );
    //     }
    //     $post = UpgradeCar::find($id);
    //     $post->mycar_id = $request->input('mycar_id');
    //     $post->type = $request->input('type');
    //     $post->date = $request->input('date');
    //     $post->save();
    //     return response()->json(
    //         [
    //             'status' => true,
    //             'data' => [],
    //             'message' => "อัปเดทข้อมูลการอัปเกรดรถเรียบร้อยเเล้ว",
    //         ], 200);
    // }
    // public function upgc_destroy($id)
    // {
    //     UpgradeCar::find($id)->delete();
    //     return response()->json(
    //         [
    //             'status' => true,
    //             'data' => [],
    //             'message' => "ลบข้อมูลการอัปเกรดรถยนต์เรียบร้อยเเล้ว",
    //         ], 200);
    // }
}
