<?php
namespace App\Objects;
 use Illuminate\Support\Facades\DB;

 class User{
    public $name;
    public $password;
    public $sys_role;
    public $email;
    public $tckn;


    function set_name($name) {
        $this->name = $name;
    }
    function get_name() {
        return $this->name;
    }

    public static function all(){
       $user=DB::table("users")
           ->select(["name","id","email"])
           ->get();
       return $user;

    }
    public static function deneme($email){
        $user=DB::table("users")->select(["email"])->where("email","=",$email)->get();
        return $user;
    }


    function set_password($password) {
        $this->password = $password;
    }
    function get_password() {
        return $this->password;
    }
    function get_sys_role(){
        return $this->sys_role;
    }
    function set_sys_role($sys_role){
        $this->sys_role = $sys_role;
    }
     function get_email(){
         return $this->email;
     }
     function set_email($email){
         $this->email = $email;
     }
     function get_tckn(){
         return $this->tckn;
     }
     function set_tckn($tckn){
         $this->tckn = $tckn;
     }

}

