<?php

use Illuminate\Database\Seeder;
use App\Coupon;
class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Coupon::create([
            'code' => "78jjj",
            'type' =>  "fixed",
            'value' => 30,
        ]);

        Coupon::create([
            'code' => "78jtt",
            'type' =>  "percent",
            'value' => 40,
        ]);
    }
}
