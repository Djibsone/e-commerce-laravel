@extends('layouts.master')

@section('extra-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('extra-scrip')
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
    <div class="col-md-12">
        <h1>Page de paiement</h1>
        <div class="row">
            <div class="com-md-6">
                <form action="{{ route('checkout.store') }}" method="POST" class="my-4" id="payment-form">
                    {{-- @crsf --}}
                    <div id="card-element">
                    </div>

                    <div id="card-errors" role="alert"></div>

                    <button class="btn btn-success mt-4" id="submit">Procéder au paiement
                        ({{ getPrice(Cart::total()) }})</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script>
        var stripe = Stripe('pk_test_TYooMQauvdEDq54NiTphI7jx');
        var elements = stripe.elements();
        var style = {
            base: {
                color: "#32325d",
                fontFamily: '"Helvetico Neue", Helvetico, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "raab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        };
        var card = elements.create("card", {
            style: style
        });
        card.mount("#card-element");
        card.addEventListener('change', ({
            error
        }) => {
            const displayError = document.getElementById('card-errors');
            if (error) {
                displayError.classList.add('alert', 'alert-warning');
                displayError.textContent = error.message;
            } else {
                displayError.classList.remove('alert', 'alert-warning');
                displayError.textContent = '';
            }
        });
        var submitButton = document.getElementById('submit');

        submitButton.addEventListener('click', function(ev) {
            ev.preventDefault();
            submitButton.disabled = true;
            stripe.confirmCardPayment("{{ $clientSecret }}", {
                payment_method: {
                    card: card
                }
            }).then(function(result) {
                if (result.error) {
                    // Inform the customer that there was an error.
                    submitButton.disabled = false;
                    console.log(result.error.message);
                } else {
                    // Handle next step based on PaymentIntent's status.
                    if (result.paymentIntent.status == 'succeeded') {
                        var paymentIntent = result.paymentIntent;
                        var token = document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content');
                        var form = document.getElementById('payment-form');
                        var url = form.action;

                        fetch(
                            url, {
                                headers: {
                                    "Content-Type": "application/json",
                                    "Accept": "application/json, text-plain, */*",
                                    "X-Requested-with": "XMLHttpRequest",
                                    "X-CSRF-TOKEN": token
                                },
                                method: 'post',
                                body: JSON.stringify({
                                    paymentIntent: paymentIntent
                                })
                            }).then((data) => {
                            if (data.status === 400) {
                                var redirect = '/boutiques';
                            } else {
                                var redirect = '/merci';
                            }
                            window.location.href = redirect;
                        }).catch((error) => {
                            console.log(error)
                        })
                        //console.log(result.paymentIntent);
                    }
                }
            });
        });
    </script>
@endsection
