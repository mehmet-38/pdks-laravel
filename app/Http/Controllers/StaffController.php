<?php

namespace App\Http\Controllers;

use App\Models\Qr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{


    public function myParks(){

        $data["title"] = "myParks";
        $data["content"] = "staff panel";
        $data["sidebar"] =view("users.staff.sidebar");
        return view("users.staff",$data);
    }

    public function sendSteps(Request $request)
    {
        $currentUser = Auth::user()->id;
        $currentDate = Date("Y-m-d");
        $currentTime = Date("H:i:s" ,time());
        $query = DB::SELECT("SELECT actionID FROM actions WHERE fk_user_id = '$currentUser' AND created_at = '$currentDate'");
        if(isset($query[0]->actionID)){
            $rowID = $query[0]->actionID;
            DB::UPDATE("UPDATE actions SET steps = JSON_ARRAY_APPEND(steps, '$', JSON_OBJECT('lat',$request->lat,'lng',$request->lng)) WHERE actionID = '$rowID'");
            DB::UPDATE("UPDATE actions SET finish_at = '$currentTime' WHERE actionID = '$rowID'");
        } else {
            DB::INSERT("INSERT INTO actions (fk_user_id, steps, created_at, finish_at,started_at,fk_QR_id) VALUES ('$currentUser', '[]','$currentDate','$currentTime','$currentTime','$request->fk_QR_id')");

        }
    }
    public function listTasksFM(){
        $userID = Auth::user() -> id;
        $query = DB::TABLE("users")
            -> join("parks","users.fk_parkID","=","parks.parkID")
            -> where("users.id","=","$userID")
            -> get();
        return response() -> json($query);
    }
    public function addQr(Request $request){

        $qr = new Qr();
        $qr->QRdata =$request->QRdata;
        $qr->fk_parkID=$request->fk_parkID;
        $qr->fk_user_id=$request->fk_user_id;
        $result=$qr->save();
        //$query = DB::select("SELECT QRid FROM qrs ORDER BY QRid DESC LIMIT 1");

        if ($result){
            return ["Result"=>"Data saved"];
            //return  response()->json($query);
        }else{
            return ["Result"=>"Failed"];
        }
    }
    public function getQrId(){
        $query = DB::select("SELECT QRid FROM qrs ORDER BY QRid DESC LIMIT 1");
        return  response()->json($query);
    }

}
