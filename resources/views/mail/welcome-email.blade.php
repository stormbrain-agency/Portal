<!-- mail/welcome-email.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Supplemental Rate Payment Program</title>
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
    <div class="wrap-content" style="color: #000000;">
        <b>Welcome, {{$data['name']}}!</b>
        <p>Congratulations! You are now part of the Supplemental Rate Payment Program.</p>
        
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
        </ol>

        <a href="{{$data['link']}}" target="_blank" class="btn-confirm">Login Now</a>
    </div>
</body>
</html>
