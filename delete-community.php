<?php
require_once 'includes/dbconfig.php';
include_once 'includes/functions.php';

if(isset($_GET['comId'])){
    $id = checkValues($_GET['comId']);

    $delete = mysqli_query($con, "DELETE FROM communities WHERE community_id = '$id'");
    if($delete){
        $delete_don = mysqli_query($con, "DELETE FROM donations WHERE community_id = '$id'");

        echo 'success';
    }
    else{
        echo 'error';
    }
}
else{
    echo 'noData';
}