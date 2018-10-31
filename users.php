<?php
require_once 'includes/dbconfig.php';
include_once 'includes/functions.php';
?>
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
$results = $mysqli=mysqli_query($con,"SELECT COUNT(*) FROM users") or die('query error');
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
<?php

//Limit our results within a specified range.
$results = mysqli_query($con,"SELECT * FROM users ORDER BY user_id DESC LIMIT $page_position, $item_per_page");

//Display records fetched from database.
?>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">All Users</h3>
        </div>
    <div class="box-body">
        <table class="table table-striped">
            <tr>
                <th style="width: 10px">ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Date Joined</th>
            </tr>

            <?php
            while($userRows=mysqli_fetch_array($results))
            {

                ?>
                <tr>
                    <td><?php echo $userRows['user_id'] ?></td>
                    <td><?php echo $userRows['fullname'] ?></td>
                    <td><?php echo $userRows['email'] ?></td>
                    <td><?php echo $userRows['user_type'] ?></td>
                    <td><?php echo $userRows['date_created'] ?></td>
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
                $pagination .= '<ul class="user-pagination pagination pagination-sm no-margin pull-right">';

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
        $('#mainBody').on( "click", ".user-pagination a", function (e){
            e.preventDefault();
            var page = $(this).attr("data-page"); //get page number from link

            $('#mainBody').load("users.php",{"page":page});

        });
    });
</script>v