<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailContent['subject'] }}</title>
    @include('mail.styles.style')
</head>
<body>
    <div class="body">
        <div class="mb-2 logo-wrapper">
            <a href="https://supplementalratepayment.org/" target="_blank">
                <img width="186px" src="{{ $message->embedData(file_get_contents(public_path('libs/images/logo.png')), 'logo.png', 'image/png') }}" alt="Logo">
            </a>
        </div>
        <div class="wrap-content mail">
            <p>
                <b>Hi, {{$data['name']}}!</b>
            </p>
            <p>{{ $emailContent['body'] }}</p>
            @if (isset($data['first_login']) && $data['first_login'] == true)
            <p class="note">
                <i>"NOTE: please use your email address as the username and password on your first login. You may reset your password in Settings once logged in."</i>
            </p>
            @endif
            <a href="{{ $data['link'] }}" target="_blank" class="btn-confirm">{{ $emailContent['button_title'] }}</a>
        </div>
        <div class="copyright">
            <p>
                ©️ 2023 Supplemental Rate Payment Program | CDA. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>