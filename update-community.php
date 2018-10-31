<?php
require_once 'includes/dbconfig.php';
include_once 'includes/functions.php';

if(isset($_GET['comId']) && isset($_GET['name']) && isset($_GET['region']) && isset($_GET['girls']) && isset($_GET['contact_person']) && isset($_GET['contact_number'])){
    $name = checkValues($_GET['name']);
    $id = checkValues($_GET['comId']);
    $region = checkValues($_GET['region']);
    $girls = checkValues($_GET['girls']);
    $contact_person = checkValues($_GET['contact_person']);
    $contact_number = checkValues($_GET['contact_number']);

    $query = mysqli_query($con, "UPDATE communities SET community_name = '$name', community_region='$region',num_of_girls='$girls',
                                      community_contact_name='$contact_person', community_contact_number='$contact_number' WHERE community_id='$id'");
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
