@extends('layouts.app')
@section('sidebar')
    @parent
@endsection
@section('contents')
<div class="container-fluid">
<main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">User Order</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">

            </div>
<!--            <a href="{{route('admin.category.create')}}"  class="btn btn-sm badge-dark"> Add New </a>-->

        </div>
    </div>
<!--    <div class="col-md-12">-->
<!--        @if(Session()->has('message'))-->
<!--        <div class="alert alert-success">-->
<!--            {{Session('message')}}-->
<!--        </div>-->
<!--        @endif-->
<!--    </div>-->

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#ID</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>Adress</th>
                <th>TotalQty</th>
                <th>Totalprice</th>
                <th>Status</th>
                <th>Date Created</th>
                <th>Action</th>

            </tr>
            </thead>
            <tbody>

            @if($orders->count() > 0 )
            @foreach($orders as $category)
{{--                {{dd($category->user->name)}}--}}
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->user->name}}</td>
                <td>{{ $category->user->email }} </td>
                <td>{{ $category->customer->billing_address1 }} </td>
                <td>{{ $category->totalqty }} </td>
                <td>{{ $category->totalprice }} </td>
                <td>{{ $category->status }} </td>
                <td>{{ $category->created_at }} </td>

                <td><a class="btn btn-primary btn-sm" href="{{route('single',$category->id )}}">View Inv</a>
{{--                    |<a class="btn btn-danger btn-sm" href="{{url('order_review')}}">View Inv</a>--}}

                </td>

{{--<!--                <td>-->--}}
{{--<!--                    <form method="post" action="{{url('category', $category->id)}}">-->--}}
{{--<!--                        @csrf @method('DELETE')-->--}}
{{--<!--                        <button type="submit" class="btn btn-danger btn-sm" >Delete</button>-->--}}
{{--<!--                    </form>-->--}}
{{--<!--                </td>-->--}}



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
<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script> -->
@endsection

