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
        <div class="card table-responsive">
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
                        <input type="hidden" value="{{$total += $product['price'] * $product['quantity']}}">
                        <input type="hidden" value="{{$totalQty += $product['quantity'] }}">

                    <tr>
                        <td>
                            <figure class="media">
                                <div class="img-wrap"><img src="{{asset('images/'.$product['img'])}}" class="img-thumbnail img-sm" width="100" height="70"></div>
                                <figcaption class="media-body">
                                    <h6 class="title text-truncate">{{$product['pname']}}</h6>
                                    <dl class="param param-inline small">
{{--                                        <dt>Size: </dt>--}}
{{--                                        <dd>XXL</dd>--}}
                                    </dl>
                                    <dl class="param param-inline small">
{{--                                        <dt>Color: </dt>--}}
{{--                                        <dd>Orange color</dd>--}}
                                    </dl>
                                </figcaption>
                            </figure>
                        </td>
                        <td>
{{--                            {{url('cart/update',$product['product'])}}--}}
{{--                            <form method="POST" action="" >--}}
{{--                                @csrf--}}
                                <input type="number" name="qty" dataup-id="{{ $id }}" class="form-control text-center quantity update-cart" min="0" max="99" value="{{$product['quantity']}}">
{{--                                <input type="submit" name="update" value="Update" class="btn btn-block btn-outline-success btn-round">--}}
{{--                            </form>--}}

                        </td>
                        <td>
                            <div class="price-wrap">
                                <span  class="price">USD{{$product['price'] * $product['quantity']  }}</span>
                                <small class="text-muted">USD{{$product['price']}} </small>
                            </div> <!-- price-wrap .// -->
                        </td>
                        <td class="text-right">
                            <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}">Remove</button>

                            {{--                            <form action="{{url('cart/remove',1)}}" method="POST" accept-charset="utf-8">--}}
{{--                                @csrf--}}
{{--                                <input type="submit" name="remove" value="x Remove" class="btn btn-outline-danger"/>--}}
{{--                            </form>--}}
{{--                            <a href="{{url('cart/remove',$pname)}}" class="btn btn-outline-danger">X Remove</a>--}}
                        </td>
                    </tr>

                @endforeach
                <tr>
                    <th colspan="2">Total Qty: </th>
                    <td>{{$totalQty}}</td>
                </tr>
                <tr>
                    <th colspan="2">Total Price: </th>
                    <td>{{$total}}</td>
                    <td>
                    <td class="text-right">
                        <a href="{{url('checkout')}}" class="btn btn-dark btn-lg " >checkout</a>
                    </td>
                    </td>
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

        $(".update-cart").click(function (e) {
            e.preventDefault();
            var pid        = $(this).attr("dataup-id");
            var quantity   =  $(this).parents("tr").find(".quantity").val();

            $.ajax({
                url: '{{ url('cart/update') }}',
                method: "patch",
                data: {_token: '{{ csrf_token() }}', id: pid, quantity: quantity},
                success: function (data) {
                    // console.log(data);
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var removeid = $(this).attr("data-id");
            if(confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('cart/remove') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: removeid},
                    success: function (response) {
                        returen (response);
                        // window.location.reload();
                    }
                });
            }
        });

        </script>

    @endsection
