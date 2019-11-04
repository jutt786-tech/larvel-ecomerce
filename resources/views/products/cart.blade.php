@extends('layouts.app')
@section('text')
    <div class="row">
        <div class="col-md-12">
            <section class="jumbotron text-center">
                <div class="container">
                    <h1 class="jumbotron-heading">Album example</h1>
                    <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
                    <p>
                        <a href="#" class="btn btn-primary my-2">Main call to action</a>
                        <a href="#" class="btn btn-secondary my-2">Secondary action</a>
                    </p>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection
@section('contents')
    <h2>Shopping Cart Page</h2>

    @if(session('cart'))
        <div class="card table-responsive " >
            <table class="table table-hover shopping-cart-wrap">
                <thead class="text-muted">
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col" width="120">Quantity</th>
                    <th scope="col" width="120">Price</th>
                    <th scope="col" width="200" class="text-right">Action</th>
                </tr>
                </thead>
                <tbody>
                @php $total= 0; $totalQty= 0 @endphp
                @foreach(session('cart') as $id=>  $product)

                    <input id="cart-quantity" type="hidden" value="{{$total += $product['price'] * $product['quantity']}}">
                    <input type="hidden" value="{{$totalQty += $product['quantity'] }}">

                    <tr id="cart-data-{{$id}}">
                        <td id="cart-remove" >
                            <figure class="media">
                                <div id="cart-img" class="img-wrap"><img src="{{asset('images/'.$product['img'])}}" class="img-thumbnail img-sm" width="100" height="70"></div>
                                <figcaption class="media-body">
                                    <h6 id="cart-pname" class="title text-truncate">{{$product['pname']}}</h6>
                                    <dl class="param param-inline small">

                                    </dl>
                                    <dl class="param param-inline small">
                                        <dt> </dt>
                                        <dd></dd>
                                    </dl>
                                </figcaption>
                            </figure>
                        </td>
                        <td>

                            <div class="input-group product-qty"  id="product-qtty">
                                <span class="input-group-btn">
                                      <button onclick="decrement_quantity(  '{{$id}}', '{{$product['price']}}' )" type="button" class="btn btn-default btn-number"
                                              data-type="minus"
                                              data-field="quant">
                                          <span class="glyphicon glyphicon-minus">-</span>
                                      </button>
                                  </span>
                                <input type="text" id="input-quantity-{{$id}}"  name="quantity" class="form-control input-number" value="{{$product['quantity']}}">
                                <span class="input-group-btn">
                                          <button type="button" class="btn btn-default btn-number" onclick="increment_quantity ('{{$id}}', '{{$product['price']}}' );" data-type="plus" data-field="{{$id}}">
                                              <span class="glyphicon glyphicon-plus">+</span>
                                          </button>
                                </span>
                            </div>

                            {{--                            <input type="text" id="cart-quantity" name="qty" dataup-id="{{ $id }}" class="form-control text-center quantity update-cart" min="0" max="99" value="{{$product['quantity']}}">--}}
                        </td>
                        <td>
                            <div class="price-wrap-{{$id}}">
                                <span id="cart-quantity-{{$id}}" class="price">USD{{$product['price'] * $product['quantity']  }}</span>
                                <small id="cart-price" class="text-muted">USD{{$product['price']}} </small>
                            </div> <!-- price-wrap .// -->
                        </td>
                        <td class="text-right">
                            <button id="remove-product"  class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}" >Remove</button>
                        </td>
                    </tr>

                @endforeach
                <tr class="totalq">
                    <th  colspan="2">Total Qty: </th>
                    <td id="totalqty">{{$totalQty}}</td>
                </tr>
                <tr class="totalp">
                    <th colspan="2" >SubTotal Price: </th>
                    <td id="totalprice">{{$total}}</td><br>

                </tr>
                <tr>
                    <th>
                        <h6 id="couponName">Discount Coupon (Coupon Cod:{{session()->get('coupon')['name']}})</h6>

                        <form method="post" action="{{route('coupon.destroy')}}" >
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Del</button>
                        </form>
                    </th>
                    <td><span id="couponValue" class="text-muted">{{session()->get('coupon')['cvalue']}}</span></td>
                </tr>

                <tr class="totalItemAmount">
                    <th colspan="2" >Total Price: </th>
                    <td id="totalItemAmount">
                        @if(isset(session()->get('coupon')['totalsum']))

                        {{ $total - session()->get('coupon')['cvalue'] }}

                        @else
                            {{$total}}
                        @endif
                    </td>
                    <br>
                </tr>

                <tr>
                    <th>
                        <div class="input-group">
                            <input name="coupon_code" id="coupon_code" type="text" class="form-control" placeholder="Coupon code">
                            <div class="input-group-append">
                                <button type="submit" id="submitid" class="btn btn-secondary coupon" >Add Coupon</button>
                            </div>
                        </div>
                    </th>
                    <td class="text-right"><a href="{{url('checkout')}}" class="btn btn-dark btn-lg " >checkout</a></td>
                </tr>
                </tbody>
            </table>
        </div> <!-- card.// -->
    @else
        <p class="alert alert-danger">No Products in the Cart <a href="{{route('products.all')}}">Buy Some Products</a></p>
    @endif
@endsection
@section('script')
    <script type="text/javascript">

            function totalamount(){
                var total = document.getElementById("totalprice").innerHTML;
                var coupon = document.getElementById("couponValue").innerHTML;
                var total = total- coupon;
                document.getElementById("totalItemAmount").innerHTML = total;
            }
// add coupon
        $('#submitid').on('click', function() {
            var couponCode = $( "#coupon_code" ).val();

            if(couponCode !=''){
                $.ajax({
                    url: '{{route('coupon.couponValue')}}',
                    method : "post",
                    dataType: 'json', //this will expect a json response
                    data:{_token: '{{ csrf_token() }}', coupon_code : couponCode},
                    success: function(response){
                        console.log(response);

                        swal({
                            title: "Coupon!",
                            text: response.message,
                            type: "success",
                            timer: 2000
                        });

                        $("#totalItemAmount").text(response[0].totalsum);   //get total sum of quantity when coupon accept
                        $("#couponName").text(response[0].coupon.code).replaceWith("Discount Coupon(Coupon Code:"+response[0].coupon.code+")");
                        $("#couponValue").text(response[0].coupon.value); //get coupon value
                    }
                });
            }

        });


        function increment_quantity(cart_id, price) {
            var inputQuantityElement = $("#input-quantity-"+cart_id);
            var newQuantity = parseInt($(inputQuantityElement).val())+1;  //increment value in quantity
            var newprice = newQuantity * price;   // get single row total quantity price
            save_to_db(cart_id, newQuantity, newprice); //pass value save_to_db function
        }
        function decrement_quantity(cart_id, price) {
            // get input guantity id
            var inputQuantityElement = $("#input-quantity-"+cart_id);
            if($(inputQuantityElement).val() > 1)
            {
                var newQuantity = parseInt($(inputQuantityElement).val()) - 1;  // if value greater then 1 then decrement
                var newprice = newQuantity * price;   //get single row total quantity price
                save_to_db(cart_id, newQuantity, newprice);  //pass value save_to_db function
            }
        }

        function save_to_db(cart_id, new_quantity, newprice) {
            var inputQuantityElement = $("#input-quantity-" + cart_id);
            var priceElement = $("#cart-quantity-"+cart_id);
            $.ajax({
                url: '{{ url('cart/update') }}',
                method: "patch",
                dataType: "JSON",
                data: {_token: '{{ csrf_token() }}', id: cart_id, quantity: new_quantity},
                success: function (response) {
                    // add alerts button with response
                    swal({
                        title: "Updated!",
                        text: response.message,
                        type: "success",
                        timer: 2000
                    });
                    //return new value  input id="input-quantity-1" quantity elements
                    $(inputQuantityElement).val(new_quantity);
                    // return new price value id=cart-quantity-1
                    $(priceElement).text("USD"+newprice);

                    // cout totalquantity by using input[id*='input-quantity-'] loop/ return all value and count it
                    var totalItemqty = 0;
                    $("input[id*='input-quantity-']").each(function () {
                      var cartqty= $(this).val();
                     totalItemqty = parseInt(totalItemqty) + parseInt(cartqty);
                    });
                    $("#totalqty").text(totalItemqty);

                    // cout totalItemPrice by using span[id*='cart-quantity-'] loop/ return all value price and count it
                    var totalItemPrice = 0;
                    $("span[id*='cart-quantity-']").each(function() {
                        var cart_price = $(this).text().replace("USD","");
                        totalItemPrice = parseInt(totalItemPrice) + parseInt(cart_price);
                    });
                    $("#totalprice").text(totalItemPrice);

                    totalamount();
                }
            });
        }


        //Remove produt by get product  id
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            //get product id
            var removeid = $(this).attr("data-id");
            // e.preventDefault();
            //sweet alert condition if you want to delete then delete else  redirect
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this Product again!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",

            }).then((result) => {
                if (result.value) {

                    $.ajax({
                        url: '{{ url('cart/remove') }}',
                        method: "DELETE",
                        dataType: 'JSON',
                        data: {_token: '{{ csrf_token() }}', id: removeid},
                        success: function (response) {
                            console.log(response.cart);
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message,
                                type: "success",
                                 timer: 2000
                            });
                            //when product deleted then show present value  in cart <tr id="cart-data-$id">
                            $("#cart-data-" + response.product_id).html(response.cart);
                            var totalprice = 0;
                            var totalqty = 0;

                            //response show josn boject value then seprate vaue with loop and get total qty and price
                            $.each(response.cart, function (key, value) {
                                totalprice += value.price * value.quantity;
                                totalqty += parseFloat(value.quantity);
                            });

                            // show product total value after deleted
                            $('.totalq').empty()
                                .append(' <th colspan="2" >Total Qty: </th><td id="totalqty">' + totalqty + '</td>');

                            // show product total price after deleted any product
                            $('.totalp').empty()
                                .append(' <th  colspan="2">Total Price: </th><td id="totalprice">' + totalprice + '</td>');

                            // count object key thats show top of the navbar and append new value
                            $('#count').empty()
                                .append('CART ' + Object.keys(response.cart).length);
                            totalamount();
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'Your Product file is safe :)',
                        'error'
                    )
                }

            });
        });



    </script>

@endsection
