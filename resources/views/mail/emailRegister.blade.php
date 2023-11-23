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
    <div class="wrap-content" style="color: #000000;">
        <ul class="list">
            <b>Notification Mail</b>
            <p>We would like to inform you that a new user has registered and is awaiting approval.</p>
            <br>
            <p>Date/Time of Registration: {{$time}}</p>
            <p>User Email Address: {{$email}}</p>
            <p>County Designation: {{$county_designation}}</p>
        </ul>
        <a href="{{$link}}" target="_blank" class="btn-confirm">APPROVE / DENY ACCOUNT</a>
    </div>
</body>
</html>