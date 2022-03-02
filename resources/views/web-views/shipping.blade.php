@extends('layouts.app', ['class' => 'bg-default'])
<style>
    .card-header img{
        height: 30px;
    }
</style>
@section('content')
<div class="header bg-gradient-primary pt-3 pb-1">
    <div class="container mb-8">
        <div class="header-body text-center mt-7 mb-4">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white">{{ __('Welcome to TigaTech Shipping Service') }}</h1>
                </div>
            </div>
        </div>
        <div class="payment-type wallet card w-100">
            <span class="card-header py-1">Shipping Options</span>
            @php($shippings=\App\CPU\Helpers::get_shipping_methods())
            <div class="card-body pb-1 row">
                @foreach ($shippings[0] as $ship)
                {{-- {{ dd($ship[0]) }} --}}
                <div class="col-md-6 mb-4 col-6 d-flex justify-content-center" style="cursor: pointer">
                    <div class="card">
                        <div class="card-header">
                            <img src="{{ asset('assets/front-end/img/'.$ship[0]['code'].'.png') }}" alt="">
                        </div>
                        <div class="card-body">
                            @foreach ($ship[0]['costs'] as $cost)
                            {{-- {{ dd($cost) }} --}}
                                <li>Service : {{ $cost['service'] }}</li>
                                <span class="ml-4">Cost : {{ $cost['cost'][0]['value'] }}</span><br>
                                <span class="ml-4">Estimation : {{ $cost['cost'][0]['etd'].' days' }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
    <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
            xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
</div>

<div class="container mt--10 pb-5"></div>
@endsection
