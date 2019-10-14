<div class="container">
    <div class="row py-5">
        <div class="col-md-12 col-sm-3">
            <div class="card bg-light mb-3">
                <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-list"></i> Categories</div>
                <ul class="list-group category_block ">

                    @foreach($categories as $category)
                        <li class="list-group-item "><a href="#">{{$category->title}}</a></li>
                  @endforeach
                </ul>
            </div>
{{--            {{dd($lastproducts)}}--}}
{{--        @if(isset($lastproducts))--}}
            <div class="card bg-light mb-3">
                <div class="card-header bg-success text-white text-uppercase">Last product</div>
                <div class="card-body">
                    <img class="img-fluid" src="{{asset('images/'.$lastproducts->img)}}" width="600" height="400"/>
                    <h5 class="card-title">{{$lastproducts->pname}}</h5>
                    <p class="card-text">{!! $lastproducts->description !!}</p>
                    <p class="bloc_left_price">{{$lastproducts->price }}$</p>
                </div>
{{--                <div class="col-md-12">--}}
{{--                    <a href="{{route('products.addToCart',$product->id)}}" class="btn btn-success btn-block">Add to cart</a>--}}
{{--                </div>--}}
            </div>
        </div>
{{--        @endif--}}
    </div>
</div>
