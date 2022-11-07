<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarDetailResource;
use App\Models\Brand;
use App\Models\CarData;
use App\Models\MakeOver;
use App\Models\SubVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarDataController extends Controller
{
    public function car_store(Request $request)
    {
        $customMessage = [
            "brand.required" => "กรุณาส่งค่า brand(ยี่ห้อ) มาด้วยน่ะครับ",
            "model.required" => "กรุณาส่งค่า model(รุ่น) มาด้วยน่ะครับ",
            "makeover.required" => "กรุณาส่งค่า makeover(โฉม) มาด้วยน่ะครับ",
            "subversion.required" => "กรุณาส่งค่า subversion(รุ่นย่อย) มาด้วยน่ะครับ",
            "fuel.required" => "กรุณาส่งค่า fuel(เชื้อเพลิง) มาด้วยน่ะครับ",
        ];

        $validator = Validator::make($request->all(), [
            'brand' => ['required'],
            'model' => ['required'],
            'makeover' => ['required'],
            'subversion' => ['required'],
            'fuel' => ['required'],
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
        $car = $request->input('brand').$request->input('model').$request->input('makeover').$request->input('subversion').$request->input('fuel');
        $again = CarData::get();
        foreach ( $again as $data) {
            $car_again = $data->brand.$data->model.$data->makeover.$data->subversion.$data->fuel;
            if ($car == $car_again) { 
                return response()->json(
                [
                    'status' => false,
                    'data' => [],
                    'message' => "ข้อมูลที่ป้อนซ้ำ",
                ], 200);
            }
            
        }
        $post = new CarData;
        $post->brand = $request->input('brand');
        $post->model = $request->input('model');
        $post->makeover = $request->input('makeover');
        $post->subversion = $request->input('subversion');
        $post->fuel = $request->input('fuel');
        $post->save();

        return response()->json(
            [
                'status' => true,
                'car' => $car,
                'car_again' => $car_again,
                'message' => "บันทึกข้อมูลรถยนต์เรียบร้อยเเล้ว",
            ], 200);
    }

    public function car_data()
    {
        $car_data = CarData::get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'car_data' => $car_data,
                ],
                'message' => "ข้อมูลรถยนต์ทั้งหมด",
            ], 200);
    }

    public function car_detail($id)
    {
        $car_detail = CarData::find($id);
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'car_detail' => CarDetailResource::make($car_detail),
                ],
                'message' => "รายละเอียดข้อมูลรถยนต์",
            ], 200);
    }

    public function car_update(Request $request, $id)
    {
        $customMessage = [
            "brand.required" => "กรุณาส่งค่า brand(ยี่ห้อ) มาด้วยน่ะครับ",
            "model.required" => "กรุณาส่งค่า model(รุ่น) มาด้วยน่ะครับ",
            "makeover.required" => "กรุณาส่งค่า makeover(โฉม) มาด้วยน่ะครับ",
            "subversion.required" => "กรุณาส่งค่า subversion(รุ่นย่อย) มาด้วยน่ะครับ",
            "fuel.required" => "กรุณาส่งค่า fuel(เชื้อเพลิง) มาด้วยน่ะครับ",
        ];

        $validator = Validator::make($request->all(), [
            'brand' => ['required'],
            'model' => ['required'],
            'makeover' => ['required'],
            'subversion' => ['required'],
            'fuel' => ['required'],
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
        $post = CarData::find($id);
        $post->brand = $request->input('brand');
        $post->model = $request->input('model');
        $post->makeover = $request->input('makeover');
        $post->subversion = $request->input('subversion');
        $post->fuel = $request->input('fuel');
        $post->save();

        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "อัปเดตข้อมูลรถยนต์เรียบร้อยเเล้ว",
            ], 200);
    }

    public function car_destroy($id)
    {
        CarData::find($id)->delete();
        return response()->json(
            [
                'status' => true,
                'data' => [],
                'message' => "ลบข้อมูลรถยนต์เรียบร้อยเเล้ว",
            ], 200);
    }

    // public function brand_store(Request $request)
    // {
    //     $customMessage = [
    //         "brand.required" => "กรุณาส่งค่า brand(ยี่ห้อ) มาด้วยน่ะครับ",
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'brand' => ['required'],
    //     ], $customMessage);

    // if ($validator->fails()) {
    //     $errors = $validator->errors();

    //     return response()->json(
    //         [
    //             'status' => false,
    //             'data' => [],
    //             'message' => $errors->first(),
    //         ], 400
    //     );
    // }
    // $post = new Brand;
    // $post->brand = $request->input('brand');
    // $post->save();

    // return response()->json(
    //     [
    //         'status' => true,
    //         'data' => [],
    //         'message' => "บันทึกข้อมูลยี่ห้อรถยนต์เรียบร้อยเเล้ว",
    //     ], 200);
    // }

    public function brand_data()
    {
        $brand = CarData::select('brand')->distinct()->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'brand' => $brand,
                ],
                'message' => "ข้อมูลยี่ห้อรถยนต์ทั้งหมด",
            ], 200);
    }
    public function model_data()
    {
        $model = CarData::select('model')->distinct()->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'model' => $model,
                ],
                'message' => "ข้อมูลรุ่นรถยนต์ทั้งหมด",
            ], 200);
    }
    public function makeover_data()
    {
        $makeover = CarData::select('makeover')->distinct()->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'makeover' => $makeover,
                ],
                'message' => "ข้อมูลโฉมรถยนต์ทั้งหมด",
            ], 200);
    }
    public function subversion_data()
    {
        $subversion = CarData::select('subversion')->distinct()->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'subversion' => $subversion,
                ],
                'message' => "ข้อมูลรุ่นย่อยรถยนต์ทั้งหมด",
            ], 200);
    }
    public function fuel_data()
    {
        $fuel = CarData::select('fuel')->distinct()->get();
        return response()->json(
            [
                'status' => true,
                'data' => [
                    'fuel' => $fuel,
                ],
                'message' => "ข้อมูลเชื้อเพลิงรถยนต์ทั้งหมด",
            ], 200);
    }

    // public function brand_update(Request $request,$id)
    // {
    //     $customMessage = [
    //         "brand.required" => "กรุณาส่งค่า brand(ยี่ห้อ) มาด้วยน่ะครับ",
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'brand' => ['required'],
    //     ], $customMessage);

    // if ($validator->fails()) {
    //     $errors = $validator->errors();

    //     return response()->json(
    //         [
    //             'status' => false,
    //             'data' => [],
    //             'message' => $errors->first(),
    //         ], 400
    //     );
    // }
    // $post = Brand::find($id);
    // $post->brand = $request->input('brand');
    // $post->save();

    // return response()->json(
    //     [
    //         'status' => true,
    //         'data' => [],
    //         'message' => "อัปเดตข้อมูลยี่ห้อรถยนต์เรียบร้อยเเล้ว",
    //     ], 200);
    // }

    // public function brand_destroy($id)
    // {
    //     Brand::find($id)->delete();
    //     return response()->json(
    //         [
    //             'status' => true,
    //             'data' => [],
    //             'message' => "ลบข้อมูลยี่ห้อรถยนต์เรียบร้อยเเล้ว",
    //         ], 200);
    // }

    // public function model_store(Request $request)
    // {
    //     $customMessage = [
    //         "brand_id.required" => "กรุณาส่งค่า brand_id(ยี่ห้อ) มาด้วยน่ะครับ",
    //         "model.required" => "กรุณาส่งค่า model(รุ่น) มาด้วยน่ะครับ",
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'brand_id' => ['required'],
    //         'model' => ['required'],
    //     ], $customMessage);

    // if ($validator->fails()) {
    //     $errors = $validator->errors();

    //     return response()->json(
    //         [
    //             'status' => false,
    //             'data' => [],
    //             'message' => $errors->first(),
    //         ], 400
    //     );
    // }
    // $post = new CarModel;
    // $post->brand_id = $request->input('brand_id');
    // $post->model = $request->input('model');
    // $post->save();

    // return response()->json(
    //     [
    //         'status' => true,
    //         'data' => [],
    //         'message' => "บันทึกข้อมูลรุ่นรถยนต์เรียบร้อยเเล้ว",
    //     ], 200);
    // }

    // public function model_update(Request $request,$id)
    // {
    //     $customMessage = [
    //         "brand_id.required" => "กรุณาส่งค่า brand_id(ยี่ห้อ) มาด้วยน่ะครับ",
    //         "model.required" => "กรุณาส่งค่า model(รุ่น) มาด้วยน่ะครับ",
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'brand_id' => ['required'],
    //         'model' => ['required'],
    //     ], $customMessage);

    // if ($validator->fails()) {
    //     $errors = $validator->errors();

    //     return response()->json(
    //         [
    //             'status' => false,
    //             'data' => [],
    //             'message' => $errors->first(),
    //         ], 400
    //     );
    // }
    // $post = CarModel::find($id);
    // $post->brand_id = $request->input('brand_id');
    // $post->model = $request->input('model');
    // $post->save();

    // return response()->json(
    //     [
    //         'status' => true,
    //         'data' => [],
    //         'message' => "อัปเดตข้อมูลรุ่นรถยนต์เรียบร้อยเเล้ว",
    //     ], 200);
    // }

    // public function model_destroy($id)
    // {
    //     CarModel::find($id)->delete();
    //     return response()->json(
    //         [
    //             'status' => true,
    //             'data' => [],
    //             'message' => "ลบข้อมูลรุ่นรถยนต์เรียบร้อยเเล้ว",
    //         ], 200);
    // }

    // public function makeover_store(Request $request)
    // {
    //     $customMessage = [
    //         "model_id.required" => "กรุณาส่งค่า model_id(รุ่น) มาด้วยน่ะครับ",
    //         "makeover.required" => "กรุณาส่งค่า makeover(โฉม) มาด้วยน่ะครับ",
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'model_id' => ['required'],
    //         'makeover' => ['required'],
    //     ], $customMessage);

    // if ($validator->fails()) {
    //     $errors = $validator->errors();

    //     return response()->json(
    //         [
    //             'status' => false,
    //             'data' => [],
    //             'message' => $errors->first(),
    //         ], 400
    //     );
    // }
    // $post = new MakeOver;
    // $post->model_id = $request->input('model_id');
    // $post->makeover = $request->input('makeover');
    // $post->save();

    // return response()->json(
    //     [
    //         'status' => true,
    //         'data' => [],
    //         'message' => "บันทึกข้อมูลโฉมรถยนต์เรียบร้อยเเล้ว",
    //     ], 200);
    // }

    // public function makeover_update(Request $request,$id)
    // {
    //     $customMessage = [
    //         "model_id.required" => "กรุณาส่งค่า model_id(รุ่น) มาด้วยน่ะครับ",
    //         "makeover.required" => "กรุณาส่งค่า makeover(โฉม) มาด้วยน่ะครับ",
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'model_id' => ['required'],
    //         'makeover' => ['required'],
    //     ], $customMessage);

    // if ($validator->fails()) {
    //     $errors = $validator->errors();

    //     return response()->json(
    //         [
    //             'status' => false,
    //             'data' => [],
    //             'message' => $errors->first(),
    //         ], 400
    //     );
    // }
    // $post = MakeOver::find($id);
    // $post->model_id = $request->input('model_id');
    // $post->makeover = $request->input('makeover');
    // $post->save();

    // return response()->json(
    //     [
    //         'status' => true,
    //         'data' => [],
    //         'message' => "อัปเดตข้อมูลโฉมรถยนต์เรียบร้อยเเล้ว",
    //     ], 200);
    // }

    // public function makeover_destroy($id)
    // {
    //     MakeOver::find($id)->delete();
    //     return response()->json(
    //         [
    //             'status' => true,
    //             'data' => [],
    //             'message' => "ลบข้อมูลโฉมรถยนต์เรียบร้อยเเล้ว",
    //         ], 200);
    // }

    // public function subversion_store(Request $request)
    // {
    //     $customMessage = [
    //         "makeover_id.required" => "กรุณาส่งค่า makeover_id(โฉม) มาด้วยน่ะครับ",
    //         "subversion.required" => "กรุณาส่งค่า subversion(รุ่นย่อย) มาด้วยน่ะครับ",
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'makeover_id' => ['required'],
    //         'subversion' => ['required'],
    //     ], $customMessage);

    // if ($validator->fails()) {
    //     $errors = $validator->errors();

    //     return response()->json(
    //         [
    //             'status' => false,
    //             'data' => [],
    //             'message' => $errors->first(),
    //         ], 400
    //     );
    // }
    // $post = new SubVersion;
    // $post->makeover_id = $request->input('makeover_id');
    // $post->subversion = $request->input('subversion');
    // $post->save();

    // return response()->json(
    //     [
    //         'status' => true,
    //         'data' => [],
    //         'message' => "บันทึกข้อมูลรุ่นย่อยรถยนต์เรียบร้อยเเล้ว",
    //     ], 200);
    // }

    // public function subversion_update(Request $request,$id)
    // {
    //     $customMessage = [
    //         "makeover_id.required" => "กรุณาส่งค่า makeover_id(โฉม) มาด้วยน่ะครับ",
    //         "subversion.required" => "กรุณาส่งค่า subversion(รุ่นย่อย) มาด้วยน่ะครับ",
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'makeover_id' => ['required'],
    //         'subversion' => ['required'],
    //     ], $customMessage);

    // if ($validator->fails()) {
    //     $errors = $validator->errors();

    //     return response()->json(
    //         [
    //             'status' => false,
    //             'data' => [],
    //             'message' => $errors->first(),
    //         ], 400
    //     );
    // }
    // $post = SubVersion::find($id);
    // $post->makeover_id = $request->input('makeover_id');
    // $post->subversion = $request->input('subversion');
    // $post->save();

    // return response()->json(
    //     [
    //         'status' => true,
    //         'data' => [],
    //         'message' => "อัปเดตข้อมูลรุ่นย่อยรถยนต์เรียบร้อยเเล้ว",
    //     ], 200);
    // }

    // public function subversion_destroy($id)
    // {
    //     SubVersion::find($id)->delete();
    //     return response()->json(
    //         [
    //             'status' => true,
    //             'data' => [],
    //             'message' => "ลบข้อมูลรุ่นย่อยรถยนต์เรียบร้อยเเล้ว",
    //         ], 200);
    // }

    // public function model_data_test($id)
    // {
    //     $model_data_test = CarModel::where('brand_id',$id)->get();
    //     return response()->json(
    //         [
    //             'status' => true,
    //             'data' => [
    //                 'model_data_test' => $model_data_test,
    //             ],
    //             'message' => "ข้อมูลรุ่นรถยนต์",
    //         ], 200);
    // }
    // public function makeover_data_test($id)
    // {
    //     $makeover_data_test = MakeOver::where('model_id',$id)->get();
    //     return response()->json(
    //         [
    //             'status' => true,
    //             'data' => [
    //                 'makeover_data_test' => $makeover_data_test,
    //             ],
    //             'message' => "ข้อมูลโฉมรถยนต์",
    //         ], 200);
    // }
    // public function subversion_data_test($id)
    // {
    //     $subversion_data_test = SubVersion::where('makeover_id',$id)->get();
    //     return response()->json(
    //         [
    //             'status' => true,
    //             'data' => [
    //                 'subversion_data_test' => $subversion_data_test,
    //             ],
    //             'message' => "ข้อมูลรุ่นย่อยรถยนต์",
    //         ], 200);
    // }
}
