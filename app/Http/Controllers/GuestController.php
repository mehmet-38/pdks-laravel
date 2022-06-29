<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
