<div class="log_function d-flex align-items-center">
    <div class="nothing" id="nothing_"></div>
    <div class="container">
        <div class="title">
            <div class="logo">
                <h2>Welcome to DirtyLesc</h2>
            </div>
            <p>Access tons of novels and manga with a single login</p>
        </div>
        <div id="form_content">
            <form action="{{ route('process_login') }}" method="POST" id="form_login">
                @csrf
                <h3 id="h3_log_in">Login Account</h3>
                <div class="success"></div>
                <ul id="ul_login" class="ps-0">
                    <div class="login_errors"></div>
                    <li id="username_login"><span class="col-3">Email</span> <input class="col-9" type="text"
                            name="email"></li>
                    <li id="password_login"><span class="col-3">Password</span> <input class="col-9" type="password"
                            name="password"></li>
                    <li id="submit_1"><button>Submit</button></li>
                    <li id="dha"><a href="###">Don't have an account?</a></li>
                    <li><a>OR</a></li>
                    <li id="fa"><a href="###">Forget your password?</a></li>
                </ul>
            </form>
            <form action="{{ route('api.registering') }}" method="POST" id="form_register">
                @csrf
                <h3 id="h3_sign_up">Register Account</h3>
                <ul id="ul_register" class="ps-0">
                    <div class="register_errors"></div>
                    <li id="username_signup">
                        <span class="col-4">Username</span>
                        <input type="text" name="nickname">
                    </li>
                    <li id="gmail">
                        <span class="col-4">Email</span>
                        <input type="email" name="email">
                    </li>
                    <li id="password_signup">
                        <span class="col-4">Password</span>
                        <input type="password" name="password">
                    </li>
                    <li id="re_password">
                        <span class="col-4">Re-Password</span>
                        <input type="password" name="password_confirmation">
                    </li>
                    <li id="submit_2">
                        <button class="btn btn-primary">Submit</button>
                    </li>
                    <li id="ha">
                        <a href="###">Have an account?</a>
                    </li>
                    <li><a>OR</a></li>
                    <li id="fa"><a href="###">Forget your password?</a></li>
                </ul>
            </form>
            <div class="soliate d-flex align-items-center justify-content-center">
                <a href="{{ route('auth.redirect', 'github') }}" class="bg-gray-800"><i
                        class="fa-brands fa-github"></i></a>
                <a href="{{ route('auth.redirect', 'google') }}" class="bg-gray-800"><i
                        class="fa-brands fa-google ms-3"></i></a>
            </div>
        </div>
        <div class="company_info">
            <ul class="ps-0 d-flex justify-content-center">
                <li>© 2022 DirtyLess</li>
                <li><a href="">Terms of Service</a></li>
                <li><a href="">Privacy Policy</a></li>
            </ul>
        </div>
    </div>
</div>
