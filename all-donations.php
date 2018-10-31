<?php
require_once 'includes/dbconfig.php';
include_once 'includes/functions.php';
?>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/validation.min.js"></script>
<script>
    $(document).ready(function () {
        var pageNum = $('#page-number').val();
        $('#mainBody').on( "click", ".donation-pagination a", function (e){
            e.preventDefault();
            var page = $(this).attr("data-page"); //get page number from link

            $('#mainBody').load("all-donations.php",{"page":page});

        });

       $('.change-status').on('click',function () {
          var donId = $(this).attr('id').replace(/change-btn-/,"");
           var deleteDiv = $('#error-div-'+donId);
           var btn = $('#change-btn-'+donId);
           var status = $('#status-'+donId).val();

           alert(donId);
           alert(status);

           $.ajax({
               url : 'change-status.php',
               type: 'get',
               data: {donId : donId, status : status},
               beforeSend: function () {
                   deleteDiv.html('').fadeOut();
                   btn.html('<span class="fa fa-spin fa-spinner"></span> changing...').attr('disabled','disabled');
               },
               success: function (data) {

                   if(data == 'noData'){
                       deleteDiv.fadeIn(1000, function () {
                           deleteDiv.html('<div class="alert alert-danger">Kindly select status!</div>')
                       });
                   }
                   else if(data == 'error'){
                       deleteDiv.fadeIn(1000, function () {
                           deleteDiv.html('<div class="alert alert-danger">Update failed</div>')
                       });
                   }
                   else if(data == 'success'){
                       deleteDiv.fadeIn(1000, function () {
                           deleteDiv.html('<div class="alert alert-success">Update successful! Wait as page reloads</div>');

                           setTimeout(function () {
                               $('#changeStatus-'+donId).modal('hide');
                               $('.modal-backdrop').css('display','none');
                               $('#mainBody').load('all-donations.php',{"page":pageNum});
                           }, 1800);
                       });
                   }
                   else{
                       deleteDiv.fadeIn(1000, function () {
                           deleteDiv.html('<div class="alert alert-danger">Error! Try again</div>')
                       });
                   }

                   btn.html('Change').removeAttr('disabled');
               }
           })
       });
    });
</script>
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
$results = $mysqli=mysqli_query($con,"SELECT COUNT(*) FROM donations") or die('query error');
$get_total_rows = mysqli_fetch_row($results); //hold total records in variable
if ($get_total_rows[0] == 0){
    echo '<div class="alert alert-info"><div align="center"><h1>No records found</h1></div></div> ';
    exit;
}
//break records into pages
$total_pages = ceil($get_total_rows[0]/$item_per_page);

//get starting position to fetch the records
$page_position = (($page_number-1) * $item_per_page);
?>
<input type="hidden" id="page-number" value="<?php echo $page_number ?>">

<?php

//Limit our results within a specified range.
$results = mysqli_query($con,"SELECT * FROM donations ORDER BY donation_id DESC LIMIT $page_position, $item_per_page");

//Display records fetched from database.
?>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">All Donations</h3>
    </div>
    <div class="box-body">
        <table class="table table-striped">
            <tr>
                <th style="width: 10px">ID</th>
                <th>Name</th>
                <th>Item name</th>
                <th>Quantity</th>
                <th>Community</th>
                <th>Status</th>
                <th>Date Donated</th>
                <th></th>
            </tr>

            <?php
            while($donationRows=mysqli_fetch_array($results))
            {
                $user_id = $donationRows['user_id'];
                $comId = $donationRows['community_id'];

                $select_user = mysqli_query($con, "SELECT * FROM users WHERE user_id='$user_id'");
                $user = mysqli_fetch_array($select_user);

                $select_com = mysqli_query($con, "SELECT * FROM communities WHERE community_id = '$comId'");
                $comm = mysqli_fetch_array($select_com);
                ?>
                <tr>
                    <td><?php echo $donationRows['donation_id'] ?></td>
                    <td><?php echo $user['fullname'] ?></td>
                    <td><?php echo $donationRows['item_name'] ?></td>
                    <td><?php echo $donationRows['item_quanity'] ?></td>
                    <td><?php echo $comm['community_name'] ?></td>
                    <td><?php echo $donationRows['status'] ?></td>
                    <td><?php echo $donationRows['date_donated'] ?></td>
                    <td><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#changeStatus-<?php echo $donationRows['donation_id'] ?>">Change Status</button> </td>
                </tr>

                <div class="modal fade" id="changeStatus-<?php echo $donationRows['donation_id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="addNewLabel">Change Status</h4>
                            </div>

                            <form id="statusForm">
                                <div class="modal-body">
                                    <div id="error-div-<?php echo $donationRows['donation_id'] ?>">

                                    </div>

                                    <div class="form-group">
                                        <select id="status-<?php echo $donationRows['donation_id'] ?>" class="form-control" name="status" required>
                                            <option value="" disabled selected>--Select Status--</option>
                                            <option value="Not Received">Not Received</option>
                                            <option value="Received">Received</option>
                                            <option value="Shipped">Shipped</option>
                                            <option value="Donated">Donated</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary change-status" id="change-btn-<?php echo $donationRows['donation_id'] ?>">Change</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <?php
            }
            ?>

        </table>
        <div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="addNewLabel">Change Status</h4>
                    </div>

                    <form id="statusForm">
                        <div class="modal-body">
                            <div class="error-div">

                            </div>
                            <div class="form-group">
                                <input  type="hidden" name="comId" id="comId">
                            </div>

                            <div class="form-group">
                                <select id="status" class="form-control" name="status" required>
                                    <option value="" disabled selected>--Select Status--</option>
                                    <option value="Not Received">Not Received</option>
                                    <option value="Received">Received</option>
                                    <option value="Shipped">Shipped</option>
                                    <option value="Donated">Donated</option>
                                </select>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="change-btn">Change</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
                $pagination .= '<ul class="donate-pagination pagination pagination-sm no-margin pull-right">';

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

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#mainBody').on( "click", ".donate-pagination a", function (e){
            e.preventDefault();
            var page = $(this).attr("data-page"); //get page number from link

            $('#mainBody').load("all-donations.php",{"page":page});

        });
    });
</script>v