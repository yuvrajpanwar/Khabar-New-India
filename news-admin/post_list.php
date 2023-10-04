<?php
date_default_timezone_set('Asia/Kolkata');
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
			$sel_record=$db->query("select * from khabarnewindia_post_records where id='$tid'");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:post_list.php");die();
			}
			else
			{
				$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
				$post_image=$fetch_record['post_image'];
				$image_path="../post_images/".$post_image;
				if(file_exists($image_path))
				{
					unlink($image_path);
				}
				
				$Delete_query = $db->prepare("update khabarnewindia_post_records set is_enabled=:enable,is_deleted=:deleted where id= :id");
				$params = array("enable"=>'N',"deleted"=>'Y',"id" => $tid);
				$data = $Delete_query->execute($params);
				
				$del_category=$db->prepare("update khabarnewindia_post_category set is_enabled=:enable,is_deleted=:deleted where id= :id");
				$params_del_category = array("enable"=>'N',"deleted"=>'Y',"id" => $tid);
				$data_del_category = $del_category->execute($params_del_category);
				
				$Delete_comments = $db->prepare("delete from khabarnewindia_post_comment where post_id= :id");
				$params_comments = array("id" => $tid);
				$data_comments = $Delete_comments->execute($params_comments);
				header("location:post_list.php");die();
			}
		}
		
		// status update..........................
		if(isset($_GET['act']) && base64_decode($_GET['act']) == 'status')
		{
			$encode_tid=$_GET['tid'];
			$tid=base64_decode($encode_tid);
			
			$pdoConnect = new connect_pdo();
			$db = $pdoConnect->connectToDB();
			$sel_record=$db->query("select * from khabarnewindia_post_records where id='$tid'");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:post_list.php");die();
			}
			else
			{
				
				$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
				$status=$fetch_record['status'];
				if($status==1)
				{
					$update_status=0;
				}
				else
				{
					$update_status=1;
				}	
				$update_query = $db->prepare("update khabarnewindia_post_records SET status= :st where id= :id");
				$params = array("st" => $update_status,"id" => $tid);
				$data = $update_query->execute($params);
				header("location:post_list.php");die();
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
        <link href="assets/plugins/datatables/css/jquery.dataTables.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/datatables/extensions/TableTools/css/dataTables.tableTools.min.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" "><!-- START TOPBAR -->
        <script>
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '144768862897307',
              xfbml      : true,
              version    : 'v2.11'
            });
            FB.AppEvents.logPageView();
          };

          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "https://connect.facebook.net/en_US/sdk.js";
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));
        </script>
        <div class='page-topbar '>
            <div class='logo-area'>

            </div>
			<?php $page_name="post"; require_once("include/top_bar.php"); ?>

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
                                <h1 class="title">Post</h1>                            </div>

                            <div class="pull-right hidden-xs">
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="dashboard.php"><i class="fa fa-home"></i>Home</a>
                                    </li>
                                    <li>
                                        <a href="add_post.php">Add Post</a>
                                    </li>
                                    <li class="active">
                                        <strong>All Post</strong>
                                    </li>
                                </ol>
                            </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-lg-12">
                        <section class="box ">
                            <header class="panel_header">
                            </header>
                            <div class="content-body">    
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 content_block">



                                        <!-- ********************************************** -->


                                        <table id="example" class="display table table-hover table-condensed" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Title</th><th>Category Name</th><th>Type</th><th style='width: 90px;'>Date</th><th>Status</th><th> View</th><th style='width: 170px;'>Action</th></tr>
													
													<!--<th>Unverified/Total</th>-->
                                            </thead>

                                            <tbody>
											<?php
												$sel_record=$db->query("select * from khabarnewindia_post_records where is_enabled='Y' and is_deleted='N'  ORDER BY id desc");
												$num_record=$sel_record->rowCount();
												if($num_record)
												{
													while($fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC))
													{
														$t_id=$fetch_record['id'];
														$encrypt_id=base64_encode($t_id);
														$title=$fetch_record['title'];
														$news_type=$fetch_record['news_type'];
														$author=$fetch_record['author'];
														$created_on=$fetch_record['created_on'];
														$mod_formate=date("d-M-Y",strtotime($created_on));
														
														$cat_count=1;
														$category_content="";
														$sel_category=$db->query("select khabarnewindia_post_category.*, khabarnewindia_category.name from khabarnewindia_post_category,khabarnewindia_category where khabarnewindia_post_category.category_id=khabarnewindia_category.id and khabarnewindia_post_category.post_id='$t_id'");
														$num_category=$sel_category->rowCount();
														while($fetch_category=$sel_category->fetch(PDO::FETCH_ASSOC))
														{
															$category_name=$fetch_category['name'];
															$category_content.=$category_name;
															if($cat_count<$num_category)
															{
																$category_content.=", ";
															}
															$cat_count++;
														}
														
														$status=$fetch_record['status'];													
														if($status==1)
														{
															$st_content="Deactive";
															$status_dispaly="Active";
														}
														else
														{
															$st_content="Active";
															$status_dispaly="Deactive";
														}	
														$dt_text=base64_encode("del");
														$ed_text=base64_encode("edit");
														$st_text=base64_encode("status");
														
														
														
														echo"<tr>
														<td>$title</td>
														<td>$category_content</td>
														<td>$news_type</td>
														<td>Published On $mod_formate</td>
														<td>$status_dispaly</td>
														
														<td><a href='post_details.php?tid=$encrypt_id' title='View Post'><i class='fa fa-eye' aria-hidden='true'></i></a></td>
														<td><a href='add_post.php?tid=$encrypt_id&act=$ed_text' title='Edit Post'><i class='fa fa-pencil' aria-hidden='true''></i></a> | <a href='post_list.php?tid=$encrypt_id&act=$st_text'>$st_content</a> | <a class='delete_link' href='post_list.php?tid=$encrypt_id&act=$dt_text' title='Delete Post'><i class='fa fa-trash' aria-hidden='true'></i></a></td>
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
        <script src="assets/plugins/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script><script src="assets/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script><script src="assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js" type="text/javascript"></script><script src="assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.js" type="text/javascript"></script>
		<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <!-- Sidebar Graph - START --> 
        <script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
        <!-- Sidebar Graph - END --> 

        <!-- General section box modal start -->
        <div class="modal" id="section-settings" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Section Settings</h4>
                    </div>
                    <div class="modal-body">

                        Body goes here...

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                        <button class="btn btn-success" type="button">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal end -->
    </body>
<script>
	$(".delete_link").click(function(){
		var conf = confirm("Are you sure to delete this News?");
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
