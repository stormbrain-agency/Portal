<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .wrap-content {
            color: #000000;
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
        }

        .btn-confirm {
            display: inline-block;
            cursor: pointer;
            padding: 10px 20px;
            background-color: #002559;
            color: #FFFFFF !important;
            font-size: 1.1rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="wrap-content">
        <b>Please confirm your account.</b>
        <p>
            Thank you for registering. To complete your registration, please click the button below:
        </p>
        <br>
        <a href="{{ $data['link'] }}" target="_blank" class="btn-confirm">CONFIRM ACCOUNT</a>
        {{-- <p>
            If you didn't create an account, you can safely ignore this email.
        </p> --}}
    </div>
</body>
</html>
