<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function admin_login(Request $request)
    {
        $customMessage = [
            "tel.required" => "กรุณาส่งค่า tel.(เบอร์โทรศัพท์) มาด้วยน่ะครับ",
            "password.required" => "กรุณาส่งค่า password(รหัสผ่าน) มาด้วยน่ะครับ",
        ];

        $validator = Validator::make($request->all(), [
            'tel' => 'required',
            'password' => 'required',
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
        if (auth()->attempt(['tel' => $request->tel, 'password' => $request->password]
        )) {
            $user = Auth::user();
            $token = $user->createToken('web')->plainTextToken;
            $cookie = cookie('jwt',$token,60*24*365);   
            return response()->json(
                [
                    'status' => true,
                    'data' => [
                        "id" => $user->id,
                        'token'=> $token
                    ],
                    'message' => "เข้าสู่ระบบสำเร็จ",
                ], 200)->withCookie($cookie);
        } else {
            return response()->json(
                [
                    'status' => true,
                    'data' => [],
                    'message' => "กรุณาทำการเข้าสู่ระบบใหม่ เนื่องอีเมลหรือรหัสผ่านไม่ถูกต้อง",
                ], 200);
        }
    }
    public function LoginAndRegister(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if (!$user) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->provider_id = $request->id;
            if ($request->file('avatar')) {
                $file = $request->file('avatar');
                $ldate = date('YmdHis');
                $filename = $request->input('name') . '_' . $ldate . '.' . $file->getClientOriginalExtension();
                $request->avatar->move('storage/user/user_image_assets', $filename);
                $user->avatar = $filename;
            }
            $user->role = "user";
            $user->save();
        }
        Auth::login($user);
        return response()->json(
            [
                'status' => true,
                'data' => [
                    "id" => auth()->user()->id,
                    "name" => auth()->user()->name,
                    "email" => auth()->user()->email,
                ],
                'message' => "เข้าสู่ระบบสำเร็จ",
            ], 200);
    }
    public function RegisterOrLogin_Google(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if (!$user) {
            $user = new User;
            $user->name = $request->displayName;
            $user->email = $request->email;
            $user->avatar = $request->photoUrl;
            $user->role = "user";
            $user->type = "google";
            $user->save();
        }
        //Auth::login($user);
        $tel = User::where('tel', '!=', null)->first(); 
        if (!$tel) {
            if ( $request->tel == null) {
                return response()->json(
                    [
                        'status' => true,
                        'data' => [
                            "email" => $user->email,
                        ],
                        'message' => "กรุณาระบุเบอร์โทรมาเพื่อทำ  otp ด้วยน่ะครับ",
                    ], 200);
            }
            User::where('email',$request->email)->update(array('tel'=>$request->tel,));
        }
        
    }
    public function RegisterOrLogin_Facebook(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if (!$user) {
            $user = new User;
            $user->email = $request->email;
            $user->role = "user";
            $user->type = "fackbook";
            $user->save();
        }
    }
    public function RegisterOrLogin_Tel(Request $request)
    {
        $user = User::where('tel', '=', $request->tel)->first();
        if (!$user) {
            $user = new User;
            $user->tel = $request->tel;
            $user->role = "user";
            $user->type = "tel";
            $user->save();
        }
    }
    public function SaveOTP(Request $request)
    {

    }
    public function ConfirmOTP(Request $request)
    {

    }
}
// public function login(Request $request){
//     $input = $request->all();


//     if(Auth::attempt(array('email'=>$input['email'],'password'=>$input['password']))){
//         $user = Auth::user();
//         $token = $user->createToken('web')->plainTextToken;
//         $cookie = cookie('jwt',$token,60*24*365);

//         if (Auth::user()->type == 'rc') {
//             // return response()->json(['status' => 'success','type'=>'1'], 200);
//             $type = 'rc';
//             $status = 'success';
//         }
//         elseif (Auth::user()->type == 'of') {
//             $type = 'of';
//             $status = 'success';
//         }
//         elseif (Auth::user()->type == 'b'){
//             $type = 'b';
//             $status = 'success';
//         }
//         elseif (Auth::user()->type == 'ch_b'){
//             $type = 'ch_b';
//             $status = 'success';
//         }
//         elseif (Auth::user()->type == 'sctr'){
//             $type = 'sctr';
//             $status = 'success';
//         }elseif (Auth::user()->type == 'vp'){
//             $type = 'vp';
//             $status = 'success';
//         }else{
//             $type = '';
//             $status = 'login_error';
//         }
         
//     }else{
//         $type = '';
//         $status = 'login_error';
//         $token = '';
//     }
//     return response()->json([
//         'type' => $type,
//         'status' => $status,
//         'token'=> $token
//     ])->withCookie($cookie);
    
// }
        
        // $user = Auth::user(); 
        // //$token = $user->createToken('web')->plainTextToken;
        // $cookie = cookie('jwt',$token,60*24*365);   
        // return response()->json([
        //     'id' => $user->id,
        //     'token'=> $token
        // ])->withCookie($cookie);
