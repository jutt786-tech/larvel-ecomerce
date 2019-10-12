<?php

namespace App;



class Cart
{
    //
    private $contents;
    private $totalQty;
    private  $totalPric;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->contents = $oldCart->contents;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPric = $oldCart->totalPric;
        }
    }

    public function addProduct($product, $qty){

        $products  =   ['qty'=> 0 , 'price' =>$product->price, 'product'=>$product];

        if ($this->contents){
            if (array_key_exists($product->pname, $this->contents)){
                $products = $this->contents[$product->pname];
            }
        }
        $products['qty']+=$qty;
        $product['price']= $product->price * $products['qty'];
        $this->contents[$product->pname]= $products;
        $this->totalQty+= $qty;
        $this->totalPric += $product->price;
    }

    public function removeProduct(Product $product){
//         dd('ddd');
        if ($this->contents){
            if (array_key_exists( $product->pname, $this->contents)) {
                $rProduct = $this->contents[$product->pname];
                $this->totalQty -= $rProduct['qty'];
                $this->totalPric -=$rProduct['price'];
                array_forget($this->contents, $product->pname);
            }
        }
    }

    public function updateProduct(Product $product, $qty){
        if ($this->contents){
            if (array_key_exists( $product->pname, $this->contents)) {
                $products = $this->contents[$product->pname];

            }
        }
        $this->totalQty -= $products['qty'];
        $this->totalPric -= $products['price'];
        $products['qty'] = $qty;
        $products['price'] = $product->price * $qty;
        $this->totalPric += $products['price'];
        $this->totalQty += $qty;
        $this->contents[$product->pname] = $products;
    }



    public function getContents(){
        return $this->contents;
    }
    public function totalQty(){
        return $this->totalQty;

    }
    public function totalPrice(){
        return $this->totalPric;
    }

}
