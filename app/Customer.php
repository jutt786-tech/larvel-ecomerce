<?php

namespace App;

use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    use Billable;

    protected  $guarded = [];

    public function order(){
        return $this->hasMany('App\Order');
    }
}
