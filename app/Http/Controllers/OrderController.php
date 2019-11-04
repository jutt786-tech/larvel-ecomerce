<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  Session;
use App\Cart;
use App\Customer;
use App\Http\Requests\OrderRequest;
use Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        return $this->middleware('checkout');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()) {

            if (!Session::has('cart') || empty(Session::get('cart') || empty(Session::has('coupon') || (SESSION::get('coupon'))))) {
                return redirect('products')->with('message', 'No Products in the Cart');
            }

            $carts = Session::get('cart');
            $coupons = Session::get('coupon');

            return view('products.checkout', compact('carts', 'coupons'));
        }else{
            return  redirect(route('login'));
        }
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
//        $cart = [];
//        $customer='';
//        $orders='';
        $totalqty = 0;
        $totalprice = 0;

        $carts =session()->get('cart');

        foreach ($carts as $cart) {
            $totalqty +=$cart['quantity'];
            $totalprice +=$cart['quantity'] * $cart['price'];
        }
        $subtotal =  isset(session()->get('coupon')['cvalue']) ? $totalprice - session()->get('coupon')['cvalue'] : $totalprice;

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

            $order = [
                'totalqty'      => $totalqty,
                'totalprice'    => $subtotal,
                'status'        => 'pending',
                'user_id'       => Auth::user()->id,
                'customer_id'   => $customer->id,
                'cartdata'      => json_encode($carts),
                'coupon'        => session()->get('coupon')['cvalue']
            ];

            $orders = Order::create($order);

        \Stripe\Stripe::setApiKey('sk_test_mZb1SQyiW5AGyaVWtu4F7f2C00IH8N1mpC');
        $token = $_POST['stripeToken'];
        $amount = \Stripe\Charge::create([
            'amount' => $subtotal,
            'currency' => 'usd',
            'source' => $token,
            'description' => 'sucessfully by: jutt840@gmail.com',
        ]);

        session()->forget('cart', $carts);
        session()->put('customer',$customer );

       if ($customer && $orders){
           DB::commit();
//           session()->flush();
           return redirect(url('order_list'));
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
