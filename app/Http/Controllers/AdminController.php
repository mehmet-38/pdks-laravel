<?php

namespace App\Http\Controllers;

use App\Helper\APIHelpers;
use App\Models\Qr;
use App\Models\Task;
use App\Objects\Park;
use App\Objects\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Factory;
use Symfony\Component\Console\Input\Input;

class AdminController extends Controller
{
    protected $auth;
    public  function __construct()
    {
        $this->middleware(["auth"]);
        // bu kod ile başlangıçta authanticate olmadan sayfa açılmasın dedik

        // firebase auth connect codes
        $factory = (new Factory)
            ->withServiceAccount(__DIR__.'/adminsdk2.json')
            ->withDatabaseUri('https://pdks.firebaseio.com/');

        $this->auth = $factory->createAuth();


    }
    public function getUser(){
        $user = User::all();
        //$response=APIHelpers::createAPIResponse(false,200,'',$user);
        return json_encode(["users"=>$user]);
    }

    public function home(){

        $data["title"] = "users";
        $data["content"] = "Home";
        $data["sidebar"] =view("users.admin.sidebar");
        return view("users.admin",$data);
    }

    public function users(){
        $users["users"] = DB::table("users")->get();
        $data["title"] = "users";
        $data["content"] = view("users.admin.userControl",$users);
        $data["sidebar"] =view("users.admin.sidebar");
        return view("users.admin",$data);

    }
    public function parks(Request $request){
        $parks["parks"] = DB::table("parks")->get();
        $parksData["parksData"]=DB::table("parks")->where("parkID","=",$request->id)->get();
        $data["title"] = "Parks";
        $data["content"] = view("users.admin.parkControl",$parks,$parksData);
        $data["sidebar"] =view("users.admin.sidebar");
        return view("users.admin",$data);

    }
    public function addPark(Request $request){
        $parkData = new Park();
        $parkData->set_name($request->input('parkName'));
        $parkData->set_loc_x($request->input('latitude'));
        $parkData->set_loc_y($request->input('longitude'));
        $parkData->set_m2($request->input('m2'));
        $park_data =array('parkName'=>$parkData->get_name(),'latitude'=>$parkData->get_loc_x(),'longitude'=>$parkData->get_loc_y(),'m2'=>$parkData->get_m2());

        $result = DB::table("parks")->insert($park_data);

        if ($result)return redirect()->route("a-parks");
        else echo "Wrong";
    }
    public function addUye(Request $request){

        $userData = new User();
        $userData->set_name($request->input('name'));
        $userData->set_password($request->input('password'));
        $userData->set_sys_role($request->input('sys_role'));
        $userData->set_email
        ($request->input('email'));
        $userData->set_tckn($request->input('tckn'));
        $data =array('name'=>$userData->get_name(),'password'=>Hash::make($userData->get_password()),'sys_role'=>$userData->get_sys_role(),'email'=>$userData->get_email(),'tckn'=>$userData->get_tckn());
         $response= DB::table("users")->insert($data);

         if ($response){
             $this->auth->createUserWithEmailAndPassword($request->input('email'), $request->input('password'));
             return redirect()->route("a-users");
         }

         else
              echo "Wrong";

    }
    public function deleteUye(Request $request){
        $response = DB::table("users")->where("id","=",$request->id)->delete();
        if ($response){
            return redirect()->route("a-users");
        }
        else
            echo "Wrong";
    }
    public function qrs(){
            //$qrs["qrs"] = DB::table("qrs")->get();
        $qrs["qrs"] = Qr::query()->join("users","users.id","=","qrs.fk_user_id")
            ->join("parks","parks.parkID","=","qrs.fk_park_id")
            ->get();
            $data["title"] = "users";
            $data["content"] = view("users.admin.qrControl",$qrs);
            $data["sidebar"] =view("users.admin.sidebar");
             return view("users.admin",$data);
        }
    public function rapor(Request $request){


            $search = $request->input('search');
            $start_date = $request->input('start_date');
            $finish_date = $request->input('finish_date');
            if ($search !=''){
                /*
                $task = Task::where('user_id','like','%'.$search.'%')
                    ->paginate(2)
                    ->setpath('');*/
                $task = Task::query()->join("users","users.id","=","tasks.user_id")
                    ->where("users.name","like","%".$search."%")
                    ->where("start_at",$start_date?">=":"<>", $start_date?$start_date:'')
                    ->where("finish_at",$finish_date?"<=":"<>", $finish_date?$finish_date:'')
                    ->paginate(2)
                    ->setPath('');
                $task->appends(array(
                    'search'=>$request->input('search'),
                    'start_date'=>$request->input('start_date'),
                    'finish_date'=>$request->input('finish_date')
                ));
                if (count($task)>0){
                    $data["title"]="Rapor";
                    $data["content"]=view("users.admin.rapor")->with(['task'=>$task]);
                    $data["sidebar"]=view("users.admin.sidebar");
                    return view('users.admin',$data);
                }
                return view('users.admin.rapor')->withMessage("asdasd");

            }



        //return $query;

    }
    public function all_rapor(){


       /*
            $query["query"] = DB::table("tasks")
                ->select("start_at","qr_id","user_id","finish_at")
                ->join("users","users.id","=","tasks.user_id")
                ->paginate(2);*/


       $task = Task::query()->join("users","users.id","=","tasks.user_id")
           ->paginate(2);

        $data["title"] = "Rapor";
        $data["content"]=view("users.admin.rapor",compact('task'));
        $data["sidebar"]=view("users.admin.sidebar");
        return view("users.admin",$data);
    }




}
