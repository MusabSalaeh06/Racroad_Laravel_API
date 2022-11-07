<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/getUser',[App\Http\Controllers\API\UserController::class,'getUser']);
});


Route::post('/login', [App\Http\Controllers\API\Auth\LoginController::class, 'LoginAndRegister'])->name('LoginAndRegister');

//admin
Route::post('/admin/login', [App\Http\Controllers\API\Auth\LoginController::class, 'admin_login'])->name('admin.login');
Route::post('/admin/store', [App\Http\Controllers\API\UserController::class, 'admin_store'])->name('admin.store');
Route::get('/admin/data', [App\Http\Controllers\API\UserController::class, 'admin_data'])->name('admin.data');

//all user
Route::post('/user/store', [App\Http\Controllers\API\UserController::class, 'user_store'])->name('user.store');
Route::get('/user/data', [App\Http\Controllers\API\UserController::class, 'user_data'])->name('user.data');
Route::post('/user/update/{id}', [App\Http\Controllers\API\UserController::class, 'user_update'])->name('user.update');
Route::delete('/user/destroy/{id}', [App\Http\Controllers\API\UserController::class, 'user_destroy'])->name('user.destroy');
Route::get('/my/profile/{id}', [App\Http\Controllers\API\UserController::class, 'my_profile'])->name('my.profile');

//car data
Route::post('/car/store', [App\Http\Controllers\API\CarDataController::class, 'car_store'])->name('car.store');
Route::get('/car/data', [App\Http\Controllers\API\CarDataController::class, 'car_data'])->name('car.data');
Route::get('/car/detail/{id}', [App\Http\Controllers\API\CarDataController::class, 'car_detail'])->name('car.detail');
Route::post('/car/update/{id}', [App\Http\Controllers\API\CarDataController::class, 'car_update'])->name('car.update');
Route::delete('/car/destroy/{id}', [App\Http\Controllers\API\CarDataController::class, 'car_destroy'])->name('car.destroy');
Route::get('/brand/data', [App\Http\Controllers\API\CarDataController::class, 'brand_data'])->name('brand.data');
Route::get('/model/data', [App\Http\Controllers\API\CarDataController::class, 'model_data'])->name('model.data');
Route::get('/makeover/data', [App\Http\Controllers\API\CarDataController::class, 'makeover_data'])->name('makeover.data');
Route::get('/subversion/data', [App\Http\Controllers\API\CarDataController::class, 'subversion_data'])->name('subversion.data');
Route::get('/fuel/data', [App\Http\Controllers\API\CarDataController::class, 'fuel_data'])->name('fuel.data');

//club
Route::post('/club/store', [App\Http\Controllers\API\ClubController::class, 'club_store'])->name('club.store');
Route::post('/club/update/{id}', [App\Http\Controllers\API\ClubController::class, 'club_update'])->name('club.update');
Route::delete('/club/destroy/{id}', [App\Http\Controllers\API\ClubController::class, 'club_destroy'])->name('club.destroy');
Route::post('club/add/director', [App\Http\Controllers\API\ClubController::class, 'club_add_director'])->name('club.add.director');
Route::get('/club/all', [App\Http\Controllers\API\ClubController::class, 'club_all'])->name('club.all');
Route::get('/club/wait/approve', [App\Http\Controllers\API\ClubController::class, 'club_wait_approve'])->name('club.wait.approve');
Route::post('/club/respond/{id}', [App\Http\Controllers\API\ClubController::class, 'club_respond'])->name('club.respond');
Route::get('/club/approve', [App\Http\Controllers\API\ClubController::class, 'club_approve'])->name('club.approve');
Route::get('/club/approve/detail/{id}', [App\Http\Controllers\API\ClubController::class, 'club_approve_detail'])->name('club.approve.detail');

//technician
Route::post('/technician/store', [App\Http\Controllers\API\TechnicianController::class, 'technician_store'])->name('technician.store');
Route::post('/technician/update/{id}', [App\Http\Controllers\API\TechnicianController::class, 'technician_update'])->name('technician.update');
Route::delete('/technician/destroy/{id}', [App\Http\Controllers\API\TechnicianController::class, 'technician_destroy'])->name('technician.destroy');
Route::get('/technician/all', [App\Http\Controllers\API\TechnicianController::class, 'technician_all'])->name('technician.all');
Route::get('/technician/wait/approve', [App\Http\Controllers\API\TechnicianController::class, 'technician_wait_approve'])->name('technician.wait.approve');
Route::post('/technician/respond/{id}', [App\Http\Controllers\API\TechnicianController::class, 'technician_respond'])->name('technician.respond');
Route::get('/technician/approve', [App\Http\Controllers\API\TechnicianController::class, 'technician_approve'])->name('technician.approve');
Route::get('/technician/approve/detail/{id}', [App\Http\Controllers\API\TechnicianController::class, 'technician_approve_detail'])->name('technician.approve.detail');

//mycar
Route::post('/mycar/store', [App\Http\Controllers\API\MyCarController::class, 'mycar_store'])->name('mycar.store');
Route::post('/mycar/update/{id}', [App\Http\Controllers\API\MyCarController::class, 'mycar_update'])->name('mycar.update');
Route::delete('/mycar/destroy/{id}', [App\Http\Controllers\API\MyCarController::class, 'mycar_destroy'])->name('mycar.destroy');
Route::get('/mycar/all/{id}', [App\Http\Controllers\API\MyCarController::class, 'mycar_all'])->name('mycar.all');
Route::get('/mycar/detail/{id}', [App\Http\Controllers\API\MyCarController::class, 'mycar_detail'])->name('mycar.detail');

//nomiles
Route::post('/nomiles/store', [App\Http\Controllers\API\MyCarController::class, 'nomiles_store'])->name('nomiles.store');
Route::get('/nomiles/cal/{id}', [App\Http\Controllers\API\MyCarController::class, 'nomiles_cal'])->name('nomiles.cal');

//upgrade-car
Route::post('/upgc/store', [App\Http\Controllers\API\UpgradeCarController::class, 'upgc_store'])->name('upgc.store');
Route::get('/upgc/cal/{id}', [App\Http\Controllers\API\UpgradeCarController::class, 'upgc_cal'])->name('upgc.cal');

// Route::post('/brand/store', [App\Http\Controllers\API\CarDataController::class, 'brand_store'])->name('brand.store');
// Route::post('/brand/update/{id}', [App\Http\Controllers\API\CarDataController::class, 'brand_update'])->name('brand.update');
// Route::delete('/brand/destroy/{id}', [App\Http\Controllers\API\CarDataController::class, 'brand_destroy'])->name('brand.destroy');

// Route::post('/model/store', [App\Http\Controllers\API\CarDataController::class, 'model_store'])->name('model.store');
// Route::post('/model/update/{id}', [App\Http\Controllers\API\CarDataController::class, 'model_update'])->name('model.update');
// Route::delete('/model/destroy/{id}', [App\Http\Controllers\API\CarDataController::class, 'model_destroy'])->name('model.destroy');

// Route::post('/makeover/store', [App\Http\Controllers\API\CarDataController::class, 'makeover_store'])->name('makeover.store');
// Route::post('/makeover/update/{id}', [App\Http\Controllers\API\CarDataController::class, 'makeover_update'])->name('makeover.update');
// Route::delete('/makeover/destroy/{id}', [App\Http\Controllers\API\CarDataController::class, 'makeover_destroy'])->name('makeover.destroy');

// Route::post('/subversion/store', [App\Http\Controllers\API\CarDataController::class, 'subversion_store'])->name('subversion.store');
// Route::post('/subversion/update/{id}', [App\Http\Controllers\API\CarDataController::class, 'subversion_update'])->name('subversion.update');
// Route::delete('/subversion/destroy/{id}', [App\Http\Controllers\API\CarDataController::class, 'subversion_destroy'])->name('subversion.destroy');

// Route::get('/model/data/test/{id}', [App\Http\Controllers\API\CarDataController::class, 'model_data_test'])->name('model.data.test');
// Route::get('/makeover/data/test/{id}', [App\Http\Controllers\API\CarDataController::class, 'makeover_data_test'])->name('makeover.data.test');
// Route::get('/subversion/data/test/{id}', [App\Http\Controllers\API\CarDataController::class, 'subversion_data_test'])->name('subversion.data.test');
