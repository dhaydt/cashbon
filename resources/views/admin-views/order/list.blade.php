@extends('layouts.backend.app')
@section('title', 'Order')
@section('content')
@include('admin-views.order.partials._headerList')
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
                <span class="for-feature-title">Product List</span>
              </div>
            </div>

            <div class="row product-wrapper p-4">
              {{-- @foreach($product as $product) --}}
              {{-- @if($key<12) --}} <div class="product-item px-0  col-12 h-100"
                style="margin-bottom: 10px">
                <div class="card">
                    <!-- Card header -->
                    {{-- <div class="card-header border-0">
                        <h3 class="mb-0">Admin table</h3>
                    </div> --}}
                    <!-- Light table -->
                    {{-- {{ var_dump($admin) }} --}}
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th scope="col" class="sort" data-sort="no">No</th>
                                    <th scope="col" class="sort" data-sort="id">ID</th>
                                    <th scope="col" class="sort" data-sort="cus_id">Customer Id</th>
                                    <th scope="col" class="sort" data-sort="total">Total</th>
                                    <th scope="col" class="sort" data-sort="payment">Payment</th>
                                    <th scope="col" class="sort" data-sort="completion">Action</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                {{-- {{ dd($admin) }} --}}
                                <?php $no = 1;?>
                                @foreach ($orders as $ad)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body text-center">
                                                <span class="name mb-0 text-sm">
                                                    {{ $no++ }}
                                                </span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget text-center">
                                        {{ $ad['id'] }}
                                    </td>
                                    <td class="budget text-center">
                                        {{ $ad['customer_id'] }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dot mr-4">
                                            {{-- <i class="bg-warning"></i> --}}
                                            <span class="status">{{ \App\CPU\Helpers::currency_converter($ad['order_amount']) }}</span>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dot mr-4">
                                            {{-- <i class="bg-warning"></i> --}}
                                            <span class="status">{{ $ad['payment_method'] }}</span>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-around">
                                            {{-- <a href="{{ route('admin.viewProduct', ['id' => $ad['id']]) }}"
                                                class="viewUser" data-toggle="tooltip" data-placement="left" title="view">
                                                <i class="far fa-eye"></i>
                                            </a> --}}
                                            <a href="javascript:" onclick="addCart({{ $ad['id'] }})"
                                                class="viewUser text-green" data-toggle="tooltip" data-placement="top" title="edit">
                                                <i class="fas fa-add"></i>
                                            </a>
                                            {{-- <a href="{{ route('admin.delProduct', ['id' => $ad['id']]) }}"
                                                class="viewUser text-red" data-toggle="tooltip" data-placement="top" title="delete">
                                                <i class="far fa-trash-alt"></i>
                                            </a> --}}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer">
                        {{-- <nav aria-label="...">
                            <ul class="pagination justify-content-end mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">
                                        <i class="fas fa-angle-left"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="fas fa-angle-right"></i>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav> --}}
                        <div
                            class="row justify-content-center justify-content-sm-between justify-content-md-center align-items-sm-center">
                            <div class="col-sm-auto">
                                <div class="d-flex justify-content-center justify-content-sm-end">
                                    <!-- Pagination -->
                                    @if(count($orders)==0)
                                    <div class="text-center p-4">
                                        <img class="mb-3" src="{{asset('assets/img')}}/sorry.svg" alt="Image Description"
                                            style="width: 7rem;">
                                        <p class="mb-0">No data to show</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


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
@push('script')
                <script>
                    function addCart(val) {
                        if (checkAddToCartValidity()) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.post({
                                url: '{{route('admin.order.add')}}',
                                data: {'id' : val, 'quantity': 1},
                                beforeSend: function () {
                                    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
                                        $('#loading').addClass('loading-mobile');
                                    }
                                    $('#loading').show();
                                },
                                success: function (response) {
                                    // console.log(response);
                                    if (response.status == 1) {
                                        updateNavCart();
                                        toastr.success(response.message, {
                                            CloseButton: true,
                                            ProgressBar: true
                                        });
                                        $('.call-when-done').click();
                                        return false;
                                    } else if (response.status == 0) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Cart',
                                            text: response.message
                                        });
                                        return false;
                                    }
                                },
                                complete: function () {
                                    $('#loading').hide();
                                    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
                                        $('#loading').removeClass('loading-mobile');
                                    }
                                }
                            });
                        } else {
                            Swal.fire({
                                type: 'info',
                                title: 'Cart',
                                text: 'Please choose all the options'
                            });
                        }
                    }

                </script>
                @endpush
