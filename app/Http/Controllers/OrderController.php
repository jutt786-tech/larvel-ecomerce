<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  Session;
use App\Cart;
use App\Customer;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(!Session::has('cart') || empty(Session::get('cart')) ){
            return redirect('products')->with('message', 'No Products in the Cart');
        }
        $carts = Session::get('cart');
//        dd($carts);
        return view('products.checkout', compact('carts'));

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
    public function store(OrderRequest $request)
    {
        $cart = [];
        $customer='';
        $orders='';
        if (session()->has('cart')){
            $cart =session()->get('cart');
        }
        //
        if (isset($request->billing_lastName) && !empty( $request->shipping_firstName)){

            $customer = [
                "billing_firstName" => $request->billing_firstName,
                "billing_lastName" => $request->billing_lastName,
                "username" => $request->username,
                "email" => $request->email,
                "billing_address1" => $request->billing_address1,
                "billing_address2" => $request->billing_address2,
                "billing_country" => $request->billing_country,
                "billing_state" => $request->billing_state,
                "billing_zip" => $request->billing_zip,
                "shipping_address" => $request->shipping_address,
                "shipping_firstName" => $request->shipping_firstName,
                "shipping_lastName" => $request->shipping_lastName,
                "shipping_address1" => $request->shipping_address1,
                "shipping_address2" => $request->shipping_address2,
                "shipping_country" => $request->shipping_country,
                "shipping_state" => $request->shipping_state,
                "shipping_zip" => $request->shipping_zip,
            ];
        }else{

            $customer = [
                "billing_firstName" => $request->billing_firstName,
                "billing_lastName" => $request->billing_lastName,
                "username" => $request->username,
                "email" => $request->email,
                "billing_address1" => $request->billing_address1,
                "billing_address2" => $request->billing_address2,
                "billing_country" => $request->billing_country,
                "billing_state" => $request->billing_state,
                "billing_zip" => $request->billing_zip,
                "shipping_address" => $request->shipping_address,
               ];

        }
        DB::beginTransaction();
        $customer = Customer::create($customer);
       foreach (session('cart') as $id => $products){
          $order =[
               'qty' => $products['quantity'],
               'price' => $products['price'],
               'status' => 'pending',
               'customer_id' => $customer->id,
               'product_id'=> $id,

           ];
           $orders =   Order::create($order);

       }
       if ($customer && $orders){
           DB::commit();
           session()->flush();
           return  redirect(route('product.all'));
       }else{
           DB::rollBack();
           return back()->with('message','Invalid data ');
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
