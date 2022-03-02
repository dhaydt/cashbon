@section('title', 'Edit profile')
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
    }
</style>
@section('content')
@include('admin-views.admin.profile._headerProfile', [
'title' => __('Hello') . ' '. auth('admin')->user()->name,
'description' => __('This is your profile page. You can see the progress you\'ve made with your work and manage your
projects or assigned tasks'),
'class' => 'col-lg-7'
])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="javascript:">
                                <img id="imgPict" src="{{ asset('storage/profile/'.auth('admin')->user()->image) }}"
                                    class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                        {{-- <a href="#" class="btn btn-sm btn-info mr-4">{{ __('Connect') }}</a>
                        <a href="#" class="btn btn-sm btn-default float-right">{{ __('Message') }}</a> --}}
                    </div>
                </div>
                <div class="card-body pt-0 pt-md-4 mt-5">
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <div class="d-flex justify-content-center">
                            <form id="imgForm" method="post" enctype="multipart/form-data">
                                @csrf
                                <a href="javascript:" class="btn btn-sm btn-info">
                                    <input id="changeImg" type="file" name="image" onchange="changeImgs()">
                                    {{ __('Change Image') }}</a>
                                </form>
                            {{-- <a href="#" class="btn btn-sm btn-default float-right">{{ __('Message') }}</a> --}}
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                <div>
                                    <span class="heading">22</span>
                                    <span class="description">{{ __('Friends') }}</span>
                                </div>
                                <div>
                                    <span class="heading">10</span>
                                    <span class="description">{{ __('Photos') }}</span>
                                </div>
                                <div>
                                    <span class="heading">89</span>
                                    <span class="description">{{ __('Comments') }}</span>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="text-center">
                        <h3>
                            {{ auth('admin')->user()->name }}<span class="font-weight-light">, 27</span>
                        </h3>
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i>{{ __('Bucharest, Romania') }}
                        </div>
                        <div class="h5 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>{{ __('Solution Manager - Creative Tim
                            Officer') }}
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>{{ __('University of Computer Science') }}
                        </div>
                        <hr class="my-4" />
                        <p>{{ __('Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes,
                            performs and records all of his own music.') }}</p>
                        <a href="#">{{ __('Show more') }}</a>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">{{ __('Edit Profile') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.adminInfo') }}" autocomplete="off">
                        @csrf
                        @method('put')
                        <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
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
                                <input type="text" name="name" id="input-name"
                                    class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Name') }}"
                                    value="{{ old('name', auth('admin')->user()->name) }}" required autofocus>

                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-phonr">{{ __('Phone') }}</label>
                                <input type="number" name="phone" id="input-phone"
                                    class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Phone') }}"
                                    value="{{ old('phone', auth('admin')->user()->phone) }}" required autofocus>

                                @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                <input type="email" name="email" id="input-email"
                                    class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Email') }}"
                                    value="{{ old('email', auth('admin')->user()->email) }}" required>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                    <hr class="my-4" />
                    <form method="post" action="{{ route('admin.adminPass') }}" autocomplete="off">
                        @csrf
                        @method('put')

                        <h6 class="heading-small text-muted mb-4">{{ __('Password') }}</h6>

                        @if (session('password_status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('password_status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="pl-lg-4">
                            {{-- <input type="hidden" name="email" value="{{ auth('admin')->user()->email }}">
                            <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-current-password">{{ __('Current Password')
                                    }}</label>
                                <input type="password" name="old_password" id="input-current-password"
                                    class="form-control form-control-alternative{{ $errors->has('old_password') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Current Password') }}" value="" required>

                                @if ($errors->has('old_password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('old_password') }}</strong>
                                </span>
                                @endif
                            </div> --}}
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-password">{{ __('New Password') }}</label>
                                <input type="password" name="password" id="input-password"
                                    class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('New Password') }}" value="" required>

                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm New
                                    Password') }}</label>
                                <input type="password" name="c_password" id="input-password-confirmation"
                                    class="form-control form-control-alternative"
                                    placeholder="{{ __('Confirm New Password') }}" value="" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Change password') }}</button>
                            </div>
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
