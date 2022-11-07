<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MycarDetailResource;
use App\Http\Resources\MycarResource;
use App\Http\Resources\NoMilesResource;
use App\Models\MyCar;
use App\Models\NoMiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MyCarController extends Controller
{
    public function mycar_all($id)
    {
        $mycar_data = MyCar::where('user_id',$id)->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'mycar_data' =>  MycarResource::collection($mycar_data),
                ],
                'message' => "ข้อมูลรถของฉันทั้งหมด",
            ], 200);
    }
    public function mycar_detail($id)
    {
        $mycar_detail = MyCar::find($id);
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'mycar_detail' => MycarDetailResource::make($mycar_detail),
                ],
                'message' => "ข้อมูลรถของฉันแบบละเอียด",
            ], 200);
    }
    public function nomiles_cal($id)
    {
        $nomiles_data = NoMiles::where('mycar_id',$id)->where('status',"ล่าสุด")->first();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'nomiles_data' => NoMilesResource::make($nomiles_data),
                ],
                'message' => "ข้อมูลเลขไมล์ของรถยนต์",
            ], 200);
    }
    
    public function mycar_store(Request $request)
    {
        $customMessage = [
            "user_id.required" => "กรุณาส่งค่า user_id(ชื่อผู้ใช้) มาด้วยน่ะครับ",
            "car_id.required" => "กรุณาส่งค่า car_id(ข้อมูลรถ) มาด้วยน่ะครับ",
            "profile_car.required" => "กรุณาส่งค่า profile_car(รูปรถยนต์) มาด้วยน่ะครับ",
        ];

        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'car_id' => ['required'],
            'profile_car' => ['required'],
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
        $post = new MyCar;
        $post->user_id = $request->input('user_id');
        $post->car_id = $request->input('car_id');
        if ($request->file('profile_car')) {
            $file = $request->file('profile_car');
            $ldate = date('YmdHis');
            $filename = $request->input('car_id') . '_' . $ldate . '.' . $file->getClientOriginalExtension();
            $request->profile_car->move('storage/car/car_image_assets', $filename);
            $post->profile_car = $filename;
        }
        $post->save();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "บันทึกข้อมูลรถของท่านเรียบร้อยเเล้ว",
            ], 200);
    }
    public function mycar_update(Request $request,$id)
    {
        $customMessage = [
            "user_id.required" => "กรุณาส่งค่า user_id(ชื่อผู้ใช้) มาด้วยน่ะครับ",
            "car_id.required" => "กรุณาส่งค่า car_id(ข้อมูลรถ) มาด้วยน่ะครับ",
            "profie_car.required" => "กรุณาส่งค่า profie_car(รูปรถยนต์) มาด้วยน่ะครับ",
        ];

        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'car_id' => ['required'],
            'profie_car' => ['required'],
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
        $post = MyCar::find($id);
        $post->user_id = $request->input('user_id');
        $post->car_id = $request->input('car_id');
        if ($request->file('profile_car')) {
            $file = $request->file('profile_car');
            $ldate = date('YmdHis');
            $filename = $request->input('car_id') . '_' . $ldate . '.' . $file->getClientOriginalExtension();
            $request->profile_car->move('storage/car/car_image_assets', $filename);
            $post->profile_car = $filename;
        }
        $post->save();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "อัปเดทข้อมูลรถของท่านเรียบร้อยเเล้ว",
            ], 200);
    }
    public function mycar_destroy($id)
    {
        MyCar::find($id)->delete();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "ลบข้อมูลรถยนต์เรียบร้อยเเล้ว",
            ], 200);
    }
    public function nomiles_store(Request $request)
    {
        $customMessage = [
            "mycar_id.required" => "กรุณาส่งค่า mycar_id(ข้อมูลรถ) มาด้วยน่ะครับ",
            "no_miles.required" => "กรุณาส่งค่า no_miles(เลขไมล์) มาด้วยน่ะครับ",
        ];

        $validator = Validator::make($request->all(), [
            'mycar_id' => ['required'],
            'no_miles' => ['required'],
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
        $last = NoMiles::where('status',"ล่าสุด")->where('mycar_id',$request->input('mycar_id'))->get()->count();
        if ($last == 0) {
        $post = new NoMiles;
        $post->mycar_id = $request->input('mycar_id');
        $post->no_miles = $request->input('no_miles');
        $post->status = "ล่าสุด";
        $post->save();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "บันทึกข้อมูลเลขไมล์รถของท่านเรียบร้อยเเล้ว",
            ], 200);
        }else { 
            NoMiles::where('status',"ล่าสุด")->where('mycar_id',$request->input('mycar_id'))->update(array('status'=>"",));
            $post = new NoMiles;
            $post->mycar_id = $request->input('mycar_id');
            $post->no_miles = $request->input('no_miles');
            $post->status = "ล่าสุด";
            $post->save();
            return response()->json(
                [
                    'status' => true,
                    'data' => [],
                    'message' => "บันทึกข้อมูลเลขไมล์รถของท่านเรียบร้อยเเล้ว",
                ], 200);
        }
    }
    // public function nomiles_update(Request $request,$id)
    // {
    //     $customMessage = [
    //         "mycar_id.required" => "กรุณาส่งค่า mycar_id(ข้อมูลรถ) มาด้วยน่ะครับ",
    //         "no_miles.required" => "กรุณาส่งค่า no_miles(เลขไมล์) มาด้วยน่ะครับ",
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'mycar_id' => ['required'],
    //         'no_miles' => ['required'],
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
    //     $post = NoMiles::find($id);
    //     $post->mycar_id = $request->input('mycar_id');
    //     $post->no_miles = $request->input('no_miles');
    //     $post->save();
    //     return response()->json(
    //         [
    //             'status' => true,
    //             'data' => [],
    //             'message' => "อัปเดทข้อมูลเลขไมล์รถของท่านเรียบร้อยเเล้ว",
    //         ], 200);
    // }
    // public function nomiles_destroy($id)
    // {
    //     NoMiles::find($id)->delete();
    //     return response()->json(
    //         [
    //             'status' => true,
    //             'data' => [],
    //             'message' => "ลบข้อมูลเลขไมล์ของรถเรียบร้อยเเล้ว",
    //         ], 200);
    // }
}
