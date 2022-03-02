@extends('layouts.backend.app')
@section('title', 'Manual Order Service')
@section('content')
@include('admin-views.order.service.partials._headerManual')
<style>

</style>
<div class="content container-fluid">
  <!-- Content Row -->
  <div class="row gx-2 gx-lg-3 mt--8">
    <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
      <div class="card">
        {{-- <div class="card-header">
          coupon_form')}}
        </div> --}}
        <section class="container rtl">
          <!-- Heading-->
          <div class="section-header pt-2">
            <div class="feature_header">
              <span class="for-feature-title">Service</span>
            </div>
          </div>

          <div class="row product-wrapper p-4">
            {{-- @foreach($product as $product) --}}
            {{-- @if($key<12) --}} <div class="product-item px-0  col-12 h-100"
              style="margin-bottom: 10px">
              @include('admin-views.order.service.partials._single-product',['product'=>$product])
          </div>
          {{-- @endif --}}
          {{-- @endforeach --}}
      </div>
      </section>
    </div>
  </div>
</div>
</div>
@endsection
