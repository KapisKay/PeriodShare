<?php
require_once 'includes/dbconfig.php';
include_once 'includes/functions.php';

if(isset($_GET['donId']) && isset($_GET['status'])){
    $id = checkValues($_GET['donId']);
    $status = checkValues($_GET['status']);

    $update = mysqli_query($con, "UPDATE donations SET status = '$status' WHERE donation_id = '$id'");
    if($update){

        echo 'success';
    }
    else{
        echo 'error';
    }
}
else{
    echo 'noData';
}