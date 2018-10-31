<?php session_start();

require_once 'includes/dbconfig.php';
include_once 'includes/functions.php';

if(isset($_SESSION['donor_app_session_key'])){
    $user_id =$_SESSION['donor_app_session_key'];
    $select = mysqli_query($con, "SELECT * FROM users WHERE user_id= '$user_id'");
    $user = mysqli_fetch_array($select);

    $select_donations = mysqli_query($con, "SELECT * FROM donations WHERE user_id = '$user_id'");
    $num_of_donations = mysqli_num_rows($select_donations);
    $donations = mysqli_fetch_array($select_donations);

    $select_comm = mysqli_query($con, "SELECT * FROM communities");
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $user['fullname'] ?> | Dashboard</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="bower_components/morris.js/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    </head>
    <body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="index.html" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>P</b>S</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Period</b>SHARE</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"> You have no messages</li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have no notifications</li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="dist/img/avatar.png" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?php echo $user['fullname'] ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="dist/img/avatar.png" class="img-circle" alt="User Image">

                                    <p>
                                        <?php echo $user['fullname'] ?> - <?php echo $user['user_type']?>
                                        <small>Member since <?php echo $user['date_created'] ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                            &nbsp;
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <?php
                                            if($user['user_type'] === 'donor'){
                                                ?>
                                                <a href="#">Donations</a>
                                                <p> <?php echo $num_of_donations ?></p>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        &nbsp;
                                    </div>
                                    <div class="pull-right">
                                        <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="dist/img/avatar.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?php echo $user['fullname'] ?></p>
                        <a href="#"><?php echo $user['user_type'] ?></a>
                    </div>
                </div>

                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="active">
                        <a href="dashboard.php">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>

                    <?php if($user['user_type'] == 'donor'){
                        ?>
                        <li class="goToDonations">
                            <a href="#">
                                <i class="fa fa-files-o"></i>
                                <span>Donate</span>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                    <?php if($user['user_type'] == 'admin'){
                        ?>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-cogs"></i>
                                <span>Management</span>
                                <span class="pull-right-container">
                                 <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="#" class="goToUsers"><i class="fa fa-circle-o"></i> Users</a></li>
                                <li><a href="#" class="goToAllDonations"><i class="fa fa-circle-o"></i> Donations</a></li>
                                <li><a href="#" class="goToCommunities"><i class="fa fa-circle-o"></i> Communities</a></li>
                            </ul>
                        </li>
                    <?php
                    }?>


                    <li class="treeview comm">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span>Communities</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <?php
                            while ($com_row = mysqli_fetch_array($select_comm)){
                                ?>
                                <li><a href="#" class="checkCommunity" id="com-<?php echo $com_row['community_id'] ?>"><i class="fa fa-circle-o"></i> <?php echo $com_row['community_name'] ?></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" id="mainBody">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Dashboard
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <?php

                    if($user['user_type'] == 'admin'){
                        $select_users = mysqli_query($con, "SELECT COUNT(*) FROM users WHERE user_type= 'donor'");
                        $users = mysqli_fetch_array($select_users);
                        $total_users = $users[0];

                        $select_donations = mysqli_query($con, "SELECT COUNT(*) FROM donations");
                        $don = mysqli_fetch_array($select_donations);
                        $total_don = $don[0];

                        $select_communities = mysqli_query($con, "SELECT COUNT(*) FROM communities");
                        $comm= mysqli_fetch_array($select_communities);
                        $total_comm = $comm[0];

                        $select_girls = mysqli_query($con, "SELECT num_of_girls FROM communities");
                        $total_girls = 0;
                        while($girls_row = mysqli_fetch_array($select_girls)){
                            $total_girls = $total_girls + (int)$girls_row['num_of_girls'];
                        }

                        ?>
                        <div class="row">
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3><?php echo $total_users ?></h3>

                                        <p>Donors</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>
                                    <a href="#" class="small-box-footer goToUsers">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h3><?php echo $total_don ?></h3>

                                        <p>Donations</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="#" class="small-box-footer goToAllDonations">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3><?php echo $total_girls ?></h3>

                                        <p>Girls</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="#" class="small-box-footer goToCommunities">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-red">
                                    <div class="inner">
                                        <h3><?php echo $total_comm ?></h3>

                                        <p>Communities</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <a href="#" class="small-box-footer goToCommunities">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                <?php
                    }
                ?>

                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-7 connectedSortable">

                        <!-- solid sales graph -->
                        <div class="box box-solid bg-green-gradient">
                            <div class="box-header with-border">
                                <h3 class="box-title">Donation Chart</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="line-chart" style="height: 300px;"></div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                        <?php
                        if($user['user_type'] == 'admin') {
                            ?>
                            <!-- quick email widget -->
                            <div class="box box-info">
                                <div class="box-header">
                                    <i class="fa fa-envelope"></i>

                                    <h3 class="box-title">Quick Email</h3>
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">
                                        <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                                                title="Remove">
                                            <i class="fa fa-times"></i></button>
                                    </div>
                                    <!-- /. tools -->
                                </div>
                                <div class="box-body">
                                    <form action="#" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="emailto" placeholder="Email to:">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="subject" placeholder="Subject">
                                        </div>
                                        <div>
                  <textarea class="textarea" placeholder="Message"
                            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="box-footer clearfix">
                                    <button type="button" class="pull-right btn btn-default" id="sendEmail">Send
                                        <i class="fa fa-arrow-circle-right"></i></button>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </section>
                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-5 connectedSortable">

                        <!-- Calendar -->
                        <div class="box box-solid bg-green-gradient">
                            <div class="box-header">
                                <i class="fa fa-calendar"></i>

                                <h3 class="box-title">Calendar</h3>
                                <!-- tools box -->
                                <div class="pull-right box-tools">
                                    <!-- button with a dropdown -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-bars"></i></button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li><a href="#">Add new event</a></li>
                                            <li><a href="#">Clear events</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#">View calendar</a></li>
                                        </ul>
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                                    </button>
                                </div>
                                <!-- /. tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <!--The calendar -->
                                <div id="calendar" style="width: 100%"></div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                    </section>
                    <!-- right col -->
                </div>
                <!-- /.row (main row) -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">

            <strong>Copyright &copy; 2018 <a href="index.html">Donation App</a>.</strong> All rights
            reserved.
        </footer>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="bower_components/raphael/raphael.min.js"></script>
    <script src="bower_components/morris.js/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="bower_components/moment/min/moment.min.js"></script>
    <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script src="js/validation.min.js"></script>

    <script>
        var line = new Morris.Line({
            element          : 'line-chart',
            resize           : true,
            data             : [
                { y: '2011 Q1', item1: 2666 },
                { y: '2011 Q2', item1: 2778 },
                { y: '2011 Q3', item1: 4912 },
                { y: '2011 Q4', item1: 3767 },
                { y: '2012 Q1', item1: 6810 },
                { y: '2012 Q2', item1: 5670 },
                { y: '2012 Q3', item1: 4820 },
                { y: '2012 Q4', item1: 15073 },
                { y: '2013 Q1', item1: 10687 },
                { y: '2013 Q2', item1: 8432 }
            ],
            xkey             : 'y',
            ykeys            : ['item1'],
            labels           : ['Item 1'],
            lineColors       : ['#efefef'],
            lineWidth        : 2,
            hideHover        : 'auto',
            gridTextColor    : '#fff',
            gridStrokeWidth  : 0.4,
            pointSize        : 4,
            pointStrokeColors: ['#efefef'],
            gridLineColor    : '#efefef',
            gridTextFamily   : 'Open Sans',
            gridTextSize     : 10
        });
    </script>

    <script>
        $(document).ready(function () {
            var mainDiv = $('#mainBody');

            $('.goToDonations').on('click', function () {
                $('li').removeClass('active');
                mainDiv.load('donations.php');
                $('.goToDonations').addClass('active');
            });

            $('.goToUsers').on('click', function () {
                $('li').removeClass('active');
                mainDiv.load('users.php');
                $('.goToUsers').addClass('active');
            });

            $('.goToAllDonations').on('click', function () {
                $('li').removeClass('active');
                mainDiv.load('all-donations.php');
                $('.goToAllDonations').addClass('active');
            });

            $('.goToCommunities').on('click', function () {
                $('li').removeClass('active');
                mainDiv.load('communities.php');
                $('.goToCommunities').addClass('active');
            });

            $('.checkCommunity').on('click', function () {
                var comId = $(this).attr('id').replace(/com-/,"");
                $('li').removeClass('active');
                mainDiv.load('view-com.php?com='+comId);
                $('.comm').addClass('active');
            });

            mainDiv.on( "click", ".community-pagination a", function (e){
                e.preventDefault();
                var page = $(this).attr("data-page"); //get page number from link

                $('#mainBody').load("communities.php",{"page":page});

            });


        });
    </script>

    </body>
    </html>
<?php
}
else{
    redirect_to('login.php');
}

?>
