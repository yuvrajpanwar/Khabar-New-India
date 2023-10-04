<?php 
    session_start();  
    require_once('../classes/utils.php');
    require_once('../classes/connect_pdo_emp.php');
    require_once('../classes/access_stats_emp.php');
    $privilege = '0';
    $nav = new access_stats($privilege);
    set_timezone();
    $pdoConnect = new connect_pdo();
    $db = $pdoConnect->connectToDB();
    $redirectPath_site=path();
    
    if(isLoginSessionExpired()) {

        header("Location: $redirectPath_site/news-admin/index.php?route=102");
    }
    // echo"here";die();
    try
        {
            
            $adminid = $_SESSION['uID'];
            $adminemail = $_SESSION['admin_email'];
            $adminname = $_SESSION['admin_name'];
            $now = 'NOW()';
            $val="";
            $empID = $_SESSION['uID'];
            $prepQuery = $db->query("select * from khabarnewindia_adminlogin where id='$adminid' and user_name='$adminemail' and name='$adminname' limit 1");
            $complete_rows = $prepQuery->rowCount();
            
            if($complete_rows<=0)
            {
                header("Location: index.php");die();
            
            }
            
            
            
        }
        catch(PDOException $ex) 
        {
                echo "An Error occured! Please contact Administrator.";
        }

?>
<!DOCTYPE html>
<html class=" ">
<head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Khabar New India - सोच ईमानदार, खबर दमदार </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
        
        <!-- CORE CSS FRAMEWORK - START -->
        <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <link href="assets/plugins/morris-chart/css/morris.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/jquery-ui/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/rickshaw-chart/css/graph.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/rickshaw-chart/css/detail.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/rickshaw-chart/css/legend.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/rickshaw-chart/css/extensions.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/rickshaw-chart/css/rickshaw.min.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/rickshaw-chart/css/lines.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/jvectormap/jquery-jvectormap-2.0.1.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/icheck/skins/minimal/white.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->

</head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" "><!-- START TOPBAR -->
        <div class='page-topbar '>
            <div class='logo-area'>

            </div>
		<?php $page_name=""; require_once("include/top_bar.php"); ?>

        </div>
        <!-- END TOPBAR -->
        <!-- START CONTAINER -->
        <div class="page-container row-fluid">

            <!-- SIDEBAR - START -->
			<?php require_once("include/sidebar.php"); ?>
            <!--  SIDEBAR - END -->

            <!-- START CONTENT -->
            <section id="main-content" class=" ">
                <section class="wrapper main-wrapper" style=''>

                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <div class="page-title">

                            <div class="pull-left">
                                <h1 class="title">Dashboard</h1>
                            </div>


                        </div>
                    </div>
                    <div class="clearfix"></div>


                    <div class="col-lg-12">
                        <section class="box nobox">
                            <div class="content-body">
								<?php
										date_default_timezone_set('Asia/Kolkata');
										$current_date = date("Y-m-d");
										$start=$current_date." 00:00:00";
										$end=$current_date." 23:59:59";
										
										
										
										
										$sel_total_category=$db->query("select COUNT(*) from khabarnewindia_category where status=1");
										$fetch_total_category=$sel_total_category->fetch(PDO::FETCH_ASSOC);
										$total_category=$fetch_total_category['COUNT(*)'];
										
										$sel_total_post=$db->query("select COUNT(*) from khabarnewindia_post_records where status=1");
										$fetch_total_post=$sel_total_post->fetch(PDO::FETCH_ASSOC);
										$total_post=$fetch_total_post['COUNT(*)'];
										
										
										
										$sel_total_category_all=$db->query("select COUNT(*) from khabarnewindia_category");
										$fetch_total_category_all=$sel_total_category_all->fetch(PDO::FETCH_ASSOC);
										$total_category_all=$fetch_total_category_all['COUNT(*)'];
										
										$sel_total_category_deactive=$db->query("select COUNT(*) from khabarnewindia_category where status=0");
										$fetch_total_category_deactive=$sel_total_category_deactive->fetch(PDO::FETCH_ASSOC);
										$total_category_deactive=$fetch_total_category_deactive['COUNT(*)'];
										
										$sel_total_post_all=$db->query("select COUNT(*) from khabarnewindia_post_records");
										$fetch_total_post_all=$sel_total_post_all->fetch(PDO::FETCH_ASSOC);
										$total_post_all=$fetch_total_post_all['COUNT(*)'];
										
										$sel_total_post_deactive=$db->query("select COUNT(*) from khabarnewindia_post_records where status=0");
										$fetch_total_post_deactive=$sel_total_post_deactive->fetch(PDO::FETCH_ASSOC);
										$total_post_deactive=$fetch_total_post_deactive['COUNT(*)'];
										
										
								?>

                                <div class="row">
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <div class="r4_counter db_box">
											<i class="pull-left fa fa-suitcase icon-md icon-rounded icon-primary"></i>
                                            <div class="stats">
                                                <h4><strong><?=$total_category?></strong></h4>
                                                <span>Categories</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <div class="r4_counter db_box">
											<i class="pull-left fa fa-newspaper-o icon-md icon-rounded icon-orange" aria-hidden="true"></i>
                                            <div class="stats">
                                                <h4><strong><?=$total_post?></strong></h4>
                                                <span>Posts</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- End .row -->	



                                <div class="row">
	

                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <div class="r3_weather" style='height: 200px !important;background: #1FB5AC;'>
                                            <div class="wid-weather wid-weather-small">
                                                <div class="">

                                                    <div class="location">
                                                        <h3>Categories</h3>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="clearfix"></div>
                                                    <div class="weekdays bg-white">
                                                        <ul class="list-unstyled">
                                                            <li><span class='day'>Total</span><span class='temp'><?=$total_category_all?></span></li>
                                                            <li><span class='day'>Active</span><span class='temp'><?=$total_category?></span></li>
                                                            <li><span class='day'>Deactive</span><span class='temp'><?=$total_category_deactive?></span></li>
															<?php 
															$user_type=$_SESSION['loginType'];
															if($user_type=="administrator")
															{	
															?>
															<li style='text-align: center; font-size: 21px;'><span class='day'><a href="category_list.php" class='manage_link'>Manage</a></span></li>
															<?php }?>
                                                        </ul>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>	
									<div class="col-md-3 col-sm-6 col-xs-12">
                                        <div class="r3_weather" style='height: 200px;'>
                                            <div class="wid-weather wid-weather-small">
                                                <div class="">

                                                    <div class="location">
                                                        <h3>Posts</h3>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="clearfix"></div>
                                                    <div class="weekdays bg-white">
                                                        <ul class="list-unstyled">
                                                            <li><span class='day'>Total</span><span class='temp'><?=$total_post_all?></span></li>
                                                            <li><span class='day'>Active</span><span class='temp'><?=$total_post?></span></li>
                                                            <li><span class='day'>Deactive</span><span class='temp'><?=$total_post_deactive?></span></li>
															<?php 
															$user_type=$_SESSION['loginType'];
															if($user_type=="administrator")
															{	
															?>
															<li style='text-align: center; font-size: 21px;'><span class='day'><a href="post_list.php" class='manage_link'>Manage</a></span></li>
															<?php }?>
                                                        </ul>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div> <!-- End .row -->


                            </div>
                        </section></div>



                </section>
            </section>
            <!-- END CONTENT -->

            <div class="chatapi-windows ">


            </div>    
			</div>
        <!-- END CONTAINER -->
        <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->


        <!-- CORE JS FRAMEWORK - START --> 
        <script src="assets/js/jquery-1.11.2.min.js" type="text/javascript"></script> 
        <script src="assets/js/jquery.easing.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
        <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
        <!-- CORE JS FRAMEWORK - END --> 


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <script src="assets/plugins/rickshaw-chart/vendor/d3.v3.js" type="text/javascript"></script> <script src="assets/plugins/jquery-ui/smoothness/jquery-ui.min.js" type="text/javascript"></script> <script src="assets/plugins/rickshaw-chart/js/Rickshaw.All.js"></script><script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script><script src="assets/plugins/easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script><script src="assets/plugins/morris-chart/js/raphael-min.js" type="text/javascript"></script>
		<!--<script src="assets/plugins/morris-chart/js/morris.min.js" type="text/javascript"></script>-->
		<script src="assets/plugins/jvectormap/jquery-jvectormap-2.0.1.min.js" type="text/javascript"></script><script src="assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script><script src="assets/plugins/gauge/gauge.min.js" type="text/javascript"></script><script src="assets/plugins/icheck/icheck.min.js" type="text/javascript">
		</script>
		<!--<script src="assets/js/dashboard.js" type="text/javascript"></script>--><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <!-- Sidebar Graph - START --> 
        <script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
        <!-- Sidebar Graph - END --> 


    </body>
</html>
<script type="text/javascript">
</script>