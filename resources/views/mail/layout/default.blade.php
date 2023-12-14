<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('mail.styles.style')
    @hasSection('title')
       <title>@yield('title')</title>
    @endif
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #F1F3F8;">
  <table role="presentation" align="center" cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse; max-width: 600px; margin: auto;">
      <tr>
          <td class="email-body">
              <div style="text-align: center;">
                <a href="https://supplementalratepayment.org/" target="_blank">
                    <img width="186px" src="{{ $message->embedData(file_get_contents(public_path('libs/images/logo.png')), 'logo.png', 'image/png') }}" alt="Logo" style="max-width: 100%; height: auto;">
                </a>
              </div>

              @yield('content')
              <p style="color: #b7b7b7; font-size: 12px; margin-top: 20px; text-align: center;">©️ 2023 Supplemental Rate Payment Program | CDA. All rights reserved.</p>
          </td>
      </tr>
  </table>
</body>
</html>
