<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryParent;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\AbstractList;
use App\Cart;
use PhpParser\Node\Stmt\DeclareDeclare;
use App\Http\Requests\productRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('categories')->get();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(productRequest $request)
    {

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $filename = $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(300, 300);
            $image_resize->save(public_path('images/' . $filename));
            $uploadimage = $filename;

        }
        $product = Product::create([
            'pname' => $request->pname,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount,
            'discount_price' => $request->discount_price,
            'img' => $uploadimage,

        ]);
        $product->categories()->attach($request->category);
        return redirect(route('admin.product.index'))->with('message', 'Product add sucessfully');
//        dd($product);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $lastproducts = Product::latest('id')->first();
        $products = Product::all();

        $categories = Category::whereNull('category_id')
            ->with('childrenCategories')
            ->get();

        return view('products.all', compact('products', 'categories', 'lastproducts'));
    }


    public function single(Product $product)
    {
        return view('products.single', ['product' => $product]);
    }

    public function addToCart($id)
    {
        $product = Product::find($id);
        if (!$product) {
            abort(404);
        }
        $cart = Session::get('cart');
        // if cart is empty then this the first product of session
        if (!$cart) {
            $cart = [
                $id => [
                    "pname" => $product->pname,
                    "description" => $product->description,
                    "quantity" => 1,
                    "price" => $product->price,
                    "discount_price" => $product->discount_price,
                    "img" => $product->img
                ]
            ];
            Session::put('cart', $cart);
        }

        $cart[$id] = [
            "pname" => $product->pname,
            "description" => $product->description,
            "quantity" => 1,
            "price" => $product->price,
            "discount_price" => $product->discount_price,
            "img" => $product->img
        ];
        Session::put('cart', $cart);

        $response = array(
            'status' => 'success',
            'message' => 'Product has been Added sucessfully.',
            'cart' => $cart,
        );
        return response()->json($response);
    }

    public function cart()
    {
        if (!session()->get('cart')){
          return  redirect(route('products.all'));
        }else {

            if (!Session::has('cart') || empty(Session::get('cart') || empty($categories) || empty($lastproducts))) {
                return view('products.all');
            } else {
                $carts = Session::get('cart');
                $lastproducts = Product::latest('id')->first();
                $categories = Category::whereNull('category_id')
                    ->with('childrenCategories')
                    ->get();

                return view('products.cart', compact('carts', 'categories', 'lastproducts'));
            }

        }
    }

    public function updateProduct(Request $request)
    {
        if ($request->id and $request->quantity) {
            $cart = session()->get('cart');
            $q = $cart[$request->id]["quantity"] = $request->quantity;
            $p = $cart[$request->id]['price'];
            session()->put('cart', $cart);
            $response = array(
                'price' => $p,
                'status' => 'success',
                'message' => 'Product has been updated.',
                'cart' => $cart,
                'newprice' => $p * $q,
                'product_id' => $request->id
            );
            return response()->json($response);
        }

    }

    public function removeProduct(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            $response = array(
                'status' => 'success',
                'message' => 'product has been deleted Sucessfully.',
                'cart' => $cart,
                'product_id' => $request->id,
            );
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product  $product)
    {
       $categories= Category::all();
      return view('admin.product.create',['categories'=> $categories , 'product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(productRequest $request, $id)
    {

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
