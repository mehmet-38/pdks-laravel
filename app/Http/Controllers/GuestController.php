<?php

namespace App\Http\Controllers;

use App\Objects\Park;
use App\Objects\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Qr;

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
         $result=$qr->save();
         if ($result){
             return ["Result"=>"Data saved"];
         }else{
             return ["Result"=>"Failed"];
         }

    }


}
