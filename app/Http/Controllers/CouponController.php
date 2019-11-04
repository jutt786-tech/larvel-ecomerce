<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

    }

    public function couponValue(Request $request){

        $coupon = Coupon::where('code',$request->coupon_code)->first();

        if (!$coupon){
            $respons = array([
                'status' => 'Sucess',
                'message' => 'Invalid Coupon Card',
                'coupon' => $coupon,
            ]);
            return response()->json($respons);
        }

        $subtotal= 0;
        $carts =session()->get('cart');
        foreach ($carts as $key=>$cart ){
            $subtotal += $cart['price'] *$cart['quantity'];
        }
        session()->put('subtotal',$subtotal);
        $subtotal =session()->get('subtotal');

         session()->put('coupon',[
            'name'=> $coupon->code,
            'cvalue'=> $coupon->value,
            'totalsum'=>$coupon->discount($subtotal),
        ]);

        $response = array([
            'status' => 'Sucess',
            'message' => 'Coupon Matched sucessfully',
            'totalsum'=>$coupon->discount($subtotal),
            'coupon' => $coupon,
        ]);

        return response()->json($response);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        session()->forget('coupon');
        return redirect(url('cart'))->with('message','Coupon delete sucessfully');

    }
}
