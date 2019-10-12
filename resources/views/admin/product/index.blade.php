@extends('admin.app')

@section('admin_css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin.css')}}">
@endsection

@section('content')

    @include ('admin.partials.navbar')
    @include ('admin.partials.sidebar')


    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Product Table</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    {{--            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>--}}
                    {{--            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>--}}
                </div>
                <a href="{{route('admin.product.create')}}" class="btn btn-dark btn-sm">Add Product</a>
                {{--          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">--}}
                {{--            <span data-feather="calendar"></span>--}}
                {{--            This week--}}
                {{--          </button>--}}
            </div>
        </div>

        <div class="col-md-12">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                </div>
                @endif
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Discoun&%</th>
                    <th>Discount Price</th>
                    <th>Category</th>
                    <th>Images</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->pname}}</td>
                        <td>{!! $product->description !!}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->discount}}%</td>
                        <td>{{$product->discount_price}}</td>
                        <td>
                            @foreach($product->categories as $category)
                                {{$category->title}},
                            @endforeach
                        </td>
                        <td><img src="{{asset('images/'.$product->img)}}" width="100" height="70"></td>
                        <td><a class="btn btn-primary btn-sm" href="{{url('product',$product->id)}}/edit" >Edit</a> |
                            <form method="post" action="{{url('product')}}/{{$product->id}}">
                                @csrf
                                @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"  > Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </main>
    </div>
    </div>

    <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script> -->

@endsection
