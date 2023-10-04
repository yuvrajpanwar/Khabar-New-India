<?php
session_start();  
require_once('../classes/utils.php');
require_once('../classes/connect_pdo_emp.php');
require_once('../classes/access_stats_emp.php');
date_default_timezone_set('Asia/Kolkata');
include("resizecode.php");
$privilege = '0';
$nav = new access_stats($privilege);
set_timezone();
$pdoConnect = new connect_pdo();
$db = $pdoConnect->connectToDB();
$validate_message="";
$tag_name="";
$tag_description="";
$tag_slug="";
$redirectPath_site=path();
if(isLoginSessionExpired()) {

    header("Location: $redirectPath_site/news-admin/index.php?route=102");
}
  try
	{
		
		$adminid = $_SESSION['uID'];
		$todayNow = date('Y-m-d H:i:s');
		$todayDate = date('Y-m-d');
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
		if(isset($_POST['submit']) == 'Save')
		{
			//echo "here";die();
			$name=$_POST['title'];
			$slug=$_POST['slug'];
			$description=$_POST['description'];

			
			if($name=="")
			{
				$validate_message="<div class='alert alert-error alert-dismissible fade in'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
									 Please Provide Tag Name.
								</div>";
			}
			else
			{	
				
				$insert_query = $db->prepare("insert into khabarnewindia_tags_details (tag_name,tag_slug,tag_description,status,created) values (:title,:sl,:des,:st,:date)");
				
				$params = array("title" => $name,"sl" => $slug,"des" => $description,"st" => 'active',"date" => $todayNow);
				$data = $insert_query->execute($params);
				
				
				$validate_message="<div class='alert alert-success alert-dismissible fade in'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
										Tag Add Sucessfully.
									</div>
								";
				
			}
		}
		if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
		{
			//echo"here";die();
			$encode_tid=$_GET['tid'];
			$tid=base64_decode($encode_tid);
			$sel_record=$db->query("select * from khabarnewindia_tags_details where id='$tid' limit 1");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:tag_list.php");die();
			}
			else
			{
				
				$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
				
				$tag_name=$fetch_record['tag_name'];
				$tag_description=$fetch_record['tag_description'];
				$tag_slug=$fetch_record['tag_slug'];
			}
		}

		if(isset($_GET['act']) && base64_decode($_GET['act']) == 'update')
		{
			
			$encode_tid=$_GET['tid'];
			$tid=base64_decode($encode_tid);
			// echo $tid;die();
			$pdoConnect = new connect_pdo();
			$db = $pdoConnect->connectToDB();
			$sel_record=$db->query("select * from khabarnewindia_tags_details where id='$tid'");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:tag_list.php");die();
			}
			else
			{
				$name=$_POST['title'];
				$slug=$_POST['slug'];
				$description=$_POST['description'];

				
				if($name=="")
				{
					$validate_message="<div class='alert alert-error alert-dismissible fade in'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
										 Please Provide Tag Name.
									</div>";
				}
				else
				{

					$update_query = $db->prepare("update khabarnewindia_tags_details SET tag_name = :name, tag_slug = :sl, tag_description = :des where id = :rid");
					$params = array("name" => $name,"sl" => $slug,"des" => $description,"rid" => $tid);
					$data = $update_query->execute($params);
					header("location:tag_list.php");die();
				}	
				
			}
		}
		
	}
	 catch(PDOException $ex) 
	 {
			echo "An Error occured! Please contact Administrator.";
	 }
	 // echo"here";die();
		
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
        <link href="assets/plugins/datepicker/css/datepicker.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->
		<style>
		.error
		{
			color:red !important;
		}
		</style>
		<!-- CORE CSS TEMPLATE - END -->
		 <script src="i-js/jquery-2.2.3.min.js"></script>
		<script src="i-js/jquery.validate.min.js"></script>
		<script>
		  (function($,W,D)
		{
			var JQUERY4U = {};

			JQUERY4U.UTIL =
			{
				setupFormValidation: function()
				{
					//form validation rules
					$("#tag_form").validate({
						rules: 
                        {
                            title:
                            {
                                required: true,
                            },
									
									
						},
						messages: 
						{
							title:
							{
								required:"Please provide Tag Name",
								
							},
						},
						submitHandler: function(form) {
							form.submit();
						}
					});
					
			
				}
			}

			//when the dom has loaded setup form validation rules
			$(D).ready(function($) {
				JQUERY4U.UTIL.setupFormValidation();
			});

		})(jQuery, window, document);

		  </script>
    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" ">
        <!-- START TOPBAR -->
        <div class='page-topbar '>
            <div class='logo-area'>

            </div>
			<?php $page_name="tag"; require_once("include/top_bar.php"); ?>

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

                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 page_title_block'>
                        <div class="page-title">

                            <div class="pull-left">
                                <h1 class="title">Add Tag</h1>                            
							</div>

                            <div class="pull-right hidden-xs">
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="dashboard.php"><i class="fa fa-home"></i>Home</a>
                                    </li>
                                    <li>
                                        <a href="tag_list.php">Tags</a>
                                    </li>
                                    <li class="active">
                                        <strong>Add Tag</strong>
                                    </li>
                                </ol>
                            </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <section class="box ">
                           <header class="panel_header">
                               
                            </header>
                            <div class="content-body">
                                <div class="row">
									<?php 
									 if($validate_message)
										 echo $validate_message;
									?>
									<?php
								if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
								{
									$ed_text=base64_encode("update");
								?>
									<form action ="add_tag.php?tid=<?=$encode_tid?>&act=<?=$ed_text?>" method="post" name="tag_form" id="tag_form" enctype="multipart/form-data">
								<?php } else { ?>
									 <form action ="add_tag.php" method="post" name="tag_form" id="tag_form" enctype="multipart/form-data">
								<?php } ?>
                                   
                                        <div class="col-lg-4 col-md-8 col-sm-9 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label" for="field-1">Tag Name</label>
                                                <span class="desc"></span>
                                                <div class="controls">
                                                    <input type="text" value="<?=$tag_name?>" class="form-control" id="title" name="title">
                                                </div>
                                            </div>

                                         </div>
                                         <div class="col-lg-4 col-md-8 col-sm-9 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label" for="field-1">Tag Slug</label>
                                                <span class="desc"></span>
                                                <div class="controls">
                                                    <input type="text" value="<?=$tag_slug?>" class="form-control" id="slug" name="slug">
                                                </div>
                                            </div>

                                        </div>
                                         <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label" for="field-6">Description</label>
                                                <span class="desc"></span>
                                                <div class="controls">
                                                    <textarea class="form-control autogrow" cols="5" id="description" name="description"><?=$tag_description?></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                            <div class="text-left">
											   <?php
												if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
												{
												?>
												<button type="submit" name="update" class="btn btn-primary">Update</button>
												<?php } else { ?>
												<button type="submit" name="submit" class="btn btn-primary">Save</button>
												<?php }?>
                                            </div>
                                        </div>
                                    </form>
                                </div>


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
        <script src="assets/plugins/datepicker/js/datepicker.js" type="text/javascript"></script> <script src="assets/plugins/autosize/autosize.min.js" type="text/javascript"></script><script src="assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <!-- Sidebar Graph - START --> 
        <script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
        <!-- Sidebar Graph - END --> 



    </body>


</html>



