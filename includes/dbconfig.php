<?php
$host = "localhost";
$user = "root";
$password = "";

    $con = mysqli_connect($host,$user,$password);
    mysqli_select_db($con,"PeriodShare") OR DIE('could not connect to database');

