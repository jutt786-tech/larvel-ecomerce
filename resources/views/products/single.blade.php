@extends('layouts.app')
@section('sidebar')
    @parent
    @endsection
@section('contents')
<main role="main">

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4 shadow-sm">
                            <div class="row">
                                <div class="col-md-4">
                                    <img class=" img-thumbnail" src="{{asset('images/'.$product->img)}}" >
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h4 class="card-title">{{$product->pname}}</h4>
                                        <p class="card-text">{!! $product->description !!}</p>
                                        <div class="d-block justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <a href="{{route('products.addToCart',$product)}}" type="button" class="btn btn-sm btn-outline-secondary">Add to Cart</a>
                                            </div>
                                            <p class="text-muted">9 mins</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

            </div>
        </div>
    </div>

</main>
    @endsection
