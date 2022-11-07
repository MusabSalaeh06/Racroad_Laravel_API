<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MyProfileResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getUser()
    {   
        $user = Auth::user(); 
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'message' => "ข้อมูลผู้ใช้",
            ], 200);
        // $user = Auth()->user();   
        // return response()->json($user);
    }
    public function my_profile($id)
    {
        $my_profile = User::find($id);
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'my_profile' => MyProfileResource::make($my_profile),
                ],
                'message' => "ข้อมูลโปรไฟล์ของฉัน",
            ], 200);
    }
    public function admin_store(Request $request)
    {
        $customMessage = [
            "name.required" => "กรุณาส่งค่า name(ชื่อ) มาด้วยน่ะครับ",
            "card_id.required" => "กรุณาส่งค่า card_id(บัจรประจำตัวประชาชน) มาด้วยน่ะครับ",
            "card_id.max" => "เลขบัตรประจำตัวประชาชนมากกว่า 13 หลัก",
            "card_id.min" => "เลขบัตรประจำตัวประชาชนน้อยกว่า 13 หลัก",
            "tel.required" => "กรุณาส่งค่า tel(เบอร์โทรศัพท์) มาด้วยน่ะครับ",
            "tel.max" => "เบอร์โทรศัพท์มากกว่า 10 หลัก",
            "tel.min" => "เบอร์โทรศัพท์น้อยกว่า 10 หลัก",
            "tel.unique" => "กรุณาส่งค่า tel(เบอร์โทรศัพท์)ใหม่ เนื่องจากมีผู้ใช้เบอร์โทรศัพท์นี้เเล้ว",
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'card_id' => 'required|max:13|min:13',
            'tel' => 'required|unique:users|max:10|min:10',
        ], $customMessage);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json(
                [
                    'status' => false,
                    'data' => [],
                    'error' => $errors->first(),
                ], 400
            );
        }

        $post = new User;
        $post->name = $request->input('name');
        $post->card_id = $request->input('card_id');
        $post->tel = $request->input('tel');
        $post->email = $request->input('email');
        $post->password = Hash::make($request->input('card_id'));
        $post->show_password = $request->input('card_id');
        $post->county = $request->input('county');
        $post->road = $request->input('road');
        $post->alley = $request->input('alley');
        $post->house_number = $request->input('house_number');
        $post->group_no = $request->input('group_no');
        $post->sub_district = $request->input('sub_district');
        $post->district = $request->input('district');
        $post->province = $request->input('province');
        $post->ZIP_code = $request->input('ZIP_code');
        $post->role = "admin";
        $post->save();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "เพิ่มเจ้าหน้าที่ใหม่สำเร็จ",
            ], 200
        );
    }
    public function admin_data()
    {
        $admin_data = User::where('role',"admin")->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'admin_data' => UserResource::collection($admin_data),
                ],
                'message' => "ข้อมูลเจ้าหน้าที่หลังบ้านทั้งหมด",
            ], 200);
    }
    public function user_store(Request $request)
    {
        $customMessage = [
            "name.required" => "กรุณาส่งค่า name(ชื่อ) มาด้วยน่ะครับ",
            "card_id.required" => "กรุณาส่งค่า card_id(บัจรประจำตัวประชาชน) มาด้วยน่ะครับ",
            "card_id.max" => "เลขบัตรประจำตัวประชาชนมากกว่า 13 หลัก",
            "card_id.min" => "เลขบัตรประจำตัวประชาชนน้อยกว่า 13 หลัก",
            "tel.required" => "กรุณาส่งค่า tel(เบอร์โทรศัพท์) มาด้วยน่ะครับ",
            "tel.max" => "เบอร์โทรศัพท์มากกว่า 10 หลัก",
            "tel.min" => "เบอร์โทรศัพท์น้อยกว่า 10 หลัก",
            "tel.unique" => "กรุณาส่งค่า tel(เบอร์โทรศัพท์)ใหม่ เนื่องจากมีผู้ใช้เบอร์โทรศัพท์นี้เเล้ว",
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'card_id' => 'required|max:13|min:13',
            'tel' => 'required|unique:users|max:10|min:10',
        ], $customMessage);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json(
                [
                    'status' => false,
                    'data' => [],
                    'error' => $errors->first(),
                ], 400
            );
        }

        $post = new User;
        $post->name = $request->input('name');
        $post->card_id = $request->input('card_id');
        $post->tel = $request->input('tel');
        $post->email = $request->input('email');
        $post->password = Hash::make($request->input('card_id'));
        $post->show_password = $request->input('card_id');
        $post->county = $request->input('county');
        $post->road = $request->input('road');
        $post->alley = $request->input('alley');
        $post->house_number = $request->input('house_number');
        $post->group_no = $request->input('group_no');
        $post->sub_district = $request->input('sub_district');
        $post->district = $request->input('district');
        $post->province = $request->input('province');
        $post->ZIP_code = $request->input('ZIP_code');
        $post->role = "user";
        $post->save();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "เพิ่มผู้ใช้ใหม่สำเร็จ",
            ], 200
        );
    }
    public function user_data()
    {
        $user_data = User::where('role','!=',"admin")->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'user_data' => UserResource::collection($user_data),
                ],
                'message' => "ข้อมูลผู้ใช้ทั้งหมด",
            ], 200);
    }
    public function user_update(Request $request,$id)
    {
        $user = User::find($id);
        if ($user->tel == $request->input('tel')) {
            $user->tel = '';
            $user->save();
        }
        $customMessage = [
            "name.required" => "กรุณาส่งค่า name(ชื่อ) มาด้วยน่ะครับ",
            "card_id.required" => "กรุณาส่งค่า card_id(บัจรประจำตัวประชาชน) มาด้วยน่ะครับ",
            "card_id.max" => "เลขบัตรประจำตัวประชาชนมากกว่า 13 หลัก",
            "card_id.min" => "เลขบัตรประจำตัวประชาชนน้อยกว่า 13 หลัก",
            "tel.required" => "กรุณาส่งค่า tel(เบอร์โทรศัพท์) มาด้วยน่ะครับ",
            "tel.max" => "เบอร์โทรศัพท์มากกว่า 10 หลัก",
            "tel.min" => "เบอร์โทรศัพท์น้อยกว่า 10 หลัก",
            "tel.unique" => "กรุณาส่งค่า tel(เบอร์โทรศัพท์)ใหม่ เนื่องจากมีผู้ใช้เบอร์โทรศัพท์นี้เเล้ว",
            // "password.required" => "กรุณาป้อนรหัสผ่านเก่าด้วยน่ะครับ",
            // "new_password.required" => "กรุณาป้อนรหัสผ่านใหม่ด้วยน่ะครับ",
            // "new_password.same" => "การยืนยันรหัสผ่านไม่ถูกต้อง",
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'card_id' => 'required|max:13|min:13',
            'tel' => 'required|unique:users|max:10|min:10',
            // 'password' => 'required',
            // 'new_password' => 'required|same:password_confirmation',
        ], $customMessage);

        if ($validator->fails()) {
            $user = User::find($id);
            if ($user->tel == '') {
                $user->tel = $request->input('tel');
                $user->save();
            }
            $errors = $validator->errors();

            return response()->json(
                [
                    'status' => false,
                    'data' => [],
                    'error' => $errors->first(),
                ], 400
            );
        }

        $post = User::find($id);
        $post->name = $request->input('name');
        $post->tel = $request->input('tel');
        $post->email = $request->input('email');
        $post->card_id = $request->input('card_id');
        // $post->password = Hash::make($request->input('new_password'));
        // $post->show_password = $request->input('new_password');
        if ($request->file('avatar')) {
            $file = $request->file('avatar');
            $ldate = date('YmdHis');
            $filename = $request->input('name') . '_' . $ldate . '.' . $file->getClientOriginalExtension();
            $request->avatar->move('storage/user/user_image_assets', $filename);
            $post->avatar = $filename;
        }
        $post->county = $request->input('county');
        $post->road = $request->input('road');
        $post->alley = $request->input('alley');
        $post->house_number = $request->input('house_number');
        $post->group_no = $request->input('group_no');
        $post->sub_district = $request->input('sub_district');
        $post->district = $request->input('district');
        $post->province = $request->input('province');
        $post->ZIP_code = $request->input('ZIP_code');
        $post->save();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "อัปเดตข้อมูลเจ้าหน้าที่สำเร็จ",
            ], 200
        );
    }
    public function user_destroy($id)
    {
        User::find($id)->delete();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "ลบข้อมูลผู้ใช้เรียบร้อยเเล้ว",
            ], 200);
    }
}
