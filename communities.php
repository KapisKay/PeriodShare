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
        $('#mainBody').on( "click", ".community-pagination a", function (e){
            e.preventDefault();
            var page = $(this).attr("data-page"); //get page number from link

            $('#mainBody').load("communities.php",{"page":page});

        });

        $('#communityForm').validate({
            rules : {
                name : {
                    required : true
                },
                region : {
                    required : true
                },
                girls : {
                    required : true
                },
                contact_person : {
                    required : true
                },
                contact_number : {
                    required : true
                }
            },
            messages : {
                name : "kindly enter community's name",
                region : "kindly select region",
                girls : "kindly enter number of girls",
                contact_person : "kindly enter name of contact person",
                contact_number : "Kindly enter phone number of contact person"
            },
            submitHandler : submitCommunity
        });

        function submitCommunity() {
            var data = $('#communityForm').serialize();
            var btnHtml = 'Add Community';
            var btn = $('#add-community');
            var errorDiv = $('.error-div');
            $.ajax({
                url : 'submit-community.php',
                type: 'get',
                data : data,
                beforeSend : function () {
                    btn.html('<span class="fa fa-spin fa-spinner"></span> validating...').attr('disabled','disabled');
                    errorDiv.html('').fadeOut();
                },
                success : function (data) {
                    btn.html(btnHtml).removeAttr('disabled');
                    if(data === 'success'){
                        errorDiv.fadeIn(1000, function () {
                            errorDiv.html('<div class="alert alert-success"><span class="fa fa-check"></span> Community added! Kindly wait as page reloads</div>');
                        });
                        setTimeout(function () {
                            $('#addNew').modal('hide');
                            $('.modal-backdrop').css('display','none');
                            $('#mainBody').load('communities.php');
                        }, 1500);
                    }
                    else if(data === 'noData'){
                        errorDiv.fadeIn(1000, function () {
                            errorDiv.html('<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> Input all form fields</div>');
                        })
                    }

                    else if(data === 'error'){
                        errorDiv.fadeIn(1000, function () {
                            errorDiv.html('<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> An error occurred please try again later</div>');
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

        $('.delete-com-btn').on('click',function () {

            var comId = $(this).attr('id').replace(/delete-community-/,"");
            var deleteDiv = $('#error-div-'+comId);
            var btn = $('#delete-community-'+comId);

            $.ajax({
                url : 'delete-community.php',
                type: 'get',
                data: {comId : comId},
                beforeSend: function () {
                    deleteDiv.html('').fadeOut();
                    btn.html('<span class="fa fa-spin fa-spinner"></span> Deleting...').attr('disabled','disabled');
                },
                success: function (data) {

                    if(data == 'noData'){
                        deleteDiv.fadeIn(1000, function () {
                            deleteDiv.html('<div class="alert alert-danger">Parse Error!</div>')
                        });
                    }
                    else if(data == 'error'){
                        deleteDiv.fadeIn(1000, function () {
                            deleteDiv.html('<div class="alert alert-danger">Deletion failed</div>')
                        });
                    }
                    else if(data == 'success'){
                        deleteDiv.fadeIn(1000, function () {
                            deleteDiv.html('<div class="alert alert-success">Deletion successful! Wait as page reloads</div>');

                            setTimeout(function () {
                                $('#deleteModal-'+comId).modal('hide');
                                $('.modal-backdrop').css('display','none');
                                $('#mainBody').load('communities.php',{"page":pageNum});
                            }, 1800);
                        });
                    }
                    else{
                        deleteDiv.fadeIn(1000, function () {
                            deleteDiv.html('<div class="alert alert-danger">Error! Try again</div>')
                        });
                    }

                    btn.html('Delete').removeAttr('disabled');
                }
            })
        });

        $('.edit-comm-btn').on('click',function () {
            var comId = $(this).attr('id').replace(/edit-community-/,"");
            var deleteDiv = $('#error-div-'+comId);
            var btn = $('#edit-community-'+comId);

            var name = $('#name'+comId).val();
            var region = $('#region'+comId).val();
            var girls = $('#girls'+comId).val();
            var c_name = $('#contact_person'+comId).val();
            var c_num = $('#contact_number'+comId).val();


            $.ajax({
                url : 'update-community.php',
                type: 'get',
                data: {comId : comId, name : name, region:region, girls:girls, contact_person:c_name, contact_number:c_num},
                beforeSend: function () {
                    deleteDiv.html('').fadeOut();
                    btn.html('<span class="fa fa-spin fa-spinner"></span> updating...').attr('disabled','disabled');
                },
                success: function (data) {

                    if(data == 'noData'){
                        deleteDiv.fadeIn(1000, function () {
                            deleteDiv.html('<div class="alert alert-danger">Parse Error!</div>')
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
                                $('#editModal-'+comId).modal('hide');
                                $('.modal-backdrop').css('display','none');
                                $('#mainBody').load('communities.php',{"page":pageNum});
                            }, 1800);
                        });
                    }
                    else{
                        deleteDiv.fadeIn(1000, function () {
                            deleteDiv.html('<div class="alert alert-danger">Error! Try again</div>')
                        });
                    }

                    btn.html('Edit Community').removeAttr('disabled');
                }
            })
        })
    });
</script>
<div class="box">
    <div class="box-body">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNew">
            Add a New Community
        </button>
    </div>

    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="addNewLabel">Add New Community</h4>
                </div>

                <form id="communityForm">
                    <div class="modal-body">
                        <div class="error-div">

                        </div>
                        <div class="form-group">
                            <input  type="text" name="name" id="name" placeholder="Community's name"
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <select id="region" class="form-control" name="region" required>
                                <option value="" disabled selected>--Select Region--</option>
                                <option value="Upper East Region">Upper East Region</option>
                                <option value="Upper West Region">Upper West Region</option>
                                <option value="Northern Region">Northern Region</option>
                                <option value="Volta Region">Volta Region</option>
                                <option value="Brong Ahafo Region">Brong Ahafo Region</option>
                                <option value="Ashanti Region">Ashanti Region</option>
                                <option value="Western Region">Western Region</option>
                                <option value="Eastern Region">Eastern Region</option>
                                <option value="Central Region">Central Region</option>
                                <option value="Greater Accra Region">Greater Accra Region</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="number" name="girls" id="girls" placeholder="Number of Girls" min="1"
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="contact_person" id="contact_person" placeholder="Contact Person"
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input type="tel" name="contact_number" id="contact_number" placeholder="Contact Number"
                                   class="form-control" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="add-community">Add Community</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


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
$results = $mysqli=mysqli_query($con,"SELECT COUNT(*) FROM communities") or die('query error');
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
$results = mysqli_query($con,"SELECT * FROM communities ORDER BY community_id DESC LIMIT $page_position, $item_per_page");

//Display records fetched from database.
?>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">All Communities</h3>
    </div>
    <div class="box-body">
        <table class="table table-striped">
            <tr>
                <th style="width: 10px">ID</th>
                <th>Community name</th>
                <th>Region</th>
                <th>Number of girls</th>
                <th>Contact person</th>
                <th>Contact number</th>
                <th></th>
            </tr>

            <?php
            while($comRow=mysqli_fetch_array($results))
            {

                ?>
                <tr>
                    <td><?php echo $comRow['community_id'] ?></td>
                    <td><?php echo $comRow['community_name'] ?></td>
                    <td><?php echo $comRow['community_region'] ?></td>
                    <td><?php echo $comRow['num_of_girls'] ?></td>
                    <td><?php echo $comRow['community_contact_name'] ?></td>
                    <td><?php echo $comRow['community_contact_number'] ?></td>
                    <td>
                        <a href="#" title="edit" data-toggle="modal" data-target="#editModal-<?php echo $comRow['community_id'] ?>">
                            <i class="fa fa-edit"></i>
                        </a>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <a href="#" title="delete" data-toggle="modal" data-target="#deleteModal-<?php echo $comRow['community_id'] ?>">
                            <i class="fa fa-trash" style="color: red"></i>
                        </a>
                    </td>
                </tr>


            <div class="modal fade" id="deleteModal-<?php echo $comRow['community_id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title">Delete Community</h3>
                        </div>
                        <div class="modal-body text-center">
                            <div id="error-div-<?php echo $comRow['community_id'] ?>">

                            </div>
                            <h4>Are you sure you want to delete this community?</h4>
                            <p>Remember this action cannot be reverted</p>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger delete-com-btn" id="delete-community-<?php echo $comRow['community_id'] ?>">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

                <div class="modal fade" id="editModal-<?php echo $comRow['community_id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" >Edit Community</h4>
                            </div>

                            <form id="edit-comm-<?php echo $comRow['community_id'] ?>">
                                <div class="modal-body">
                                    <div id="error-div-<?php echo $comRow['community_id'] ?>">

                                    </div>
                                    <input type="hidden" name="comId" value="<?php echo $comRow['community_id'] ?>">
                                    <div class="form-group">
                                        <input  type="text" name="name" id="name<?php echo $comRow['community_id'] ?>" value="<?php echo $comRow['community_name'] ?>"
                                                class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <select id="region<?php echo $comRow['community_id'] ?>" class="form-control" name="region" required>
                                            <option value="<?php echo $comRow['community_region'] ?>" selected><?php echo $comRow['community_region'] ?></option>
                                            <option value="Upper East Region">Upper East Region</option>
                                            <option value="Upper West Region">Upper West Region</option>
                                            <option value="Northern Region">Northern Region</option>
                                            <option value="Volta Region">Volta Region</option>
                                            <option value="Brong Ahafo Region">Brong Ahafo Region</option>
                                            <option value="Ashanti Region">Ashanti Region</option>
                                            <option value="Western Region">Western Region</option>
                                            <option value="Eastern Region">Eastern Region</option>
                                            <option value="Central Region">Central Region</option>
                                            <option value="Greater Accra Region">Greater Accra Region</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input type="number" name="girls" id="girls<?php echo $comRow['community_id'] ?>" value="<?php echo $comRow['num_of_girls'] ?>" min="1"
                                               class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="contact_person" id="contact_person<?php echo $comRow['community_id'] ?>" value="<?php echo $comRow['community_contact_name'] ?>"
                                               class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="tel" name="contact_number" id="contact_number<?php echo $comRow['community_id'] ?>" value="<?php echo $comRow['community_contact_number'] ?>"
                                               class="form-control" required>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success edit-comm-btn" id="edit-community-<?php echo $comRow['community_id'] ?>">Edit Community</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


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
                $pagination .= '<ul class="community-pagination pagination pagination-sm no-margin pull-right">';

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

