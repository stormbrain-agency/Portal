<!DOCTYPE html>
<html lang="en">
<head>
    <title>“W-9” Submission Confirmation</title>
</head>
<body>
    <p>This alert is to notify you that a W-9 submission has ben received. The details of the submission are as follows: </p>
    <ul>
        <li>
            <span>Date/Time of Submission: </span>
            <span>{{$data_time_submission}}</span>
        </li>
        <li>
            <span>Submission: </span>
            <span>{{$submitted}}</span>
        </li>
        <li>
            <span>User Email Address: </span>
            <span>{{$user_email_address}}</span>
        </li>
        <li>
            <span>County Designation: </span>
            <span>{{$county_designation}}</span>
        </li>
    </ul>
    <a href="{{$link}}" class="btn-confirm" style="display: inline-block;cursor: pointer;padding: 6px 100px;background-color: #3e97ff;color: #ffffff;font-size: 1.1rem;font-weight: 500;text-decoration: none;">View Submission History</a>
</body>
</html>