<?php
    $post_class="";
    $category_class="";
    $site_user_class="";
    $tag_class="";
    $subscriber_class="";
    $admin_user_class="";
    $horoscope_calss="";
    $blog_class="";
    $album_class="";
    $front_page="";
    $breaking_class="";
    $setting_class ="";

	switch ($page_name) {
	case "post":
		$post_class="open";
		break;
    case "breaking":
		$breaking_class="open";
		break;    
	case "category":
		$category_class="open";
		break;
	case "site_user":
		$site_user_class="open";
		break;
	case "admin_user":
		$admin_user_class="open";
		break;
	case "dashboard":
		$dashboard_class="open";
		break;
	case "subscriber":
		$subscriber_class="open";
		break;
	case "horo":
		$horoscope_calss="open";
		break;	
	case "tag":
	{
		$tag_class="open";
		break;
	}
	case "blog":
	{
		$blog_class="open";
		break;
    }
	case "album":
		$album_class="open";
		break;
    case "setting":
		$setting_class="open";
		break;        
	default:
		$front_page="open";
	}
	$sel_cat = $db->query("select * from khabarnewindia_category where status=1");
	$count_cat = $sel_cat->rowCount();
	
	$sel_tag = $db->query("select * from khabarnewindia_tags_details where status='active'");
	$count_tag = $sel_tag->rowCount();

	$sel_posts = $db->query("select * from khabarnewindia_post_records where status=1");
    $count_posts = $sel_posts->rowCount();
    
	$sel_admin_user = $db->query("select * from khabarnewindia_adminlogin");
	$count_admin_user = $sel_admin_user->rowCount();
?>
		   <div class="page-sidebar " style="    height: 100%;">

                <!-- MAIN MENU - START -->
                <div class="page-sidebar-wrapper" id="main-menu-wrapper"> 

                    <!-- USER INFO - START -->
                    <div class="profile-info row">

                       

                    </div>
                    <!-- USER INFO - END -->



                    <ul class='wraplist'>	


                        <li class="<?=$front_page?>"> 
                            <a href="dashboard.php" style="padding-top: 50px;">
                                <i class="fa fa-dashboard"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
						<?php 
						$user_type=$_SESSION['loginType'];
						if($user_type=="administrator")
						{	
						?>
                        <!-- <li class="<?=$breaking_class?>"> 
                            <a href="javascript:;">
                                <i class="fa fa-file" aria-hidden="true"></i>

                                <span class="title">Breaking News</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu" >
                                <li>
                                    <a class="" href="add_breaking.php">Add New</a>
                                </li>
                                <li>
                                    <a class="" href="breaking_list.php">All Breaking</a>
                                </li>
                            </ul>
                        </li> -->
                        <li class="<?=$category_class?>"> 
                            <a href="javascript:;">
                                <i class="fa fa-suitcase"></i>
                                <span class="title">Categories</span>
                                <span class="arrow "></span><span class="label label-orange"><?=$count_cat?></span>
                            </a>
                            <ul class="sub-menu" >
                                <li>
                                    <a class="" href="add_category.php">Add New</a>
                                </li>
                                <li>
                                    <a class="" href="category_list.php">All Categories</a>
                                </li>
                            </ul>
                        </li>
						
						 <li class="<?=$post_class?>"> 
                            <a href="javascript:;">
                                <!--<i class="fa fa-newspaper-o" aria-hidden="true"></i>-->
								<i class="fa fa-rss-square" aria-hidden="true"></i>
                                <span class="title">Post</span>
                                <span class="arrow "></span><span class="label label-orange"><?=$count_posts?></span>
                            </a>
                            <ul class="sub-menu" >
                                <li>
                                    <a class="" href="add_post.php">Add New</a>
                                </li>
                                <li>
                                    <a class="" href="post_list.php">All Posts</a>
                                </li>
                            </ul>
                        </li>
						<li class="<?=$tag_class?>"> 
                            <a href="javascript:;">
                               <i class="fa fa-tags" aria-hidden="true"></i>

                                <span class="title">Tags</span>
                                <span class="arrow "></span><span class="label label-orange"><?=$count_tag?></span>
                            </a>
                            <ul class="sub-menu" >
                                <li>
                                    <a class="" href="add_tag.php">Add New</a>
                                </li>
                                <li>
                                    <a class="" href="tag_list.php">All Tags</a>
                                </li>
                            </ul>
                        </li>
						<!--<li class="<?=$album_class?>"> 
                            <a href="javascript:;">
                                <i class="fa fa-picture-o" aria-hidden="true"></i>
                                <span class="title">Gallery</span>
                            </a>
                            <ul class="sub-menu" >
                                <li>
                                    <a class="" href="add_album.php">Add New</a>
                                </li>
                                <li>
                                    <a class="" href="album_list.php">All Gallery</a>
                                </li>
                            </ul>
                        </li>-->
						<li class="<?=$subscriber_class?>"> 
                            <a href="subscriber.php">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                <span class="title">Subscribers</span>
                            </a>
                           
                        </li>
						
						
						<?php } ?>
						
						<li class="<?=$setting_class?> setting_menu" style="display:none;"> 
                            <a href="javascript:;">
                               <i class="fa fa-cog" aria-hidden="true"></i>


                                <span class="title">settings</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu" >
                                <li>
                                    <a class="" href="chnage_password.php" style="padding-left: 0px;"> Change Password</a>
                                </li>
                                <li>
                                    <a class="" href="logout.php">Logout</a>
                                </li>
                            </ul>
                        </li>
                        
                    </ul>

                </div>
                <!-- MAIN MENU - END -->



                <div class="project-info">

                    

                </div>



            </div>