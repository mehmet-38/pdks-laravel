<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Action;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\GuestController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix'=>'admin',"middleware"=>["auth","can:isAdmin","verified"]],function (){
    Route::get('users',[AdminController::class,"users"])->name("a-users");
    Route::get('parks',[AdminController::class,"parks"])->name("a-parks");
    Route::get('home',[AdminController::class,"home"])->name("a-home");
    Route::get('qrs',[AdminController::class,"qrs"])->name("a-qrs");
    Route::get('rapor',[AdminController::class,"rapor"])->name("a-rapor");
    Route::get('all-rapor',[AdminController::class,"all_rapor"])->name("all-rapor");
   // Route::get('get-users',[AdminController::class,"getUser"])->name("get-users");
});
Route::get('get-users',[GuestController::class,"getUser"])->name("get-users");
Route::get('get-parks',[GuestController::class,"getPark"])->name("get-parks");
Route::get('/signup', [\App\Http\Controllers\firebaseController::class,"signUp"]);
Route::group(["prefix"=>"staff","middleware"=>["auth","can:isStaff","verified"]],function (){
    Route::get('myParks',[StaffController::class,"myParks"])->name("myParks");
});
Route::get("test",function (){
    $user = new User();

     $user->name = "mehmet";
     $user->email ="mehmet@gmail";
     $user->sys_role=1;
     $user->password =Hash::make("12345678");
    $user->tckn ="1";
     $user->save();
})->name("test");

Route::post("/addUye",[AdminController::class,"addUye"])->name("addUye");
Route::post("/addPark",[AdminController::class,"addPark"])->name("addPark");
Route::post("/deleteUye",[AdminController::class,"deleteUye"])->name("deleteUye");
Route::get('/', function () {
    return view('auth.login');
});
Route::get("guest/Index",[GuestController::class,"Index"]);


require __DIR__.'/auth.php';
