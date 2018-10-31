<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Donation App</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/validation.min.js"></script>
    <script src="js/login.js"></script>
    <style>
        .error-div,
        .error,
        #error{
            color: red;
        }
    </style>
</head>
<body>
<div class="container justify-content-center">
    <div class="row" style="margin-top: 150px">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2 class="text-center">Login</h2>
            <form method="post" id="loginForm">
                <div class="error-div">

                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <a href="signup.php">Click here to sign up</a>
                <br>
                <br>
                <button class="btn btn-primary" type="submit" id="submit-login">Login</button>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
</body>
</html>
