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
            <p>
                <b>Welcome, {{$data['name']}}!</b>
            </p>
            {{ $emailContent['body'] }}
            {{-- <p>Congratulations! You are now part of the Supplemental Rate Payment Program.</p>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

            <ul style="color: #002559;">
                <li>Proin eu metus eu est tincidunt auctor.</li>
                <li>Integer vitae elit nec justo bibendum fermentum.</li>
                <li>Curabitur sit amet libero in urna tristique laoreet.</li>
            </ul>

            <ol style="color: #002559;">
                <li>Duis condimentum urna in lacus sagittis, vitae fringilla odio fermentum.</li>
                <li>Vivamus eu nisi ac justo congue pulvinar.</li>
                <li>Fusce auctor justo eu metus vehicula, vitae laoreet purus imperdiet.</li>
            </ol> --}}

            <p>
                <a href="{{$data['link']}}" target="_blank" class="btn-confirm">{{ $emailContent['button_title'] }}</a>
            </p>
        </div> 
        <div class="copyright">
            <p>
                ©️ 2023 Supplemental Rate Payment Program | CDA. All rights reserved.
            </p>
        </div>
    </div>
   
</body>
</html>
