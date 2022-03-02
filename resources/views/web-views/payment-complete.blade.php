@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <div class="header bg-gradient-primary py-2 pt-0 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-0 mb-3">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">Your Payment Was Successfully</h1>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-10 col-lg-10">
                    <div class="card">
                        @if(auth('customer')->check())
                            <div class=" p-5 pt-0">
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <center>
                                            <i style="font-size: 100px; color: #0f9d58" class="fa fa-check-circle"></i>
                                        </center>
                                    </div>
                                </div>

                                <span class="font-weight-bold d-block mt-4" style="font-size: 17px;">{{('Hello')}}, {{auth('customer')->user()->f_name}}</span>
                                <span>{{('You payment has been confirmed and will be shipped according to the method you selected!')}}</span>

                                <div class="row mt-4 justify-content-between mobile-checkout-complete">
                                        {{-- <a href="{{route('home')}}" class="btn btn-primary col-md-4 col-4 disabled">
                                            Go Shopping
                                        </a>

                                    @if (session()->get('payment') != 'cash_on_delivery' && session()->get('payment_status') != 'success')
                                        <form class="needs-validation col-md-4 col-4" target="_blank" method="POST" id="payment-form"
                                        action="{{route('payment.vaInvoice')}}">
                                            <input type="hidden" name="type" value="{{ session()->get('payment') }}">
                                            <input type="hidden" name="order_id" value="{{ session()->get('orderID') }}">
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger w-100" id="pay-btn" type="submit" onclick="hidePay()">
                                                Pay Now
                                            </button>
                                        </form>
                                    @endif --}}

                                        {{-- <a href="{{route('account-oder')}}"
                                           class="btn btn-secondary pull-{{Session::get('direction') === "rtl" ? 'left' : 'right'}} col-md-4 col-4">
                                            {{('check_orders')}}
                                        </a> --}}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <div class="container mt--10 pb-5"></div>
@endsection
