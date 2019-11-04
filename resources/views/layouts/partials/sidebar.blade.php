<div class="container">
    <div class="row py-5">
        <div class="col-md-12 col-sm-3">
            <div class="card bg-light mb-3">
                <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-list"></i> Categories</div>

                <ul class="mtree transit">
                    @foreach ($categories as $category)
                    <li><a href="#">{{$category->title}}</a>
                        <ul>
                            @foreach ($category->childrenCategories as $childCategory)
                                @include('layouts.partials.child_category', ['child_category' => $childCategory])
                            @endforeach

                        </ul>
                    </li>

                   @endforeach
                </ul>






            <!-- start accordion nav block -->
{{--                <nav class="acnav" role="navigation">--}}
{{--                    <!-- start level 1 -->--}}
{{--                    <ul class="acnav__list acnav__list--level1">--}}
{{--                    @foreach ($categories as $category)--}}
{{--                        <!-- start group 1 -->--}}
{{--                        <li class="has-children">--}}
{{--                            <div class="acnav__label">--}}
{{--                                {{$category->title}}--}}
{{--                            </div>--}}
{{--                            <!-- start level 2 -->--}}
{{--                            <ul class="acnav__list acnav__list--level2">--}}

{{--                                @foreach ($category->childrenCategories as $childCategory)--}}
{{--                                    @include('layouts.partials.child_category', ['child_category' => $childCategory])--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </nav>--}}
                <!-- end accordion nav block -->





            </div>
{{--            {{dd($lastproducts)}}--}}
        @if($lastproducts)
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
            @else
            <div  class="alert alert-danger"> products is empty</div>

            @endif
        </div>
{{--        @endif--}}
    </div>
</div>
