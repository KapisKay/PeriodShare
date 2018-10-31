<?php session_start();
require_once 'includes/dbconfig.php';
include_once 'includes/functions.php';

if(isset($_GET['community']) && isset($_GET['name']) && isset($_GET['quantity'])) {

    $user_id = $_SESSION['donor_app_session_key'];
    $community = checkValues($_GET['community']);
    $item_name = checkValues($_GET['name']);
    $quantity = checkValues($_GET['quantity']);

    $query = mysqli_query($con, "INSERT INTO donations(user_id, item_name, item_quanity, community_id) 
                                         VALUES ('$user_id','$item_name','$quantity','$community')");

    if($query){
        echo 'success';
    }
    else{
        echo 'error';
    }
}
else{
    echo 'noData';
}