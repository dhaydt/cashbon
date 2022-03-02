@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
<div class="header bg-gradient-primary pt-3 pb-1">
    <div class="container">
        <div class="header-body text-center mt-7 mb-4">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white">{{ __('Welcome to TigaTech Payment System') }}</h1>
                </div>
            </div>
        </div>
        @if (count($ewallet) != 0)
        <div class="payment-type wallet card w-100">
            <span class="card-header py-1">E-Wallet</span>
            <div class="card-body pb-1 row">
                @foreach ($ewallet as $ewall)
                <div class="col-md-6 mb-4 col-6" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 100px">
                            <a class="btn btn-block" href="{{route('checkout-complete',['payment_method'=>$ewall->name])}}">
                                <img width="150" style="margin-top: -10px"
                                    src="{{asset('assets/front-end/img/'.strtolower($ewall->name).'.png')}}" />
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        @endif

        {{-- Virtual Account --}}
        @if (count($va) != 0)
        <div class="card virtual payment-type w-100">
            <span class="card-header py-1">
                Virtual Account
            </span>
            <div class="card-body row">
                @foreach ($va as $v)

                <div class="col-md-6 mb-4 col-6" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 100px">
                            <a class="btn btn-block" href="{{route('checkout-complete',['payment_method'=>$v->name])}}">
                                <img width="150" style="margin-top: -10px"
                                    src="{{asset('assets/front-end/img/'.strtolower($v->name).'.png')}}" />
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Retail --}}
        @if (count($retail) != 0)
        <div class="card retail payment-type w-100">
            <span class="card-header py-1">Retail</span>
            <div class="card-body row">
                @foreach ($retail as $r)

                <div class="col-md-6 mb-4 col-6" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 100px">
                            <a class="btn btn-block"
                            href="{{route('checkout-complete',['payment_method'=>$r->name])}}">
                            <img width="150" style="margin-top: -10px"
                            src="{{asset('assets/front-end/img/'.strtolower($r->name).'.png')}}" />
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            </div>

        </div>
        @endif

        {{-- Other --}}
        <div class="card other payment-type w-100">
            <span class="card-header py-1">{{('other')}}</span>
            <div class="card-body row">
                <div class="col-md-6 mb-4 col-6" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 100px">
                            <a class="btn btn-block" href="{{route('checkout-complete',['payment_method'=>'QRIS'])}}">
                                <img width="150" style="margin-top: -10px"
                                    src="{{asset('assets/front-end/img/qris-ready.png')}}" />
                            </a>
                        </div>
                    </div>
                </div>

                {{-- @php($config=\App\CPU\Helpers::get_business_settings('cash_on_delivery'))
                @if($config['status']) --}}
                <div class="col-md-6 mb-4 col-6" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 100px">
                            <a class="btn btn-block"
                                href="{{route('checkout-complete',['payment_method'=>'cash_on_delivery'])}}">
                                <img width="150" style="margin-top: -10px"
                                    src="{{asset('assets/front-end/img/cod.png')}}" />
                            </a>
                        </div>
                    </div>
                </div>
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
