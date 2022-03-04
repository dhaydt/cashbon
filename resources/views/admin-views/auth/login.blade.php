@extends('layouts.backend.app', ['class' => 'bg-default'])

@section('content')
<style>
    .container {
        height: 100vh;
        max-height: 100vh;
    }

    .container .row {
        margin-top: auto;
    }

    .container img {
        height: 80px;
    }
</style>

<div class="container py-3 py-sm-7">
    @php($e_commerce_logo=\App\Models\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)
    <a class="d-flex justify-content-center mb-3" href="javascript:">
        <img class="z-index-2" src="{{asset("storage/company/".$e_commerce_logo)}}" alt="Logo"
             onerror="this.src='{{asset('assets/back-end/img/400x400/img2.jpg')}}'"
             {{-- style="width: 8rem;" --}}
             >
    </a>
    <div class="row justify-content-center h-100 align-items-center">
        <div class="col-lg-7 col-md-8">
            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center text-muted mb-4">
                        <small>
                            Admin Area
                        </small>
                    </div>
                    <form class="js-validate" role="form" method="POST" action="{{route('admin.auth.adminLogin')}}">
                        @csrf

                        <div class="js-form-message form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="pl-2 form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}"
                                    id="signinSrEmail" required data-msg="Please enter a valid email address.">
                            </div>
                            @if ($errors->has('email'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="js-form-message form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input id="signupSrPassword"
                                    class="pl-2 js-toggle-password form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password" placeholder="{{ __('Password') }}" type="password" required
                                    data-hs-toggle-password-options='{
                                    "target": "#changePassTarget",
                                    "defaultClass": "fa-eye-slash",
                                    "showClass": "fa-eye",
                                    "classChangeTarget": "#changePassIcon"
                                }'>
                                <div id="changePassTarget" class="input-group-append">
                                    <a class="input-group-text" href="javascript:">
                                        <i id="changePassIcon" class="fas fa-eye-slash"></i>
                                    </a>
                                </div>
                            </div>
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="custom-control custom-control-alternative custom-checkbox">
                            <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox" {{
                                old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customCheckLogin">
                                <span class="text-muted">{{ __('Remember me') }}</span>
                            </label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary my-4">{{ __('Sign in') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- JS Plugins Init. -->

<!-- JS Implementing Plugins -->
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="{{asset('assets/back-end')}}/js/vendor.min.js"></script>

<!-- JS Front -->
{{-- <script src="{{asset('assets/back-end')}}/js/theme.min.js"></script> --}}
<script src="{{asset('assets/back-end')}}/js/toastr.js"></script>
{!! Toastr::message() !!}

@if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif

<script>
    $(document).on('ready', function () {
        // INITIALIZATION OF SHOW PASSWORD
        // =======================================================
        $('.js-toggle-password').each(function () {
            new HSTogglePassword(this).init()
        });

        // INITIALIZATION OF FORM VALIDATION
        // =======================================================
        $('.js-validate').each(function () {
            $.HSCore.components.HSValidation.init($(this));
        });
    });
</script>


@if(env('APP_MODE')=='demo')
    <script>
        function copy_cred() {
            $('#signinSrEmail').val('admin@admin.com');
            $('#signupSrPassword').val('12345678');
            toastr.success('Copied successfully!', 'Success!', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
@endif
