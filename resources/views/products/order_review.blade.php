@extends('layouts.app')
@section('sidebar')
    @parent
@endsection
@section('contents')
    <div class="container">
{{--        {{dd($orders)}}--}}
        <div class="row mt-5">
{{--            @foreach($orders as $order)--}}

            <div class="col-md-12">
                <section id="cart_items">
                    <div class="container">

{{--                        <div class="breadcrumbs">--}}
{{--                            <ol class="breadcrumb">--}}
{{--                                <li><a href="#">Home</a></li>/--}}
{{--                                <li class="active"><a href="{{asset(url('checkout'))}}">Checkout</a> </li>--}}
{{--                            </ol>--}}
{{--                        </div>--}}

                        <div class="review-payment">
                           <sapn> <h3>Customer Detail</h3>
                       <a onclick="printfn()" class="btn btn-outline-danger float-right">print</a></sapn>
{{--                            <a href="{{route('OrderCancel', $order->id )}}" class="btn btn-outline-danger float-right">Order Cancel</a>--}}
                            </sapn>
                        </div>

                    </div>

                        <div class="table-responsive cart_info">
                            <table class="table table-condensed">

                                <tbody>
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">

                                        <tr class="cart_menu">
                                            <td class="image">OrderNO:</td>
                                            <td class="image">{{$order->customer->id}}</td>
                                        </tr>

                                        <tr class="cart_menu">
                                            <td class="image">UserName</td>
                                            <td class="image">{{$order->user->name}}</td>
                                        </tr>

                                        <tr class="cart_menu">
                                            <td class="image">Email</td>
                                            <td class="image">{{$order->user->email}}</td>
                                        </tr>

                                        <tr class="cart_menu">
                                            <td class="image">Adress</td>
                                            <td class="image">{{$order->customer->billing_address1}}</td>
                                        </tr>

                                        <tr class="cart_menu">
                                            <td class="image">Country</td>
                                            <td class="image">{{$order->customer->billing_country}}</td>
                                        </tr>

                                        <tr class="cart_menu">
                                            <td class="image">State</td>
                                            <td class="image">{{$order->customer->billing_state}}</td>
                                        </tr>

                                        <tr class="cart_menu">
                                            <td class="image">Zip</td>
                                            <td class="image">{{$order->customer->billing_zip}}</td>
                                        </tr>

                                    </div>
                                </div>

                                </tbody>
                            </table>
{{--                        </div>--}}
                    </div>
                </section> <!--/#cart_items-->

                <h2>Product Review</h2>
                    <div class="card table-responsive " >
                        <table class="table table-hover shopping-cart-wrap">
                            <thead class="text-muted">
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col" width="120">Quantity</th>
                            </tr>
                            </thead>
                            <tbody>

{{--                            @foreach($orders as   $product)--}}
                                @foreach(json_decode($order->cartdata) as $ord)
                                <tr id="cart-data">
                                    <td id="cart-remove" >
                                        <figure class="media">
{{--                                            <div id="cart-img" class="img-wrap"><img src="{{asset('images/'. $order->img)}}" class="img-thumbnail img-sm" width="100" height="70"></div>--}}
                                            <figcaption class="media-body">
                                                <h6 id="cart-pname" class="title text-truncate">{{$ord->pname}}</h6>
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
                                            <button type="text" >{{$ord->quantity}}</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="totalq">
                                <th  colspan="2">Total Qty: </th>
                                <td id="totalqty">{{$order->totalqty}}</td>
                            </tr>

                            <tr class="totalp">
                                <th  colspan="2">SubTotal: </th>
                                <td id="totalprice">{{$order->totalprice}}</td>
                            </tr>

                            <tr>
                                <th>
                                    <h6 id="couponName">Discount Coupon</h6>
                                </th>
                                <td><span id="couponValue" class="text-muted">{{$order->coupon ? $order->coupon : 0}}</span></td>
                            </tr>

                            <tr class="totalItemAmount">
                                <th colspan="2" >Total Price: </th>
                                <td id="totalItemAmount">
                                  {{$order->totalprice}}
                                </td>
                            </tr>

{{--                            @endforeach--}}
                            </tbody>
                        </table>
                    </div> <!-- card.// -->
            </div>
{{--@endforeach--}}
        </div>

{{--        <section class="mt-5">--}}
{{--            <form action="{{route('charge.payment')}}" method="post" id="payment-form">--}}
{{--                @csrf--}}
{{--                <div class="form-row">--}}
{{--                    <label for="card-element">--}}
{{--                        Credit or debit card--}}
{{--                    </label>--}}
{{--                    <div id="card-element">--}}
{{--                        <!-- A Stripe Element will be inserted here. -->--}}
{{--                    </div>--}}

{{--                    <!-- Used to display form errors. -->--}}
{{--                    <div id="card-errors" role="alert"></div>--}}
{{--                </div>--}}

{{--                <button class="btn-primary">Submit Payment</button>--}}
{{--            </form>--}}
{{--        </section>--}}

    </div>


@endsection

@section('script')

    <script>
        function printfn(){
            window.print();
        }
        // Create a Stripe client.
        var stripe = Stripe('pk_test_aSvXoHFvTnWJ266r2lfaz7bD00mCSf3QKU');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>
@endsection





{{--$(function(){--}}
{{--$('#same-address').on('change', function(){--}}
{{--$('#shipping_address').slideToggle(!this.checked)--}}
{{--})--}}
{{--})--}}
