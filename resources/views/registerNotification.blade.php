<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Form</title>
</head>
<body>
    <style>
        .form-group{
           display: flex;
           margin-bottom : 12px;
        }

        form label{
            width: 165px;
            display: block;
        }
        
        form button[type="submit"]{
            padding: 6px 24px;
            background-color: #ff0000;
            color: #ffffff;
            border: 1px solid #000000;
            cursor: pointer;
        }
    </style>
    <form action="{{ route('send-email') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Full Name :</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password :</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmation Password :</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</body>
</html>