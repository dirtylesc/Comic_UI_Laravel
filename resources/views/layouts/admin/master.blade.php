<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    @include('libraries')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app-creative.min.css') }}">
    @stack('css')
    <style>
        .bullet {
            display: inline-block;
            border-radius: 6px;
            width: 8px;
            height: 4px;
            flex-shrink: 0;
            background-color: var(--bg_bullet);
        }

        .bullet-dot {
            width: 4px;
            height: 4px;
            border-radius: 100% !important;
        }

        .menu-item {
            display: block;
            padding: 0.15rem 0;
        }

        .menu-item a span {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .current {
            background-color: #4FC9DA;
            border-radius: 0.95rem;
        }

        .currentSpan {
            color: var(--bg_bullet);
        }

        .current .currentSpan {
            color: var(--bg_fff) !important;
        }

        .current .bullet {
            background: var(--bg_fff) !important;
        }

        td {
            padding: .5rem .5rem !important;
        }
    </style>
</head>

<body>
    <section>
        <div class="container-fluid m-0">
            <div class="row">
                @include('layouts.admin.sidebar')
                <div class="content col-md-10" style="margin-left: 270px">
                    @yield('content-header')
                    @yield('content-wrapper')
                </div>
            </div>
        </div>
    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script rel="text/javascript" src="{{ asset('js/vendor.min.js') }}"></script>
<script rel="text/javascript" src="{{ asset('js/app.min.js') }}"></script>
<script rel="text/javascript" src="{{ asset('js/constants/api.js') }}" type="module"></script>
<script rel="text/javascript" src="{{ asset('js/helper.js') }}" type="module"></script>
@stack('js')

</html>
