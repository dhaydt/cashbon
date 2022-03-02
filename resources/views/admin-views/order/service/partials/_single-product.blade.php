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
                    <th scope="col" class="sort" data-sort="name">ID</th>
                    <th scope="col" class="sort" data-sort="budget">Product name</th>
                    <th scope="col" class="sort" data-sort="status">Purchase Price</th>
                    <th scope="col" class="sort" data-sort="status">Discount</th>
                    <th scope="col" class="sort" data-sort="status">Stock</th>
                    <th scope="col">Product</th>
                    <th scope="col" class="sort" data-sort="completion">Action</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody class="list">
                {{-- {{ dd($admin) }} --}}
                @foreach ($product as $ad)
                <tr>
                    <th scope="row">
                        <div class="media align-items-center">
                            {{-- <a href="#" class="avatar rounded-circle mr-3">
                                <img alt="Image placeholder" src="../assets/img/theme/bootstrap.jpg">
                            </a> --}}
                            <div class="media-body text-center">
                                <span class="name mb-0 text-sm">{{ $ad['id'] }}</span>
                            </div>
                        </div>
                    </th>
                    <td class="budget text-center">
                        {{ $ad['name'] }}
                    </td>
                    <td class="text-center">
                        <span class="badge badge-dot mr-4">
                            {{-- <i class="bg-warning"></i> --}}
                            <span class="status">{{ $ad['price'] }}</span>
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-dot mr-4">
                            {{-- <i class="bg-warning"></i> --}}
                            <span class="status">{{ $ad['discount'] }}</span>
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-dot mr-4">
                            {{-- <i class="bg-warning"></i> --}}
                            <span class="status">{{ $ad['current_stock'] }}</span>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="avatar-group d-flex justify-content-center">
                            @foreach (json_decode($ad['images']) as $key => $photo)
                            <a href="javascript:" class="avatar avatar-sm rounded-circle"
                                data-toggle="tooltip" data-original-title="Ryan Tompson">
                                <img alt="Image placeholder"
                                    src="{{ asset('storage/service/'.$photo) }}">
                            </a>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center justify-content-around">
                            {{-- <a href="{{ route('admin.viewProduct', ['id' => $ad['id']]) }}"
                                class="viewUser" data-toggle="tooltip" data-placement="left" title="view">
                                <i class="far fa-eye"></i>
                            </a> --}}
                            <a href="javascript:" onclick="addCart({{ $ad['id'] }})"
                                class="viewUser text-green" data-toggle="tooltip" data-placement="top" title="add cart">
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
                    @if(count($product)==0)
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
                data: {'id' : val, 'quantity': 1, 'type': 'service'},
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
