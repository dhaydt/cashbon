<style>
    .cart_title {
        font-weight: 400 !important;
        font-size: 16px;
    }

    .cart_total_value {
        color: {{$web_config['primary_color']}}     !important;
        font-weight: 700 !important;
        font-size: 25px !important;
    }

    .cart_value {
        font-weight: 600 !important;
        font-size: 16px;
    }
</style>

<aside class="col-lg-12 pt-4 pt-lg-0 px-0">
    <div class="cart_total">
        @php($sub_total=0)
        @php($total_tax=0)
        @php($total_shipping_cost=0)
        @php($total_discount_on_product=0)
        @php($cart=\App\CPU\CartManager::get_cart())
        @php(session(['cart_group_id' => $cart[0]['cart_group_id']]))
        {{-- {{ dd(session()) }} --}}
        {{-- @php($shipping_cost=\App\CPU\CartManager::get_shipping_cost()) --}}
        @if($cart->count() > 0)
            @foreach($cart as $key => $cartItem)
            {{-- {{ dd($cartItem['tax']) }} --}}
                @php($sub_total+=$cartItem['price']*$cartItem['quantity'])
                @php($total_tax+=$cartItem['tax']*$cartItem['quantity'])
                @php($total_discount_on_product+=$cartItem['discount']*$cartItem['quantity'])
            @endforeach
            {{-- @php($total_shipping_cost=$shipping_cost) --}}
        @else
            <span>{{('empty_cart')}}</span>
        @endif
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{('sub_total')}}</span>
            <span class="cart_value">
                {{\App\CPU\Helpers::currency_converter($sub_total)}}
            </span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{('tax')}}</span>
            <span class="cart_value">
                {{\App\CPU\Helpers::currency_converter($total_tax)}}
            </span>
        </div>
        {{-- @if (!Request::is('shop-cart'))
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{('shipping')}}</span>
            <span class="cart_value">
                {{\App\CPU\Helpers::currency_converter($total_shipping_cost)}}
            </span>
        </div>
        @endif --}}
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{('discount_on_product')}}</span>
            <span class="cart_value">
                - {{\App\CPU\Helpers::currency_converter($total_discount_on_product)}}
            </span>
        </div>
        @if(session()->has('coupon_discount'))
          <div class="d-flex justify-content-between">
              <span class="cart_title">{{('coupon_code')}}</span>
              <span class="cart_value" id="coupon-discount-amount">
                  - {{session()->has('coupon_discount')?\App\CPU\Helpers::currency_converter(session('coupon_discount')):0}}
              </span>
          </div>
          @php($coupon_dis=session('coupon_discount'))
      @else
      @if (!Request::is('shop-cart'))
          <div class="mt-2">
              <form class="needs-validation" method="post" novalidate id="coupon-code-ajax">
                  <div class="form-group">
                      <input class="form-control input_code" type="text" name="cod" placeholder="{{('Coupon code')}}"
                             required>
                             <input type="hidden" class="hiddenCoupon" name="code">
                      <div class="invalid-feedback">{{('please_provide_coupon_code')}}</div>
                  </div>
                  <button class="btn btn-primary btn-block" type="button" onclick="couponCode()">{{('apply_code')}}
                  </button>
              </form>
          </div>
          @endif
          @php($coupon_dis=0)
      @endif
      <hr class="mt-2 mb-2">
      <div class="d-flex justify-content-between">
          <span class="cart_title">{{('total')}}</span>
          <span class="cart_value">
             {{\App\CPU\Helpers::currency_converter($sub_total+$total_tax-$coupon_dis-$total_discount_on_product)}}
          </span>
      </div>
      @if (!Request::is('checkout-details'))
      <div class="d-flex justify-content-center">
          <span class="cart_total_value mt-2">
              {{\App\CPU\Helpers::currency_converter($sub_total+$total_tax-$coupon_dis-$total_discount_on_product)}}
          </span>
      </div>
      @endif
  </div>
    {{-- <div class="container mt-2 d-none">
        <div class="row p-0">
            <div class="col-md-3 p-0 text-center mobile-padding">
                <img style="height: 29px;" src="{{asset("public/assets/front-end/png/delivery.png")}}" alt="">
                <div class="deal-title">3 {{('days')}} <br><span>{{('free_delivery')}}</span></div>
            </div>

            <div class="col-md-3 p-0 text-center">
                <img style="height: 29px;" src="{{asset("public/assets/front-end/png/money.png")}}" alt="">
                <div class="deal-title">{{('money_back_guarantee')}}</div>
            </div>
            <div class="col-md-3 p-0 text-center">
                <img style="height: 29px;" src="{{asset("public/assets/front-end/png/Genuine.png")}}" alt="">
                <div class="deal-title">100% {{('genuine')}}<br><span>{{('product')}}</span></div>
            </div>
            <div class="col-md-3 p-0 text-center">
                <img style="height: 29px;" src="{{asset("public/assets/front-end/png/Payment.png")}}" alt="">
                <div class="deal-title">{{('authentic_payment')}}</div>
            </div>
        </div>
    </div> --}}
</aside>
@push('script')
    <script>
        $(".input_code").on("input", function() {
            // console.log($(this).val())
            $(".hiddenCoupon").val($(this).val())
        });
    </script>
@endpush
