@extends('admin.app')

@section('admin_css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin.css')}}">
@endsection

@section('content')

    @include ('admin.partials.navbar')
    @include ('admin.partials.sidebar')


    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            {{--<h1 class="h2"></h1>--}}
            <a href="{{route('admin.product.index')}}"  class="btn btn-sm btn-dark">Product View</a>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                </div>
            </div>
        </div>


        <div class="table-responsive">
            <div class="container">
                <form method="post" action="@if(isset($product->id))  {{route('admin.product.update',$product->id)}}
                @else {{route('admin.product.store')}} @endif" enctype="multipart/form-data">

                @if(isset($product->id)) @csrf @method('PUT') @else @csrf  @endif



                    <div class="form-group row">
                        <div class="col-md-8 col-md-offset-2">
                            <label for="Title">Enter Product</label>
                            <input id="pname" type="text" class="form-control @error('pname') is-invalid @enderror"  value="{{isset($product->pname) ? $product->pname : ''}}"  name="pname"  placeholder="Enter your title">
                            @error('pname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-8 col-md-offset-2">
                            <label for="Title">Enter Discription</label>
                            <textarea   id="editor" type="text" cols="5" rows="12" class="form-control @error('description') is-invalid  @enderror" name="description" value="" placeholder="Enter your Discription">
                            {{isset($product->description) ? $product->description : ''}}
                            </textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-8 col-md-offset-2">
                            <label for="price">Enter Price</label>
                            <input id="price" value="{{isset($product->price) ? $product->price : ''}}" type="tel" class="form-control @error('price') is-invalid @enderror"   name="price"  placeholder="Enter Price">
                            @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-8 col-md-offset-2">
                            <label for="discount">Discount</label>
                            <input id="discount"  value="{{isset($product->discount) ? $product->discount : ''}}" type="text" class="form-control @error('discount') is-invalid @enderror"   name="discount"  placeholder="Enter your Discount">
                            @error('discount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-8 col-md-offset-2">
                            <label for="discount_price">Discount Price</label>
                            <input id="net" readonly onClick="sum()" value="{{isset($product->discount_price) ? $product->discount_price : ''}}" type="text" class="form-control @error('discount_price') is-invalid @enderror"   name="discount_price"  placeholder="Enter your discount_price">
                            @error('discount_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>
                    @if(isset($categories))
                        <div class="form-group row">
                            <div class="col-md-8 col-md-offset-2">
                                <label for="Title">Enter category</label>
                                <select class="form-control @error('category') is-invalid @enderror" name="category[]" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}"
                                        {{isset($product) && in_array($category->id, $product->categories()->pluck('category_id')->toArray()) ? 'selected' : '' }}
                                        >{{$category->title}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror

                            </div>
                        </div>
                        @else
                        <div class="form-group row">
                            <div class="col-md-8 col-md-offset-2">
                                <label for="Title">Enter category</label>
                                <select class="form-control @error('category') is-invalid @enderror" name="category[]" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror

                            </div>
                        </div>

                        @endif

                    <div class="form-group row">
                        <div class="col-md-8 col-md-offset-2">
                            <label for="img">Image Upload</label>
                            <input name="img" id="img" type="file" class="form-control @error('img') is-invalid @enderror" placeholder="upload image" >
                            @error('img')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" >{{isset($product->id) ? 'Update' : 'Submit'}}</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </main>
    </div>
    </div>

    <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script> -->


@endsection
@section('js')
    <script type="text/javascript">

        $(function () {
            ClassicEditor
                .create( document.querySelector( '#editor' ), {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                        ]
                    }
                } )
                .catch( error => {
                    console.log( error );
                } );

            // $('.parent').select2({
            //     placeholder: 'This is my placeholder',
            //     allowClear: true,
            //     maximumSelectionLength: 5,
            //     theme: "classic"
            //
            // });




        });

        function sum()
        {
            a=Number(document.getElementById("price").value);
            b=Number(document.getElementById("discount").value);

            c=a-(Number(a)*Number(b)/100);
            document.getElementById("net").value=c;

        }

    </script>
@endsection
