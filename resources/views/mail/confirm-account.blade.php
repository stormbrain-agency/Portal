<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailContent['subject'] }}</title>
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
        .note{
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="wrap-content">
        <div class="mb-2">
            <a href="https://supplementalratepayment.org/" target="_blank">
                <img width="186px" src="{{ $message->embedData(file_get_contents(public_path('libs/images/logo.png')), 'logo.png', 'image/png') }}" alt="Logo">
            </a>
        </div>
        <br>
        <p>
            <b>Hi, {{$data['name']}}!</b>
        </p>
        <p>{{ $emailContent['body'] }}</p>
        <br>
        @if (isset($data['first_login']) && $data['first_login'] == true)
        <p class="note">
            <i>"NOTE: please use your email address as the username and password on your first login. You may reset your password in Settings once logged in."</i>
        </p>
        @endif
        <a href="{{ $data['link'] }}" target="_blank" class="btn-confirm">{{ $emailContent['button_title'] }}</a>
    </div>
    <br>
    <div class="copyright">©️ 2023 Supplemental Rate Payment Program | CDA. All rights reserved.</div>
</body>
</html>
