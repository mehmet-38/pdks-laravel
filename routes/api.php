<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\StaffController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

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

Route::get('/login',function (Request $request){
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'Login information is invalid.'
        ], 401);
    }
    $user = User::where('email',$request['email'])->firstOrFail();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return response()->json(["email"=>$user->createToken('bearer')->plainTextToken,"id"=>Auth::user()->id]);

});
Route::GROUP(["prefix" => "staff", "middleware" => ["auth:sanctum","role:2"]], function () {
    Route::POST("/steps", [StaffController::class, "sendSteps"]);
    Route::get("/tasks",[StaffController::class,"listTasksFM"]);
    Route::post("/addQr",[StaffController::class,"addQr"]);
    Route::get("/getQrId",[StaffController::class,"getQrId"]);
});




Route::post("/steps", [\App\Http\Controllers\GuestController::class,"postSteps"]);
Route::get('/user/{id}',function ($id){
    $user = \App\Objects\User::deneme($id);
    return $user;
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post("/addQr",[GuestController::class,"addQr"]);
