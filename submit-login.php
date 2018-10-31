<?php session_start();
require_once 'includes/dbconfig.php';
include_once 'includes/functions.php';

if(isset($_GET['email']) && isset($_GET['password'])){
    $email = checkValues($_GET['email']);
    $pass = checkValues($_GET['password']);

    $pass = md5($pass);
    $query = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' AND password = '$pass'");
    if($query){
        $num = mysqli_num_rows($query);
        if($num == 1){
            $res = mysqli_fetch_array($query);
            $id = $res['user_id'];
            echo 'success';
            $_SESSION['donor_app_session_key'] = $id;
        }
        else{
            echo 'noUser';
        }
    }
    else{
        echo 'error';
    }
}
else{
    echo 'noData';
}
