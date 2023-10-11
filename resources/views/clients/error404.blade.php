<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('libraries')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link href="{{ asset('css/app-creative.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
</head>

<body class="authentication-bg" data-layout-config="{&quot;darkMode&quot;:false}" data-leftbar-compact-mode="condensed">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card">
                        <!-- Logo -->
                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <a href="{{ route('reader.index') }}" style="color: var(--bg_fff)" class="lc1_5">
                                <h3>Dirtylesc Company</h3>
                            </a>
                        </div>

                        <div class="card-body p-4">
                            <div class="text-center">
                                <h1 class="text-error">404</h1>
                                <h4 class="text-uppercase text-danger mt-3">Page Not Found</h4>
                                <p class="text-muted mt-3">It's looking like you may have taken a wrong turn. Don't
                                    worry... it
                                    happens to the best of us. Here's a
                                    little tip that might help you get back on track.</p>

                                <a class="btn btn-info mt-3" href="{{ route('reader.index') }}"> Return Home</a>
                            </div>
                        </div> <!-- end card-body-->
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        2018 - 2020 © Hyper - Coderthemes.com
    </footer>
</body>

</html>
