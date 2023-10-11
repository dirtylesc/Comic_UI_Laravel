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

<body class="authentication-bg" data-layout-config="{&quot;darkMode&quot;:false}">
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
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li class="list-style-circle">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('process_login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input class="form-control" type="email" id="email" required=""
                                        placeholder="Enter your email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control"
                                            placeholder="Enter your password" name="password">
                                        <div class="input-group-append" data-password="false">
                                            <div class="input-group-text">
                                                <i class="fa-regular fa-eye"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin"
                                            checked="">
                                        <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary" type="submit"> Log In </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer footer-alt">
        <p style="font-size: 14px; font-weight: bold;" class=".bg-primary">
            © 2022 Dirtylesc Company
        </p>
    </footer>
</body>

</html>
