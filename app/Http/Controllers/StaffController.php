<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{


    public function myParks(){

        $data["title"] = "myParks";
        $data["content"] = "staff panel";
        $data["sidebar"] =view("users.staff.sidebar");
        return view("users.staff",$data);
    }
}
