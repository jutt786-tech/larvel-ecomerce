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
            <a href="{{route('admin.category.index')}}"  class="btn btn-sm btn-dark">Category View</a>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">

                </div>

            </div>
        </div>


        <div class="table-responsive">
            <div class="container">
                <form method="post" action="@if(isset($category->id)) {{route('admin.category.update', $category->id)}} @else {{route('admin.category.store')}} @endif ">
                    @if(isset($category->id)) @csrf @method('PUT') @else @csrf  @endif

                    <div class="form-group row">
                        <div class="col-md-8 col-md-offset-2">
                            <label for="Title">Enter title</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"   name="title" value="{{isset($category->title) ? $category->title : ''}} " placeholder="Enter your title">
                            @error('title')
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
                                {{isset($category->description) ? $category->description : ''}}
                            </textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>



                        @if(isset($cat))

                            <div class="form-group row">
                                <div class="col-md-8 col-md-offset-2">
                                    <label for="Title">Enter Category</label>
                                    @if($cat)
                                        <select  name="parent_id[]" class="form-control parent @error('parent_id') is-invalid @enderror" multiple>
                                            <option value="0">Parent</option>
                                            @foreach($cat as $categor)
                                                <option value="{{$categor->id}}"
                                                    {{ isset($category) && in_array($categor->id, $category->children()->pluck('parent_id')->toarray()) ? 'selected' : '' }}
                                                >{{$categor->title}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @error('parent_id')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <div class="form-group row">
                                <div class="col-md-8 col-md-offset-2">
                                    <label for="Title">Enter Category</label>
                                    @if($categories)
                                        <select  name="parent_id" class="form-control parent @error('parent_id') is-invalid @enderror" >
                                            <option value=" ">Parent</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @error('parent_id')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                    <div class="form-group row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" >
{{--                                {{isset($category->id)? 'update' :'Submit'}}--}}
                                @if(isset($cat)) {{'Update'}}   @else {{'SUbmit'}} @endif
                            </button>
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

    </script>
@endsection
