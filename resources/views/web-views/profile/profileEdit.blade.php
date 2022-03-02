@extends('layouts.app', ['class' => 'bg-default'])
<style>
    .card-header img {
        height: 30px;
    }
    .form-row {
        width: 100%;
    }
</style>
@section('content')
<div class="header bg-gradient-primary pt-3 pb-1">
    <div class="container mb-8">
        <div class="header-body text-center mt-7 mb-4">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white">{{ __('Welcome to TigaTech Customer Profile') }}</h1>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <section class="col-lg-9 col-md-9 account-mobile">
                <div class="card box-shadow-sm">
                    <div class="card-header">
                        <form class="mt-3" action="{{route('profile.user-update')}}" method="post"
                            enctype="multipart/form-data">
                            <div class="row photoHeader">
                                @csrf
                                {{-- {{ dd($customer) }} --}}
                                <img id="blah" style=" border-radius: 50px; margin-{{Session::get('direction') === "
                                    rtl" ? 'right' : 'left' }}: 30px; width: 50px!important;height: 50px!important;"
                                    class="rounded-circle border"
                                    onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                    src="{{asset('storage/profile')}}/{{$customer['image']}}">

                                <div class="col-md-10">
                                    <h5 class="font-name">{{$customer->name}}</h5>
                                    <label for="files" style="cursor: pointer; color:{{$web_config['primary_color']}};"
                                        class="spandHeadO">
                                        Change your Profile
                                    </label>
                                    <span style="color: red;font-size: 10px">( * {{('Image ratio should be')}} 1:1
                                        )</span>
                                    <input id="files" name="image" style="visibility:hidden;" type="file">
                                </div>

                                <div class="card-body {{Session::get('direction') === " rtl" ? 'mr-3' : 'ml-3' }}">
                                    <h3 class="font-nameA">Account Information</h3>


                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="firstName">Nama </label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{$customer['name']}}" required>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Email </label>
                                                <input type="email" class="form-control" type="email" id="account-email"
                                                    value="{{$customer['email']}}" disabled>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">Phone Number </label>
                                                {{-- <small class="text-primary">(
                                                    * {{('country_code_is_must')}} {{('like_for_BD_880')}}
                                                    )</small></label> --}}
                                                <input type="number" class="form-control" type="text" id="phone"
                                                    name="phone" value="{{$customer['phone']}}" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="si-password">New Password</label>
                                                <div class="password-toggle">
                                                    <input class="form-control" name="password" type="password"
                                                        id="password">
                                                    <label class="password-toggle-btn">
                                                        <input class="custom-control-input" type="checkbox"
                                                            style="display: none">
                                                        <i class="czi-eye password-toggle-indicator"
                                                            onChange="checkPasswordMatch()"></i>
                                                        <span class="sr-only">{{('Show')}} {{('password')}} </span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="newPass">Confirm Password </label>
                                                <div class="password-toggle">
                                                    <input class="form-control" name="con_password" type="password"
                                                        id="confirm_password">
                                                    <div>
                                                        <label class="password-toggle-btn">
                                                            <input class="custom-control-input" type="checkbox"
                                                                style="display: none">
                                                            <i class="czi-eye password-toggle-indicator"
                                                                onChange="checkPasswordMatch()"></i><span
                                                                class="sr-only">{{('Show')}} {{('password')}} </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id='message'></div>
                                            </div>
                                        </div>
                                        <div class="nav-profiile col-7">
                                            <button type="submit"
                                                class="btn btn-primary float-{{Session::get('direction') === " rtl"
                                                ? 'left' : 'right' }}">{{('Update')}} {{('Informations')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>

    </div>
    <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
            xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
</div>

<div class="container mt--10 pb-5"></div>
@endsection

@push('script')
    <script src="{{asset('assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.js"></script>
    <script src="{{asset('assets/back-end/js/croppie.js')}}"></script>
    <script>
        function checkPasswordMatch() {
            var password = $("#password").val();
            var confirmPassword = $("#confirm_password").val();
            $("#message").removeAttr("style");
            $("#message").html("");
            if (confirmPassword == "") {
                $("#message").attr("style", "color:black");
                $("#message").html("Please ReType Password");

            } else if (password == "") {
                $("#message").removeAttr("style");
                $("#message").html("");

            } else if (password != confirmPassword) {
                $("#message").html("Passwords do not match");
                $("#message").attr("style", "color:red");
            } else if (confirmPassword.length <= 6) {
                $("#message").html("password Must Be 6 Character");
                $("#message").attr("style", "color:red");
            } else {

                $("#message").html("Passwords match.");
                $("#message").attr("style", "color:green");
            }

        }

        $(document).ready(function () {
            $("#confirm_password").keyup(checkPasswordMatch);

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#files").change(function () {
            readURL(this);
        });

    </script>
@endpush
