@extends('layouts.app')
@section('sidebar')
    @parent
    @endsection
@section('contents')
    <div class="row">
        <div class="col-md-4 ml-auto order-md-2 mb-4">

            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">getTotalQty</span>
            </h4>
            <ul class="list-group mb-3">
                @php $totalQty = 0; $totalPrice = 0;    @endphp
                @foreach($carts as $pname => $product)
                    <input type="hidden" value="{{$totalPrice += $product['price'] * $product['quantity']}}">
                    <input type="hidden" value="{{$totalQty +=  $product['quantity']}}">

                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">{{$product['pname']}}</h6>
                            <small class="text-muted">{{$product['quantity']}}</small>
                        </div>
                        <span class="text-muted">{{$product['price'] * $product['quantity']}}</span>
                    </li>

                @endforeach

                <li class="list-group-item d-flex justify-content-between">
                    <span>{{$totalQty}} </span>
                    <strong>$Total Qty</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    <span>{{Session::get('coupon')['cvalue']}} </span>
                    <strong>$Coupon Code</strong>
                </li>


                <li class="list-group-item d-flex justify-content-between">
                    <span>{{$totalPrice}} </span>
                    <strong>$Sub Total</strong>
                </li>


                <li class="list-group-item d-flex justify-content-between">
                    <span>$ @if(isset(session()->get('coupon')['totalsum']))
                            {{ $totalPrice - session()->get('coupon')['cvalue'] }}
                        @else
                            {{$totalPrice}}
                        @endif </span>
                    <strong>$Total Price</strong>
                </li>
            </ul>

        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Billing address</h4>
            <form class="needs-validation" novalidate="" id="payment-form" action="{{route('checkout.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">First name</label>
                        <input type="text" name="billing_firstName" class="form-control" id="firstName" placeholder="" value="" required="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                        @if($errors->has('billing_firstName'))
                            <div class="alert alert-danger">
                                {{$errors->first('billing_firstName')}}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last name</label>
                        <input type="text" name="billing_lastName" class="form-control" id="lastName" placeholder="" value="" required="">
                        @if($errors->has('billing_lastName'))
                            <div class="alert alert-danger">
                                {{$errors->first('billing_lastName')}}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input name="username" type="text" class="form-control" id="username" placeholder="Username" required="">
                        @if($errors->has('username'))
                            <div class="alert alert-danger">
                                {{$errors->first('username')}}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email">Email <span class="text-muted">(Optional)</span></label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com">
                    @if($errors->has('email'))
                        <div class="alert alert-danger">
                            {{$errors->first('email')}}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" name="billing_address1" class="form-control" id="address" placeholder="1234 Main St" required="">
                    @if($errors->has('billing_address1'))
                        <div class="alert alert-danger">
                            {{$errors->first('billing_address1')}}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="address2">Address Line 2 <span class="text-muted">(Optional)</span></label>
                    <input type="text"name="billing_address2" class="form-control" id="address2" placeholder="Apartment or suite">
                    @if($errors->has('billing_address2'))
                        <div class="alert alert-danger">
                            {{$errors->first('billing_address2')}}
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="country">Country</label>
                        <select name="billing_country" class="custom-select d-block w-100" id="country" required="">
                            <option value="">Choose...</option>
                            <option>United States</option>
                        </select>
                        @if($errors->has('billing_country'))
                            <div class="alert alert-danger">
                                {{$errors->first('billing_country')}}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="state">State</label>
                        <select name="billing_state" class="custom-select d-block w-100" id="state" required="">
                            <option value="">Choose...</option>
                            <option>California</option>
                        </select>
                        @if($errors->has('billing_state'))
                            <div class="alert alert-danger">
                                {{$errors->first('billing_state')}}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zip">Zip</label>
                        <input name="billing_zip" type="text" class="form-control" id="zip" placeholder="" required="">
                        @if($errors->has('billing_zip'))
                            <div class="alert alert-danger">
                                {{$errors->first('billing_zip')}}
                            </div>
                        @endif
                    </div>
                </div>
                <hr class="mb-4">
                <div class="custom-control custom-checkbox">
                    <input name="shipping_address"  type="checkbox" class="custom-control-input" id="same-address">
                    <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="save-info">
                    <label name="guest" class="custom-control-label" for="save-info">Checkout as Guest</label>
                </div>


                <div id="shipping_address" class="col-md-12 order-md-1">
                    <hr class="mb-4">
                    <h4 class="mb-3">Shipping address</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">First name</label>
                            <input name="shipping_firstName" type="text" class="form-control" id="firstName" placeholder="" value="" required="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Last name</label>
                            <input type="text" name="shipping_lastName" class="form-control" id="lastName" placeholder="" value="" required="">

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" name="shipping_address1" class="form-control" id="address" placeholder="1234 Main St" required="">
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address2">Address Line 2<span class="text-muted">(Optional)</span></label>
                        <input type="text" name="shipping_address2" class="form-control" id="address2" placeholder="Apartment or suite">
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="country">Country</label>
                            <select name="shipping_country" class="custom-select d-block w-100" id="country" required="">
                                <option value="">Choose...</option>
                                <option>United States</option>
                            </select>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="state">State</label>
                            <select name="shipping_state" class="custom-select d-block w-100" id="state" required="">
                                <option value="">Choose...</option>
                                <option>California</option>
                            </select>

                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="zip">Zip</label>
                            <input type="text" name="shipping_zip" class="form-control" id="zip" placeholder="" required="">

                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <section class="mt-5">
{{--                    <form action="{{route('charge.payment')}}" method="post" id="payment-form">--}}
                        @csrf
                        <div class="form-row">
                            <label for="card-element">
                                Credit or debit card
                            </label>
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>

                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>
                        </div>

                        <button class="btn-primary">Submit Payment</button>
{{--                    </form>--}}
                </section>
{{--                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>--}}
            </form>
        </div>
    </div>

@endsection
@section('script')
    <script>
        // Create a Stripe client.
        var stripe = Stripe('pk_test_aSvXoHFvTnWJ266r2lfaz7bD00mCSf3QKU');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }

        $(function(){
            $('#same-address').on('change', function(){
                $('#shipping_address').slideToggle(!this.checked)
            })
        })

    </script>
@endsection







{{--$(function(){--}}
{{--$('#same-address').on('change', function(){--}}
{{--$('#shipping_address').slideToggle(!this.checked)--}}
{{--})--}}
{{--})--}}
