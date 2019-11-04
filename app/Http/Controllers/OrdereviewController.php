<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Error\Card;
use Stripe\Stripe;
use PDF;

class OrdereviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
//        dd($orders);
        return view('admin.order.index', compact('orders'));

    }

    //ORDER CANCEL METHODE
    public function OrderCancel($id) {

        $page = Order::findOrFail($id);
        if($page) {
            $page->status = 'canceled';
            $page->save();
        }
        return redirect(route('admin.order.index'))->with('message', 'Order updated Sucessfully');
    }

    //ORDER CANCEL METHODE
    public function OrderSucess($id) {
        $page = Order::findOrFail($id);
        if($page) {
            $page->status = 'Sucess';
            $page->save();
        }
        return redirect(route('admin.order.index'))->with('message', 'Order updated Sucessfully');
    }


    public function  chargepayment(Request $request)
    {
        \Stripe\Stripe::setApiKey('sk_test_mZb1SQyiW5AGyaVWtu4F7f2C00IH8N1mpC');
        $token = $_POST['stripeToken'];

// `source` is obtained with Stripe.js; see https://stripe.com/docs/payments/cards/collecting/web#create-token
      $amount = \Stripe\Charge::create([
            'amount' => 7000,
            'currency' => 'usd',
            'source' => $token,
            'description' => 'Charge for jenny.rosen@example.com',
        ]);
      if (!$amount){
          return redirect(route('order_review.create'))->with('message','plz enter valid Account');
      }else{
          session()->flush();
          return redirect(route('products.all'))->with('message','Payment recived sucessfully');
      }

    }


    // ORDER LIST

    public  function OrderList( ){
        $orders = Order::with('user','customer')->where('user_id', Auth::user()->id)->get();
//        dd($orders);
        return view('products.order_list', compact('orders'));
    }

    //get singel order{

    public  function singleOrder($id){
     $order =  Order::find($id);
        return view('products.order_review', compact('order'));

//        dd($oid);

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        dd($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $id = Order::find($id);
      $id->delete();
      return  redirect(route('admin.order.index'))->with('message', 'Order Del Sucessfully');
        //
    }
}
