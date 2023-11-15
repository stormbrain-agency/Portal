<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mail Notification</title>
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
            background-color: #3E97FF;
            color: #FFFFFF;
            font-size: 1.1rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="wrap-content">
        <h1>Please confirm your account.</h1>
        <p>
            Thank you for registering. To complete your registration, please click the button below:
        </p>
        <a href="{{ $data['link'] }}" target="_blank" class="btn-confirm">CONFIRM ACCOUNT</a>
        <p>
            If you didn't create an account, you can safely ignore this email.
        </p>
    </div>
</body>
</html>
