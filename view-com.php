<?php
require_once 'includes/dbconfig.php';
include_once 'includes/functions.php';
if(isset($_GET['com'])){
    $id = checkValues($_GET['com']);

    $select = mysqli_query($con, "SELECT * FROM communities WHERE community_id = '$id'");
    $comRow = mysqli_fetch_array($select);

    ?>
<div class="container">
    <div class="row" style="margin-top: 100px">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="box  box-primary">
                <div class="box-header with-border text-center">
                    <h3 class="box-title text-center"><?php echo $comRow['community_name'] ?></h3>
                </div>
                <div class="box-body">
                    <p class="text-center">
                        <?php echo $comRow['community_name'] ?> is a community in the <?php echo $comRow['community_region'] ?> of Ghana with
                        <?php echo $comRow['num_of_girls'] ?> girls.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>
<?php
}

