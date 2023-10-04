<?php
session_start();  
require_once('../classes/utils.php');
require_once('../classes/connect_pdo_emp.php');
require_once('../classes/access_stats_emp.php');
date_default_timezone_set('Asia/Kolkata');
$privilege = '0';
$nav = new access_stats($privilege);
set_timezone();
$pdoConnect = new connect_pdo();
$db = $pdoConnect->connectToDB();
$validate_message="";
$redirectPath_site=path();
if(isLoginSessionExpired()) {

    header("Location: $redirectPath_site/news-admin/index.php?route=102");
}
$title="";
  try
	{
		
		$adminid = $_SESSION['uID'];
		$todayNow = date('Y-m-d H:i:s');
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
			//echo"here";die();

			$name=$_POST['title'];
			if($name=="")
			{
				//$validate_message="<p style='color:red;'>Please Provide Category Name</p>";
				$validate_message="<div class='alert alert-error alert-dismissible fade in'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
									 Please Provide Category Name.
								</div>";

			}
			else
			{
				$insert_query = $db->prepare("insert into khabarnewindia_category (name,status,created) values (:title,:st,:date)");
				
				$params = array("title" => $name,"st" => 1,"date" => $todayNow);
				$data = $insert_query->execute($params);
				$validate_message="<div class='alert alert-success alert-dismissible fade in'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
										Category Add Sucessfully.
									</div>";
				
				//$encode_msg=base64_encode("done");
				//header("location:add_question.php?msg=$encode_msg");die();
				
			}
		}
		if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
		{
			
			$encode_tid=$_GET['tid'];
			$tid=base64_decode($encode_tid);
			$sel_record=$db->query("select * from khabarnewindia_category where id='$tid'");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:category_list.php");die();
			}
			else
			{
				
				$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
				$title=$fetch_record['name'];
			}	
		}
		if(isset($_GET['act']) && base64_decode($_GET['act']) == 'update')
		{
			
			$encode_tid=$_GET['tid'];
			$tid=base64_decode($encode_tid);
			// echo $tid;die();
			$pdoConnect = new connect_pdo();
			$db = $pdoConnect->connectToDB();
			$sel_record=$db->query("select * from khabarnewindia_category where id='$tid'");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:category_list.php");die();
			}
			else
			{
				$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
				$validate_message="";
				$name=$_POST['title'];
				if($name=="")
				{
					$validate_message="<p style='color:red;'>Please Provide Category Name</p>";
				}
				else
				{

					$update_query = $db->prepare("update khabarnewindia_category SET name = :title where id = :rid");
					$params = array("title" => $name,"rid" => $tid);
					$data = $update_query->execute($params);
					header("location:category_list.php");die();
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
					$("#category_form").validate({
						rules: {
									title:
									{
										required: true,
									}
						},
						messages: 
						{
							title:
							{
								required:"Please provide Category Name",
								
							}
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
			<?php $page_name="category"; require_once("include/top_bar.php"); ?>

        </div>
        <!-- END TOPBAR -->
        <!-- START CONTAINER -->
        <div class="page-container row-fluid">

            <!-- SIDEBAR - START -->
			<?php require_once("include/sidebar.php"); ?>
            <!--  SIDEBAR - END -->
            <!-- START CONTENT -->
            <section id="main-content" class=" ">$validationMsg
                <section class="wrapper main-wrapper" style='margin-top: 17px;'>

                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 page_title_block'>
                        <div class="page-title">

                            <div class="pull-left">
                                <h1 class="title">Add Category</h1>                            </div>

                            <div class="pull-right hidden-xs">
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="dashboard.php"><i class="fa fa-home"></i>Home</a>
                                    </li>
                                    <li>
                                        <a href="category_list.php">Categories</a>
                                    </li>
                                    <li class="active">
                                        <strong>Add Category</strong>
                                    </li>
                                </ol>
                            </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <section class="box ">
                      
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
								<form  method="POST" action="add_category.php?tid=<?=$encode_tid?>&act=<?=$ed_text?>" name="category_form" id="category_form">
								<?php } else { ?>
								<form  method="POST" action="add_category.php" name="category_form" id="category_form">
								<?php } ?>
                                    
                                        <div class="col-lg-4 col-md-8 col-sm-9 col-xs-12">

                                            <div class="form-group">
                                                <label class="form-label" for="field-1">Category Name</label>
                                                <span class="desc"></span>
                                                <div class="controls">
                                                    <input type="text" value="<?=$title?>" class="form-control" name="title" id="title">
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30" >
                                            <div class="text-left">
                                               
                                                 <?php
													if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
													{
													?>
													<button type="submit" name="update" class="btn btn-primary" style="margin-top: 30px;">Update</button>
													<?php } else { ?>
													 <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 30px;">Save</button>
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



