@extends('layouts.backend.app')
@section('title', ('Categories'))
<style>
    .btn.btn-primary {
        text-transform: capitalize;
    }
    tr td {
        vertical-align: middle !important;
    }
</style>
@section('content')
@include('admin-views.category.partials._headerBussines')
<div class="content container-fluid mt--8">
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Category Form
                </div>
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{route('admin.category.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <ul class="nav nav-tabs mb-4">
                                <li class="nav-item">
                                    <a class="nav-link lang_link active"
                                       href="#"
                                       id="en-link">En</a>
                                </li>
                        </ul>
                        <div class="row">
                            <div class="col-6">
                                {{-- @foreach(json_decode($language) as $lang) --}}
                                    <div class="form-group active lang_form"
                                         id="en-form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{('name')}}
                                            ({{strtoupper('en')}})</label>
                                        <input type="text" name="name[]" class="form-control"
                                               placeholder="{{('New')}} {{('Category')}}" required>
                                    </div>
                                    <input type="hidden" name="lang[]" value="en">
                                {{-- @endforeach --}}
                                <input name="position" value="0" style="display: none">
                            </div>
                            <div class="col-6 from_part_2">
                                <label>{{('image')}}</label><small style="color: red">*
                                    ( {{('ratio')}} 3:1 )</small>
                                <div class="custom-file" style="text-align: left">
                                    <input type="file" name="image" id="customFileEg1"
                                           class="custom-file-input"
                                           accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*"
                                           required>
                                    <label class="custom-file-label"
                                           for="customFileEg1">{{('choose')}} {{('file')}}</label>
                                </div>
                            </div>
                            <div class="col-12 from_part_2">
                                <div class="form-group">
                                    <hr>
                                    <center>
                                        <img
                                            style="width: 30%;border: 1px solid; border-radius: 10px;"
                                            id="viewer"
                                            src="{{asset('assets/back-end/img/900x400/img1.jpg')}}"
                                            alt="image"/>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">{{('submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px" id="cate-table">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-between justify-content-between align-items-center flex-grow-1">
                        <div>
                            <h5>Category Table <span style="color: red;">({{ $categories->total() }})</span></h5>
                        </div>
                        <div style="width: 30vw">
                            <!-- Search -->
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input id="" type="search" name="search" class="form-control"
                                        placeholder="" value="{{ $search }}" required>
                                    <button type="submit" class="btn btn-primary">{{('search')}}</button>
                                </div>
                            </form>
                            <!-- End Search -->
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th style="width: 100px">{{ ('category')}} {{ ('ID')}}</th>
                                <th>{{ ('name')}}</th>
                                <th>{{ ('slug')}}</th>
                                <th>{{ ('icon')}}</th>
                                <th>{{ ('home_status')}}</th>
                                <th class="text-center" style="width:15%;">{{ ('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $key=>$category)
                                <tr>
                                    <td class="text-center">{{$category['id']}}</td>
                                    <td>{{$category['name']}}</td>
                                    <td>{{$category['slug']}}</td>
                                    <td>
                                        <img width="64"
                                             onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                             src="{{asset('storage/category')}}/{{$category['icon']}}">
                                    </td>
                                    <td>
                                        @if($category->home_status == true)
                                            <div style="padding: 10px;border: 1px solid;cursor: pointer"
                                                 onclick="location.href='{{route('admin.category.status',[$category['id'],0])}}'">
                                                <span class="legend-indicator bg-success" style="{{Session::get('direction') === "rtl" ? 'margin-right: 0;margin-left: .4375rem;' : 'margin-left: 0;margin-right: .4375rem;'}}"></span>{{('active')}}
                                            </div>
                                        @elseif($category->home_status == false)
                                            <div style="padding: 10px;border: 1px solid;cursor: pointer"
                                                 onclick="location.href='{{route('admin.category.status',[$category['id'],1])}}'">
                                                <span class="legend-indicator bg-danger" style="{{Session::get('direction') === "rtl" ? 'margin-right: 0;margin-left: .4375rem;' : 'margin-left: 0;margin-right: .4375rem;'}}"></span>{{('disabled')}}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm edit" style="cursor: pointer;"
                                           href="{{route('admin.category.edit',[$category['id']])}}">
                                            <i class="tio-edit"></i>{{ ('Edit')}}
                                        </a>
                                        <a class="btn btn-danger btn-sm delete" style="cursor: pointer;"
                                           id="{{$category['id']}}">
                                            <i class="tio-add-to-trash"></i>{{ ('Delete')}}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    {{$categories->links()}}
                </div>
                @if(count($categories)==0)
                    <div class="text-center p-4">
                        <img class="mb-3" src="{{asset('assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                        <p class="mb-0">{{('no_data_found')}}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>

    <script>
        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: 'Are you sure?',
                text: "You will able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{('Yes')}}, {{('delete it')}}!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.category.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{('Category_deleted_Successfully.')}}');
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
@endpush
