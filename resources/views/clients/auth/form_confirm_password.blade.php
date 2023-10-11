<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Account</title>
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
                            <a href="index.html" style="color: var(--bg_fff)" class="lc1_5">
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
                            <div class="success"></div>
                            <form action="{{ route('confirm_new_password') }}" method="POST">
                                @csrf
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
                                <div class="form-group">
                                    <label for="password">Re-Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password_confirmation" class="form-control"
                                            placeholder="Enter your password" name="password_confirmation">
                                        <div class="input-group-append" data-password="false">
                                            <div class="input-group-text">
                                                <i class="fa-regular fa-eye"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary" type="submit"> Submit </button>
                                </div>
                            </form>
                            @if (user()->email_verified_at === null)
                                <form action="{{ route('api.vertify_email') }}" method="POST" id="form_vertify">
                                    @csrf
                                    <button class="btn btn-link">Resend email verified..</button>
                                </form>
                            @endif
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
<script>
    $(document).ready(function() {
        $('#form_vertify').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('api.vertify_email') }}",
                type: 'POST',
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success) {
                        console.log(data);
                        $('.login_errors').empty();

                        let string =
                            `<div class="alert alert-info" role="alert">${data.message}</div>`

                        $('.success').html(string);
                    }
                },
                error: function(data) {
                    if (data.responseJSON.errors) {
                        const errors = Object.values(data.responseJSON.errors);
                        showError($('.login_errors'), errors);
                    } else if (!data.success) {
                        $('.login_errors').empty();
                        let string =
                            `<div class="alert alert-danger" role="alert">${data.responseJSON.message}</div>`

                        $('.login_errors').html(string);
                    }
                }
            });
        });
    });
</script>

</html>
