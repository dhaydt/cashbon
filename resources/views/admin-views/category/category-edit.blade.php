@extends('layouts.backend.app')
@section('title', ('Categories'))

@section('content')
@include('admin-views.category.partials._headerEdit')
    <div class="content container-fluid mt--8">
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Category Form Edit
                    </div>
                    <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <form action="{{route('admin.category.update',[$category['id']])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <ul class="nav nav-tabs mb-4">
                                    <li class="nav-item">
                                        <a class="nav-link lang_link active"
                                           href="#"
                                           id="en-link">{{'en'}}</a>
                                    </li>
                            </ul>
                            <div class="row">
                                <div class="col-6">
                                        <div class="form-group {{'en' != 'en' ? 'd-none':''}} lang_form"
                                             id="en-form">
                                            <label class="input-label">{{('name')}}
                                                ({{strtoupper('en')}})</label>
                                            <input type="text" name="name[]"
                                                   value="{{$category['name']}}"
                                                   class="form-control"
                                                   placeholder="{{('New')}} {{('Category')}}" required>
                                        </div>
                                        <input type="hidden" name="lang[]" value="en">
                                </div>
                                <!--image upload only for main category-->
                                @if($category['parent_id']==0)
                                    <div class="col-6 from_part_2">
                                        <label>{{('image')}}</label><small style="color: red">
                                            ( {{('ratio')}} 3:1 )</small>
                                        <div class="custom-file" style="text-align: left">
                                            <input type="file" name="image" id="customFileEg1"
                                                   class="custom-file-input"
                                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label"
                                                   for="customFileEg1">{{('choose')}} {{('file')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-12 from_part_2">
                                        <div class="form-group">
                                            <hr>
                                            <center>
                                                <img style="width: 30%;border: 1px solid; border-radius: 10px;"
                                                     id="viewer"
                                                     src="{{asset('storage/category')}}/{{$category['icon']}}"
                                                     alt=""/>
                                            </center>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary">{{('update')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script>
        $(".lang_link").click(function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
            if (lang == 'en') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });

        $(document).ready(function () {
            $('#dataTable').DataTable();
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
