<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\AbstractList;
use App\Cart;
use Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
      $products = Product::with('categories')->get();
//      dd($products);
        return view('admin.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
       $categories= Category::all();
        return view('admin.product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        Validator::make($request->all(), [
            'pname' => 'required|unique:products|max:255',
            'description' => 'required',
            'img'   =>  'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ])->validate();
        if($request->hasFile('img')) {
            $image       = $request->file('img');
            $filename    = $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(300, 300);
            $image_resize->save(public_path('images/' .$filename));
            $uploadimage= $filename;

        }
       $product =Product::create([
            'pname' => $request->pname,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount,
            'discount_price' => $request->discount_price,
            'img'       => $uploadimage,

        ]);
        $product->categories()->attach($request->category);
        return redirect(route('admin.product.index'))->with('message','Product add sucessfully');
//        dd($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
//        dd(Session::get('cart'));
       $products= Product::all();
       $categories= Category::all();
        return  view('products.all',compact('products','categories'));
    }

    public function single(Product $product){
        return view('products.single',['product'=> $product]);
    }

//    public function cartUpdate($cat_id, $qty)
//    {
//        $cart = Cart::find(('cat_id'));
//        $product = Product::find($cart->product_id);
//        $cart->no_of_items = Input::get('qty');
//        $cart->price = $product->price * $cart->no_of_items;
//        $cart->save();
//    }


    public function addToCart($id)
    {
        $product = Product::find($id);
        if(!$product) {
            abort(404);
        }
        $cart = Session::get('cart');
        // if cart is empty then this the first product
        if(!$cart) {
            $cart = [
                $id => [
                    "pname" => $product->pname,
                    "description"=> $product->description,
                    "quantity" => 1,
                    "price" => $product->price,
                    "discount_price" => $product->discount_price,
                    "img" => $product->img
                ]
            ];
            Session::put('cart', $cart);
            return redirect()->back()->with('message', 'Product added to cart successfully!');
        }
        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
            Session::put('cart', $cart);
            return redirect()->back()->with('message', 'Product added to cart successfully!');
        }
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "pname" => $product->pname,
            "description"=> $product->description,
            "quantity" => 1,
            "price" => $product->price,
            "discount_price" => $product->discount_price,
            "img" => $product->img
        ];
        Session::put('cart', $cart);
        return back()->with('message','Product added to cart successfully!');
        return redirect()->back()->with('message', 'Product added to cart successfully!');
    }

    public function updateProduct(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('message', 'Cart updated successfully');
        }
    }

    public function removeProduct(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('message', 'Product removed successfully');
        }
    }


//    public  function addToCart(Product $product, Request $request){
//          $oldCart = Session:: has('cart') ? Session::get('cart') : null;
//          $qty = $request->qty ? $request->qty : 1;
//          $cart = new Cart($oldCart);
//          $cart->addProduct($product, $qty);
//
//        Session::put('cart',$cart);
//        return back()->with('message',"Product .$product->pname. addtocart sucessfully");
//    }


    public function cart(){
        if (!Session::has('cart')){
            return view('products.cart');
        }else{
          $carts = Session::get('cart');
            return view('products.cart',compact('carts'));
        }
    }

//    public  function removeProduct(Product $product){
//
//      $oldCart =  Session::has('cart') ? Session::get('cart') : null;
//        $cart = new Cart($oldCart);
//        $cart->removeProduct($product);
//
//        Session::put('cart',$cart);
////        session()->flush();
//
//        return back()->with('message',"Product .$product->pname. has sucessfully Delete" );
//
//    }
//
//    public  function updateProduct(Product $product, Request $request){
////        dd('dd');
//        $oldCart =  Session::has('cart') ? Session::get('cart') : null;
//        $qty = $request->qty ? $request->qty : 1;
//        $cart = new Cart($oldCart);
//        $cart->updateProduct($product, $qty);
//        Session::put('cart',$cart);
//        return back()->with('message',"Product .$product->pname. has sucessfully Updated" );
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product  $product)
    {
        //
       $categories= Category::all();

//      dd($products);
      return view('admin.product.create',['categories'=> $categories , 'product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

//        dd($request->all());
        Validator::make($request->all(), [
            'pname' => 'required|max:255',
            'description' => 'required',
            'img'   =>  'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ])->validate();
        if($request->hasFile('img')) {

            $image = $request->file('img');
            $filename = $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(300, 300);
            $image_resize->save(public_path('images/' . $filename));
            $uploadimage = $filename;
        }

        $pid = Product::findOrFail($id);
        $pid->pname = $request->pname;
        $pid->description = $request->description;
        $pid->price = $request->price;
        $pid->discount = $request->discount;
        $pid->discount_price = $request->discount_price;
        $pid->img = $uploadimage;
        $pid->save();
        $pid->categories()->sync($request->category);

        return redirect(route('admin.product.index'))->with('message','Data updated Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $pid = Product::findOrFail($id);
        $pid->delete();
        return redirect(route('admin.product.index'))->with('message','Product Deleted Sucessfully');
    }
}
