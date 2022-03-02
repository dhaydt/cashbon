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
@include('admin-views.coupon.partials._headerBussines')
<div class="content container-fluid">
    <!-- Content Row -->
    <div class="row gx-2 gx-lg-3 mt--8">
        <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
            <div class="card">
                {{-- <div class="card-header">
                    coupon_form')}}
                </div> --}}
                <div class="card-body">
                    <form action="{{route('admin.coupon.add-new')}}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">Type</label>
                                    <select class="form-control" name="coupon_type"
                                            style="width: 100%" required>
                                        {{--<option value="delivery_charge_free">Delivery Charge Free</option>--}}
                                        <option value="discount_on_purchase">Discount on Purchase</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">Title</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                           placeholder="Title" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">Code</label>
                                    <input type="text" name="code" value="{{\Illuminate\Support\Str::random(10)}}"
                                           class="form-control" id="code"
                                           placeholder="" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="name">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" id="start date"
                                           placeholder="start date" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="name">Expire Date</label>
                                    <input type="date" name="expire_date" class="form-control" id="expire date"
                                           placeholder="expire date" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label
                                        for="exampleFormControlInput1">Limit for same user</label>
                                    <input type="number" name="limit" id="coupon_limit" class="form-control"
                                           placeholder="EX: 10">
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="name">Discount type</label>
                                    <select class="form-control" name="discount_type"
                                            onchange="checkDiscountType(this.value)"
                                            style="width: 100%">
                                        <option value="amount">Amount</option>
                                        <option value="percentage">percentage</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="name">Discount</label>
                                    <input type="number" min="1" max="1000000" name="discount" class="form-control"
                                           id="discount"
                                           placeholder="discount" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <label for="name">Minimum purchase</label>
                                <input type="number" min="1" max="1000000" name="min_purchase" class="form-control"
                                       id="minimum purchase"
                                       placeholder="minimum purchase" required>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="name">Maximum discount</label>
                                    <input type="number" min="1" max="1000000" name="max_discount"
                                           class="form-control" id="maximum discount"
                                           placeholder="maximum discount" required>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer pl-0">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between align-items-center flex-grow-1">
                        <div class="col-lg-3 mb-3 mb-lg-0">
                            <h5>Coupons Table <span style="color: red;">({{ $cou->total() }})</span>
                            </h5>
                        </div>
                        <div class="col-lg-6">
                            <!-- Search -->
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input id="datatableSearch_" type="search" name="search" class="form-control"
                                           placeholder="Search by Title or Code or Discount Type"
                                           value="{{ $search }}" aria-label="Search orders" required>
                                    <button type="submit" class="btn btn-primary">search</button>
                                </div>
                            </form>
                            <!-- End Search -->
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="datatable"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               style="width: 100%">
                            <thead class="thead-light">
                            <tr>
                                <th>SL#</th>
                                <th>Coupon Type</th>
                                <th>Title</th>
                                <th>Code</th>
                                <th>user limit</th>
                                <th>Minimum purchase</th>
                                <th>Maximum discount</th>
                                <th>Discount</th>
                                <th>Discount type</th>
                                <th>Start date</th>
                                <th>Expire date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cou as $k=>$c)
                                <tr>
                                    <th scope="row">{{$cou->firstItem() + $k}}</th>
                                    <td style="text-transform: capitalize">{{str_replace('_',' ',$c['coupon_type'])}}</td>
                                    <td class="text-capitalize">
                                        {{substr($c['title'],0,20)}}
                                    </td>
                                    <td>{{$c['code']}}</td>
                                    <td>{{ $c['limit'] }}</td>
                                    <td>{{ $c['min_purchase'] }}</td>
                                    <td>{{ $c['max_discount'] }}</td>
                                    <td>{{$c['discount_type']=='amount'?$c['discount']:$c['discount']}}</td>
                                    <td>{{$c['discount_type']}}</td>
                                    <td>{{date('d-M-y',strtotime($c['start_date']))}}</td>
                                    <td>{{date('d-M-y',strtotime($c['expire_date']))}}</td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm">
                                            <input type="checkbox" class="toggle-switch-input"
                                                   onclick="location.href='{{route('admin.coupon.status',[$c['id'],$c->status?0:1])}}'"
                                                   class="toggle-switch-input" {{$c->status?'checked':''}}>
                                            <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                        </span>
                                        </label>
                                    </td>
                                    <td>
                                        <a href="{{route('admin.coupon.update',[$c['id']])}}"
                                           class="btn btn-primary btn-sm">
                                            Update
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{$cou->links()}}
                </div>
                @if(count($cou)==0)
                    <div class="text-center p-4">
                        <img class="mb-3" src="{{asset('assets/back-end')}}/svg/illustrations/sorry.svg"
                             alt="Image Description" style="width: 7rem;">
                        <p class="mb-0">No data to show</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('assets/back-end')}}/js/select2.min.js"></script>
<script>
    $(".js-example-theme-single").select2({
        theme: "classic"
    });

    $(".js-example-responsive").select2({
        width: 'resolve'
    });
</script>

<!-- Page level plugins -->
<script src="{{asset('assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('assets/back-end')}}/js/demo/datatables-demo.js"></script>
@endpush
