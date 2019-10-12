 @extends('admin.app')

 @section('admin_css')
<link rel="stylesheet" type="text/css" href="{{asset('css/admin.css')}}">
 @endsection

@section('content')

 @include ('admin.partials.navbar')
 @include ('admin.partials.sidebar')

 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Category Table</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">

          </div>
            <a href="{{route('admin.category.create')}}"  class="btn btn-sm badge-dark"> Add New </a>

        </div>
      </div>
     <div class="col-md-12">
     @if(Session()->has('message'))
         <div class="alert alert-success">
             {{Session('message')}}
         </div>
     @endif
     </div>

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#ID</th>
              <th>Title</th>
              <th>description</th>
                <th>Category</th>
                <th>Date Created</th>
              <th>Action</th>

            </tr>
          </thead>
          <tbody>

          @if($categories->count() > 0 )
          @foreach($categories as $category)
            <tr>
              <td>{{$category->id}}</td>
              <td>{{$category->title}}</td>
              <td>{!!$category->description !!} </td>
                <td>
                @if($category->children()->count() > 0)
                    @foreach($category->children as $child)
                        {{$child->title}},
                    @endforeach
                @else
                    <strong>Parent Category</strong>
                    @endif
                </td>

              <td>{{$category->created_at}}</td>
                <td><a class="btn btn-primary btn-sm" href="{{url('category')}}/{{$category->id}}/edit">Edite</a>|

                </td>

                <td>
                    <form method="post" action="{{url('category', $category->id)}}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" >Delete</button>
                    </form>
                </td>



            </tr>
            @endforeach
              @else
          <tr>
              <td colspan="5">Category no recor</td>
          </tr>
          @endif
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>

       <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script> -->


@endsection
