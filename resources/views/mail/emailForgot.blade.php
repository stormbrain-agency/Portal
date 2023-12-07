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
            padding: 8px 16px;
            background-color: #002559;
            color: #FFFFFF !important;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="wrap-content" style="color: #000000;">
        <div class="mb-2">
            <img width="186px" src="{{ $message->embedData(file_get_contents(public_path('libs/images/logo.png')), 'logo.png', 'image/png') }}" alt="Logo">
        </div>
        <br>
        <p>You have requested to reset your password for your {{ config('app.name') }} account.</p>
        <p>To reset your password, please click on the following link:</p>
        <a href="{{$actionUrl}}" target="_blank" class="btn-confirm">RESET PASSWORD</a>
    </div>
</body>
</html>
