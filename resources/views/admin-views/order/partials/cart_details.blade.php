<section class="col-md-8">
    @php($cart=\App\Models\Cart::where(['customer_id' => auth('admin')->id()])->get()->groupBy('cart_group_id'))
    <div class="cart_information">
        @foreach($cart as $group_key=>$group)
            @foreach($group as $cart_key=>$cartItem)
            <div class="cart_item mb-2">
                <div class="row">
                    <div class="col-md-7 col-sm-6 col-9 d-flex align-items-center">
                        <div class="media">
                            <div
                                class="media-header d-flex justify-content-center align-items-center {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}">
                                <a href="javascript:">
                                    @if ($cartItem['type'] == 'service')
                                    <img style="height: 82px;"
                                         onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                         src="{{\App\CPU\ProductManager::service_image_path('thumbnail')}}/{{$cartItem['thumbnail']}}"
                                         alt="Product">
                                    @else
                                    <img style="height: 82px;"
                                         onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                         src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$cartItem['thumbnail']}}"
                                         alt="Product">
                                    @endif
                                </a>
                            </div>

                            <div class="media-body-cart d-flex justify-content-center align-items-center">
                                <div class="cart_product">
                                    <div class="product-title">
                                        <a href="javascript:">{{$cartItem['name']}}</a>
                                    </div>
                                    <div
                                        class=" text-accent">{{ \App\CPU\Helpers::currency_converter($cartItem['price']-$cartItem['discount']) }}</div>
                                    @if($cartItem['discount'] > 0)
                                        <strike style="font-size: 12px!important;color: grey!important;">
                                            {{\App\CPU\Helpers::currency_converter($cartItem['price'])}}
                                        </strike>
                                    @endif
                                    {{-- @foreach(json_decode($cartItem['variations'],true) as $key1 =>$variation)
                                        <div class="text-muted"><span
                                                class="mr-2">{{$key1}} :</span>{{$variation}}
                                        </div>
                                    @endforeach --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-2 col-3 d-flex align-items-center">
                        <div>
                            <select name="quantity[{{ $cartItem['id'] }}]" id="cartQuantity{{$cartItem['id']}}"
                                    onchange="updateCartQuantity('{{$cartItem['id']}}')">
                                @for ($i = 1; $i <= 10; $i++)
                                    <option
                                        value="{{$i}}" {{$cartItem['quantity'] == $i?'selected':''}}>
                                        {{$i}}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div
                        class="col-md-4 col-sm-4 offset-4 offset-sm-0 text-center d-flex justify-content-between align-items-center">
                        <div class="">
                            <div class=" text-accent">
                                {{ \App\CPU\Helpers::currency_converter(($cartItem['price']-$cartItem['discount'])*$cartItem['quantity']) }}
                            </div>
                        </div>
                        <div style="margin-top: 3px;">
                            <button class="btn btn-link px-0 text-danger"
                                    onclick="removeFromCart({{ $cartItem['id'] }})" type="button"><i
                                    class="far fa-times-circle mr-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="mt-3"></div>
        @endforeach

    </div>
    <div class="row pt-2 mobile-cart-detail">
        <div class="col-6 text-start">
            <a href="{{route('admin.dashboard')}}" class="btn btn-primary">
                <i class="fa fa-backward px-1"></i> Back to Product
            </a>
        </div>
        <div class="col-6">
            <a href="{{route('admin.order.checkout-complete')}}"
               class="btn btn-primary pull-right">
                Proses order
                <i class="fa fa-forward px-1"></i>
            </a>
        </div>
    </div>
</section>
<div class="d-block col-lg-4">
    @include('admin-views.order.partials._order-summary')
</div>
