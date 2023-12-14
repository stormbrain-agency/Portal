<!-- mail/welcome-email.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailContent['subject'] }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #F1F3F8;">
    <table role="presentation" align="center" cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse; max-width: 600px; margin: auto; background-color: #F1F3F8;">
        <tr>
            <td style="padding: 40px; margin-top:40px;">
                <div style="text-align: center;">
                    <a href="https://supplementalratepayment.org/" target="_blank">
                        <img width="186px" src="{{ $message->embedData(file_get_contents(public_path('libs/images/logo.png')), 'logo.png', 'image/png') }}" alt="Logo" style="max-width: 100%; height: auto;">
                    </a>
                </div>
                <div style="border-radius: 5px; color: #000000; line-height: 1.6; background-color: #FFFFFF; border: 1px solid #f1f1f1; padding: 20px; box-shadow: 1px 1px 5px 1px #f1f1f1; margin-top: 20px; text-align: left; width: 100%;">
                    <p style="color: #000000;">{{ $emailContent['body'] }}</p>
                    <p style="color: #000000;">Details of the submission:</p>
                    <ul style="color: #000000;">
                        <li style="color: #000000;">Date/Time of Submission: {{ $data['time'] }}</li>
                        <li style="color: #000000;">Month/Year of documents Submitted: {{ $data['month_year'] }}</li>
                        <li style="color: #000000;">Submitted by: {{ $data['name'] }}</li>
                        <li style="color: #000000;">User Email Address: {{ $data['email'] }}</li>
                        <li style="color: #000000;">County Designation: {{ $data['county_designation'] }}</li>
                    </ul>
                    <p><a style="display: inline-block; cursor: pointer; padding: 7px 12px; background-color: #002559; color: #FFFFFF; font-size: 14px; font-weight: 500; text-decoration: none; border-radius: 3px; margin-top: 15px;" href="{{ url('/county-provider-payment-report')}}" target="_blank" >{{ $emailContent['button_title'] }}</a></p>
                </div>
                <p style="color: #b7b7b7; font-size: 12px; margin-top: 20px; text-align: center;">©️ 2023 Supplemental Rate Payment Program | CDA. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>
</html>