 @extends('admin.app')

 @section('admin_css')
<link rel="stylesheet" type="text/css" href="{{asset('css/admin.css')}}">
 @endsection

@section('content')

 @include ('admin.partials.navbar')
 @include ('admin.partials.sidebar')


{{-- <div class="jumbotron">--}}


{{-- </div>--}}





    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <h1 class="h2">Dashboard</h1>
        <div class="row ">
            <div class="col-md-3">
                <div class="card border-info mx-sm-1 p-3">
                    <div class="card border-info shadow text-info p-3 my-card" ><span class="fa fa-car" aria-hidden="true"></span></div>
                    <div class="text-info text-center mt-3"><h4>Cars</h4></div>
                    <div class="text-info text-center mt-2"><h1>234</h1></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-success mx-sm-1 p-3">
                    <div class="card border-success shadow text-success p-3 my-card"><span class="fa fa-eye" aria-hidden="true"></span></div>
                    <div class="text-success text-center mt-3"><h4>Eyes</h4></div>
                    <div class="text-success text-center mt-2"><h1>9332</h1></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-danger mx-sm-1 p-3">
                    <div class="card border-danger shadow text-danger p-3 my-card" ><span class="fa fa-heart" aria-hidden="true"></span></div>
                    <div class="text-danger text-center mt-3"><h4>Hearts</h4></div>
                    <div class="text-danger text-center mt-2"><h1>346</h1></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-warning mx-sm-1 p-3">
                    <div class="card border-warning shadow text-warning p-3 my-card" ><span class="fa fa-inbox" aria-hidden="true"></span></div>
                    <div class="text-warning text-center mt-3"><h4>Inbox</h4></div>
                    <div class="text-warning text-center mt-2"><h1>346</h1></div>
                </div>
            </div>
        </div>

    {{--      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">--}}
{{--        <h1 class="h2">Dashboard</h1>--}}
{{--        <div class="btn-toolbar mb-2 mb-md-0">--}}
{{--          <div class="btn-group mr-2">--}}
{{--            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>--}}
{{--            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>--}}
{{--          </div>--}}
{{--          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">--}}
{{--            <span data-feather="calendar"></span>--}}
{{--            This week--}}
{{--          </button>--}}
{{--        </div>--}}
{{--      </div>--}}

<!--       <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
 -->

    </main>
  </div>
</div>

       <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script> -->


@endsection
