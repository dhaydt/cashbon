<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title')</title>
    <!-- Favicon -->
    <link href="{{ asset('storage/company/'.$web_config['fav_icon']->value) }}" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Extra details for Live View on GitHub Pages -->

    <!-- Icons -->
    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Argon CSS -->
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/back-end/css/main.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .main-content .header.bg-primary {
            background-color: {{$web_config['primary_color']}} !important;
        }

        .breadcrumb-item {
            text-transform: capitalize;
        }

        table.table {
            color: #5e72e4;
        }

        .switch {
            position: relative;
            display: inline-block;
        }

        .switch.switch-status input {
            width: 38px;
            height: 20px;
            cursor: pointer;
        }
        .avatar-group .avatar {
            z-index: 0;
        }

        td span {
            color: grey;
        }

        .legend-indicator {
            display: inline-block;
            width: 0.5rem;
            height: 0.5rem;
            background-color: #bdc5d1;
            border-radius: 50%;
            margin-right: 0.4375rem;
        }

        /* cart */
        .widget-cart-item {
            position: relative;
        }
        .widget-product-title {
            font-family: 'Roboto', sans-serif;
            position: relative;
            margin-bottom: 0.25rem;
            font-size: .875rem;
            font-weight: 500;
        }
        .widget-product-title a{
            color: black !important;
            text-decoration: none;
            text-transform: capitalize;
            background-color: transparent;
        }
        .widget-product-meta {
            font-size: .875rem;
        }
        .text-accent {
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: #000;
        }
        hr {
            margin: 0;
            border: 0;
            border-top: 1px solid #e3e9ef;
        }
        .navbar-tool-icon-box {
            color: {{$web_config['primary_color']}};
        }

        .navbar-tool-text {
            padding-left: 5px !important;
            font-size: 16px;
        }

        .navbar-tool-label {
            position: absolute;
            top: -.3125rem;
            right: -.3125rem;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            background-color: {{$web_config['secondary_color']}}!important;
            color: #fff;
            font-size: .75rem;
            font-weight: 500;
            text-align: center;
            line-height: 1.25rem;
        }
        .navbar-tool-text > small {
            color: #4b566b !important;
        }
    </style>
</head>

<body class="{{ $class ?? '' }}">
    @auth('admin')
    <form id="logout-form" action="{{ route('admin.auth.logout') }}" method="GET" style="display: none;">
        @csrf
    </form>
    @include('layouts.backend.partials._sidebar')
    @endauth

    <div class="main-content">
        @if(!Route::is('admin.auth.adminLogin'))
        @include('layouts.backend.partials._header')
        @endif
        @yield('content')
    </div>

    @guest()
    @if(!Route::is('admin.auth.adminLogin'))
    {{-- @include('layouts.backend.partials._footer') --}}
    @endif
    @endguest
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- JS Front -->
    @if(Route::is('admin.auth.adminLogin'))
    <script src="{{asset('assets/back-end')}}/js/vendor.min.js"></script>
    @endif
    <script src="{{asset('assets/back-end')}}/js/theme.min.js"></script>
    <script src="{{asset('assets/back-end')}}/js/sweet_alert.js"></script>
    <script src="{{asset('assets/back-end')}}/js/toastr.js"></script>
    {!! Toastr::message() !!}
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

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

    @stack('js')
    <script>
        $(document).on('ready', function () {
        $('.js-select2-custom').each(function () {
            var select2 = $.HSCore.components.HSSelect2.init($(this));
        });

        // INITIALIZATION OF UNFOLD
        // =======================================================
        $('.js-hs-unfold-invoker').each(function () {
            var unfold = new HSUnfold($(this)).init();
        });


        // INITIALIZATION OF FORM SEARCH
        // =======================================================
        $('.js-form-search').each(function () {
            new HSFormSearch($(this)).init()
        });


        // INITIALIZATION OF SELECT2
        // =======================================================
        $('.js-select2-custom').each(function () {
            var select2 = $.HSCore.components.HSSelect2.init($(this));
        });


        // INITIALIZATION OF DATERANGEPICKER
        // =======================================================
        $('.js-daterangepicker').daterangepicker();

        $('.js-daterangepicker-times').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'M/DD hh:mm A'
            }
        });

        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#js-daterangepicker-predefined .js-daterangepicker-predefined-preview').html(start.format('MMM D') + ' - ' + end.format('MMM D, YYYY'));
        }

        $('#js-daterangepicker-predefined').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);


        // INITIALIZATION OF CLIPBOARD
        // =======================================================
        $('.js-clipboard').each(function () {
            var clipboard = $.HSCore.components.HSClipboard.init(this);
        });
    });
    function checkAddToCartValidity() {
        var names = {};
        $('#add-to-cart-form input:radio').each(function () { // find unique names
            names[$(this).attr('name')] = true;
        });
        var count = 0;
        $.each(names, function () { // then count them
            count++;
        });
        if ($('input:radio:checked').length == count) {
            return true;
        }
        return false;
    }
    function removeFromCart(key) {
        $.post('{{ route('admin.order.remove') }}', {_token: '{{ csrf_token() }}', key: key}, function (response) {
            console.log(response)
            updateNavCart();
            location.reload();
            $('#cart-summary').empty().html(response.data);
            toastr.info('{{('Item has been removed from cart')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        });
    }
    function updateNavCart() {
        $.post('{{route('admin.order.nav-cart')}}', {_token: '{{csrf_token()}}'}, function (response) {
            $('#cart_items').html(response.data);
        });
    }

    function updateCartQuantity(key) {
        var quantity = $("#cartQuantity" + key).children("option:selected").val();
        $.post('{{route('admin.order.updateQuantity')}}', {
            _token: '{{csrf_token()}}',
            key: key,
            quantity: quantity
        }, function (response) {
            if (response.status == 0) {
                toastr.error(response.message, {
                    CloseButton: true,
                    ProgressBar: true
                });
                $("#cartQuantity" + key).val(response['qty']);
            } else {
                updateNavCart();
                $('#cart-summary').empty().html(response);
            }
        });
    }

    function cartQuantityInitialize() {
        $('.btn-number').click(function (e) {
            e.preventDefault();

            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());

            if (!isNaN(currentVal)) {
                if (type == 'minus') {

                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {

                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });}

    </script>
    @stack('script')
    @stack('script_2')
    <!-- Argon JS -->
    <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
