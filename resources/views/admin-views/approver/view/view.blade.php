@section('title', 'Deatils Customer')
@extends('layouts.backend.app')
<style>
    #changeImg {
        position: absolute;
        opacity: 0;
    }
    #imgPict{
        height: 180px;
        width: 180px;
        background-color: #fff;
        margin-top: -35px;
    }
    .user-name {
        text-transform: capitalize;
    }
</style>
@section('content')
@include('admin-views.approver.view._headerPage', [
'title' => __('Hello') . ' '. $user->name,
'description' => __('This is your profile page. You can see the progress you\'ve made with your work and manage your
projects or assigned tasks'),
'class' => 'col-lg-7'
])

<div class="container-fluid mt--7">
    <div class="row justify-content-center">
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="javascript:">
                                    <img id="imgPict" src="{{ asset('storage/profile/'.$user->image) }}"
                                        class="rounded-circle">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.adminInfo') }}" autocomplete="off">
                        @csrf
                        @method('put')
                        <h6 class="heading-small text-muted mb-4">{{ __($user->name.' information') }}</h6>
                        @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                <input type="text" readonly name="name" id="input-name"
                                    class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Name') }}"
                                    value="{{ old('name', $user->name) }}" required autofocus>

                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-phonr">{{ __('Phone') }}</label>
                                <input type="number" readonly name="phone" id="input-phone"
                                    class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Phone') }}"
                                    value="{{ old('phone', $user->phone) }}" required autofocus>

                                @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                <input type="email" readonly name="email" id="input-email"
                                    class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Email') }}"
                                    value="{{ old('email', $user->email) }}" required>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
{{--
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    function changeImgs() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("changeImg").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("imgPict").src = oFREvent.target.result;
            var formData = new FormData(document.getElementById('imgForm'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.adminPict')}}',
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
                        toastr.success('product updated successfully!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#product_form').submit();
                    }
                }
            });
        };
    };
</script>
