@extends('layouts.backend.app')
@section('title', ('Payment'))
@push('css_or_js')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
<style>
    .btn.btn-primary {
        text-transform: capitalize;
    }
</style>
@section('content')
@include('admin-views.coupon.partials._headerEdit')
<div class="row mt--8">
    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                <form action="{{route('admin.coupon.update',[$c['id']])}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label  for="name">{{('Type')}}</label>
                                <select class="form-control" name="coupon_type"
                                        style="width: 100%" required>
                                    {{--<option value="delivery_charge_free">Delivery Charge Free</option>--}}
                                    <option value="discount_on_purchase" {{$c['coupon_type']=='discount_on_purchase'?'selected':''}}>{{('Discount on Purchase')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="name">{{('Title')}}</label>
                                <input type="text" name="title" class="form-control" id="title" value="{{$c['title']}}"
                                    placeholder="{{('Title')}}" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="name">{{('Code')}}</label>
                                <input type="text" name="code" value="{{$c['code']}}"
                                       class="form-control" id="code"
                                       placeholder="" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="name">{{('start_date')}}</label>
                                <input type="date" name="start_date" class="form-control" id="start date" value="{{date('Y-m-d',strtotime($c['start_date']))}}"
                                    placeholder="{{('start date')}}" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="name">{{('expire_date')}}</label>
                                <input type="date" name="expire_date" class="form-control" id="expire date" value="{{date('Y-m-d',strtotime($c['expire_date']))}}"
                                       placeholder="{{('expire date')}}" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label  for="exampleFormControlInput1">{{('limit')}} {{('for')}} {{('same')}} {{('user')}}</label>
                                    <input type="number" name="limit" value="{{ $c['limit'] }}" id="coupon_limit" class="form-control" placeholder="{{('EX')}}: {{('10')}}">
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label  for="name">{{('discount_type')}}</label>
                                <select class="form-control" name="discount_type"
                                        onchange="checkDiscountType(this.value)"
                                        style="width: 100%">
                                    <option value="amount" {{$c['discount_type']=='amount'?'selected':''}}>{{('Amount')}}</option>
                                    <option value="percentage" {{$c['discount_type']=='percentage'?'selected':''}}>{{('percentage')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="name">{{('Discount')}}</label>
                                <input type="number" min="1" max="1000000" name="discount" class="form-control" id="discount" value="{{$c['discount_type']=='amount'?$c['discount']:$c['discount']}}"
                                       placeholder="{{('discount')}}" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <label for="name">{{('minimum_purchase')}}</label>
                            <input type="number" min="1" max="1000000" name="min_purchase" class="form-control" id="minimum purchase" value="{{$c['min_purchase']}}"
                                    placeholder="{{('minimum purchase')}}" required>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="name">{{('maximum_discount')}}</label>
                                <input type="number" min="1" max="1000000" name="max_discount" class="form-control" id="maximum discount" value="{{$c['max_discount']}}"
                                       placeholder="{{('maximum discount')}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{('Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('script')
<script>
    function checkDiscountType(val) {
        if (val == 'amount') {
            $('#max-discount').hide()
        } else if (val == 'percentage') {
            $('#max-discount').show()
        }
    }
</script>
<script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
<script>
    $(".js-example-theme-single").select2({
        theme: "classic"
    });

    $(".js-example-responsive").select2({
        width: 'resolve'
    });
</script>
@endpush
