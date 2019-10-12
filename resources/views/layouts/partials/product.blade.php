<main role="main">

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
{{--                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>--}}
                        <img class="card-img-top img-thumbnail" src="{{asset('images/'.$product->img)}}" >
                        <div class="card-body">
                            <h4 class="card-title">{{$product->pname}}</h4>
                            <p class="card-text">{!! $product->description !!}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="{{route('products.single',$product->id)}}" type="button" class="btn btn-sm btn-outline-secondary">View Product</a>
                                    <a href="{{route('products.addToCart',$product)}}" type="button" class="btn btn-sm btn-outline-secondary">Add to Cart</a>
                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

</main>
