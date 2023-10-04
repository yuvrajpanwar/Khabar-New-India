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
		

		// Delete records....................................
		if(isset($_GET['act']) && base64_decode($_GET['act']) == 'del')
		{
			//echo"here";die();
			$encode_tid=$_GET['tid'];
			$tid=base64_decode($encode_tid);
			// echo $tid;die();
			$pdoConnect = new connect_pdo();
			$db = $pdoConnect->connectToDB();
			$sel_record=$db->query("select * from khabarnewindia_breaking_news where id='$tid'");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:breaking_list.php");die();
			}
			else
			{
				
				$Delete_query = $db->prepare("update khabarnewindia_breaking_news set is_enabled=:enable,is_deleted=:deleted where id= :id");
				$params = array("enable"=>'N',"deleted"=>'Y',"id" => $tid);
				$data = $Delete_query->execute($params);
				header("location:breaking_list.php");die();
			}
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

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
        <link href="assets/plugins/datatables/css/jquery.dataTables.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/datatables/extensions/TableTools/css/dataTables.tableTools.min.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


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
			<?php require_once("include/top_bar.php"); ?>

        </div>
        <!-- END TOPBAR -->
        <!-- START CONTAINER -->
        <div class="page-container row-fluid">

            <!-- SIDEBAR - START -->
			<?php $page_name="breaking"; require_once("include/sidebar.php"); ?>
            <!--  SIDEBAR - END -->
            <!-- START CONTENT -->
            <section id="main-content" class=" ">
                <section class="wrapper main-wrapper" style=''>

                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <div class="page-title">

                            <div class="pull-left">
                                <h1 class="title">Breaking</h1>                            </div>

                            <div class="pull-right hidden-xs">
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="dashboard.php"><i class="fa fa-home"></i>Home</a>
                                    </li>
                                    <li>
                                        <a href="add_breaking.php">Add Breaking</a>
                                    </li>
                                    <li class="active">
                                        <strong>All Breaking</strong>
                                    </li>
                                </ol>
                            </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-lg-12">
                        <section class="box ">
                            <header class="panel_header">
                                <div class="actions panel_actions pull-right">
                                    <i class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></i>
                                </div>
                            </header>
                            <div class="content-body">    <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">



                                        <!-- ********************************************** -->


                                        <table id="example" class="display table table-hover table-condensed" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Title</th><th>Date Time</th><th>Action</th> </tr>
                                            </thead>

                                            <tbody>
											<?php
												$sel_record=$db->query("select * from khabarnewindia_breaking_news where is_enabled='Y' and is_deleted='N' order by created desc");
												$num_record=$sel_record->rowCount();
												if($num_record)
												{
													while($fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC))
													{
														$t_id=$fetch_record['id'];
														$encrypt_id=base64_encode($t_id);
														$title=$fetch_record['title'];
														$date_time=$fetch_record['created'];
														
														
														$dt_text=base64_encode("del");
														$ed_text=base64_encode("edit");
														
														echo"<tr>
														<td>$title</td>
														<td>$date_time</td>
														<td><a href='add_breaking.php?tid=$encrypt_id&act=$ed_text'>Edit</a> | <a href='breaking_list.php?tid=$encrypt_id&act=$dt_text' class='delete_link'>Delete</a></td>
														</tr>";
													}	
												}
												else
												{
													echo"<tr><td>No Record found!</td><td></td><td></td><td></td></tr>";
												}
											?>

                                            </tbody>
                                        </table>
                                        <!-- ********************************************** -->




                                    </div>
                                </div>
                            </div>
                        </section></div>






                </section>
            </section>
            <!-- END CONTENT -->
 


            <div class="chatapi-windows ">


            </div>    </div>
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
        <script src="assets/plugins/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script><script src="assets/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script><script src="assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js" type="text/javascript"></script><script src="assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <!-- Sidebar Graph - START --> 
        <script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
        <!-- Sidebar Graph - END --> 

    </body>
<script>
	$(".delete_link").click(function(){
		var conf = confirm("Are you sure to delete this Breaking?");
			if(conf==true)
			{ return true; }
			else
			{ return false; }
	});


$(document).ready(function() {
   $('#example').dataTable( {
  "ordering": false,
} );
} );

</script>
</html>



