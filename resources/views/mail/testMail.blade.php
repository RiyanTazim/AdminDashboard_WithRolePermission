{{-- Hey {{ $data }},<br>
This  is  a Demo Mailtrap testing. --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            padding: 30px;
        }
        .otp-code {
            font-size: 32px;
            letter-spacing: 8px;
            font-weight: bold;
            color: #0d6efd;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            font-size: 13px;
            color: #999999;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="email-container">
    <h2 class="text-center mb-3">Email Verification Code</h2>

    {{-- <p>Dear {{ $user->name }},</p> --}}

    <p>Your One-Time Password (OTP) for email verification is:</p>

    {{-- <div class="otp-code">{{ $user->email_otp }}</div> --}}
    <p>
    This code will expire at
    {{-- {{ \Carbon\Carbon::parse($user->otp_expires_at)->format('h:i A') }} ({{ \Carbon\Carbon::parse($user->otp_expires_at)->diffForHumans() }}) --}}
</p>


    <p>Please enter this code on the verification page. This code will expire in 1 minutes.</p>

    <p>If you did not request this, please ignore this email.</p>

    <div class="footer">
        &copy; {{ date('Y') }} . All rights reserved.
    </div>
</div>

</body>
</html>
