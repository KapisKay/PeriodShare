<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Donation App</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">
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
    <div class="row" style="margin-top: 50px">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2 class="text-center">Sign Up</h2>
            <form method="post" id="signupForm">
                <div class="error-div">

                </div>
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group">
                    <label for="cPassword">Confirm Password</label>
                    <input id="cPassword" type="password" class="form-control" name="cPassword" required>
                </div>
                <div class="form-group">
                    <label for="type">User Type</label>
                    <select class="form-control" name="type" id="type">
                        <option value="" disabled selected>-Select User Type-</option>
                        <option value="donor">Donor</option>
                        <option value="receiver">Receiver</option>
                    </select>
                </div>
                <a href="login.php">Click here to log in</a>
                <br>
                <br>

                <button class="btn btn-primary" type="submit" id="submit-signup">Sign Up</button>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
</body>
</html>
