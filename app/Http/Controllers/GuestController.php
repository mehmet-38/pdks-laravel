<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Objects\Park;
use App\Objects\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Qr;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{


    public function Index (){

        if (Auth::user()->sys_role==env("role_admin")){
            return redirect()->route("a-home");
        }
        else if(Auth::user()->sys_role==env("role_staff")){
            return redirect()->route("myParks");

        }

    }
    public function getUser(){
        $user = User::all();

        return json_encode($user);
    }
    public function getPark(){
        $park = Park::all();
        return json_encode($park);

    }
    public function addQr(Request $request){
        $qr = new Qr();
        $qr->code =$request->code;
         $qr->park_id=$request->park_id;
         $qr->fk_user_id = $request->fk_user_id;
         $result=$qr->save();
         if ($result){
             return ["Result"=>"Data saved"];
         }else{
             return ["Result"=>"Failed"];
         }
//        update actions set steps=JSON_ARRAY_APPEND(steps,'$',JSON_OBJECT("LAT","123","LNG","56")) WHERE id=58;
    }
    public function postSteps(Request $request){

        $currentUser = $request->fk_user_id;
        $currentDate = Date("Y-m-d");
        $currentTime = Date("H:i:s" ,time());
        $query = DB::SELECT("SELECT id FROM actions WHERE fk_user_id = '$currentUser' AND created_at = '$currentDate'");
        if(isset($query[0]->id)){
            $actionID = $query[0]->id;
            DB::UPDATE("UPDATE actions SET steps = JSON_ARRAY_APPEND(steps, '$', JSON_OBJECT('lat',$request->lat,'lng',$request->lng)) WHERE id = '$actionID'");
            DB::UPDATE("UPDATE actions SET finished_at = '$currentTime' WHERE ID = '$actionID'");
        } else {
            DB::INSERT("INSERT INTO actions (fk_user_id, steps, created_at, finished_at) VALUES ('$currentUser', '[]','$currentDate','$currentTime')");
        }


    }
    /*
    public function login1(Request $request){
        if (!\Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Login information is invalid.'
            ], 401);
        }

        $user = \App\Models\User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
*/

}
