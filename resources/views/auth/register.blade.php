<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign Up</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('assets/signInAssets/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('assets/signInAssets/css/style.css') }}">
</head>
<body>

    <div class="main">
        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>

                        <form method="POST" action="{{ route('register') }}" class="register-form" id="register-form">
                            @csrf

                            {{-- Name --}}
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name" value="{{ old('name') }}" required />
                            </div>
                            @error('name')
                                <p class="text-danger" style="color:red">{{ $message }}</p>
                            @enderror

                            {{-- Email --}}
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" value="{{ old('email') }}" required />
                            </div>
                            @error('email')
                                <p class="text-danger" style="color:red">{{ $message }}</p>
                            @enderror

                            {{-- Password --}}
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password" required />
                            </div>
                            @error('password')
                                <p class="text-danger" style="color:red">{{ $message }}</p>
                            @enderror

                            {{-- Confirm Password --}}
                            <div class="form-group">
                                <label for="password_confirmation"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repeat your password" required />
                            </div>
                            @error('password_confirmation')
                                <p class="text-danger" style="color:red">{{ $message }}</p>
                            @enderror

                            {{-- Optional: Terms --}}
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term">
                                    <span><span></span></span>I agree to all statements in <a href="#" class="term-service">Terms of service</a>
                                </label>
                            </div>

                            {{-- Submit --}}
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>

                    <div class="signup-image">
                        <figure><img src="{{ asset('assets/signInAssets/images/signup-image.jpg') }}" alt="sign up image"></figure>
                        <a href="{{ route('login') }}" class="signup-image-link">I am already member</a>
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
