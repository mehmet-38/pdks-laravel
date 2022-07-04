<?php
namespace App\Helper;

class APIHelpers{
    public static function createAPIResponse($is_error,$code,$message,$content){
        $result =[];
        if ($is_error){
            $result['success']=false;
            $result['code']=$code;
            $result['message']=$message;
        }
        else{
            $result['success']=true;
            $result['code']=$code;
            if ($content==null){
                $result['message']=$message;
            }
            else{
                $result['content']=$content;
                $result['data']=$message;
            }
        }
        return $result;
    }
}
