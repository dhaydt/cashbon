@extends('layouts.backend.app')
@section('title', ('Banner'))
@push('css_or_js')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
<style>
    .btn.btn-primary {
        text-transform: capitalize;
    }
</style>
@section('content')
@include('admin-views.banner.partials._headerBussines')
<div class="content container-fluid mt--8">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12" id="banner-btn">
            <button id="main-banner-add" class="btn btn-primary"><i class="fas fa-plus-circle"></i> add main
                banner</button>
            <button id="secondary-banner-add" class="btn btn-primary ml-2"><i class="fas fa-plus-circle mr-2"></i>add
                secondary banner</button>
            <button id="popup-banner-add" class="btn btn-primary ml-2 propup"><i class="fas fa-plus-circle mr-2"></i>add
                popup banner</button>
            {{-- <button id="header-banner-add" class="btn btn-primary ml-2 propup"><i class="fas fa-plus-circle"></i>
                add header banner</button> --}}
            {{-- <button id="floating-banner-add" class="btn btn-primary ml-2 propup"><i class="fas fa-plus-circle"></i>
                {{ ('add_floating_button')}}</button> --}}
        </div>
    </div>
    <!-- Content Row -->
    <div class="row pt-4" id="main-banner" style="display: none;text-align: {{Session::get('direction') === " rtl"
        ? 'right' : 'left' }};">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Main Banner Form
                </div>
                <div class="card-body">
                    <form action="{{route('admin.banner.store')}}" method="post" enctype="multipart/form-data"
                        class="banner_form">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" id="id" name="id">
                                    <label for="name">{{ ('banner_url')}}</label>
                                    <input type="text" name="url" class="form-control" id="url" required>
                                    <input type="hidden" id="type" name="banner_type" value="Main Banner">
                                    <label for="name">{{ ('Image')}}</label><span class="badge badge-soft-danger">(
                                        {{('ratio')}} 4:1 )</span>
                                    <br>
                                    <div class="custom-file" style="text-align: left">
                                        <input type="file" name="image" id="mbimageFileUploader"
                                            class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="mbimageFileUploader">{{('choose')}}
                                            {{('file')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <center>
                                        <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;"
                                            id="mbImageviewer" src="{{asset('assets\back-end\img\400x400\img1.jpg')}}"
                                            alt="banner image" />
                                    </center>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a class="btn btn-danger text-white cancel">{{ ('Cancel')}}</a>
                            <button id="add" type="submit" class="btn btn-primary">{{ ('save')}}</button>
                            <a id="update" class="btn btn-primary" style="display: none; color: #fff;">{{
                                ('update')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-4" id="secondary-banner" style="display: none">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ ('secondary_banner_form')}}
                </div>
                <div class="card-body">
                    <form class="banner_form" action="{{route('admin.banner.store')}}" method="post"
                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left' }};"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" id="id" name="id">
                                    <label for="name">{{ ('banner_url')}}</label>
                                    <input type="text" name="url" class="form-control" id="footerurl" required>
                                    <input type="hidden" id="footertype" name="banner_type" value="Footer Banner">
                                    <label for="name">{{ ('Image')}}</label><span class="badge badge-soft-danger">( {{
                                        ('ratio')}} 3:1 )</span>
                                    <br>
                                    <div class="custom-file" style="text-align: left">
                                        <input type="file" name="image" id="fbimageFileUploader"
                                            class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="fbimageFileUploader">{{('choose')}}
                                            {{('file')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <center>
                                        <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;"
                                            id="fbImageviewer" src="{{asset('assets\back-end\img\400x400\img2.jpg')}}"
                                            alt="banner image" />
                                    </center>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a class="btn btn-danger text-white cancel">{{ ('Cancel')}}</a>
                            <button type="submit" id="addfooter" class="btn btn-primary">{{ ('save')}}</button>
                            <a id="footerupdate" class="btn btn-primary" style="display: none; color: #fff;">{{
                                ('update')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-4" id="popup-banner" style="display: none">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Popup Banner Form
                </div>
                <div class="card-body">
                    <form class="banner_form" action="{{route('admin.banner.store')}}" method="post"
                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left' }};"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" id="id" name="id">
                                    <label for="name">Banner Url</label>
                                    <input type="text" name="url" class="form-control" id="popupurl" required>
                                    <input type="hidden" id="popuptype" name="banner_type" value="Popup Banner">
                                    <label for="name">{{('Image')}}</label><span class="badge badge-soft-danger">(
                                        {{('ratio')}} 3:1 )</span>
                                    <br>
                                    <div class="custom-file" style="text-align: left">
                                        <input type="file" name="image" id="pbimageFileUploader"
                                            class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="pbimageFileUploader">{{('choose')}}
                                            {{('file')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <center>
                                        <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;"
                                            id="pbImageviewer" src="{{asset('assets\back-end\img\400x400\img2.jpg')}}"
                                            alt="banner image" />
                                    </center>
                                </div>
                            </div>
                        </div>

                        <div class="card-secondary">
                            <a class="btn btn-danger text-white cancel">{{ ('Cancel')}}</a>
                            <button id="addpopup" type="submit" class="btn btn-primary">{{ ('save')}}</button>
                            <a id="popupupdate" class="btn btn-primary" style="display: none; color: #fff;">{{
                                ('update')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-4" id="header-banner" style="display: none">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ ('header_banner_form')}}
                </div>
                <div class="card-body">
                    <form class="banner_form" action="{{route('admin.banner.store')}}" method="post"
                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left' }};"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" id="id" name="id">
                                    <label for="name">{{ ('playstore_url')}}</label>
                                    <input type="text" name="url" class="form-control" id="headerurl" required>
                                    <label for="name">{{ ('app_store_url')}}</label>
                                    <input type="text" name="url2" class="form-control" id="headerurl2" required>
                                    <input type="hidden" id="headertype" name="banner_type" value="Header Banner">
                                    <label for="name">{{('Image')}}</label><span class="badge badge-soft-danger">(
                                        {{('ratio')}} 6:1 )</span>
                                    <br>
                                    <div class="custom-file" style="text-align: left">
                                        <input type="file" name="image" id="pbimageFileUploader"
                                            class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="pbimageFileUploader">{{('choose')}}
                                            {{('file')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <center>
                                        <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;"
                                            id="pbImageviewer" src="{{asset('assets\back-end\img\400x400\img2.jpg')}}"
                                            alt="banner image" />
                                    </center>
                                </div>
                            </div>
                        </div>

                        <div class="card-secondary">
                            <a class="btn btn-danger text-white cancel">{{ ('Cancel')}}</a>
                            <button id="addpopup" type="submit" class="btn btn-primary">{{ ('save')}}</button>
                            <a id="popupupdate" class="btn btn-primary" style="display: none; color: #fff;">{{
                                ('update')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row pt-4" id="floating-banner" style="display: none">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ ('floating_banner_form')}}
                </div>
                <div class="card-body">
                    <form class="banner_form" action="{{route('admin.banner.store')}}" method="post"
                        style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left' }};"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" id="id" name="id">
                                    <label for="name">{{ ('floating_url')}}</label>
                                    <input type="text" name="url" class="form-control" id="floatingurl" required>
                                    <input type="hidden" id="headertype" name="banner_type" value="Floating Banner">
                                    <label for="name">{{('Floating GIF')}}</label><span
                                        class="badge badge-soft-danger">( {{('ratio')}} 1:1 )</span>
                                    <br>
                                    <div class="custom-file" style="text-align: left">
                                        <input type="file" name="image" id="pbimageFileUploader"
                                            class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="pbimageFileUploader">{{('choose')}}
                                            {{('file')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <center>
                                        <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;"
                                            id="pbImageviewer" src="{{asset('assets\back-end\img\400x400\img2.jpg')}}"
                                            alt="banner image" />
                                    </center>
                                </div>
                            </div>
                        </div>

                        <div class="card-secondary">
                            <a class="btn btn-danger text-red cancel">{{ ('Cancel')}}</a>
                            <button id="addpopup" type="submit" class="btn btn-primary">{{ ('save')}}</button>
                            <a id="popupupdate" class="btn btn-primary" style="display: none; color: #fff;">{{
                                ('update')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row" style="margin-top: 20px" id="banner-table">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="flex-between row justify-content-between align-items-center flex-grow-1 mx-1">
                        <div class="flex-between d-flex">
                            <div>
                                <h5>Banner Table</h5>
                            </div>
                            <div class="mx-1">
                                <h5 style="color: red;">({{ $banners->total() }})</h5>
                            </div>
                        </div>
                        {{-- <div style="width: 30vw">
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input id="datatableSearch_" type="search" name="search" class="form-control"
                                        placeholder="{{ ('Search_by_Banner_Type')}}" aria-label="Search orders"
                                        value="{{ $search }}" required>
                                    <button type="submit" class="btn btn-primary">{{ ('Search')}}</button>
                                </div>
                            </form>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="columnSearchDatatable" style="text-align: {{Session::get('direction') === " rtl"
                            ? 'right' : 'left' }};"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{('sl')}}</th>
                                    <th>{{('image')}}</th>
                                    <th>{{('banner_type')}}</th>
                                    <th>{{('published')}}</th>
                                    <th style="width: 50px">{{('action')}}</th>
                                </tr>
                            </thead>
                            @foreach($banners as $key=>$banner)
                            <tbody>

                                <tr>
                                    <th scope="row">{{$banners->firstItem()+$key}}</th>
                                    <td>
                                        <img width="80"
                                            onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                            src="{{asset('storage/banner')}}/{{$banner['photo']}}">
                                    </td>
                                    <td>{{$banner->banner_type}}</td>
                                    <td>
                                        <div class="form-check form-switch switch switch-status">
                                            <input class="form-check-input status" type="checkbox" role="switch"
                                                id="{{$banner->id}}" <?php if ($banner->published == 1) echo "checked"
                                            ?>>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="tio-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item  edit" style="cursor: pointer;"
                                                    id="{{$banner['id']}}"> Edit</a>
                                                <a class="dropdown-item delete" style="cursor: pointer;"
                                                    id="{{$banner['id']}}"> Delete</a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>

                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{$banners->links()}}
                </div>
                @if(count($banners)==0)
                <div class="text-center p-4">
                    <img class="mb-3" src="{{asset('assets/back-end')}}/svg/illustrations/sorry.svg"
                        alt="Image Description" style="width: 7rem;">
                    <p class="mb-0">{{ ('No_data_to_show')}}</p>
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
    function mbimagereadURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#mbImageviewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#mbimageFileUploader").change(function () {
            mbimagereadURL(this);
        });

        function fbimagereadURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#fbImageviewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#fbimageFileUploader").change(function () {
            fbimagereadURL(this);
        });


        function pbimagereadURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#pbImageviewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#pbimageFileUploader").change(function () {
            pbimagereadURL(this);
        });

</script>
<script>
    $('#main-banner-add').on('click', function () {
            $('#main-banner').show();
            $('#secondary-banner').hide();
            $('#popup-banner').hide();
            $('#banner-table').hide();
            $('#header-banner').hide();
            $('#floating-banner').hide();
        });
        $('#secondary-banner-add').on('click', function () {
            $('#main-banner').hide();
            $('#secondary-banner').show();
            $('#popup-banner').hide();
            $('#banner-table').hide();
            $('#header-banner').hide();
            $('#floating-banner').hide();
        });

        $('#popup-banner-add').on('click', function () {
            $('#main-banner').hide();
            $('#secondary-banner').hide();
            $('#popup-banner').show();
            $('#banner-table').hide();
            $('#header-banner').hide();
            $('#floating-banner').hide();
        });
        $('#header-banner-add').on('click', function () {
            $('#main-banner').hide();
            $('#secondary-banner').hide();
            $('#popup-banner').hide();
            $('#banner-table').hide();
            $('#header-banner').show();
            $('#floating-banner').hide();
        });

        $('#floating-banner-add').on('click', function () {
            $('#main-banner').hide();
            $('#secondary-banner').hide();
            $('#popup-banner').hide();
            $('#banner-table').hide();
            $('#header-banner').hide();
            $('#floating-banner').show();
        });

        $('.cancel').on('click', function () {
            $('.banner_form').attr('action', "{{route('admin.banner.store')}}");
            $('#main-banner').hide();
            $('#secondary-banner').hide();
            $('#popup-banner').hide();
            $('#header-banner').hide();
            $('#banner-table').show();
            $('#floating-banner').hide();
        });

        $(document).on('change', '.status', function () {
            var id = $(this).attr("id");
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
                url: "{{route('admin.banner.status')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if (data == 1) {
                        toastr.success('{{('Banner_published_successfully')}}');
                    } else {
                        toastr.success('{{('Banner_unpublished_successfully')}}');
                    }
                }
            });
        });

        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: "Are you sure delete this banner",
                text: "You will not be able to revert this",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.banner.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{('Banner_deleted_successfully')}}');
                            location.reload();
                        }
                    });
                }
            })
        });

        $(document).on('click', '.edit', function () {
            var id = $(this).attr("id");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.banner.edit')}}",
                method: 'POST',
                data: {id: id},
                success: function (data) {
                    $('.banner_form').attr('action', "{{route('admin.banner.update')}}");
                    // console.log(data);
                    if (data.banner_type == 'Main Banner') {

                        $('#main-banner').show();
                        $('#banner-table').hide();
                        $('#add').html("{{ ('update')}}");
                        // $('#add').hide();
                        // $('#update').show();
                        // $('#id').val(data.id);
                        $('#url').val(data.url);
                        $('#url').siblings('#id').val(data.id);
                        $('#mbImageviewer').attr('src', "{{asset('storage/banner')}}" + "/" + data.photo);
                        $('#cate-table').hide();

                    } else if (data.banner_type == 'Footer Banner') {

                        $('#secondary-banner').show();
                        $('#banner-table').hide();
                        // $('#addfooter').hide();
                        $('#addfooter').html("{{ ('update')}}");
                        // $('#footerupdate').show();
                        // $('#id').val(data.id);
                        $('#footerurl').val(data.url);
                        $('#footerurl').siblings('#id').val(data.id);
                        $('#fbImageviewer').attr('src', "{{asset('storage/banner')}}" + "/" + data.photo);
                        $('#cate-table').hide();


                    } else if (data.banner_type == 'Header Banner') {

                        $('#header-banner').show();
                        $('#banner-table').hide();
                        // $('#addfooter').hide();
                        $('#addheader').html("{{ ('update')}}");
                        // $('#footerupdate').show();
                        // $('#id').val(data.id);
                        $('#headerurl').val(data.url);
                        $('#headerurl').siblings('#id').val(data.id);
                        $('#headerurl2').val(data.url2);
                        $('#headerurl2').siblings('#id').val(data.id);
                        $('#fbImageviewer').attr('src', "{{asset('storage/banner')}}" + "/" + data.photo);
                        $('#cate-table').hide();


                    } else if (data.banner_type == 'Floating Banner') {

                        $('#floating-banner').show();
                        $('#banner-table').hide();
                        // $('#addfooter').hide();
                        $('#addfloating').html("{{ ('update')}}");
                        // $('#footerupdate').show();
                        // $('#id').val(data.id);
                        $('#floatingurl').val(data.url);
                        $('#floatingurl').siblings('#id').val(data.id);
                        $('#fbImageviewer').attr('src', "{{asset('storage/banner')}}" + "/" + data.photo);
                        $('#cate-table').hide();


                    } else {
                        $('#popup-banner').show();
                        $('#banner-table').hide();
                        $('#addpopup').html("{{ ('update')}}");
                        // $('#addpopup').hide();
                        // $('#popupupdate').show();
                        // $('#id').val(data.id);
                        $('#popupurl').val(data.url);
                        $('#popupurl').siblings('#id').val(data.id);
                        $('#pbImageviewer').attr('src', "{{asset('storage/banner')}}" + "/" + data.photo);
                        $('#cate-table').hide();
                    }


                }
            });
        });
        $('#update').on('click', function () {
            $('#update').attr("disabled", true);
            var id = $('#id').val();
            var name = $('#url').val();
            var type = $('#type').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('admin.banner.update')}}",
                method: 'POST',
                data: {
                    id: id,
                    url: name,
                    banner_type: type,

                },
                success: function (data) {
                    console.log(data);
                    $('#url').val('');
                    $.ajax({
                        type: 'get',
                        url: '{{route('image-remove',[0,'main_banner_image_modal'])}}',
                        dataType: 'json',
                        success: function (data) {
                            if (data.success === 1) {
                                $("#img-suc").hide();
                                $("#img-err").hide();
                                $("#crop").hide();
                                $("#show-images").html(data.photo);
                                $("#image-count").text(data.count);
                            } else if (data.success === 0) {
                                $("#img-suc").hide();
                                $("#img-err").show();
                            }
                        },
                    });
                    toastr.success('{{('Main_Banner_updated_Successfully')}}.');


                    location.reload();
                }
            });
            $('#save').hide();

        });
        $('#footerupdate').on('click', function () {
            $('#footerupdate').attr("disabled", true);
            var id = $('#id').val();
            var name = $('#footerurl').val();
            var type = $('#footertype').val();
            console.log(type)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('admin.banner.update')}}",
                method: 'POST',
                data: {
                    id: id,
                    url: name,
                    banner_type: type,

                },
                success: function (data) {

                    $('#url').val('');
                    $.ajax({
                        type: 'get',
                        url: '{{route('image-remove',[0,'secondary_banner_image_modal'])}}',
                        dataType: 'json',
                        success: function (data) {
                            if (data.success === 1) {
                                $("#img-suc").hide();
                                $("#img-err").hide();
                                $("#crop").hide();
                                $("#show-images").html(data.photo);
                                $("#image-count").text(data.count);
                            } else if (data.success === 0) {
                                $("#img-suc").hide();
                                $("#img-err").show();
                            }
                        },
                    });
                    toastr.success('{{('Secondary_Banner_updated_Successfully')}}.');


                    location.reload();
                }
            });
            $('#save').hide();

        });
        $('#popupupdate').on('click', function () {
            $('#popupupdate').attr("disabled", true);
            var id = $('#id').val();
            var name = $('#popupurl').val();
            var type = $('#popuptype').val();


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('admin.banner.update')}}",
                method: 'POST',
                data: {
                    id: id,
                    url: name,
                    banner_type: type,

                },
                success: function (data) {

                    $('#url').val('');
                    $.ajax({
                        type: 'get',
                        url: '{{route('image-remove',[0,'popup_banner_image_modal'])}}',
                        dataType: 'json',
                        success: function (data) {
                            if (data.success === 1) {
                                $("#img-suc").hide();
                                $("#img-err").hide();
                                $("#crop").hide();
                                $("#show-images").html(data.photo);
                                $("#image-count").text(data.count);
                            } else if (data.success === 0) {
                                $("#img-suc").hide();
                                $("#img-err").show();
                            }
                        },
                    });
                    toastr.success('{{('Popup_Banner_updated_Successfully')}}.');


                    location.reload();
                }
            });
            $('#save').hide();

        });

</script>
<!-- Page level plugins -->
<script src="{{asset('assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
            $('#dataTable').DataTable();
        });
</script>
@endpush
