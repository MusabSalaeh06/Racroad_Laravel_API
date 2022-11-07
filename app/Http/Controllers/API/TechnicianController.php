<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TechnicianDetailResource;
use App\Http\Resources\TechnicianResource;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TechnicianController extends Controller
{
    public function technician_store(Request $request)
    {
        $customMessage = [
            "user_id.required" => "กรุณาส่งค่า user_id(ชื่อผู้ใช้) มาด้วยน่ะครับ",
            "address.required" => "กรุณาส่งค่า address(ที่อยู่) มาด้วยน่ะครับ",
            "tel1.required" => "กรุณาส่งค่า tel1(เบอร์โทร 1) มาด้วยน่ะครับ",
            "tel2.required" => "กรุณาส่งค่า tel1(เบอร์โทร 2) มาด้วยน่ะครับ",
            "service_zone.required" => "กรุณาส่งค่า service_zone(โซนให้บริการ) มาด้วยน่ะครับ",
            "service_time.required" => "กรุณาส่งค่า service_time(เวลาที่ให้บริการ) มาด้วยน่ะครับ",
            "service_type.required" => "กรุณาส่งค่า service_type(ประเภทงานที่ให้บริการ) มาด้วยน่ะครับ",
            "work_history.required" => "กรุณาส่งค่า work_history(ประวัติการทำงาน) มาด้วยน่ะครับ",
        ];

        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'address' => ['required'],
            'tel1' => ['required'],
            'tel2' => ['required'],
            'service_zone' => ['required'],
            'service_time' => ['required'],
            'service_type' => ['required'],
            'work_history' => ['required'],
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
        $post = new Technician;
        $post->tnc_name = $request->input('tnc_name');
        $post->user_id = $request->input('user_id');
        $post->address = $request->input('address');
        $post->tel1 = $request->input('tel1');
        $post->tel2 = $request->input('tel2');
        $post->std_history = $request->input('std_history');
        $post->service_zone = $request->input('service_zone');
        $post->service_time = $request->input('service_time');
        $post->service_type = $request->input('service_type');
        $post->work_history = $request->input('work_history');
        $post->status = "รอการอนุมัติ";
        $post->save();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "ขอสิทธิ์ในการเป็นช่างเรียบร้อยเเล้ว",
            ], 200);
    }
    public function technician_update(Request $request,$id)
    {
        $customMessage = [
            "address.required" => "กรุณาส่งค่า address(ที่อยู่) มาด้วยน่ะครับ",
            "tel1.required" => "กรุณาส่งค่า tel1(เบอร์โทร 1) มาด้วยน่ะครับ",
            "tel2.required" => "กรุณาส่งค่า tel1(เบอร์โทร 2) มาด้วยน่ะครับ",
            "service_zone.required" => "กรุณาส่งค่า service_zone(โซนให้บริการ) มาด้วยน่ะครับ",
            "service_time.required" => "กรุณาส่งค่า service_time(เวลาที่ให้บริการ) มาด้วยน่ะครับ",
            "service_type.required" => "กรุณาส่งค่า service_type(ประเภทงานที่ให้บริการ) มาด้วยน่ะครับ",
            "work_history.required" => "กรุณาส่งค่า work_history(ประวัติการทำงาน) มาด้วยน่ะครับ",
        ];

        $validator = Validator::make($request->all(), [
            'address' => ['required'],
            'tel1' => ['required'],
            'tel2' => ['required'],
            'service_zone' => ['required'],
            'service_time' => ['required'],
            'service_type' => ['required'],
            'work_history' => ['required'],
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
        $post = Technician::find($id);
        $post->tnc_name = $request->input('tnc_name');
        $post->address = $request->input('address');
        $post->tel1 = $request->input('tel1');
        $post->tel2 = $request->input('tel2');
        $post->std_history = $request->input('std_history');
        $post->service_zone = $request->input('service_zone');
        $post->service_time = $request->input('service_time');
        $post->service_type = $request->input('service_type');
        $post->work_history = $request->input('work_history');
        $post->save();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "อัปเดตข้อมูลเกี่ยวกับช่างเรียบร้อยเเล้ว",
            ], 200);
    }
    public function technician_destroy($id)
    {
        Technician::find($id)->delete();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "ลบข้อมูลช่างเรียบร้อยเเล้ว",
            ], 200);
    }
    public function technician_all()
    {
        $technician_all = Technician::all();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'technician_all' =>  TechnicianResource::collection($technician_all),
                ],
                'message' => "ข้อมูลช่างทั้งหมด",
            ], 200);
    }
    public function technician_wait_approve()
    {
        $technician_wait_approve = Technician::where('status',"รอการอนุมัติ")->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'technician_wait_approve' => TechnicianResource::collection($technician_wait_approve),
                ],
                'message' => "ข้อมูลช่างที่รอการอนุมัติ",
            ], 200);
    }
    public function technician_respond(Request $request, $id)
    {
        $customMessage = [
            "status.required" => "กรุณาส่งค่า status(สถานะ) มาด้วยน่ะครับ",
            "status.in" => "กรุณาส่งค่า status เป็น อนุมัติ,ไม่อนุมัติ",
            "sp_admin.required" => "กรุณาส่งค่า sp_admin(แอดมิน) มาด้วยน่ะครับ",
        ];

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:อนุมัติ,ไม่อนุมัติ',
            'sp_admin' => 'required',
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
        $post = Technician::find($id);
        $post->status = $request->input('status');
        $post->sp_admin = $request->input('sp_admin');
        $post->save();
        if ($request->input('status') == "อนุมัติ") {
            return response()->json(
                [
                    'status' => true,
                    'data' => [],
                    'message' => "ระบบได้ทำการอนุมัติการขอเป็นช่างเรียบร้อย",
                ], 200);
        } else {
            return response()->json(
                [
                    'status' => true,
                    'data' => [],
                    'message' => "ระบบปฏิเสธการอนุมัติการขอเป็นช่างเรียบร้อย",
                ], 200);
        }
    }
    public function technician_approve()
    {
        $technician_approve = Technician::where('status',"อนุมัติ")->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'technician_approve' => TechnicianResource::collection($technician_approve),
                ],
                'message' => "ข้อมูลช่างที่ได้รับการอนุมัติ",
            ], 200);
    }
    public function technician_approve_detail($id)
    {
        $technician_approve_detail = Technician::find($id);
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'technician_approve_detail' => TechnicianDetailResource::make($technician_approve_detail),
                ],
                'message' => "รายละเอียดข้อมูลช่าง",
            ], 200);
    }
}
