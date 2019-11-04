    @extends('layouts.app')
@section('sidebar')
{{--    @parent--}}
    @include('layouts.partials.sidebar')
@endsection
@section('text')
    <div class="row">
        <div class="col-md-12">
            <section class="jumbotron text-center">
                <div class="container">
                    <h1 class="jumbotron-heading">Album example</h1>
                    <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
                    <p>
                        <a href="#" class="btn btn-primary my-2">Main call to action</a>
                        <a href="#" class="btn btn-secondary my-2">Secondary action</a>
                    </p>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('contents')
    @include('layouts.partials.product')
@endsection

@section('footer')
    @include('layouts.partials.footer')
@endsection

@section('script')
    <script>
        $(function(){

            $(".addtocart").click(function (e) {
                e.preventDefault();
                var product_id =  $(this).attr("data-id"); //get product attributes id
                $.ajax({
                    url: '{{ url('products/addToCart')}}/'+product_id,
                    method: "GET",
                    id: product_id,
                    dataType: 'JSON',
                    data: {_token: '{{ csrf_token() }}', id: product_id},
                    success: function (response) {
                        console.log(response);
                        swal({
                            title: "Added!",
                            text: response.message,
                            type: "success",
                            timer: 2000
                        });

                        $('#count').empty()
                            .append('CART '+Object.keys(response.cart).length);
                    }

                });
            });
        });







        //strt old code

        // $('.acnav__label').click(function () {
        //     var label = $(this);
        //     var parent = label.parent('.has-children');
        //     var list = label.siblings('.acnav__list');
        //
        //     if ( parent.hasClass('is-open') ) {
        //         list.slideUp('fast');
        //         parent.removeClass('is-open');
        //     }
        //     else {
        //         list.slideDown('fast');
        //         parent.addClass('is-open');
        //     }
        // });
        // ==============



    </script>
@endsection
