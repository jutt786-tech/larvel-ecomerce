
@extends('layouts.app')
@section('sidebar')
    @parent
@endsection
@section('contents')
    <div class="container">

        <div class="row mt-5">
            <div class="col-md-12">
                <section id="cart_items">
                    <div class="container">

                        <div class="breadcrumbs">
                            <ol class="breadcrumb">
                                <li><a href="#">Home</a></li>/
                                <li class="active"><a href="{{asset(url('checkout'))}}">Checkout</a> </li>
                            </ol>
                        </div><!--/breadcrums-->

                        @php $customer = session()->get('customer'); @endphp
                        <div class="review-payment">
                            <h3>Customer Detail</h3>
                            <td><a href="{{route('order_review.invoice',$customer['id'])}} ">Download</a></td>

                        </div>

                        <div class="table-responsive cart_info">
                            <table class="table table-condensed">

                                <tbody>
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">

                                        <tr class="cart_menu">
                                            <td class="image">id</td>
                                            <td class="image">{{$customer['id']}}</td>
                                        </tr>

                                        <tr class="cart_menu">
                                            <td class="image">UserName</td>
                                            <td class="image">{{$customer['username']}}</td>
                                        </tr>

                                        <tr class="cart_menu">
                                            <td class="image">Email</td>
                                            <td class="image">{{$customer['email']}}</td>
                                        </tr>

                                        <tr class="cart_menu">
                                            <td class="image">Adress</td>
                                            <td class="image">{{$customer['billing_address1']}}</td>
                                        </tr>

                                        <tr class="cart_menu">
                                            <td class="image">Country</td>
                                            <td class="image">{{$customer['billing_country']}}</td>
                                        </tr>

                                        <tr class="cart_menu">
                                            <td class="image">State</td>
                                            <td class="image">{{$customer['billing_state']}}</td>
                                        </tr>

                                        <tr class="cart_menu">
                                            <td class="image">Zip</td>
                                            <td class="image">{{$customer['billing_zip']}}</td>
                                        </tr>

                                    </div>
                                </div>

                                </tbody>
                            </table>
                        </div>
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

                        @foreach($orders as   $product)
                            @foreach(json_decode($product->cartdata) as $order)
                                <tr id="cart-data">
                                    <td id="cart-remove" >
                                        <figure class="media">
                                            {{--                                            <div id="cart-img" class="img-wrap"><img src="{{asset('images/'. $order->img)}}" class="img-thumbnail img-sm" width="100" height="70"></div>--}}
                                            <figcaption class="media-body">
                                                <h6 id="cart-pname" class="title text-truncate">{{$order->pname}}</h6>
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
                                            <button type="text" >{{$order->quantity}}</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="totalq">
                                <th  colspan="2">Total Qty: </th>
                                <td id="totalqty">{{$product['totalqty']}}</td>
                            </tr>

                            <tr>
                                <th>
                                    <h6 id="couponName">Discount Coupon</h6>
                                </th>
                                <td><span id="couponValue" class="text-muted">{{$product['coupon']}}</span></td>
                            </tr>

                            <tr class="totalItemAmount">
                                <th colspan="2" >Total Price: </th>
                                <td id="totalItemAmount">
                                    {{$product['totalprice']}}
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div> <!-- card.// -->
            </div>

        </div>

    </div>


@endsection

@section('script')

@endsection





{{--$(function(){--}}
{{--$('#same-address').on('change', function(){--}}
{{--$('#shipping_address').slideToggle(!this.checked)--}}
{{--})--}}
{{--})--}}
