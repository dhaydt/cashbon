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
@include('admin-views.payment.partials._headerBussines')
<div class="content container-fluid mt--8">

    <div class="row" style="margin-top: 20px" id="banner-table">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="flex-between row justify-content-between align-items-center flex-grow-1 mx-1">
                        <div class="flex-between d-flex">
                            <div>
                                <h5>Payment Service</h5>
                            </div>
                        </div>
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
                                    <th>{{('payment')}}</th>
                                    <th>{{('type')}}</th>
                                    <th>{{('status')}}</th>
                                    {{-- <th style="width: 50px">{{('action')}}</th> --}}
                                </tr>
                            </thead>
                            @foreach($payment as $key=>$pay)
                            <tbody>

                                <tr>
                                    <th scope="row">{{$pay->id}}</th>
                                    <td>{{$pay->name}}</td>
                                    <td>{{$pay->type}}</td>
                                    <td>
                                        <div class="form-check form-switch switch switch-status">
                                            <input class="form-check-input status" type="checkbox" role="switch"
                                                id="{{$pay->id}}" <?php if ($pay->status == 1) echo "checked"
                                            ?>>
                                        </div>
                                    </td>

                                    {{-- <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="tio-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item  edit" style="cursor: pointer;"
                                                    id="{{$pay['id']}}"> Edit</a>
                                                <a class="dropdown-item delete" style="cursor: pointer;"
                                                    id="{{$banner['id']}}"> Delete</a>
                                            </div>
                                        </div>

                                    </td> --}}
                                </tr>

                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{-- {{$pay->links()}} --}}
                </div>
                @if(count($payment)==0)
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
                url: "{{route('admin.payment.status')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if (data == 1) {
                        toastr.success('Payment status activated successfully');
                    } else {
                        toastr.success('Payment status deactivated successfully');
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
