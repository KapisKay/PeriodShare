<?php session_start();
require_once 'includes/dbconfig.php';
include_once 'includes/functions.php';

if(isset($_GET['name']) && isset($_GET['email']) && isset($_GET['password']) && isset($_GET['cPassword']) && isset($_GET['type'])){
    $name = checkValues($_GET['name']);
    $email = checkValues($_GET['email']);
    $pass = checkValues($_GET['password']);
    $cPass = checkValues($_GET['cPassword']);
    $type = checkValues($_GET['type']);
    if($pass == $cPass){
        $pass = md5($pass);
        $query = mysqli_query($con, "INSERT INTO users (fullname, password, user_type, email) VALUES ('$name','$pass','$type', '$email')");
        if($query){
            $id = mysqli_insert_id($con);
            echo 'success';
            $_SESSION['donor_app_session_key'] = $id;
        }
        else{
            echo 'error';
        }
    }
    else{
        echo 'noMatch';
    }
}
else{
    echo 'noData';
}
