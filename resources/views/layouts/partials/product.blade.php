<main role="main">

    <div class="album py-5 bg-light">
        <div class="container">
            <h2>All Products</h2>
            <div class="row">
                @if(isset($products)  && count($products) > 0)

                @foreach($products as $product)
                <div class="col-md-4">

                    <div class="card mb-4 shadow-sm">

                        <img class="card-img-top img-thumbnail" src="{{asset('images/'.$product->img)}}" >
                        <div class="card-body">
                            <h4 class="card-title">{{$product->pname}}</h4>
                            <p class="card-text">{!! $product->description !!}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group addto">
                                    <a href="{{route('products.single',$product->id)}}" type="button" class="btn btn-sm btn-outline-secondary">View Product</a>
                                    <a data-id="{{$product->id}}" href="javscript(0)" type="button" class="btn btn-success btn-sm btn-outline-secondary addtocart ">Add to Cart</a>
                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
                    @endforeach
                @else
                    <div class="col-md-12">
                    <div class="aler alert-info text-center font-weight-bold">No More Post</div>

                    </div>
                @endif
            </div>
        </div>
    </div>

</main>
