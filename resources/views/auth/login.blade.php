<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('assets/signInAssets/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('assets/signInAssets/css/style.css') }}">
</head>

<body>
    <div class="main">
        <!-- Sign in Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="{{ asset('assets/signInAssets/images/signin-image.jpg') }}" alt="sign in image"></figure>
                        <a href="{{ route('register') }}" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign In</h2>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 text-green-600 font-semibold">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="register-form" id="login-form">
                            @csrf

                            <div class="form-group">
                                <label for="login"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" id="login" name="login" value="{{ old('login') }}" required autofocus placeholder="Email / Name / Phone">
                            </div>

                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" id="password" name="password" required placeholder="Password">
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="remember" id="remember" class="agree-term" />
                                <label for="remember" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>

                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
                            </div>

                            @if ($errors->any())
                                <div class="text-red-600 mt-2">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (Route::has('password.request'))
                                <div class="mt-2">
                                    <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-900">
                                        Forgot your password?
                                    </a>
                                </div>
                            @endif

                        </form>

                        {{-- <div class="social-login mt-4">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div> --}}

                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="{{ asset('assets/signInAssets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/signInAssets/js/main.js') }}"></script>
</body>

</html>
