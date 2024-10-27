<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    /* Background Image */
    background-image: url("images/ustpalter.png");
    background-size: cover; /* Cover the entire background */
    background-repeat: no-repeat; /* Prevent background image from repeating */
    overflow: hidden;
}
        .login-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 500px;
            margin: auto;
            margin-top: 10%;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background-color:rgb(13,28,60); /* Adjust the alpha value (last parameter) for transparency */
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            border-radius:30px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 160%;
            padding: 12px;
            margin-bottom: 20px;
            margin-left: -40px;
            border: 1px solid #ccc;
            border-radius: 30px;
            transition: border-color 0.3s ease;
        }
        .login-container input[type="text"]:focus,
        .login-container input[type="password"]:focus {
            border-color: #007bff;
        }
        .login-container input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 3px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .login-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            position: relative;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            padding-left: 40px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group .fa {
            position: absolute;
            left: -70px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(251,180,20,255);
            font-size: 25px;
        }
        img {
            margin-bottom:10px;
            width: 90px;
            height: 90px;
            border-radius: 100px;
        }
        .btn {
            width: 75px;
            height: 40px;
            border-radius: 15px;
            border: none;
            margin-left: 60px;
        }
        .btn:hover {
            background-color: green;
        }
    </style>
</head>
<body>
    <div class="login-container">
    <img src="images/logo.png" alt="Login Image">
        <form action="login.php" method="post">
            <div class="form-group">
                <i class="fa fa-user"></i>
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <i class="fa fa-lock"></i>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
