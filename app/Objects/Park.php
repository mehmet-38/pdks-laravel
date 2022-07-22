<?php
namespace App\Objects;
use Illuminate\Support\Facades\DB;

class Park{

    public $name;
    public $loc_x;
    public $loc_y;
    public $m2;

    public static function all(){
        $park=DB::table("parks")
            ->select(["loc_x","loc_y"])
            ->get();
        return $park;

    }
    function get_name(){
        return $this->name;
    }
    function set_name($name){
        return $this->name=$name;
    }
    function get_loc_x(){
        return $this->loc_x;
    }
    function set_loc_x($loc_x){
        return $this->loc_x=$loc_x;
    }
    function get_loc_y(){
        return $this->loc_y;
    }
    function set_loc_y($loc_y){
        return $this->loc_y=$loc_y;
    }
    function get_m2(){
        return $this->m2;
    }
    function set_m2($m2){
        return $this->m2=$m2;
    }




}
?>
