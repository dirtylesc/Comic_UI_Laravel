<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đồ Án Cơ Sở 2</title>
    @include('libraries')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reader/style.css') }}">
    @stack('css')
</head>

<body>
    @include('layouts.reader.header')
    @include('layouts.reader.login_form')
    <section id="side-middle">
        <div class="px-0 mx-0 w_100">
            <div class="me-0 w_100">
                @yield('content')
            </div>
        </div>
    </section>
    @include('layouts.reader.contact_box')
    <div class="notification">
    </div>
    @include('layouts.reader.footer')
</body>
<script type="module" src="{{ asset('js/reader/app.js') }}"></script>
<script rel="text/javascript" src="{{ asset('js/vendor.min.js') }}"></script>
<script rel="text/javascript" src="{{ asset('js/app.min.js') }}"></script>
<script src="{{ asset('js/helper.js') }}"></script>
<script>
    $(window).click(function(e) {
        if (!$(e.target).closest('.user_login').length) {
            $('#user_up').prop('checked', false);
        }
    });

    $('.dropdown .btn').click(function() {
        $('#user_up').prop('checked', false);
    });

    $('.library').click(function(e) {
        $.ajax({
            url: "{{ route('api.check_login') }}",
            type: "POST",
            success: function(data) {
                if (data.success) {
                    window.location.href = "{{ route('reader.library') }}";
                }
            },
            error: function(data) {
                if (!data.success) {
                    $('.log_function').addClass('hold_show');
                }
            }
        })
    });
</script>
@include('clients.reader.login_register')
@include('clients.reader.module_search')
@stack('js')

</html>
