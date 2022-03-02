@extends('layouts.backend.app')
@section('title', 'Manual Order')
@section('content')
@include('admin-views.order.partials._headerManual')
<div class="container mt--8 mb-5 rtl"
style="text-align:left;">
<div class="row d-flex justify-content-center">
   <div class="col-md-10 col-lg-10">
       <div class="card">
           @if(auth('admin')->check())
               <div class=" p-5">
                   <div class="row">
                       <div class="col-md-12">
                           <h5 style="font-size: 20px; font-weight: 900">Your order successfully processed !</h5>
                       </div>
                   </div>

                   <div class="row mb-4">
                       <div class="col-12">
                           <center>
                               <i style="font-size: 100px; color: #0f9d58" class="fa fa-check-circle"></i>
                           </center>
                       </div>
                   </div>

                   <span class="font-weight-bold d-block mt-4" style="font-size: 17px;">{{('Hello')}}, {{auth('admin')->user()->name}}</span>
                   <span>Your order has been proccessed!</span>

                   <div class="row mt-4 justify-content-between mobile-checkout-complete">
                           {{-- <a href="{{route('home')}}" class="btn btn-primary col-md-4 col-4">
                               {{('go_to_shopping')}}
                           </a> --}}

                       {{-- @if (session()->get('payment') != 'cash_on_delivery' && session()->get('payment_status') != 'success')
                           <form class="needs-validation col-md-4 col-4" target="_blank" method="POST" id="payment-form"
                           action="{{route('xendit-payment.vaInvoice')}}">
                               <input type="hidden" name="type" value="{{ session()->get('payment') }}">
                               <input type="hidden" name="order_id" value="{{ session()->get('orderID') }}">
                               {{ csrf_field() }}
                               <button class="btn btn-danger w-100" id="pay-btn" type="submit" onclick="hidePay()">
                                   {{('pay_now')}}
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
@endsection
