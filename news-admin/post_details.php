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
$image_path="";
$validate_msg="";
date_default_timezone_set('Asia/Kolkata');
$current_datetime=date("Y-m-d H:i:s");
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
		
		$encode_tid=$_GET['tid'];
		$tid=base64_decode($encode_tid);
		
		$sel_record=$db->query("select * from khabarnewindia_post_records where id='$tid'");
		$num_record=$sel_record->rowCount();
		// echo $num_record;die();
		if(!$num_record)
		{
			header("location:post_list.php");die();
		}
		else
		{
			$_SESSION['PostId']=$tid;
			$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
			$title=$fetch_record['title'];
			$description=$fetch_record['description'];
			$author=$fetch_record['author'];
			$tag_line=$fetch_record['tag_line'];
			$post_image=$fetch_record['post_image'];
			$news_type=$fetch_record['news_type'];
			$video_link=$fetch_record['video_link'];
			$created_on=$fetch_record['created_on'];
			$mod_formate=date("d-M-Y",strtotime($created_on));
			$post_image_path="../post_images/".$post_image;
			
			
		/*	$sel_total_comment=$db->query("select COUNT(*) from samvaad_post_comment where post_id='$tid'");
			$fetch_total_comment=$sel_total_comment->fetch(PDO::FETCH_ASSOC);
			$total_comment=$fetch_total_comment['COUNT(*)'];*/
			
		}
		/*if(isset($_POST['submit']))
		{
			$sel_admin_user=$db->query("select * from samvaad_user_details where type='admin' limit 1");
			$fetch_admin_user=$sel_admin_user->fetch(PDO::FETCH_ASSOC);
			$admin_user_id=$fetch_admin_user['user_id'];
			$admin_comment=$_POST['inputComment'];
			if($admin_comment=="")
			{
				
				
				$validate_msg="Please provide Comment";
				
			}
			else
			{
				//echo"here";die();
				$insert_query = $db->prepare("insert into samvaad_post_comment (usre_id,post_id,comment,status,created) values (:uid,:bid,:comm,:st,:date)");
				$params = array("uid" => $admin_user_id,"bid" =>$tid ,"comm" => $admin_comment,"st" => 'verify',"date" => $current_datetime);
				$data = $insert_query->execute($params);
			}				
		}	*/		
	/*	if(isset($_GET['act']) && base64_decode($_GET['act']) == 'status')
		{
			//echo"here";die();
			$row_id=$_GET['cid'];
			$id=base64_decode($row_id);
			
			$pdoConnect = new connect_pdo();
			$db = $pdoConnect->connectToDB();
			
			$sel_record=$db->query("select * from samvaad_post_comment where id='$id'");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:post_list.php");die();
			}
			else
			{
				//echo"here";die();
				
				$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
				$status=$fetch_record['status'];
				if($status=="unverified")
				{
					$update_status="verify";
				}
				else
				{
					$update_status="unverified";
				}	
				$update_query = $db->prepare("update samvaad_post_comment SET status= :st where id= :row_id");
				$params = array("st" => $update_status,"row_id" => $id);
				$data = $update_query->execute($params);
				header("location:post_details.php?tid=$encode_tid");die();
			}
		}
		
	/*	if(isset($_GET['act']) && base64_decode($_GET['act']) == 'del')
		{
			$row_id=$_GET['cid'];
			$id=base64_decode($row_id);
			// echo $id;die();
			$pdoConnect = new connect_pdo();
			$db = $pdoConnect->connectToDB();
			$sel_record=$db->query("select * from samvaad_post_comment where id='$id'");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:post_list.php");die();
			}
			else
			{
				$Delete_query = $db->prepare("delete from samvaad_post_comment where id= :row_id");
				$params = array("row_id" => $id);
				$data = $Delete_query->execute($params);
				header("location:post_details.php?tid=$encode_tid");die();
			}
		}
		/*if(isset($_GET['act']) && base64_decode($_GET['act']) == 'remove')
		{
			// echo"here";die();
			$row_id=$_GET['cid'];
			$id=base64_decode($row_id);
			// echo $id;die();
			$pdoConnect = new connect_pdo();
			$db = $pdoConnect->connectToDB();
			$sel_record=$db->query("select * from samvaad_post_comment where id='$id'");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:post_list.php");die();
			}
			else
			{
				$Delete_query = $db->prepare("update samvaad_post_comment set reply= :rply where id= :row_id");
				$params = array("rply" => "","row_id" => $id);
				$data = $Delete_query->execute($params);
				header("location:post_details.php?tid=$encode_tid");die();
			}
		}*/

		
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
        <title>khabarnewindia News</title>
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
        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->
        <link rel="stylesheet" href="i-css/main.css">
        <link rel="stylesheet" href="style_video.css" /> 
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />	
        <script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="fancybox/video.js"></script>
        <link rel="stylesheet" href="i-css/custom.css">
        <script src="i-js/main.js"></script>
        <script src="i-js/jquery-2.2.3.min.js"></script>
        <script>
            $(function(){
            $(".reply").click(function(){
                //alert("hello");
                var data = $(this).attr('id');
                //alert(data);
                $("#hid").val(data);
                $("#commentbox").show();
            });

            $(".close").click(function(event){

                    $("#commentbox").hide();
            });

            $("#buttion_reply").click(function(e){
                var reply_content=$("#reply_text").val();
                var key=$("#hid").val();
                if(reply_content=="")
                {
                    alert("please provide Text");
                    return false;
                }
                else
                {
                    e.preventDefault();
                    var data='key=' + key +'&text=' + reply_content;
                    $.ajax({
                        url: 'reply-handler.php',
                        type: 'POST',
                        data: data,
                        cache: false,
                        async:false,
                        success: function(html)
                        {
                            //alert(html);
                            if(html=="yes")
                            {
                                var b_id="<?=$encode_tid?>";
                                window.location.assign("post_details.php?tid="+b_id+"");
                            }
                            else if(html=="no")
                            {
                                alert("Some think went wrong Please try again!");
                                return false;
                            }
                        }
                    });
                }	

            });

            });
        </script>
        <script type="text/javascript">

            
        </script>

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" "><!-- START TOPBAR -->
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
                                <h1 class="title">News Details</h1>                            </div>

                            <div class="pull-right hidden-xs">
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="dashboard.php"><i class="fa fa-home"></i>Home</a>
                                    </li>
                                    <li>
                                        <a href="post_list.php">News</a>
                                    </li>
                                    <li class="active">
                                        <strong>News Details</strong>
                                    </li>
                                </ol>
                            </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>
					
					<?php
						if(isset($_GET['msg']))
						{
							echo"<p style='color: green;font-size: 20px;'>The post share successfully.</p>";
						}
						if($validate_msg)
						{
							echo"<p style='color: red;font-size: 20px;'>$validate_msg</p>";
						}
					?>
                    <div class="col-lg-12">
                        <section class="box ">
                            <header class="panel_header">
                                <div class="actions panel_actions pull-right">
								
                                </div>
                            </header>
                            <div class="content-body">    <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">


                                        <!-- start -->

                                        <div class="blog_post full_blog_post">
                                            <h3><a href="#"><?=$title?></a></h3>
                                            <h5>Written by <a href="#"><?=$author?></a> on <?=$mod_formate?>.</h5>
											 <h5>Tag Line <a href="#"><?=$tag_line?></a></h5>
                                            <p class="blog_info">
                                                <i class="fa fa-comment"></i> <a href="#comments"><?=$total_comment=0?> comments</a>
                                            </p>

                                            <div class="blog-content">
											<?php
												if($news_type=="Text News")
												{	
											?>
											 <img class="" style="max-width: 800px;height: auto;width:100%; margin:30px;" src="<?=$post_image_path?>" alt="">
											<?php } ?>
											
											<?php
												function getVideoID($path) 
												{
										
													$fLevel = explode("v=",$path);
													$sLevel = explode("&",$fLevel[1]);
													return $sLevel[0];
												}
												if($news_type=="Video News")
												{	
													$videoID = getVideoID($video_link);
													
													echo"<iframe src=\"http://www.youtube.com/embed/".$videoID."?fs=1&amp;autoplay=1\" style='    width: 500px; height: 400px;'></iframe>";
												}
											?>
                                                


                                               

												<?=$description?>

                                            </div>

                                            <div id="comments">

                                                
												<?php
												
												$num_comment_record=0;
												// echo $num_record;die();
												if($num_comment_record)
												{
													echo "<h3>Comments</h3>";
													while($fetch_cooment=$sel_comment->fetch(PDO::FETCH_ASSOC))
													{
														$row_id=$fetch_cooment['id'];
														$encry_pt_id=base64_encode($row_id);
														$comment=$fetch_cooment['comment'];
														$user_id=$fetch_cooment['usre_id'];
														$status=$fetch_cooment['status'];
														$reply=$fetch_cooment['reply'];
														$modify_date_time=$fetch_cooment['modified'];
														$mod_ex=explode(" ",$modify_date_time);
														$mod_date=$mod_ex[0];
														$mod_time=$mod_ex[1];
														$mod_formate=date("d-M-Y",strtotime($mod_date));
														if($reply)
														{
															$act_text=base64_encode("remove");
															$reply_content="<div class='well comment-block level-2' style='display:inline-block;width:95%;'>
																			<div class='col-md-1 col-sm-2 col-xs-3 img-area'>
																				<img src='../user-profile/user.png'>
																			</div>
																			<div class='col-md-11 col-sm-10 col-xs-9'>
																				<h5><i class='icon-user'></i>&nbsp;By <a href='#'>Admin</a> on $mod_formate.</h5>
																				<div>
																					<p>$reply</p>
																				</div>
																				<a href='post_details.php?cid=$encry_pt_id&act=$act_text&tid=$encode_tid'>Delete &nbsp;<i class='fa fa-angle-double-right'></i></a>
																			</div>
																		</div>";
															$reply_link="";
														}
														else
														{
															$reply_link="<a href='#' class='pull-left reply' id='$encry_pt_id'>Reply &nbsp;<i class='fa fa-angle-double-right'></i></a>&nbsp;";
															$reply_content="";
														}
														
														$created_date_time=$fetch_cooment['created'];
														$ex=explode(" ",$created_date_time);
														$date=$ex[0];
														$time=$ex[1];
														$formate=date("d-M-Y",strtotime($date));
														$sel_user=$db->query("select * from khabarnewindia_user_details where user_id='$user_id'");
														$fetch_user=$sel_user->fetch(PDO::FETCH_ASSOC);
														$name=ucfirst($fetch_user['name']);
														$user_email=$fetch_user['user_email'];
														$image_name=$fetch_user['image'];
														$image_path="../user-profile/".$image_name;
														$image_url="";
														if($image_name)
														{$image_url=$image_path;}
														else
														{$image_url="../user-profile/user.png";}
														if($status=="unverified")
														{
															$status_content="Verify";
														}
														else
														{
															$status_content="Unverified";
														}	
														$encode_bid=base64_encode($tid);
														$st_text=base64_encode("status");
														$del_text=base64_encode("del");
														
														echo"<div class='well comment-block level-1' style='display:inline-block;width:100%;'>
															<div class='col-md-1 col-sm-2 col-xs-3 img-area'>
																<img src='$image_url'>
															</div>
															<div class='col-md-11 col-sm-10 col-xs-9'>
																<h5><i class='icon-user'></i>&nbsp;By <a href='#'>$name</a> on $formate.</h5>
																<div>
																	<p>$comment</p>
																</div>
																
																<a href='post_details.php?cid=$encry_pt_id&act=$st_text&tid=$encode_bid'>$status_content&nbsp;<i class='fa fa-angle-double-right'></i>
																</a>&nbsp;&nbsp;<a href='post_details.php?cid=$encry_pt_id&act=$del_text&tid=$encode_bid' >Delete</a>
															</div>
														</div>";
														echo $reply_content;
													}	
													
												}
											?>

                                              

                                            </div>

                                           <div class="clearfix"></div><br>
                                            <!--<h3>Leave a Comment</h3>-->
											<div class="" id="commentbox" style="display:none;">
												<div class="poup-div-close-quote" style="width:100%;"><img src="images/cross-icon.png" class="close" style='    width: 40px;'></div>
												<h4><b>Reply</b></h4>
												<form class="brand-form" action="" method="post" id="change-status">
												<div class="form-group">
													<textarea class="form-control" id="reply_text" name="reply_text" rows="5" cols="100"></textarea>
													<input type="hidden" name="hid" id="hid" value="" />
												</div>
												<input type="submit" name="passstatus" class="btn btn-default" id="buttion_reply" value="Post">
												</form>
											</div>
											
											
                                            <form class="form row" action="post_details.php?tid=<?=$encode_tid?>" method="post" name="comment_form" id="comment_form">
                                               

                                                <div class="form-group col-xs-9">
                                                    <label class="form-label" for="inputComment">Comment</label>
                                                    <div class="controls">
                                                        <textarea class=" form-control col-md-12" id="inputComment" name="inputComment" rows="6" required ></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group col-xs-9">
                                                    <div class="controls action">
                                                        <button type="submit" name="submit" class="btn btn-primary">Post Comment</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>

                                        <!-- end -->


                                    </div>
                                </div>
                            </div>
                        </section></div>
                </section>
            </section>
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
        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <!-- Sidebar Graph - START --> 
        <script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
        <!-- Sidebar Graph - END --> 

        
    </body>

</html>
