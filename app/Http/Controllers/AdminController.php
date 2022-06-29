<?php

namespace App\Http\Controllers;

use App\Objects\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public  function __construct()
    {
        $this->middleware(["auth"]);
        // bu kod ile başlangıçta authanticate olmadan sayfa açılmasın dedik

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
    public function parks(){
        $parks["parks"] = DB::table("parks")->get();
        $data["title"] = "Parks";
        $data["content"] = view("users.admin.parkControl",$parks);
        $data["sidebar"] =view("users.admin.sidebar");
        return view("users.admin",$data);

    }
    public function addUye(Request $request){
        $userData = new User();
        $userData->set_name($request->input('name'));
        $userData->set_password($request->input('password'));
        $userData->set_sys_role($request->input('sys_role'));
        $userData->set_email($request->input('email'));
        $userData->set_tckn($request->input('tckn'));
        $data =array('name'=>$userData->get_name(),'password'=>Hash::make($userData->get_password()),'sys_role'=>$userData->get_sys_role(),'email'=>$userData->get_email(),'tckn'=>$userData->get_tckn());
         $response= DB::table("users")->insert($data);
         if ($response)
             return redirect()->route("a-users");
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



}
