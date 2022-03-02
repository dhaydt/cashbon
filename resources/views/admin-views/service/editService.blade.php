@extends('layouts.backend.app')

@section('title', 'Service Edit')

@push('css_or_js')
<link href="{{asset('public/assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
<link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
@include('admin-views.service.partials._headerAddNew')
<!-- Page Heading -->
<div class="content container-fluid mt--8">
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form class="product-form" action="{{route('admin.updateService',$product->id)}}" method="post"
                style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left' }};"
                enctype="multipart/form-data" id="product_form">
                @csrf

                <div class="card">
                    <div class="card-header">
                        {{-- @php($language=\App\Model\BusinessSetting::where('type','pnc_language')->first())
                        @php($language = $language->value ?? null) --}}
                        @php($default_lang = 'en')
                        @php($lang = 'en')

                        {{-- @php($default_lang = json_decode($language)[0]) --}}
                        <ul class="nav nav-tabs mb-4">
                            {{-- @foreach(json_decode($language) as $lang) --}}
                            <li class="nav-item">
                                <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}" href="#"
                                    id="{{$lang}}-link">Edit {{ $product->name }}</a>
                            </li>
                            {{-- @endforeach --}}
                        </ul>
                    </div>

                    <div class="card-body">

                        <div class="{{$lang != 'en'? 'd-none':''}} lang_form" id="{{$lang}}-form">
                            <div class="form-group">
                                <label class="input-label" for="{{$lang}}_ame">{{('Name')}}
                                    ({{strtoupper($lang)}})</label>
                                <input type="text" {{$lang=='en' ? 'required' :''}} name="name[]" id="{{$lang}}_name"
                                    value="{{$translate[$lang]['name']??$product['name']}}" class="form-control"
                                    placeholder="{{('New Product')}}" required>
                            </div>
                            <input type="hidden" name="lang[]" value="{{$lang}}">
                            <div class="form-group pt-4">
                                <label class="input-label">{{('Description')}}
                                    ({{strtoupper($lang)}})</label>
                                <textarea name="description[]" style="display:none" class="textarea"
                                    required>{!! $product['details'] !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-2 rest-part">
                    <div class="card-header">
                        <h4>{{('General Info')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="card mt-2 rest-part">
                            <div class="card-header">
                                <h4>Service price & image</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">{{('Unit price')}}</label>
                                            <input type="number" min="0" step="0.01" placeholder="{{('Unit price') }}"
                                                name="unit_price" class="form-control" value={{($product->price)}}
                                            required>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{('Upload product images')}}</label><small style="color: red">*
                                                    (
                                                    {{('ratio')}} 1:1 )</small>
                                            </div>
                                            <div class="p-2 border border-dashed" style="max-width:430px;">
                                                <div class="row" id="coba">
                                                    {{-- {{ dd($product->images) }} --}}
                                                    @foreach (json_decode($product->images) as $key => $photo)
                                                    <div class="col-6">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <img style="width: 100%" height="auto"
                                                                    onerror="this.src='{{asset('assets/img/image-place-holder.png')}}'"
                                                                    src="{{asset("storage/service/".$photo)}}"
                                                                    alt="Product image">
                                                                {{-- <a
                                                                    href="{{route('admin.product.remove-image',['id'=>$product['id'],'name'=>$photo])}}"
                                                                    class="btn btn-danger btn-block">{{('Remove')}}</a>
                                                                --}}

                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <br>
                            </div>
                        </div>

                        <div class="card card-footer">
                            <div class="row">
                                <div class="col-md-12" style="padding-top: 20px">
                                    @if($product->request_status == 2)
                                    <button type="button" onclick="check()" class="btn btn-primary">{{('Update &
                                        Publish')}}</button>
                                    @else
                                    <button type="button" onclick="check()"
                                        class="btn btn-primary">{{('Update')}}</button>
                                    @endif
                                </div>
                            </div>
                        </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script_2')
<script src="{{asset('assets/back-end')}}/js/tags-input.min.js"></script>
<script src="{{asset('assets/back-end/js/spartan-multi-image-picker.js')}}"></script>
<script>
    var imageCount = 1;
        var thumbnail = '{{\App\CPU\ProductManager::product_image_path('thumbnail').'/'.$product->thumbnail??asset('public/assets/back-end/img/400x400/img2.jpg')}}';
        $(function () {
            if (imageCount > 0) {
                $("#coba").spartanMultiImagePicker({
                    fieldName: 'images[]',
                    maxCount: imageCount,
                    rowHeight: 'auto',
                    groupClassName: 'col-6',
                    maxFileSize: '',
                    placeholderImage: {
                        image: '{{asset('assets/back-end/img/400x400/img2.jpg')}}',
                        width: '100%',
                    },
                    dropFileLabel: "Drop Here",
                    onAddRow: function (index, file) {

                    },
                    onRenderedPreview: function (index) {

                    },
                    onRemoveRow: function (index) {

                    },
                    onExtensionErr: function (index, file) {
                        toastr.error('{{('Please only input png or jpg type file')}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    },
                    onSizeErr: function (index, file) {
                        toastr.error('{{('File size too big')}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                });
            }

            $("#thumbnail").spartanMultiImagePicker({
                fieldName: 'image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{('Please only input png or jpg type file')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{('File size too big')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

            $("#meta_img").spartanMultiImagePicker({
                fieldName: 'meta_image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{('Please only input png or jpg type file')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{('File size too big')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function () {
            readURL(this);
        });

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
</script>

<script>
    function check() {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            var formData = new FormData(document.getElementById('product_form'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.updateService',$product->id)}}',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('Service berhasil di update!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#product_form').submit();
                    }
                }
            });
        };
</script>

<script>
    update_qty();

        function update_qty() {
            var total_qty = 0;
            var qty_elements = $('input[name^="qty_"]');
            for (var i = 0; i < qty_elements.length; i++) {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            if (qty_elements.length > 0) {

                $('input[name="current_stock"]').attr("readonly", true);
                $('input[name="current_stock"]').val(total_qty);
            } else {
                $('input[name="current_stock"]').attr("readonly", false);
            }
        }

        $('input[name^="qty_"]').on('keyup', function () {
            var total_qty = 0;
            var qty_elements = $('input[name^="qty_"]');
            for (var i = 0; i < qty_elements.length; i++) {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            $('input[name="current_stock"]').val(total_qty);
        });
</script>

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
            if (lang == 'EN') {
                $(".rest-part").removeClass('d-none');
            } else {
                $(".rest-part").addClass('d-none');
            }
        })
</script>

<script src="{{asset('/')}}vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="{{asset('/')}}vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>

<script>
    $('.textarea').ckeditor({
            contentsLangDirection : '{{Session::get('direction')}}',
        });
</script>
{{--ck editor--}}
@endpush
