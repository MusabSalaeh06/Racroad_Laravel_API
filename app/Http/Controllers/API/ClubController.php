<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClubDetailResource;
use App\Http\Resources\ClubResource;
use App\Http\Resources\MemClubResource;
use App\Models\Club;
use App\Models\MemberClub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClubController extends Controller
{
    public function club_store(Request $request)
    {
        $customMessage = [
            "user_id.required" => "กรุณาส่งค่า user_id(เจ้าของคลับ) มาด้วยน่ะครับ",
            "club_name.required" => "กรุณาส่งค่า club_name(ชื่อคลับ) มาด้วยน่ะครับ",
            "club_zone.required" => "กรุณาส่งค่า club_zone(โซน) มาด้วยน่ะครับ",
            "description.required" => "กรุณาส่งค่า description(คำอธิบาย) มาด้วยน่ะครับ",
        ];

        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'club_name' => ['required'],
            'club_zone' => ['required'],
            'description' => ['required'],
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
        $post = new Club;
        $post->user_id = $request->input('user_id');
        $post->club_name = $request->input('club_name');
        $post->club_zone = $request->input('club_zone');
        $post->description = $request->input('description');
        $post->status = "รอการอนุมัติ";
        $post->save();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "สร้างคลับใหม่เรียบร้อยเเล้ว",
            ], 200);
    }
    public function club_update(Request $request, $id)
    {
        $customMessage = [
            "club_name.required" => "กรุณาส่งค่า club_name(ชื่อคลับ) มาด้วยน่ะครับ",
            "club_zone.required" => "กรุณาส่งค่า club_zone(โซน) มาด้วยน่ะครับ",
            "description.required" => "กรุณาส่งค่า description(คำอธิบาย) มาด้วยน่ะครับ",
        ];

        $validator = Validator::make($request->all(), [
            'club_name' => ['required'],
            'club_zone' => ['required'],
            'description' => ['required'],
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
        $post = Club::find($id);
        $post->club_name = $request->input('club_name');
        $post->club_zone = $request->input('club_zone');
        $post->description = $request->input('description');
        $post->save();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "อัปเดตข้อมูลคลับเรียบร้อย",
            ], 200);
    }
    public function club_destroy($id)
    {
        Club::find($id)->delete();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "ลบข้อมูลคลับเรียบร้อยเเล้ว",
            ], 200);
    }
    public function club_add_director(Request $request)
    {
        $customMessage = [
            "club_id.required" => "กรุณาส่งค่า club_id(ชื่อคลับ) มาด้วยน่ะครับ",
            "user_id.required" => "กรุณาส่งค่า user_id(ชื่อผู้ใช้) มาด้วยน่ะครับ",
        ];

        $validator = Validator::make($request->all(), [
            'club_id' => ['required'],
            'user_id' => ['required'],
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
        $post = new MemberClub;
        $post->club_id = $request->input('club_id');
        $post->user_id = $request->input('user_id');
        $post->role = "director";
        $post->status = "ดำรงอยู่";
        $post->save();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "เพิ่มกรรมการคลับเรียบร้อยเเล้ว",
            ], 200);
    }
    public function club_all()
    {
        $club_all = Club::get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'club_all' => ClubResource::collection($club_all),
                ],
                'message' => "ข้อมูลคลับทั้งหมด",
            ], 200);
    }
    public function club_wait_approve()
    {
        $club_wait_approve = Club::where('status',"รอการอนุมัติ")->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'club_wait_approve' => ClubResource::collection($club_wait_approve),
                ],
                'message' => "ข้อมูลคลับที่รอการอนุมัติ",
            ], 200);
    }
    public function club_respond(Request $request, $id)
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
        $post = Club::find($id);
        $post->status = $request->input('status');
        $post->sp_admin = $request->input('sp_admin');
        $post->save();
        if ($request->input('status') == "อนุมัติ") {
            return response()->json(
                [
                    'status' => true,
                    'data' => [],
                    'message' => "ระบบได้ทำการอนุมัติคลับเรียบร้อย",
                ], 200);
        } else {
            return response()->json(
                [
                    'status' => true,
                    'data' => [],
                    'message' => "ระบบปฏิเสธการอนุมัติคลับเรียบร้อย",
                ], 200);
        }
    }
    public function club_approve()
    {
        $club_approve = Club::where('status',"อนุมัติ")->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'club_approve' => ClubResource::collection($club_approve),
                ],
                'message' => "ข้อมูลคลับที่ได้รับการอนุมัติ",
            ], 200);
    }
    public function club_approve_detail($id)
    {
        $club_approve_detail = Club::find($id);
        $club_director = MemberClub::where('club_id',$id)->where('role',"director")->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'club_approve_detail' =>  ClubDetailResource::make($club_approve_detail),
                    'club_director' => MemClubResource::collection($club_director),
                ],
                'message' => "รายละเอียดข้อมูลคลับ",
            ], 200);
    }
}
