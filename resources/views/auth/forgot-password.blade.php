<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('assets/signInAssets/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('assets/signInAssets/css/style.css') }}">
</head>

<body>
    <div class="main">
        <!-- Forgot Password Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="{{ asset('assets/signInAssets/images/forgot_pass.webp') }}" alt="forgot password image"></figure>
                        <a href="{{ route('login') }}" class="signup-image-link">Back to login</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Forgot Password</h2>

                        <div class="mb-4 text-sm text-gray-600">
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 text-green-600 font-semibold">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="register-form" id="forgot-form">
                            @csrf

                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required autofocus />
                            </div>

                            @if ($errors->has('email'))
                                <div class="text-red-600 mt-2">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif

                            <div class="form-group form-button mt-4">
                                <input type="submit" name="reset" id="reset" class="form-submit" value="Email Password Reset Link" />
                            </div>
                        </form>

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

