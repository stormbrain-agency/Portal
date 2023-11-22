<!DOCTYPE html>
<html lang="en">
<head>
    <title>Notification Mail</title>
</head>
<body>
    <div class="wrap-content" style="color: #000000;">
        <p>Confirmation: Lorem ipsum dolor sit amet consectetur adipisicing elit. Est aliquid rerum temporibus commodi tenetur eaque delectus facere omnis officiis ut libero perferendis fugiat expedita dolore quae, repellendus enim deserunt hic!</p>
        <p>Date/Time of Registration: {{$time}}</p>
        <p>User Email Address: {{$email}}</p>
        <p>County Designation: {{$county_designation}}</p>
        <a href="{{$link}}" target="_blank" class="btn-confirm" style="display: inline-block;cursor: pointer;padding: 6px 100px;background-color: #3e97ff;color: #ffffff;font-size: 1.1rem;font-weight: 500;text-decoration: none;">APPROVE / DENY ACCOUNT</a>
        <p>Thank you,</p>
        <p>County Designation: {{$county_designation}}</p>
    </div>
</body>
</html>
