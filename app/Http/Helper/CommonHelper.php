<?php
namespace App\Http\Helper;

class CommonHelper{
    public static function strRandom($length = 16,$str=null)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($str){
            $pool= $str;
        }
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}
?>