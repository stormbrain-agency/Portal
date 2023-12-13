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
        <div class="wrap-content mail" style="color: #000000;">
            <p>{{ $emailContent['body'] }}</p>
            <ul class="list">
                <p>Date/Time of Registration: {{$data['time']}}</p>
                <p>User Email Address: {{$data['email']}}</p>
                <p>County Designation: {{$data['county_designation']}}</p>
            </ul>
            <a href="{{$data['link']}}" target="_blank" class="btn-confirm">{{ $emailContent['button_title'] }}</a>
        </div>
        <div class="copyright">
            <p>
                ©️ 2023 Supplemental Rate Payment Program | CDA. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
