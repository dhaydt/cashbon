@extends('layouts.backend.app')
@section('title', 'Manual Order')
@section('content')
@include('admin-views.order.partials._headerManual')
<style>
.cart_information {
    background: white;
    border-radius: 9px;
    padding: 16px;
}
.cart_information .cart_item {
    box-shadow: 0px 3px 6px #0000000d;
    border-radius: 3px;
}
.media-header {
    min-height: 115px;
    padding-right: 8px;
    padding-left: 8px;
}
.media .media-body-cart {
    min-height: 115px;
}
.cart_product .product-title {
    font-family: 'Roboto', sans-serif !important;
    font-weight: 400 !important;
    font-size: 16px !important;
    position: relative;
    display: inline-block;
    word-wrap: break-word;
    text-transform: capitalize;
    overflow: hidden;
    max-height: 2.4em;
    line-height: 1.2em;
}
.product-title a{
    color: #000;
}
.cart_product .text-accent {
    font-weight: 400 !important;
    font-size: 16px;
}
.btn-link {
    font-weight: 400;
    color: #fe696a;
    text-decoration: none;
}
.cart_total {
    background: #ffffff 0% 0% no-repeat padding-box;
    border-radius: 9px;
    padding: 16px;
}
.cart_total .cart_title {
    font-weight: 400 !important;
    font-size: 16px;
}
</style>
<div class="container row pb-5 mb-2 mt--8 rtl" style="text-align: right;" id="cart-summary">
    @include('admin-views.order.partials.cart_details')
</div>
@endsection
