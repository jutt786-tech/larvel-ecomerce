<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
    protected  $guarded = [];
//    public static  function findByCode($code){
//      return  self::where('code',$code)->first();
//    }


    public  function discount($total){

        if (!empty($total)){
            return $total- ($this->value ) ;
        }else{
            return 0;
        }
    }


//    public  function discount($total){
//        dd($total);
//        if ($this->type = "fixed"){
//            return $this->value;
//        }elseif ($this->type = "percent"){
//
//            return  ($this->percent_off/100 ) * $total;
//        }else{
//            return 0;
//        }
//    }
}
