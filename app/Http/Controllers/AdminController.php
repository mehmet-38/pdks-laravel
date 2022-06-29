<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $data["title"] = "users";
        $data["content"] = "admin panel";
        $data["sidebar"] =view("users.admin.sidebar");
        return view("users.admin",$data);

    }
    public function parks(){

        $data["title"] = "Parks";
        $data["content"] = "parklar";
        $data["sidebar"] =view("users.admin.sidebar");
        return view("users.admin",$data);

    }

}
