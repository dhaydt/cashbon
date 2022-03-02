@extends('layouts.backend.app')
@section('title', 'Product List')
@section('content')
@include('admin-views.product.partials._headerList')
<style>
    .viewUser {
        font-size: 18px;
        color: #5e72e4;
    }

    .card-footer .row.justify-content-center .col-sm-auto .d-flex nav .flex {
        display: none;
    }

    .card-footer>div>div>div>nav>div.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between>div:nth-child(1)>p {
        display: none;
    }

    .card-footer>div>div>div>nav>div.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between>div:nth-child(2)>span {
        display: flex;
    }

    .card-footer>div>div>div>nav>div.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between>div:nth-child(2)>span span:first-child span svg {
        margin-right: 15px;
    }

</style>
<div class="container-fluid mt--8">
    <div class="row">
        <div class="col">
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
                                <th scope="col" class="sort" data-sort="status">Selling Price</th>
                                <th scope="col" class="sort" data-sort="status">Active status</th>
                                <th scope="col">Product</th>
                                <th scope="col" class="sort" data-sort="completion">Action</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            {{-- {{ dd($admin) }} --}}
                            @foreach ($admin as $ad)
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
                                        <span class="status">{{ $ad['purchase_price'] }}</span>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-dot mr-4">
                                        {{-- <i class="bg-warning"></i> --}}
                                        <span class="status">{{ $ad['unit_price'] }}</span>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch switch switch-status">
                                        <input class="form-check-input status" type="checkbox" role="switch" id="{{$ad['id']}}"  {{$ad->status == 1?'checked':''}}>
                                      </div>
                                </td>
                                <td class="text-center">
                                    <div class="avatar-group d-flex justify-content-center">
                                        @foreach (json_decode($ad['images']) as $key => $photo)
                                        <a href="javascript:" class="avatar avatar-sm rounded-circle"
                                            data-toggle="tooltip" data-original-title="Ryan Tompson">
                                            <img alt="Image placeholder"
                                                src="{{ asset('storage/product/'.$photo) }}">
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
                                        <a href="{{ route('admin.editProduct', ['id' => $ad['id']]) }}"
                                            class="viewUser text-green" data-toggle="tooltip" data-placement="top" title="edit">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.delProduct', ['id' => $ad['id']]) }}"
                                            class="viewUser text-red" data-toggle="tooltip" data-placement="top" title="delete">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
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
                                @if(count($admin)==0)
                                <div class="text-center p-4">
                                    <img class="mb-3" src="{{asset('assets/img')}}/sorry.svg" alt="Image Description"
                                        style="width: 7rem;">
                                    <p class="mb-0">No data to show</p>
                                </div>
                                @else
                                {!! $admin->links() !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection


    @push('script')
    <!-- Page level plugins -->
    <script src="{{asset('assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script>
        // Call the dataTables jQuery plugin
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });

    $(document).on('change', '.status', function () {
        var id = $(this).attr("id");
        console.log('id', $(this).prop("checked"))
        if ($(this).prop("checked") == true) {
            var status = 1;
        } else if ($(this).prop("checked") == false) {
            var status = 0;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('admin.statusUpdateProduct')}}",
            method: 'POST',
            data: {
                id: id,
                status: status
            },
            success: function (data) {
                if(data.success == true) {
                    toastr.success('Status berhasil di update');
                }
                else if(data.success == false) {
                    toastr.error('Update status gagal..');
                    setTimeout(function(){
                        location.reload();
                    }, 2000);
                }
            }
        });
    });

    </script>
    @endpush
