<?php session_start();
require_once 'includes/dbconfig.php';
include_once 'includes/functions.php';

$user_id = 0;
if(!isset($_SESSION['donor_app_session_key'])){
    ?>
<div class="alert alert-info">Session expired! Kindly reload page</div>
<?php
    exit();
}
else{
    $user_id = $_SESSION['donor_app_session_key'];
}
?>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/validation.min.js"></script>
<script>
    $(document).ready(function () {
        $('#donationForm').validate({
            rules : {
                community : {
                    required : true
                },
                name : {
                    required : true
                },
                quantity : {
                    required : true
                }
            },
            messages : {
                community : "kindly select the community.",
                name : "kindly enter the item name",
                quantity : "kindly enter the quantity"
            },
            submitHandler : submitDonation
        });

        function submitDonation() {
            var data = $('#donationForm').serialize();
            var btnHtml = 'Donate';
            var errorDiv = $('.errorDiv');
            var btn = $('#submit-form');
            $.ajax({
                url : 'submit-donation.php',
                type: 'get',
                data : data,
                beforeSend : function () {
                    btn.html('<span class="fa fa-spin fa-spinner"></span> validating...').attr('disabled','disabled');
                    errorDiv.html('').fadeOut();
                },
                success : function (data) {
                    alert(data);
                    btn.html(btnHtml).removeAttr('disabled');
                    if(data === 'success'){
                        errorDiv.fadeIn(1000, function () {
                            errorDiv.html('<div class="alert alert-success"><span class="fa fa-check"></span> Donation made! Kindly wait as page reloads</div>');
                        });
                        setTimeout(function () {
                            $('#mainBody').load('donations.php');
                            }, 1500);
                    }
                    else if(data === 'noData'){
                        errorDiv.fadeIn(1000, function () {
                            errorDiv.html('<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> Input all form fields</div>');
                        })
                    }

                    else if(data === 'error'){
                        errorDiv.fadeIn(1000, function () {
                            errorDiv.html('<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> An error occurred, please try again later</div>');
                        })
                    }
                    else{
                        errorDiv.fadeIn(1000, function () {
                            errorDiv.html('<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> Unknown error, kindly try again</div>');
                        })
                    }
                }
            })
        }
    });
</script>
<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-6">
            <div class="box box-primary" style="margin-top: 100px">
                <div class="box-header with-border">
                    <h3 class="box-title">Donation Form</h3>
                </div>
                <form id="donationForm">
                    <div class="box-body">
                        <div class="errorDiv">

                        </div>
                        <div class="form-group">
                            <label for="community">Community</label>
                            <select class="form-control" id="community" name="community" required>
                                <option disabled selected value="">--Select Community--</option>
                                <?php
                                $select_community = mysqli_query($con, "SELECT * FROM communities");
                                while($com_row = mysqli_fetch_array($select_community)){
                                    ?>
                                    <option value="<?php echo $com_row['community_id'] ?>"><?php echo $com_row['community_name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Item name</label>
                            <input class="form-control" id="name" type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input class="form-control" id="quantity" type="number" name="quantity" min="1" required>
                        </div>

                        <button class="btn btn-primary" name="submit-form" id="submit-form">Donate</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-4"></div>
    </div>

    <?php
    if(isset($_POST['numOfItems'])){
        $item_per_page = filter_var($_POST["numOfItems"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
    }
    else{
        $item_per_page = 20; //item to display per page
    }
    //Get page number from Ajax POST
    if(isset($_GET["page"])){
        $page_number = filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }



    //get total number of records from database for pagination
    $results = $mysqli=mysqli_query($con,"SELECT COUNT(*) FROM donations WHERE user_id ='$user_id'") or die('query error');
    $get_total_rows = mysqli_fetch_row($results); //hold total records in variable
    if ($get_total_rows[0] == 0){
        echo '<div class="alert alert-info"><div align="center"><h1>You have not donated</h1></div></div> ';
        exit;
    }
    //break records into pages
    $total_pages = ceil($get_total_rows[0]/$item_per_page);

    //get starting position to fetch the records
    $page_position = (($page_number-1) * $item_per_page);
    ?>

    <?php

    //Limit our results within a specified range.
    $results = mysqli_query($con,"SELECT * FROM donations WHERE user_id = '$user_id' ORDER BY donation_id DESC LIMIT $page_position, $item_per_page");

    //Display records fetched from database.
    ?>

    <div class="row">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">My Donations</h3>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th>Item name</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Donated To</th>
                        <th>Date Donated</th>
                    </tr>

                    <?php
                    while($donRow=mysqli_fetch_array($results))
                    {
                        $com_id = $donRow['community_id'];
                        $select_com = mysqli_query($con, "SELECT * FROM communities WHERE community_id = '$com_id'");
                        $comRow = mysqli_fetch_array($select_com);

                        ?>
                        <tr>
                            <td><?php echo $donRow['donation_id'] ?></td>
                            <td><?php echo $donRow['item_name'] ?></td>
                            <td><?php echo $donRow['item_quanity'] ?></td>
                            <td><?php echo $donRow['status'] ?></td>
                            <td><?php echo $comRow['community_name'] ?></td>
                            <td><?php echo $donRow['date_donated'] ?></td>
                        </tr>

                        <?php
                    }
                    ?>


                </table>
            </div>
            <div class="box-footer clearfix">
                <?php
                echo  '<input type="hidden" id="current-pages" value="'.$total_pages.'">';
                echo '<div align="center">';
                /* We call the pagination function here to generate Pagination link for us.
                As you can see I have passed several parameters to the function. */
                echo paginate_function($item_per_page, $page_number, $get_total_rows[0], $total_pages);
                echo '</div>';

                exit;

                function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
                {
                    $pagination = '';
                    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
                        $pagination .= '<ul class="donation-pagination pagination pagination-sm no-margin pull-right">';

                        $right_links    = $current_page + 1;
                        $previous       = $current_page - 1; //previous link
                        $next           = $current_page + 1; //next link
                        $first_link     = true; //boolean var to decide our first link

                        if($current_page > 1){
                            $previous_link = ($previous==0)? 1: $previous;
                            $pagination .= '<li><a href="#" data-page="1" title="First">&laquo;</a></li>'; //first link
                            $pagination .= '<li><a href="#" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
                            for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                                if($i > 0){
                                    $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
                                }
                            }
                            $first_link = false; //set first link to false
                        }

                        if($first_link){ //if current active page is first link
                            $pagination .= '<li class="active"><a href="#"> '.$current_page.'</a></li>';
                        }elseif($current_page == $total_pages){ //if it's the last active link
                            $pagination .= '<li class="last active"><a href="#"> '.$current_page.'</a></li>';
                        }else{ //regular current link
                            $pagination .= '<li class="active"><a href="#"> '.$current_page.'</a></li>';
                        }

                        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
                            if($i<=$total_pages){
                                $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
                            }
                        }
                        if($current_page < $total_pages){
                            $next_link = ($i > $total_pages) ? $total_pages : $i;
                            $pagination .= '<li><a href="#" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
                            $pagination .= '<li class="last"><a href="#" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
                        }

                        $pagination .= '</ul>';
                    }
                    return $pagination; //return pagination links
                }

                ?>
            </div>

        </div>
    </div>
</div>