<?php
require_once 'includes/dbconfig.php';
include_once 'includes/functions.php';

if(isset($_GET['name']) && isset($_GET['region']) && isset($_GET['girls']) && isset($_GET['contact_person']) && isset($_GET['contact_number'])){
    $name = checkValues($_GET['name']);
    $region = checkValues($_GET['region']);
    $girls = checkValues($_GET['girls']);
    $contact_person = checkValues($_GET['contact_person']);
    $contact_number = checkValues($_GET['contact_number']);
    $query = mysqli_query($con, "INSERT INTO communities (community_name, community_region, num_of_girls, community_contact_name, community_contact_number) 
                                                          VALUES ('$name','$region','$girls','$contact_person','$contact_number')");
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
